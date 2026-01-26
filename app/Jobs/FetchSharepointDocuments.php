<?php

namespace App\Jobs;

use App\Services\Microsoft\SharepointService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FetchSharepointDocuments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(        
        protected string $accessToken,
        protected string $siteId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(SharepointService $sharepointService): void
    {
        Log::info('FetchSharepointDocuments started', [
            'siteId' => $this->siteId,
        ]);

        set_time_limit(500);

        $documents = $sharepointService->getSharepointDocuments(
            $this->accessToken,
            $this->siteId
        );

        Cache::put(
            "sharepoint_docs_{$this->siteId}",
            [
                'total' => $documents->count(),
                'data' => $documents,
                'fetched_at' => now(),
            ],
            now()->addMinutes(10)
        );

        Log::info('FetchSharepointDocuments finished', [
            'total' => $documents->count(),
        ]);
    }
}
