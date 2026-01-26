<?php

namespace App\Services\Microsoft;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class SharepointService
{
    protected string $graphBaseUrl = 'https://graph.microsoft.com/v1.0';

    public function getUserMemberSites(string $accessToken)
    {
        try {
            $groups = Http::withToken($accessToken)
                ->get("{$this->graphBaseUrl}/me/memberOf?\$select=id,displayName");

            if ($groups->failed()) {
                throw new \Exception('Failed to fetch user groups');
            }

            $sites = collect();

            foreach ($groups->json('value') as $group) {
                if (!str_contains($group['@odata.type'], 'group')) {
                    continue;
                }

                $siteResponse = Http::withToken($accessToken)
                    ->get("{$this->graphBaseUrl}/groups/{$group['id']}/sites/root");

                if ($siteResponse->successful()) {
                    $sites->push([
                        'id' => $siteResponse->json('id'),
                        'name' => $siteResponse->json('name'),
                        'displayName' => $siteResponse->json('displayName'),
                        'webUrl' => $siteResponse->json('webUrl'),
                    ]);
                }
            }

            return $sites->filter()
                        ->sortBy('displayName')
                        ->unique('id')
                        ->values();

        } catch (\Exception $e) {
            Log::error('SharepointService@getSites error: ' . $e->getMessage());
            throw $e;
        }
    }


    // Deprecated
    public function getSharepointDocuments(string $accessToken, string $siteId, int $limit = 200): Collection
    {
        $allowed = ['docx', 'xlsx', 'pptx', 'pdf'];
        $items   = collect();
        $url     = "{$this->graphBaseUrl}/sites/{$siteId}/drive/root/children";

        do {
            $response = Http::withToken($accessToken)
                ->connectTimeout(5)
                ->timeout(15)
                ->get($url, [
                    '$top' => 50,
                    '$orderby' => 'lastModifiedDateTime desc',
                ]);

            if ($response->failed()) {
                throw new \Exception(
                    'Graph API error: ' . $response->body()
                );
            }

            $items = $items->merge($response->json('value'));
            $url   = $response->json('@odata.nextLink');

        } while ($url && $items->count() < $limit);

        return $items
            ->filter(fn ($item) =>
                !isset($item['folder']) &&
                isset($item['name']) &&
                in_array(
                    strtolower(pathinfo($item['name'], PATHINFO_EXTENSION)),
                    $allowed
                )
            )
            ->values();
    }


