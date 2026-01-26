<div id="disconnectMicrosoftModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
    <div class="w-full max-w-md rounded-3xl bg-white shadow-2xl transform transition-all">
        
        {{-- Modal Header with Icon --}}
        <div class="relative overflow-hidden rounded-t-3xl bg-gradient-to-br from-red-500 to-rose-600 px-8 py-8">
            {{-- Decorative Background --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full transform translate-x-16 -translate-y-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full transform -translate-x-12 translate-y-12"></div>
            
            {{-- Icon Container --}}
            <div class="relative flex items-center justify-center">
                <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm border border-white/30 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
            
            <h3 class="mt-4 text-center text-2xl font-black text-white">
                Disconnect Microsoft?
            </h3>
        </div>

        {{-- Modal Body --}}
        <div class="px-8 py-6">
            <p class="text-center text-slate-600 leading-relaxed">
                Are you sure you want to disconnect your Microsoft account? 
                You'll need to reconnect to access SharePoint documents again.
            </p>

            {{-- Warning Box --}}
            <div class="mt-4 rounded-2xl bg-amber-50 border border-amber-200 p-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-amber-800">
                        <span class="font-semibold">Important:</span> This action will remove your access to all synced documents and folders.
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="flex gap-3 px-8 pb-8">
            <button
                type="button"
                data-close-disconnect-modal
                class="flex-1 rounded-xl border-2 border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-700 transition-all hover:bg-slate-50 hover:border-slate-300 hover:shadow-md"
            >
                Cancel
            </button>

            <form method="POST" action="{{ route('microsoft.disconnect') }}" class="flex-1">
                @csrf
                <button
                    type="submit"
                    class="w-full rounded-xl bg-gradient-to-r from-red-500 to-rose-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-red-500/30 transition-all hover:shadow-red-500/50 hover:scale-105"
                >
                    Yes, Disconnect
                </button>
            </form>
        </div>

    </div>
</div>

<style>
    /* Smooth modal animation */
    #disconnectMicrosoftModal:not(.hidden) {
        animation: fadeIn 0.2s ease-out;
    }

    #disconnectMicrosoftModal:not(.hidden) > div {
        animation: slideUp 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
</style>