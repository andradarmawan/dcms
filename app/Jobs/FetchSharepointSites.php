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

class FetchSharepointSites implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $accessToken, 
        protected string $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(SharepointService $sharepointService): void
    {
        Log::info('FetchSharepointSites started');

        set_time_limit(500);

        $sites = $sharepointService->getUserMemberSites($this->accessToken);

        Cache::put(
            "sharepoint_sites_{$this->user}",
            [
                'total' => $sites->count(),
                'data' => $sites,
                'fetched_at' => now(),
            ], 
            now()->addMinutes(1440)
        );

        Log::info('FetchSharepointSites finished');
    }
}
