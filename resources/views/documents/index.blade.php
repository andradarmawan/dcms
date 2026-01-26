<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
        
        {{-- Animated Background Pattern --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none opacity-20">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Success/Error Messages --}}
                @if(session('success'))
                    <div class="mb-8 rounded-2xl bg-green-50 border-l-4 border-green-500 p-6 shadow-lg animate-slideDown">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-green-100">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-green-900">Success!</h3>
                                <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif
                
                @if(session('error') || $errors->any())
                    <div class="mb-8 rounded-2xl bg-red-50 border-l-4 border-red-500 p-6 shadow-lg animate-slideDown">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-red-100">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-red-900">Error!</h3>
                                @if(session('error'))
                                    <p class="mt-1 text-sm text-red-700">{{ session('error') }}</p>
                                @endif
                                @if($errors->any())
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                {{-- Page Header --}}
                <div class="mb-8">
                    <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                        <div>
                            <div class="inline-flex items-center gap-2 rounded-full bg-blue-100 border border-blue-200 px-4 py-2 mb-3">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                </span>
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-700">
                                    Document Management
                                </span>
                            </div>
                            <h1 class="text-4xl font-black text-slate-900 md:text-5xl">
                                Your Documents
                            </h1>
                            <p class="mt-2 text-lg text-slate-600">
                                Manage and edit your Word documents online
                            </p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button
                                type="button",
                                data-open-create-document-modal
                                class="group relative overflow-hidden rounded-xl border-2 border-blue-200 bg-white px-4 py-2 font-bold text-blue-600 transition-all hover:bg-blue-50 hover:border-blue-300 hover:shadow-lg flex items-center gap-3 justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Create New</span>
                            </button>

                            <button 
                                type="button",
                                data-open-upload-document-modal
                                class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-2 font-bold text-white shadow-xl shadow-blue-500/30 transition-all hover:shadow-blue-500/50 hover:scale-105 flex items-center gap-3 justify-center">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <svg class="relative w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <span class="relative">Upload File</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Storage Source Tabs --}}
                <div class="mb-8">
                    <div class="rounded-2xl bg-white p-2 shadow-lg border border-slate-100 inline-flex gap-2">
                        <a href="{{ route('graph.documents', array_merge(request()->except('source'), ['source' => 'sharepoint'])) }}" 
                            class="group relative overflow-hidden rounded-xl px-6 py-3 font-bold transition-all flex items-center gap-3 {{ (!request('source') || request('source') == 'sharepoint') ? 'bg-gradient-to-r from-cyan-600 to-cyan-900 text-white shadow-lg shadow-cyan-600/30' : 'text-slate-600 hover:bg-slate-50' }}">
                            @if(!request('source') || request('source') == 'sharepoint')
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-cyan-900 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            @endif
                            <svg class="relative w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                @includeIf('icons.platforms.sharepoint')
                            </svg>
                            <span class="relative">SharePoint</span>
                            @if(!request('source') || request('source') == 'sharepoint')
                                <span class="relative inline-flex items-center justify-center w-6 h-6 text-xs font-black bg-white/20 rounded-full">
                                    {{ isset($sharePointCount) ? $sharePointCount : '0' }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('graph.documents', array_merge(request()->except('source'), ['source' => 'onedrive'])) }}" 
                            class="group relative overflow-hidden rounded-xl px-6 py-3 font-bold transition-all flex items-center gap-3 {{ request('source') == 'onedrive' ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-600 hover:bg-slate-50' }}">
                            @if(request('source') == 'onedrive')
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            @endif
                            <svg class="relative w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                @includeIf('icons.platforms.onedrive')
                            </svg>
                            <span class="relative">OneDrive</span>
                            @if(request('source') == 'onedrive')
                                <span class="relative inline-flex items-center justify-center w-6 h-6 text-xs font-black bg-white/20 rounded-full">
                                    {{ isset($oneDriveCount) ? $oneDriveCount : '0' }}
                                </span>
                            @endif
                        </a>
                    </div>
                </div>

                {{-- SharePoint Site Selector & Filters --}}
                <div class="mb-8 rounded-3xl bg-white p-6 shadow-lg border border-slate-100">
                    <form method="GET" action="{{ route('graph.documents') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            
                            {{-- SharePoint Site Selector --}}
                            <div>
                                <label for="site" class="block text-sm font-bold text-slate-700 mb-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                        </svg>
                                        SharePoint Site
                                    </div>
                                </label>
                                <select 
                                    id="site" 
                                    name="site" 
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-slate-900 font-medium transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:outline-none hover:border-slate-300">
                                    {{-- <option value="">All Sites</option> --}}
                                    @if(isset($sites))
                                        @foreach($sites as $site)
                                            <option value="{{ $site['id'] }}" @selected($site['id'] === $selectedSiteId)>
                                                {{ $site['displayName'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            {{-- Document Type Filter --}}
                            <div>
                                <label for="type" class="block text-sm font-bold text-slate-700 mb-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                                        </svg>
                                        Document Type
                                    </div>
                                </label>
                                <select 
                                    id="type" 
                                    name="type" 
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-slate-900 font-medium transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:outline-none hover:border-slate-300">
                                    <option value="">All Types</option>
                                    <option value="docx" {{ request('type') == 'docx' ? 'selected' : '' }}>Word Document (.docx)</option>
                                    <option value="xlsx" {{ request('type') == 'xlsx' ? 'selected' : '' }}>Excel Spreadsheet (.xlsx)</option>
                                    <option value="pptx" {{ request('type') == 'pptx' ? 'selected' : '' }}>PowerPoint (.pptx)</option>
                                    <option value="pdf" {{ request('type') == 'pdf' ? 'selected' : '' }}>PDF Document (.pdf)</option>
                                </select>
                            </div>

                            {{-- Search Input --}}
                            <div>
                                <label for="search" class="block text-sm font-bold text-slate-700 mb-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        Search Documents
                                    </div>
                                </label>
                                <input 
                                    type="text" 
                                    id="search" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="Enter document name..."
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-slate-900 font-medium transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:outline-none hover:border-slate-300 placeholder:text-slate-400">
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-3 justify-end pt-2">
                            <a href="{{ route('graph.documents') }}" 
                                class="inline-flex items-center gap-2 rounded-xl border-2 border-slate-200 bg-white px-6 py-2.5 text-sm font-bold text-slate-700 transition-all hover:bg-slate-50 hover:border-slate-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Clear Filters
                            </a>
                            <button 
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/30 transition-all hover:shadow-blue-500/50 hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Apply Filters
                            </button>
                        </div>
                    </form>

                    {{-- Active Filters Display --}}
                    @if(request()->hasAny(['site', 'type', 'search']))
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-sm font-bold text-slate-600">Active Filters:</span>
                                @if(request('site'))
                                    <span class="inline-flex items-center gap-1 rounded-lg bg-blue-100 border border-blue-200 px-3 py-1 text-xs font-bold text-blue-700">
                                        Site: {{ collect($sites ?? [])->firstWhere('id', request('site'))['displayName'] ?? request('site') }}
                                        <a href="{{ route('graph.documents', array_filter(request()->except('site'))) }}" class="ml-1 hover:text-blue-900">×</a>
                                    </span>
                                @endif
                                @if(request('type'))
                                    <span class="inline-flex items-center gap-1 rounded-lg bg-indigo-100 border border-indigo-200 px-3 py-1 text-xs font-bold text-indigo-700">
                                        Type: {{ strtoupper(request('type')) }}
                                        <a href="{{ route('graph.documents', array_filter(request()->except('type'))) }}" class="ml-1 hover:text-indigo-900">×</a>
                                    </span>
                                @endif
                                @if(request('search'))
                                    <span class="inline-flex items-center gap-1 rounded-lg bg-purple-100 border border-purple-200 px-3 py-1 text-xs font-bold text-purple-700">
                                        Search: "{{ request('search') }}"
                                        <a href="{{ route('graph.documents', array_filter(request()->except('search'))) }}" class="ml-1 hover:text-purple-900">×</a>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Error Alert --}}
                @if(isset($error) || session('error'))
                    <div class="mb-8 rounded-2xl bg-red-50 border-l-4 border-red-500 p-6 shadow-lg animate-slideDown">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-red-100">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-red-900">Attention Required</h3>
                                <p class="mt-1 text-sm text-red-700">{{ $error ?? session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Documents Grid --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($driveItems as $item)
                        @php
                            $format = \App\Helpers\FileFormat::fromMime($item['file']['mimeType'] ?? null);
                        @endphp

                        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300 border border-slate-100 hover:border-blue-200">
                            
                            {{-- Hover Effect Background --}}
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-10 rounded-full transform translate-x-16 -translate-y-16 transition-opacity"></div>
                            
                            <div class="relative p-6">
                                {{-- Document Header --}}
                                <div class="flex items-start gap-4 mb-6">
                                    <div class="flex-shrink-0">   
                                        <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br {{ $format['gradient'] }} shadow-lg {{ $format['shadow'] }} group-hover:scale-110 transition-transform">
                                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                @includeIf('icons.files.' . $format['icon'])
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-bold text-slate-900 truncate group-hover:text-blue-600 transition-colors" title="{{ $item['name'] }}">
                                            {{ $item['name'] }}
                                        </h3>
                                        
                                        {{-- ADD: Location Display --}}
                                        @if(isset($item['folder_path']) || isset($item['full_path']) || isset($item['parentReference']['path']))
                                            <div class="flex items-center gap-2 mt-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                                </svg>
                                                <p class="text-xs text-slate-500 truncate" title="{{ $item['folder_path'] ?? $item['full_path'] ?? str_replace('/drive/root', '', $item['parentReference']['path'] ?? '') }}">
                                                    {{ $item['folder_path'] ?? $item['parent_folder'] ?? ($item['full_path'] ?? (str_replace('/drive/root', '', $item['parentReference']['path'] ?? '') ?: 'Root')) }}
                                                </p>
                                            </div>
                                        @endif
                                        
                                        <div class="flex items-center gap-2 mt-2">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <p class="text-xs text-slate-500">
                                                Modified {{ \Carbon\Carbon::parse($item['lastModifiedDateTime'])->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                {{-- Document Metadata --}}
                                <div class="mb-6 pt-4 space-y-3">
                                    {{-- Stats Row --}}
                                    <div class="flex items-center justify-between text-xs">
                                        <div class="flex items-center gap-1.5">
                                            <div class="flex items-center gap-1 rounded-lg bg-{{ $format['color'] }}-50 border border-{{ $format['color'] }}-200 px-2 py-1">
                                                <span class="font-bold text-{{ $format['color'] }}-700 uppercase tracking-wide text-[10px]">
                                                    {{ $format['label'] }}
                                                </span>
                                            </div>
                                            @if(isset($item['size']))
                                            <div class="flex items-center gap-1 text-slate-600">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="font-bold text-slate-700">{{ number_format($item['size'] / 1024, 1) }} KB</span>
                                            </div>
                                            @endif
                                        </div>

                                        {{-- Sync Indicator --}}
                                        <div class="flex items-center gap-2 text-xs text-green-600 font-semibold">
                                            <div class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                            </div>
                                            Synced with SharePoint
                                        </div>
                                    </div>
                                    
                                    {{-- Divider --}}
                                    <div class="border-t border-slate-100"></div>
                                    
                                    {{-- Created By --}}
                                    @if(isset($item['createdBy']['user']['displayName']))
                                    <div class="flex items-center gap-2.5">
                                        <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white text-xs font-bold shadow-md">
                                            {{ strtoupper(substr($item['createdBy']['user']['displayName'], 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[10px] text-slate-500 uppercase tracking-wide font-semibold">Creator</p>
                                            <p class="text-xs font-bold text-slate-900 truncate" title="{{ $item['createdBy']['user']['displayName'] }}">
                                                {{ $item['createdBy']['user']['displayName'] }}
                                            </p>
                                        </div>
                                        @if(isset($item['createdDateTime']))
                                        <div class="text-right">
                                            <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($item['createdDateTime'])->format('M d') }}</p>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>

                                {{-- Premium Footer Actions --}}
                                <div class="space-y-2.5 pt-4 border-t-2 border-slate-100">
                                    {{-- Primary Actions --}}
                                    <div class="flex gap-2">
                                        {{-- Edit Button - Primary --}}
                                        <a href="{{ $item['webUrl'] }}" 
                                        target="_blank"
                                        class="group/edit relative flex-1 overflow-hidden flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all hover:scale-[1.02] active:scale-[0.98]">
                                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 opacity-0 group-hover/edit:opacity-100 transition-opacity"></div>
                                            <span class="relative">{{ $format['label'] === 'PDF' ? 'Open' : 'Edit Now' }}</span>
                                            <svg class="relative w-3.5 h-3.5 group-hover/edit:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>

                                    {{-- Secondary Actions --}}
                                    <div class="flex items-center justify-between">
                                        {{-- Download Link --}}
                                        <a href="{{ $item['@microsoft.graph.downloadUrl'] }}" 
                                        target="_blank"
                                        class="group/download inline-flex items-center gap-2 rounded-lg bg-{{ $format['color'] }}-50 hover:bg-{{ $format['color'] }}-100 border border-{{ $format['color'] }}-200 px-3 py-1.5 text-xs font-bold text-{{ $format['color'] }}-700 transition-all hover:shadow-sm">
                                            {{-- <svg class="w-4 h-4 group-hover/download:translate-y-0.5 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                                @includeIf('icons.files.download')
                                            </svg> --}}
                                            <span>Download</span>
                                        </a>

                                        {{-- Share Link --}}
                                        <button class="group/share inline-flex items-center gap-2 rounded-lg hover:bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-blue-600 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                            </svg>
                                            <span>Share</span>
                                        </button>

                                        {{-- More Options --}}
                                        <button class="group/more inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-all">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Empty State --}}
                        <div class="col-span-full">
                            <div class="relative overflow-hidden rounded-3xl bg-white p-12 text-center shadow-lg border-2 border-dashed border-slate-200">
                                {{-- Decorative circles --}}
                                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-100 rounded-full transform translate-x-16 -translate-y-16 opacity-50"></div>
                                <div class="absolute bottom-0 left-0 w-32 h-32 bg-indigo-100 rounded-full transform -translate-x-16 translate-y-16 opacity-50"></div>
                                
                                <div class="relative">
                                    {{-- Empty Icon --}}
                                    <div class="flex items-center justify-center w-20 h-20 mx-auto rounded-3xl bg-gradient-to-br from-slate-100 to-slate-200 mb-6">
                                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    
                                    <h3 class="text-2xl font-black text-slate-900 mb-2">
                                        No Documents Yet
                                    </h3>
                                    <p class="text-slate-600 mb-8 max-w-md mx-auto">
                                        Get started by uploading your first .docx file to OneDrive or create a new document.
                                    </p>
                                    
                                    {{-- Action Buttons --}}
                                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                        <a href="#" 
                                            class="inline-flex items-center gap-3 rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-4 font-bold text-white shadow-xl shadow-blue-500/30 transition-all hover:shadow-blue-500/50 hover:scale-105">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            <span>Upload Document</span>
                                        </a>
                                        
                                        <a href="#" 
                                            class="inline-flex items-center gap-3 rounded-2xl border-2 border-slate-200 bg-white px-8 py-4 font-bold text-slate-700 transition-all hover:bg-slate-50 hover:border-slate-300 hover:shadow-md">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>Learn More</span>
                                        </a>
                                    </div>

                                    {{-- Info Cards --}}
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-12 max-w-3xl mx-auto">
                                        <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4 text-left">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                    </svg>
                                                </div>
                                                <h4 class="font-bold text-slate-900 text-sm">Upload Files</h4>
                                            </div>
                                            <p class="text-xs text-slate-600">
                                                Add document files from your computer
                                            </p>
                                        </div>

                                        <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4 text-left">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </div>
                                                <h4 class="font-bold text-slate-900 text-sm">Edit Online</h4>
                                            </div>
                                            <p class="text-xs text-slate-600">
                                                Real-time collaboration with Word
                                            </p>
                                        </div>

                                        <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4 text-left">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                    </svg>
                                                </div>
                                                <h4 class="font-bold text-slate-900 text-sm">Auto Sync</h4>
                                            </div>
                                            <p class="text-xs text-slate-600">
                                                Changes saved to SharePoint instantly
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if(isset($driveItems) && method_exists($driveItems, 'links'))
                    <div class="mt-8">
                        <div class="rounded-2xl bg-white border border-slate-100 shadow-lg p-6">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                
                                {{-- Pagination Info --}}
                                <div class="text-sm text-slate-600">
                                    Showing 
                                    <span class="font-bold text-slate-900">{{ $driveItems->firstItem() ?? 0 }}</span>
                                    to 
                                    <span class="font-bold text-slate-900">{{ $driveItems->lastItem() ?? 0 }}</span>
                                    of 
                                    <span class="font-bold text-slate-900">{{ $driveItems->total() }}</span>
                                    documents
                                </div>

                                {{-- Pagination Links --}}
                                <div class="flex items-center gap-2">
                                    {{-- Previous Button --}}
                                    @if ($driveItems->onFirstPage())
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-400 cursor-not-allowed">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </span>
                                    @else
                                        <a href="{{ $driveItems->previousPageUrl() }}" 
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl border-2 border-slate-200 bg-white text-slate-700 font-bold transition-all hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 hover:scale-105">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @php
                                        $start = max($driveItems->currentPage() - 2, 1);
                                        $end = min($driveItems->currentPage() + 2, $driveItems->lastPage());
                                    @endphp

                                    @if($start > 1)
                                        <a href="{{ $driveItems->url(1) }}" 
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl border-2 border-slate-200 bg-white text-slate-700 font-bold transition-all hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600">
                                            1
                                        </a>
                                        @if($start > 2)
                                            <span class="text-slate-400 px-2">...</span>
                                        @endif
                                    @endif

                                    @for ($i = $start; $i <= $end; $i++)
                                        @if ($i == $driveItems->currentPage())
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl border-2 border-blue-500 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold shadow-lg shadow-blue-500/30">
                                                {{ $i }}
                                            </span>
                                        @else
                                            <a href="{{ $driveItems->url($i) }}" 
                                                class="inline-flex items-center justify-center w-10 h-10 rounded-xl border-2 border-slate-200 bg-white text-slate-700 font-bold transition-all hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600">
                                                {{ $i }}
                                            </a>
                                        @endif
                                    @endfor

                                    @if($end < $driveItems->lastPage())
                                        @if($end < $driveItems->lastPage() - 1)
                                            <span class="text-slate-400 px-2">...</span>
                                        @endif
                                        <a href="{{ $driveItems->url($driveItems->lastPage()) }}" 
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl border-2 border-slate-200 bg-white text-slate-700 font-bold transition-all hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600">
                                            {{ $driveItems->lastPage() }}
                                        </a>
                                    @endif

                                    {{-- Next Button --}}
                                    @if ($driveItems->hasMorePages())
                                        <a href="{{ $driveItems->nextPageUrl() }}" 
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl border-2 border-slate-200 bg-white text-slate-700 font-bold transition-all hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 hover:scale-105">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    @else
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-400 cursor-not-allowed">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </span>
                                    @endif
                                </div>

                                {{-- Per Page Selector --}}
                                <div class="flex items-center gap-2">
                                    <label for="perPage" class="text-sm font-bold text-slate-700">Per page:</label>
                                    <select 
                                        id="perPage" 
                                        name="perPage"
                                        onchange="window.location.href='{{ route('graph.documents') }}?page=1&perPage=' + this.value + '{{ request()->has('site') ? '&site=' . request('site') : '' }}{{ request()->has('type') ? '&type=' . request('type') : '' }}{{ request()->has('search') ? '&search=' . request('search') : '' }}'"
                                        class="rounded-lg border-2 border-slate-200 bg-white px-6 py-1.5 text-sm font-bold text-slate-900 transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:outline-none hover:border-slate-300">
                                        <option value="6" {{ request('perPage', 6) == 6 ? 'selected' : '' }}>6</option>
                                        <option value="12" {{ request('perPage', 6) == 12 ? 'selected' : '' }}>12</option>
                                        <option value="24" {{ request('perPage', 6) == 24 ? 'selected' : '' }}>24</option>
                                        <option value="48" {{ request('perPage', 6) == 48 ? 'selected' : '' }}>48</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -50px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
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

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }
    </style>
    
    {{-- Create Document Modal --}}
    @include('components.modals.create-document')

    {{-- Upload Document Modal --}}
    @include('components.modals.upload-document')

</x-app-layout>