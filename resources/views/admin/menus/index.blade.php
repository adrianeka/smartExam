<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Menu Dinamis</h2>
                <p class="text-gray-500 text-sm mt-1">Atur navigasi sidebar berdasarkan Role/Permission.</p>
            </div>
            <a href="{{ route('admin.menus.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fa-solid fa-plus mr-2"></i>Tambah Menu
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50/50 text-gray-500 border-b border-gray-100">
                        <tr>
                            <th class="py-4 px-6 font-semibold">Urutan</th>
                            <th class="py-4 px-6 font-semibold">Nama Menu</th>
                            <th class="py-4 px-6 font-semibold">URL/Route</th>
                            <th class="py-4 px-6 font-semibold">Permission (Akses)</th>
                            <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($menus as $menu)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 px-6">{{ $menu->order }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="{{ $menu->icon }} text-gray-400 w-5 text-center"></i>
                                    <span class="font-medium text-gray-800">{{ $menu->name }}</span>
                                    @if($menu->parent)
                                        <span class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-500">Submenu dari {{ $menu->parent->name }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6"><span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded text-gray-600">{{ $menu->url }}</span></td>
                            <td class="py-4 px-6">
                                @if($menu->permission_name)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <i class="fa-solid fa-lock mr-1.5 text-[10px]"></i> {{ $menu->permission_name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 italic">Semua orang bisa melihat</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.menus.edit', $menu->id) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded transition-colors inline-flex">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded transition-colors ml-1">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 px-6 text-center text-gray-500">Belum ada menu dinamis.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
