<?php

namespace App\Http\Controllers\Microsoft;

use App\Services\MicrosoftGraphService;
use App\Services\MicrosoftTokenService;
use App\Helpers\WordEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class SharepointController extends Controller
{
    public function getSharepointDocuments(Request $request)
    {
        $user = $request->user();
        $token = $user->ms_access_token;

        if (!$token) {
            return redirect()->route('auth.microsoft')->with('error', 'Silahkan login ke Microsoft terlebih dahulu.');
        }

        try {
            $siteUrl = "sigmacoid.sharepoint.com:/sites/my-first-site";
            $siteResponse = Http::withToken($token)
                ->get("https://graph.microsoft.com/v1.0/sites/{$siteUrl}");

            if ($siteResponse->failed()) {
                return view('sharepoint.index')->with('error', 'Site SharePoint tidak ditemukan.');
            }

            $siteId = $siteResponse->json()['id'];

            $response = Http::withToken($token)
                ->timeout(10)
                ->get("https://graph.microsoft.com/v1.0/sites/{$siteId}/drive/root/children", [
                    '$orderby' => 'lastModifiedDateTime desc'
                ]);

            if ($response->failed()) {
                if ($response->status() === 401) {
                    return redirect()->route('auth.microsoft');
                }
                return view('sharepoint.index')->with('error', 'Gagal mengambil data dari Microsoft.');
            }

            $driveItems = $response->json()['value'];

            $driveItems = collect($driveItems)->filter(function ($item) {
                return str_ends_with($item['name'], '.docx');
            });

            // dd($driveItems);

            return view('sharepoint.index', compact('driveItems'));

        } catch (\Exception $e) {
            Log::error("MS Graph Error: " . $e->getMessage());
            return "Terjadi kesalahan koneksi: " . $e->getMessage();
        }
    }

    public function showEditor($id)
    {
        $token = auth()->user()->ms_access_token;

        try {
            // 1. Dapatkan Site ID terlebih dahulu (seperti di fungsi getAllDocs)
            $siteUrl = "sigmacoid.sharepoint.com:/sites/my-first-site";
            $siteResponse = Http::withToken($token)->get("https://graph.microsoft.com/v1.0/sites/{$siteUrl}");
            $siteId = $siteResponse->json()['id'];

            // 2. Akses item menggunakan Site ID tersebut
            // Gunakan endpoint: /sites/{site-id}/drive/items/{item-id}
            $response = Http::withToken($token)
                ->get("https://graph.microsoft.com/v1.0/sites/{$siteId}/drive/items/{$id}");

            if ($response->successful()) {
                $embedUrl = $response->json()['webUrl'];
                return view('sharepoint.edit', compact('embedUrl'));
            }

            return redirect()->route('sharepoint.index')->with('error', 'Dokumen tidak ditemukan di SharePoint.');

        } catch (\Exception $e) {
            return redirect()->route('sharepoint.index')->with('error', 'Gagal memuat editor: ' . $e->getMessage());
        }
    }

}