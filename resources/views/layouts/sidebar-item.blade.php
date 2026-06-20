@php
    $url = Str::startsWith($item->url, '/') ? url($item->url) : (Route::has($item->url) ? route($item->url) : $item->url);
    $isActiveDropdown = false;
    foreach($item->children as $child) {
        $childUrl = Str::startsWith($child->url, '/') ? url($child->url) : (Route::has($child->url) ? route($child->url) : $child->url);
        if(request()->url() == $childUrl || Str::startsWith(request()->url(), $childUrl)) {
            $isActiveDropdown = true;
            break;
        }
    }
@endphp
@if($item->children->count() > 0)
    <div x-data="{ open: {{ $isActiveDropdown ? 'true' : 'false' }} }" class="mb-0.5">
        <div @click="open = !open" class="cursor-pointer nav-item relative w-full flex items-center justify-between px-2 py-2.5 rounded-lg {{ $isActiveDropdown ? 'text-blue-600 bg-blue-50/50 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} group transition-colors">
            <span class="flex items-center gap-3">
                <i class="{{ $item->icon }} icon w-5 text-center text-gray-400 group-hover:text-blue-500 shrink-0 transition-colors"></i>
                <span class="label-text text-sm">{{ $item->name }}</span>
            </span>
            <div class="flex items-center gap-1">
                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="chevron-icon fa-solid text-[10px] text-gray-300 shrink-0 ml-1"></i>
            </div>
            @role('admin')
            <div class="admin-actions absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity bg-white px-1.5 py-0.5 rounded shadow-sm border border-gray-100 z-10" @click.stop>
                <a href="{{ route('admin.menus.settings', $item->id) }}" class="text-gray-400 hover:text-gray-700" title="Pengaturan Menu"><i class="fa-solid fa-gear text-[10px]"></i></a>
                <a href="{{ route('admin.menus.create', ['item_type' => 'menu', 'parent_id' => $item->id]) }}" class="text-gray-400 hover:text-blue-600" title="Tambah Sub-Menu di {{ $item->name }}"><i class="fa-solid fa-plus text-[10px]"></i></a>
            </div>
            @endrole
        </div>
        <div x-show="open" x-transition class="submenu mt-1 mb-1 space-y-0.5 label-text" style="display: none;">
            @foreach($item->children as $child)
                @if(!$child->permission_name || auth()->user()->hasPermissionTo($child->permission_name) || auth()->user()->hasRole('admin'))
                    @php
                        $childUrl = Str::startsWith($child->url, '/') ? url($child->url) : (Route::has($child->url) ? route($child->url) : $child->url);
                        $isChildActive = request()->url() == $childUrl || Str::startsWith(request()->url(), $childUrl);
                    @endphp
                    <div class="group/child relative flex items-center justify-between {{ $isChildActive ? 'bg-[#f0f9fa] border-l-2 border-[#0eb0e6]' : 'hover:bg-gray-50 border-l-2 border-transparent' }} transition">
                        <a href="{{ $childUrl }}" class="flex-1 py-2 pr-2 pl-[42px] text-sm {{ $isChildActive ? 'text-[#0eb0e6] font-medium' : 'text-gray-500 hover:text-gray-800' }} block">{{ $child->name }}</a>
                        @role('admin')
                        <div class="admin-actions absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-2 opacity-0 group-hover/child:opacity-100 transition-opacity bg-white px-1.5 py-0.5 rounded shadow-sm border border-gray-100 z-10">
                            <a href="{{ route('admin.menus.settings', $child->id) }}" class="text-gray-400 hover:text-gray-700 p-0.5" title="Pengaturan Menu"><i class="fa-solid fa-gear text-[10px]"></i></a>
                        </div>
                        @endrole
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@else
    <div class="group relative flex items-center justify-between {{ request()->url() == $url ? 'bg-blue-50 rounded-lg' : 'hover:bg-gray-50 rounded-lg' }} mb-0.5 transition-colors">
        <a href="{{ $url }}" class="nav-item flex-1 flex items-center px-2 py-2.5 text-gray-600 {{ request()->url() == $url ? 'text-blue-600 font-medium' : '' }}">
            <span class="flex items-center gap-3 w-full">
                <i class="{{ $item->icon }} icon w-5 text-center {{ request()->url() == $url ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors shrink-0"></i>
                <span class="label-text text-sm truncate">{{ $item->name }}</span>
            </span>
        </a>
        @role('admin')
        <div class="admin-actions absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity bg-white px-1.5 py-0.5 rounded shadow-sm border border-gray-100 z-10">
            <a href="{{ route('admin.menus.settings', $item->id) }}" class="text-gray-400 hover:text-gray-700 p-1" title="Pengaturan Menu"><i class="fa-solid fa-gear text-[10px]"></i></a>
            <a href="{{ route('admin.menus.create', ['item_type' => 'menu', 'parent_id' => $item->id]) }}" class="text-gray-400 hover:text-blue-600 p-1" title="Tambah Sub-Menu"><i class="fa-solid fa-plus text-[10px]"></i></a>
        </div>
        @endrole
    </div>
@endif
