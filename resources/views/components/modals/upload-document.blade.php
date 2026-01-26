    <div id="uploadDocumentModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-3xl bg-white shadow-2xl transform transition-all">
            
            {{-- Modal Header --}}
            <div class="relative overflow-hidden rounded-t-3xl bg-gradient-to-br from-indigo-500 to-purple-600 px-8 py-8">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full transform translate-x-16 -translate-y-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full transform -translate-x-12 translate-y-12"></div>
                
                <div class="relative flex items-center justify-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm border border-white/30 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                </div>
                
                <h3 class="mt-4 text-center text-2xl font-black text-white">
                    Upload Document
                </h3>
            </div>

            {{-- Modal Body --}}
            <form method="POST" action="#" enctype="multipart/form-data" class="px-8 py-6">
                {{-- action="{{ route('documents.upload') }}" --}}
                @csrf
                
                <div class="space-y-5">
                    {{-- Upload Area --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Select File
                        </label>
                        <div class="relative">
                            <input 
                                type="file" 
                                name="file" 
                                id="fileUpload"
                                accept=".docx,.xlsx,.pptx,.pdf"
                                required
                                class="hidden"
                                onchange="updateFileName(this)">
                            <label 
                                for="fileUpload"
                                class="flex flex-col items-center justify-center w-full rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 p-8 cursor-pointer transition-all hover:bg-blue-50 hover:border-blue-400">
                                <svg class="w-12 h-12 text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <span class="text-sm font-bold text-slate-700 mb-1">Click to upload</span>
                                <span class="text-xs text-slate-500" id="fileNameDisplay">or drag and drop</span>
                                <span class="text-xs text-slate-400 mt-2">DOCX, XLSX, PPTX, PDF (max 10MB)</span>
                            </label>
                        </div>
                    </div>

                    {{-- Storage Location --}}
                    <div>
                        <label for="uploadStorage" class="block text-sm font-bold text-slate-700 mb-2">
                            Upload to
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
                            name="site" 
                            class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-slate-900 font-medium transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:outline-none hover:border-slate-300">
                            @foreach($sites as $site)
                                <option value="{{ $site['id'] }}">{{ $site['displayName'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                {{-- Modal Footer --}}
                <div class="flex gap-3 mt-8">
                    <button
                        type="button"
                        data-close-upload-document-modal
                        class="flex-1 rounded-xl border-2 border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-700 transition-all hover:bg-slate-50 hover:border-slate-300 hover:shadow-md">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="flex-1 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/30 transition-all hover:shadow-indigo-500/50 hover:scale-105">
                        Upload File
                    </button>
                </div>
            </form>

        </div>
    </div>