<x-app-layout>
    <div class="p-6 max-w-5xl mx-auto">
        <div class="mb-6 flex justify-between items-start">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-2.5 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full uppercase tracking-wider">
                        {{ ucfirst($menu->type) }}
                    </span>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasPermissionTo('edit_menu_' . $menu->id))
                        <a href="{{ route('dynamic-page.edit', $menu->id) }}" class="px-2.5 py-1 text-xs font-semibold bg-green-100 text-green-700 hover:bg-green-200 rounded-full transition-colors">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Editor Mode
                        </a>
                    @endif
                </div>
                <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="{{ $menu->icon }} text-gray-400"></i>
                    {{ $menu->name }}
                </h2>
            </div>
            
            @role('admin')
            <a href="{{ route('admin.menus.settings', ['menu' => $menu->id, 'tab' => 'permissions']) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition flex items-center shadow-sm">
                <i class="fa-solid fa-users-gear mr-2"></i> Atur Akses (Members)
            </a>
            @endrole
        </div>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-6 flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 min-h-[400px]">
            @if(empty(strip_tags($menu->content)))
                <div class="h-full flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-file-pen text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Halaman Kosong</h3>
                        <p class="text-gray-500 mb-6">Artikel ini belum memiliki konten.</p>
                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasPermissionTo('edit_menu_' . $menu->id))
                            <a href="{{ route('dynamic-page.edit', $menu->id) }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                                Tulis Artikel Pertama
                            </a>
                        @endif
                    </div>
                </div>
            @else
                <div class="prose prose-blue max-w-none">
                    {!! $menu->content !!}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