    public function getSharepointDocumentsRecursive(string $accessToken, string $siteId, int $limit = 200): Collection
    {
        $allowed = ['docx', 'xlsx', 'pptx', 'pdf'];
        $items = collect();

        $fetchFolder = function (string $folderUrl, string $currentPath = '') use (&$fetchFolder, $accessToken, $allowed, &$items, $limit, $siteId) {
            if ($items->count() >= $limit) {
                return;
            }

            $currentUrl = $folderUrl;

            do {
                try {
                    $response = Http::withToken($accessToken)
                        ->connectTimeout(10)
                        ->timeout(30)
                        ->get($currentUrl, [
                            '$top' => 50,
                            '$orderby' => 'lastModifiedDateTime desc',
                        ]);

                    if ($response->failed()) {
                        \Log::error('Graph API error', [
                            'url' => $currentUrl,
                            'path' => $currentPath,
                            'status' => $response->status(),
                        ]);
                        break;
                    }

                    $values = collect($response->json('value') ?? []);

                    // Ambil file sesuai ekstensi dan tambahkan path info
                    $files = $values->filter(function ($item) use ($allowed) {
                        if (isset($item['folder'])) {
                            return false;
                        }
                        
                        if (!isset($item['name'])) {
                            return false;
                        }

                        $extension = strtolower(pathinfo($item['name'], PATHINFO_EXTENSION));
                        return in_array($extension, $allowed);
                    })->map(function ($item) use ($currentPath) {
                        // Tambahkan informasi path
                        $item['folder_path'] = $currentPath ?: 'Root';
                        $item['parent_folder'] = basename($currentPath) ?: 'Root';
                        
                        // Ambil dari API response jika ada
                        if (isset($item['parentReference']['path'])) {
                            $apiPath = $item['parentReference']['path'];
                            // Format: /drive/root/FolderName
                            // Kita ambil setelah /drive/root/
                            $item['full_path'] = str_replace('/drive/root', '', $apiPath);
                        }
                        
                        return $item;
                    });

                    $items = $items->merge($files);

                    if ($items->count() >= $limit) {
                        return;
                    }

                    // Rekursif ke subfolder
                    $folders = $values->filter(fn($item) => isset($item['folder']));
                    
                    foreach ($folders as $folder) {
                        if ($items->count() >= $limit) {
                            break;
                        }

                        $subFolderName = $folder['name'] ?? 'unknown';
                        $subFolderPath = $currentPath ? $currentPath . '/' . $subFolderName : $subFolderName;

                        if (isset($folder['id'])) {
                            $subFolderUrl = "{$this->graphBaseUrl}/sites/{$siteId}/drive/items/{$folder['id']}/children";
                        } elseif (isset($folder['@odata.id'])) {
                            $subFolderUrl = $folder['@odata.id'] . '/children';
                        } else {
                            continue;
                        }

                        $fetchFolder($subFolderUrl, $subFolderPath);
                    }

                    $currentUrl = $response->json('@odata.nextLink');

                } catch (\Exception $e) {
                    \Log::error('Error fetching folder', [
                        'url' => $currentUrl,
                        'path' => $currentPath,
                        'error' => $e->getMessage()
                    ]);
                    break;
                }

            } while ($currentUrl && $items->count() < $limit);
        };

        // Mulai dari root
        $rootUrl = "{$this->graphBaseUrl}/sites/{$siteId}/drive/root/children";
        
        try {
            $fetchFolder($rootUrl, '');
        } catch (\Exception $e) {
            \Log::error('Error in recursive document fetch', [
                'site_id' => $siteId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }

        return $items->take($limit)->values();
    }


    /**
     * Create document - try Graph API first, fallback to template
    */
    public function createDocument(string $accessToken, string $siteId, string $fileName, string $type = 'docx'): array
    {
        try {
            // Method 1: Try creating empty file via Graph API (RECOMMENDED)
            return $this->createEmptyViaGraph($accessToken, $siteId, $fileName, $type);
            
        } catch (\Exception $e) {
            Log::warning('Graph API creation failed, trying template fallback: ' . $e->getMessage());
            
            // Method 2: Fallback to template upload
            return $this->createFromTemplate($accessToken, $siteId, $fileName, $type);
        }
    }

    /**
     * Method 1: Create empty file using Graph API metadata
    */
    protected function createEmptyViaGraph(string $accessToken, string $siteId, string $fileName, string $type): array
    {
        try {
            $mimeType = $this->getMimeType($type);

            $response = Http::withToken($accessToken)
                ->timeout(60)
                ->post("{$this->graphBaseUrl}/sites/{$siteId}/drive/root/children", [
                    'name' => $fileName,
                    'file' => [
                        'mimeType' => $mimeType
                    ],
                    '@microsoft.graph.conflictBehavior' => 'rename'
                ]);
            
            if ($response->failed()) {
                Log::error('Graph API metadata creation failed', [
                    'status' => $response->status(),
                    'reason' => $response->reason()
                ]);
                throw new \Exception('Failed to create file metadata. Status: ' . $response->status());
            }

            $fileData = $response->json();
            $minimalContent = $this->getMinimalContent($type);
            
            if ($minimalContent) {
                $uploadResponse = Http::withToken($accessToken)
                    ->timeout(60)
                    ->withBody($minimalContent, $mimeType)
                    ->put("{$this->graphBaseUrl}/sites/{$siteId}/drive/items/{$fileData['id']}/content");
                    
                if ($uploadResponse->successful()) {
                    $fileData = $uploadResponse->json();
                    Log::info('Document content uploaded successfully');
                } else {
                    Log::warning('Initial metadata created but content upload failed', [
                        'status' => $uploadResponse->status()
                    ]);
                }
            }

            return $fileData;
            
        } catch (\Exception $e) {
            // Sanitizing the error message for the log
            $cleanMessage = mb_convert_encoding($e->getMessage(), 'UTF-8', 'UTF-8');
            Log::error('Exception in createEmptyViaGraph: ' . $cleanMessage);
            throw $e;
        }
    }

    /**
     * Method 2: Create from local template
    */
    protected function createFromTemplate(string $accessToken, string $siteId, string $fileName, string $type): array
    {
        $templatePath = storage_path("templates/empty.{$type}");
        
        if (!file_exists($templatePath)) {
            throw new \Exception("Template not found: {$templatePath}");
        }

        $content = file_get_contents($templatePath);
        $mimeType = $this->getMimeType($type);

        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => $mimeType])
            ->timeout(60)
            ->put("{$this->graphBaseUrl}/sites/{$siteId}/drive/root:/{$fileName}:/content", $content);

        if ($response->failed()) {
            throw new \Exception('Template upload failed: ' . $response->status());
        }

        return $response->json();
    }


    /**
     * Get minimal valid content for Office files
    */
    protected function getMinimalContent(string $type): ?string
    {
        $templatePath = storage_path("templates/empty.{$type}");
        
        if (file_exists($templatePath)) {
            $content = file_get_contents($templatePath);
            // Validate if content is valid
            if ($content !== false && strlen($content) > 0) {
                return $content;
            }
        }

        Log::warning("Template not found: {$templatePath}, Office Online will create empty file");
        return null;
    }

    /**
     * Get MIME type for document type
    */
    protected function getMimeType(string $type): string
    {
        return match($type) {
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'pdf' => 'application/pdf',
            default => 'application/octet-stream',
        };
    }
}
