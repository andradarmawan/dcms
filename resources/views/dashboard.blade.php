<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
        
        {{-- ================= Animated Background Pattern ================= --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none opacity-20">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 space-y-12">

            {{-- ================= Hero Section ================= --}}
            <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900 shadow-2xl">
                {{-- Decorative Elements --}}
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500 rounded-full filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
                
                <div class="relative flex flex-col items-center gap-12 p-8 md:flex-row md:p-16 lg:p-20">

                    {{-- Text Content --}}
                    <div class="flex-1 text-center md:text-left z-10">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 mb-6">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            <span class="text-xs font-bold uppercase tracking-wider text-white">
                                Enterprise Cloud Integration
                            </span>
                        </div>

                        <h1 class="text-5xl font-black leading-tight text-white md:text-6xl lg:text-7xl">
                            Document Management
                            <span class="block mt-2 bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 bg-clip-text text-transparent">
                                Made Simple
                            </span>
                        </h1>

                        <p class="mt-6 text-xl leading-relaxed text-blue-100 max-w-2xl">
                            Centralize all your SharePoint documents in a single unified platform.
                            Real-time sync with seamless collaboration.
                        </p>

                        {{-- CTA Buttons --}}
                        @php
                            $user = auth()->user();
                            $hasValidToken = $user->ms_access_token && 
                                            $user->ms_token_expires_at && 
                                            Carbon\Carbon::parse($user->ms_token_expires_at)->isFuture();
                        @endphp
                        <div class="mt-10 flex flex-col items-center gap-4 sm:flex-row md:justify-start">
                            @if($hasValidToken)
                                <a href="{{ route('graph.documents') }}"
                                    class="group relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-4 font-bold text-white shadow-2xl shadow-blue-500/50 transition-all hover:shadow-blue-500/70 hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="relative flex items-center gap-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                        </svg>
                                        <span>My Documents</span>
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </div>
                                </a>

                                <div class="flex items-center gap-3 rounded-2xl bg-green-500/10 backdrop-blur-sm border border-green-400/30 px-6 py-3">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-500 shadow-lg shadow-green-500/50">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <div class="text-xs text-green-300 font-medium">Status</div>
                                        <div class="text-sm font-bold text-white">Connected to Microsoft 365</div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('auth.microsoft') }}"
                                    class="group relative overflow-hidden rounded-2xl bg-white px-8 py-4 font-bold text-slate-900 shadow-2xl transition-all hover:shadow-xl hover:scale-105">
                                    <div class="relative flex items-center gap-3">
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 23 23">
                                            <path d="M0 0h11v11H0zM12 0h11v11H12zM0 12h11v11H0zM12 12h11v11H12z"/>
                                        </svg>
                                        <span>Connect to Microsoft 365</span>
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </div>
                                </a>

                                <div class="flex items-center gap-2 text-sm text-blue-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <span>Secure OAuth 2.0</span>
                                </div>
                            @endif
                        </div>

                        {{-- Stats --}}
                        <div class="mt-12 grid grid-cols-3 gap-6 max-w-xl">
                            <div class="text-center">
                                <div class="text-3xl font-black text-white">100%</div>
                                <div class="text-xs text-blue-200 mt-1">Secure</div>
                            </div>
                            <div class="text-center border-x border-white/20">
                                <div class="text-3xl font-black text-white">Real-time</div>
                                <div class="text-xs text-blue-200 mt-1">Sync</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-black text-white">24/7</div>
                                <div class="text-xs text-blue-200 mt-1">Access</div>
                            </div>
                        </div>
                    </div>

                    {{-- 3D Document Preview --}}
                    <div class="relative hidden lg:block w-full max-w-md">
                        <div class="relative" style="transform: perspective(1000px) rotateY(-15deg);">
                            {{-- Main Document Card --}}
                            <div class="relative rounded-2xl bg-white p-8 shadow-2xl transform hover:scale-105 transition-transform duration-300">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg">
                                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                            <path d="M14 2v6h6M16 13H8m8 4H8m2-8H8"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">Document.docx</div>
                                        <div class="text-xs text-slate-400">Microsoft Word</div>
                                    </div>
                                </div>

                                {{-- Document Content Preview --}}
                                <div class="space-y-3">
                                    <div class="h-3 bg-gradient-to-r from-slate-200 to-slate-100 rounded-full"></div>
                                    <div class="h-3 bg-gradient-to-r from-slate-200 to-slate-100 rounded-full"></div>
                                    <div class="h-3 bg-gradient-to-r from-slate-200 to-slate-100 rounded-full w-3/4"></div>
                                    <div class="h-3 bg-gradient-to-r from-slate-200 to-slate-100 rounded-full w-5/6"></div>
                                    <div class="h-3 bg-gradient-to-r from-slate-200 to-slate-100 rounded-full w-2/3"></div>
                                </div>

                                {{-- Sync Indicator --}}
                                <div class="mt-6 flex items-center gap-2 text-xs text-green-600 font-semibold">
                                    <div class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                    </div>
                                    Synced with SharePoint
                                </div>
                            </div>

                            {{-- Floating Cards --}}
                            <div class="absolute -right-6 -top-6 w-20 h-20 rounded-xl bg-gradient-to-br from-green-400 to-emerald-500 shadow-xl transform rotate-12 flex items-center justify-center animate-float">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>

                            <div class="absolute -left-6 -bottom-6 w-20 h-20 rounded-xl bg-gradient-to-br from-purple-400 to-pink-500 shadow-xl transform -rotate-12 flex items-center justify-center animate-float" style="animation-delay: 0.5s;">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            {{-- ================= Features Grid ================= --}}
            <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
                {{-- Feature 1 --}}
                <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-slate-100 hover:border-blue-200">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-10 rounded-full transform translate-x-16 -translate-y-16 transition-opacity"></div>
                    
                    <div class="relative">
                        <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/50 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        
                        <div class="mb-2 text-sm font-bold text-blue-600 uppercase tracking-wider">Step 01</div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Autentikasi Aman</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Login menggunakan OAuth 2.0 dengan Microsoft 365. Keamanan tingkat enterprise untuk semua data Anda.
                        </p>
                    </div>
                </div>

                {{-- Feature 2 --}}
                <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-slate-100 hover:border-indigo-200">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500 to-purple-600 opacity-0 group-hover:opacity-10 rounded-full transform translate-x-16 -translate-y-16 transition-opacity"></div>
                    
                    <div class="relative">
                        <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/50 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        
                        <div class="mb-2 text-sm font-bold text-indigo-600 uppercase tracking-wider">Step 02</div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Sinkronisasi Real-time</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Setiap perubahan tersimpan otomatis ke SharePoint. Kolaborasi tanpa khawatir kehilangan data.
                        </p>
                    </div>
                </div>

                {{-- Feature 3 --}}
                <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-slate-100 hover:border-purple-200">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-600 opacity-0 group-hover:opacity-10 rounded-full transform translate-x-16 -translate-y-16 transition-opacity"></div>
                    
                    <div class="relative">
                        <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 shadow-lg shadow-purple-500/50 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        
                        <div class="mb-2 text-sm font-bold text-purple-600 uppercase tracking-wider">Step 03</div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Kontrol Akses</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Izin dan permission dikelola melalui Microsoft Graph API dengan standar keamanan tertinggi.
                        </p>
                    </div>
                </div>
            </section>

            {{-- ================= Integration Partners ================= --}}
            <section class="rounded-3xl bg-white p-8 md:p-12 shadow-lg border border-slate-100">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-black text-slate-900 mb-3">Terintegrasi Dengan</h2>
                    <p class="text-slate-600">Platform enterprise terpercaya dunia</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-items-center opacity-60">
                    <div class="flex flex-col items-center gap-2">
                        <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 23 23">
                            <path d="M0 0h11v11H0zM12 0h11v11H12zM0 12h11v11H0zM12 12h11v11H12z"/>
                        </svg>
                        <span class="text-sm font-bold text-slate-700">Microsoft 365</span>
                    </div>
                    
                    <div class="flex flex-col items-center gap-2">
                        <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 22C6.486 22 2 17.514 2 12S6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
                            <path d="M12 6c-3.309 0-6 2.691-6 6s2.691 6 6 6 6-2.691 6-6-2.691-6-6-6zm0 10c-2.206 0-4-1.794-4-4s1.794-4 4-4 4 1.794 4 4-1.794 4-4 4z"/>
                        </svg>
                        <span class="text-sm font-bold text-slate-700">SharePoint</span>
                    </div>
                    
                    <div class="flex flex-col items-center gap-2">
                        <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23 3v18h-6v-1h5V4H2v16h5v1H1V3h22z"/>
                            <path d="M12 8L8 6v12l4-2 4 2V6l-4 2z"/>
                        </svg>
                        <span class="text-sm font-bold text-slate-700">OneDrive</span>
                    </div>
                    
                    <div class="flex flex-col items-center gap-2">
                        <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                            <path d="M14 2v6h6M16 13H8m8 4H8m2-8H8"/>
                        </svg>
                        <span class="text-sm font-bold text-slate-700">Word Online</span>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -50px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(12deg); }
            50% { transform: translateY(-20px) rotate(12deg); }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</x-app-layout>