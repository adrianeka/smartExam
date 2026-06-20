<aside id="sidebar"
       class="sidebar sidebar-expanded bg-white border-r border-gray-200 fixed left-0 top-0 h-full z-50 flex flex-col overflow-hidden">

    

    {{-- Hamburger --}}
    <div class="flex items-center gap-3 px-5 py-2.5">
        <button id="sidebarToggle"
                class="w-8 h-8 flex flex-col justify-center items-center gap-1.5 rounded hover:bg-gray-100 transition">
            <span class="block w-5 h-0.5 bg-gray-500 rounded transition-all duration-200" id="bar1"></span>
            <span class="block w-5 h-0.5 bg-gray-500 rounded transition-all duration-200" id="bar2"></span>
            <span class="block w-5 h-0.5 bg-gray-500 rounded transition-all duration-200" id="bar3"></span>
        </button>
        <span class="label-text text-sm font-medium text-gray-500 hidden sm:block">Menu</span>
    </div>
    {{-- Scrollable nav area --}}
    <div class="flex-1 overflow-y-auto overflow-x-hidden py-4 px-3">


        @php 
            try {
                $dynamicMenus = \App\Models\Menu::whereNull('parent_id')->orderBy('order')->with('children')->get();
            } catch (\Exception $e) {
                $dynamicMenus = collect();
            }
        @endphp

        @foreach($dynamicMenus as $menu)
            @if($menu->type === 'category')
                @php
                    $hasVisibleChildren = false;
                    foreach($menu->children as $childItem) {
                        if(!$childItem->permission_name || auth()->user()->hasPermissionTo($childItem->permission_name) || auth()->user()->hasRole('admin')) {
                            $hasVisibleChildren = true;
                            break;
                        }
                    }
                @endphp
                @if($hasVisibleChildren || auth()->user()->hasRole('admin'))
                    {{-- Render Category (Judul) --}}
                    <div class="my-3 border-t border-gray-100"></div>
                    <div class="group flex items-center justify-between px-2 mb-2 relative">
                        <p class="section-label text-[10px] font-bold text-gray-400 uppercase tracking-widest transition-all duration-200">{{ $menu->name }}</p>
                        @role('admin')
                        <div class="admin-actions absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity bg-white px-1.5 py-0.5 rounded shadow-sm border border-gray-100 z-10">
                            {{-- Settings (Discord Style) --}}
                            <a href="{{ route('admin.menus.settings', $menu->id) }}" class="text-gray-400 hover:text-gray-700 p-1" title="Pengaturan Kategori">
                                <i class="fa-solid fa-gear text-[10px]"></i>
                            </a>
                            {{-- Add Sub-Menu --}}
                            <a href="{{ route('admin.menus.create', ['item_type' => 'menu', 'parent_id' => $menu->id]) }}" class="text-gray-400 hover:text-blue-600 p-1" title="Tambah Menu di {{ $menu->name }}">
                                <i class="fa-solid fa-plus text-[10px]"></i>
                            </a>
                        </div>
                        @endrole
                    </div>

                    {{-- Render Menu Items within Category --}}
                    @foreach($menu->children as $childItem)
                        @if(!$childItem->permission_name || auth()->user()->hasPermissionTo($childItem->permission_name) || auth()->user()->hasRole('admin'))
                            @include('layouts.sidebar-item', ['item' => $childItem])
                        @endif
                    @endforeach
                @endif
            @else
                {{-- Check Permission (Admin selalu bisa lihat, atau user yang punya permission) --}}
                @if(!$menu->permission_name || auth()->user()->hasPermissionTo($menu->permission_name) || auth()->user()->hasRole('admin'))
                    {{-- Render Menu Items at Top Level (No Category) --}}
                    @include('layouts.sidebar-item', ['item' => $menu])
                @endif
            @endif
        @endforeach

        {{-- Quick Add Menu Button (Discord Style) --}}
        @role('admin')
        <a href="{{ route('admin.menus.create') }}" class="mt-2 nav-item flex items-center justify-center px-2 py-2 rounded-lg border-2 border-dashed border-gray-300 text-gray-400 hover:text-blue-500 hover:border-blue-400 hover:bg-blue-50 group transition-all mb-0.5" title="Tambah Menu Baru">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-plus text-[12px] group-hover:scale-110 transition-transform"></i>
                <span class="label-text text-xs font-medium">Tambah Menu Baru</span>
            </span>
        </a>
        
        @php $otherItems = [
            ['icon' => 'fa-solid fa-screwdriver-wrench', 'label' => 'Sistem', 'route' => 'dashboard'],
            ['icon' => 'fa-solid fa-key', 'label' => 'Keamanan & Privasi', 'route' => 'dashboard'],
        ]; @endphp

        @foreach($otherItems as $item)
        <a href="{{ route($item['route']) }}"
           class="nav-item flex items-center justify-between px-2 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 group transition-colors mb-0.5">
            <span class="flex items-center gap-3">
                <i class="{{ $item['icon'] }} icon w-5 text-center text-gray-400 group-hover:text-blue-500 transition-colors shrink-0"></i>
                <span class="label-text text-sm">{{ $item['label'] }}</span>
            </span>
            <i class="chevron-icon fa-solid fa-chevron-down text-[10px] text-gray-300 shrink-0"></i>
        </a>
        @endforeach
        @endrole
    </div>
</aside>