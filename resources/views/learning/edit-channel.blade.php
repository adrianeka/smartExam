<x-app-layout>
    {{-- Include Quill.js CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    
    <div class="fixed inset-0 z-[100] flex flex-col bg-gray-50 overflow-hidden">
        {{-- Header Bar --}}
        <div class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0 shadow-sm">
            <div class="flex items-center gap-4">
                <a href="{{ route('dynamic-page.show', $menu->id) }}" class="w-8 h-8 flex items-center justify-center rounded-md text-gray-500 hover:bg-gray-100 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div class="flex items-center gap-2">
                    <i class="{{ $menu->icon }} text-gray-400"></i>
                    <h1 class="font-bold text-gray-800 text-lg">Editing: {{ $menu->name }}</h1>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400 mr-2" id="save-status">Unsaved changes</span>
                <button form="editor-form" type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Publish
                </button>
            </div>
        </div>

        {{-- Editor Area --}}
        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            <form id="editor-form" action="{{ route('dynamic-page.update', $menu->id) }}" method="POST" class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col min-h-[70vh]">
                @csrf
                @method('PUT')
                
                {{-- Hidden input to store the HTML content --}}
                <input type="hidden" name="content" id="content-input">
                
                {{-- Quill Toolbar container will be injected automatically by Quill, or we can customize it --}}
                
                {{-- Quill Editor container --}}
                <div id="editor-container" class="flex-1 text-gray-800 text-base" style="min-h: 500px; font-size: 16px;">
                    {!! old('content', $menu->content) !!}
                </div>
            </form>
        </div>
    </div>

    {{-- Include Quill.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Quill
            const quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Start writing your brilliant article here...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['blockquote', 'code-block'],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                }
            });

            // Handle Form Submission
            const form = document.getElementById('editor-form');
            const contentInput = document.getElementById('content-input');
            const saveStatus = document.getElementById('save-status');

            form.addEventListener('submit', function(e) {
                // Get HTML content from Quill and put it in the hidden input
                contentInput.value = quill.root.innerHTML;
                saveStatus.textContent = 'Saving...';
                saveStatus.classList.add('text-blue-500');
            });

            // Track changes to update status
            quill.on('text-change', function() {
                saveStatus.textContent = 'Unsaved changes';
                saveStatus.classList.remove('text-blue-500', 'text-green-500');
                saveStatus.classList.add('text-gray-400');
            });
        });
    </script>
    
    <style>
        /* Make Quill look cleaner */
        .ql-toolbar.ql-snow {
            border: none !important;
            border-bottom: 1px solid #e5e7eb !important;
            padding: 12px 16px !important;
            background-color: #f9fafb;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }
        .ql-container.ql-snow {
            border: none !important;
        }
        .ql-editor {
            padding: 32px 48px !important;
            min-height: 500px;
        }
        /* Prose-like styling for editor */
        .ql-editor h1 { font-size: 2.25rem; font-weight: 800; margin-bottom: 1rem; }
        .ql-editor h2 { font-size: 1.875rem; font-weight: 700; margin-bottom: 0.75rem; }
        .ql-editor p { line-height: 1.75; margin-bottom: 1.25rem; }
    </style>
</x-app-layout>
