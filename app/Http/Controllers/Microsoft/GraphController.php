<?php

namespace App\Http\Controllers\Microsoft;

use App\Services\Microsoft\SharepointService;
use App\Services\MicrosoftAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Jobs\FetchSharepointDocuments;
use App\Jobs\FetchSharepointSites;
use Illuminate\Support\Facades\Cache;

class GraphController extends Controller
{
    protected SharepointService $sharepointService;
    protected MicrosoftAuthService $microsoftAuthService;

    public function __construct(SharepointService $sharepointService, MicrosoftAuthService $microsoftAuthService)
    {
        $this->sharepointService = $sharepointService;
        $this->microsoftAuthService = $microsoftAuthService;
    }

    public function getDocuments(Request $request)
    {
        $user = auth()->user();

        $source = $request->get('source', 'sharepoint');
        $token  = $user->ms_access_token;

        // === LOGIC LAMA (DIBIARKAN) ===
        $sharePointCount = 0;
        $oneDriveCount   = 0;
        $driveItems      = collect();

        try {
            if ($source === 'onedrive') {
                // Tetap pakai logic lama OneDrive
                $driveItems = $this->getOneDriveDocuments($request);
                $oneDriveCount = $driveItems->count();

            } else {
                $cacheSitesKey = "sharepoint_sites_{$user->ms_email}";
                if(!Cache::has($cacheSitesKey)) {
                    FetchSharepointSites::dispatch(
                        $token, 
                        $user->ms_email
                    );
                }

                $cacheSites = Cache::get($cacheSitesKey, [
                    'total' => 0,
                    'data'  => collect(),
                    'fetched_at' => null,
                ]);

                $sites = collect($cacheSites['data']);
                $selectedSiteId = $request->get('site', $sites->first()['id'] ?? null);
                $driveItems = $this->sharepointService->getSharepointDocumentsRecursive($token, $selectedSiteId, 100); 
                $sharePointCount = $driveItems->count();  
            }

            /**
             * Manual pagination (AMAN)
             */
            $perPage = (int) $request->get('perPage', 3);
            $page    = (int) $request->get('page', 1);

            $paginatedItems = new \Illuminate\Pagination\LengthAwarePaginator(
                $driveItems->forPage($page, $perPage),
                $driveItems->count(),
                $perPage,
                $page,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );


            return view('documents.index', [
                'driveItems'        => $paginatedItems,
                'sites'             => $sites,
                'selectedSiteId'    => $selectedSiteId,
                'sharePointCount'   => $sharePointCount,
                'oneDriveCount'     => $oneDriveCount,
                'isLoading'         => empty($payload['fetched_at'] ?? null),
            ]);

        } catch (\Exception $e) {
            \Log::error('GraphController Error', [
                'message' => $e->getMessage(),
            ]);

            if ($e->getMessage() === 'Unauthorized') {
                return redirect()->route('auth.microsoft');
            }

            return view('documents.index')->with('error', $e->getMessage());
        }
    }


    /**
     * Create new document
    */
    public function create(Request $request)
    {        
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:docx,xlsx,pptx',
            'site_id' => 'required|string',
            'storage' => 'nullable|in:sharepoint,onedrive',
        ]);

        try {
            $user = auth()->user();

            // Add extension if not present
            $fileName = $request->name;
            if (!str_ends_with(strtolower($fileName), '.' . $request->type)) {
                $fileName .= '.' . $request->type;
            }

            // Create document
            $document = $this->sharepointService->createDocument(
                $user->ms_access_token,
                $request->site_id,
                $fileName,
                $request->type
            );

            Log::info('Document created', [
                'user_id' => $user->id,
                'document_name' => $document['name'] ?? 'unknown',
                'site_id' => $request->site_id
            ]);

            return redirect()
                ->route('graph.documents', ['site' => $request->site_id])
                ->with('success', 'Document "' . $fileName . '" created successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to create document', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'request' => $request->all()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create document: ' . $e->getMessage());
        }
    }

    // Upload Document
    public function uploadDocument(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:docx,xlsx,pptx,pdf|max:10240',
            'storage' => 'required|in:sharepoint,onedrive',
            'site' => 'required_if:storage,sharepoint'
        ]);
        
        // Upload logic here
        // Redirect back with success message
    }


}