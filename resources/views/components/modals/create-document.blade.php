    <div id="createDocumentModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-3xl bg-white shadow-2xl transform transition-all">
            
            {{-- Modal Header --}}
            <div class="relative overflow-hidden rounded-t-3xl bg-gradient-to-br from-blue-500 to-indigo-600 px-8 py-8">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full transform translate-x-16 -translate-y-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full transform -translate-x-12 translate-y-12"></div>
                
                <div class="relative flex items-center justify-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm border border-white/30 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                
                <h3 class="mt-4 text-center text-2xl font-black text-white">
                    Create New Document
                </h3>
            </div>

            {{-- Modal Body --}}
            <form method="POST" action="{{ route('documents.create') }}" class="px-8 py-6">
                @csrf
                
                <div class="space-y-5">
                    {{-- Document Name --}}
                    <div>
                        <label for="documentName" class="block text-sm font-bold text-slate-700 mb-2">
                            Document Name
                        </label>
                        <input 
                            type="text" 
                            id="documentName" 
                            name="name" 
                            required
                            placeholder="Enter document name..."
                            class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-slate-900 font-medium transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:outline-none hover:border-slate-300 placeholder:text-slate-400">
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Document Type --}}
                    <div>
                        <label for="documentType" class="block text-sm font-bold text-slate-700 mb-2">
                            Document Type
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="relative flex items-center gap-3 rounded-xl border-2 border-slate-200 bg-white p-2 cursor-pointer transition-all hover:bg-blue-50 hover:border-blue-300 has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500">
                                <input type="radio" name="type" value="docx" checked class="peer sr-only">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 peer-checked:bg-blue-500 transition-colors">
                                    <svg class="w-5 h-5 text-gray-50 peer-checked:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                        @includeIf('icons.files.word')
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-slate-700">Word</span>
                            </label>

                            <label class="relative flex items-center gap-3 rounded-xl border-2 border-slate-200 bg-white p-2 cursor-pointer transition-all hover:bg-green-50 hover:border-green-300 has-[:checked]:bg-green-50 has-[:checked]:border-green-500">
                                <input type="radio" name="type" value="xlsx" class="peer sr-only">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 peer-checked:bg-green-500 transition-colors">
                                    <svg class="w-5 h-5 text-gray-50 peer-checked:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                        @includeIf('icons.files.excel')
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-slate-700">Excel</span>
                            </label>

                            
                            <label class="relative flex items-center gap-3 rounded-xl border-2 border-slate-200 bg-white p-2 cursor-pointer transition-all hover:bg-orange-50 hover:border-orange-300 has-[:checked]:bg-orange-50 has-[:checked]:border-orange-500">
                                <input type="radio" name="type" value="ppt" class="peer sr-only">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-orange-100 peer-checked:bg-orange-500 transition-colors">
                                    <svg class="w-5 h-5 text-gray-50 peer-checked:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                        @includeIf('icons.files.ppt')
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-slate-700">Power Point</span>
                            </label>
                        </div>
                    </div>

                    {{-- Storage Location --}}
                    <div>
                        <label for="uploadStorage" class="block text-sm font-bold text-slate-700 mb-2">
                            Save to
                        </label>
                        <select 
                            id="uploadStorage" 
                            name="storage" 
                            class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-slate-900 font-medium transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:outline-none hover:border-slate-300">
                            <option value="sharepoint">SharePoint</option>
                            <option value="onedrive">OneDrive</option>
                        </select>
                    </div>

                    @if(isset($sites))
                    {{-- Site Selection (if SharePoint) --}}
                    <div id="siteSelection">
                        <label for="uploadSite" class="block text-sm font-bold text-slate-700 mb-2">
                            Select Site
                        </label>
                        <select 
                            id="uploadSite" 
                            name="site_id"
                            required 
                            class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-slate-900 font-medium transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:outline-none hover:border-slate-300">
                            @foreach($sites as $site)
                                <option value="{{ $site['id'] }}">{{ $site['displayName'] }}</option>
                            @endforeach
                        </select>
                        @error('site_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif
                </div>

                {{-- Modal Footer --}}
                <div class="flex gap-3 mt-8">
                    <button
                        type="button"
                        data-close-create-document-modal
                        class="flex-1 rounded-xl border-2 border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-700 transition-all hover:bg-slate-50 hover:border-slate-300 hover:shadow-md">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="flex-1 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-500/30 transition-all hover:shadow-blue-500/50 hover:scale-105">
                        Create Document
                    </button>
                </div>
            </form>
        </div>
    </div>