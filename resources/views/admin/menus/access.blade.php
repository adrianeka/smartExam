@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.menus.index') }}" class="text-gray-400 hover:text-blue-500 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Akses Menu</h1>
            </div>
            <p class="text-gray-500 text-sm ml-7">
                Mengatur akses pengguna untuk menu: <span class="font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded ml-1"><i class="{{ $menu->icon }} mr-1"></i> {{ $menu->name }}</span>
            </p>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-6 flex items-center gap-3">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-6 flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <form action="{{ route('admin.menus.access', $menu->id) }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="sr-only">Cari Pengguna</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="Cari nama atau email pengguna...">
                    </div>
                </div>
                <div class="md:w-64">
                    <select name="role" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-200 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg transition-colors" onchange="this.form.submit()">
                        <option value="">Semua Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full md:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <form action="{{ route('admin.menus.access.update', $menu->id) }}" method="POST">
            @csrf
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                        <tr>
                            <th class="py-4 px-6 rounded-tl-xl">Pengguna</th>
                            <th class="py-4 px-6 text-center">Role</th>
                            <th class="py-4 px-6 text-center">Can View (Lihat)</th>
                            <th class="py-4 px-6 text-center rounded-tr-xl">Can Edit (Kelola)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-100 to-blue-50 text-blue-600 flex items-center justify-center font-bold shadow-sm border border-blue-100">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <input type="hidden" name="user_ids[]" value="{{ $user->id }}">
                            </td>
                            <td class="py-4 px-6 text-center">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $role->name === 'teacher' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="py-4 px-6 text-center">
                                @php
                                    // Check direct permissions. Admin has all permissions automatically via gate or role, 
                                    // but here we check direct permission so we can toggle it.
                                    $hasView = false;
                                    try {
                                        $hasView = $user->hasPermissionTo($viewPermissionName);
                                    } catch(\Exception $e) {
                                        $hasView = false;
                                    }
                                @endphp
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="access[{{ $user->id }}][view]" value="1" class="sr-only peer" {{ $hasView ? 'checked' : '' }}>
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @php
                                    $hasEdit = false;
                                    try {
                                        $hasEdit = $user->hasPermissionTo($editPermissionName);
                                    } catch(\Exception $e) {
                                        $hasEdit = false;
                                    }
                                @endphp
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="access[{{ $user->id }}][edit]" value="1" class="sr-only peer" {{ $hasEdit ? 'checked' : '' }}>
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                </label>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                    <i class="fa-solid fa-users-slash text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada pengguna ditemukan</h3>
                                <p class="text-gray-500">Coba ubah kata kunci pencarian atau filter role.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($users->count() > 0)
            <div class="p-6 border-t border-gray-100 bg-gray-50/50 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="w-full md:w-auto">
                    {{ $users->links() }}
                </div>
                <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all shadow-sm shadow-green-600/20 flex items-center justify-center gap-2 hover:-translate-y-0.5">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Akses
                </button>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection
