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

        {{-- Section: Pembelajaran --}}
        <p class="section-label text-[10px] font-bold text-gray-400 uppercase tracking-widest px-2 mb-2 transition-all duration-200">Pembelajaran</p>

        <div class="mb-1">
            @php $pembelajaranItems = [
                ['icon' => 'fa-solid fa-book', 'label' => 'Mata Kuliah Saya'],
                ['icon' => 'fa-regular fa-calendar', 'label' => 'Aktivitas Pembelajaran'],
                ['icon' => 'fa-solid fa-clipboard-check', 'label' => 'Evaluasi'],
                ['icon' => 'fa-solid fa-file-lines', 'label' => 'Laporan'],
            ]; @endphp

            @foreach($pembelajaranItems as $item)
            <a href="#"
               class="nav-item flex items-center justify-between px-2 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 group transition-colors mb-0.5">
                <span class="flex items-center gap-3">
                    <i class="{{ $item['icon'] }} icon w-5 text-center text-gray-400 group-hover:text-blue-500 transition-colors shrink-0"></i>
                    <span class="label-text text-sm">{{ $item['label'] }}</span>
                </span>
                <i class="chevron-icon fa-solid fa-chevron-down text-[10px] text-gray-300 shrink-0"></i>
            </a>
            @endforeach
        </div>

        {{-- Divider --}}
        <div class="my-3 border-t border-gray-100"></div>

        {{-- Section: Administrasi Platform --}}
        <p class="section-label text-[10px] font-bold text-gray-400 uppercase tracking-widest px-2 mb-2 transition-all duration-200">Administrasi Platform</p>

        {{-- Manajemen Pengguna (expanded by default) --}}
        <div x-data="{ open: true }" class="mb-0.5">
            <button @click="open = !open"
                    class="nav-item w-full flex items-center justify-between px-2 py-2.5 rounded-lg text-blue-600 bg-blue-50/60 font-semibold group transition-colors">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-layer-group icon w-5 text-center text-blue-500 shrink-0"></i>
                    <span class="label-text text-sm">Manajemen Pengguna</span>
                </span>
                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                   class="chevron-icon fa-solid text-[10px] text-blue-400 shrink-0"></i>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="submenu ml-4 pl-4 border-l-2 border-blue-500 mt-1 mb-1 space-y-0.5 label-text">
                <a href="#" class="block py-2 px-2 text-sm text-blue-600 font-medium rounded hover:bg-blue-50 transition">Daftar Pengguna</a>
                <a href="#" class="block py-2 px-2 text-sm text-gray-500 rounded hover:bg-gray-50 hover:text-gray-800 transition">Impor Pengguna (XML/CSV)</a>
                <a href="#" class="block py-2 px-2 text-sm text-gray-500 rounded hover:bg-gray-50 hover:text-gray-800 transition">Ekspor Pengguna</a>
                <a href="#" class="block py-2 px-2 text-sm text-gray-500 rounded hover:bg-gray-50 hover:text-gray-800 transition">Profiling</a>
                <a href="#" class="block py-2 px-2 text-sm text-gray-500 rounded hover:bg-gray-50 hover:text-gray-800 transition">Kelas</a>
            </div>
        </div>

        {{-- Other admin items --}}
        @php $adminItems = [
            ['icon' => 'fa-solid fa-folder-open', 'label' => 'Manajemen Mata Kuliah'],
            ['icon' => 'fa-solid fa-gear', 'label' => 'Pengaturan Platform'],
            ['icon' => 'fa-solid fa-screwdriver-wrench', 'label' => 'Sistem'],
            ['icon' => 'fa-solid fa-key', 'label' => 'Keamanan & Privasi'],
        ]; @endphp

        @foreach($adminItems as $item)
        <a href="#"
           class="nav-item flex items-center justify-between px-2 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 group transition-colors mb-0.5">
            <span class="flex items-center gap-3">
                <i class="{{ $item['icon'] }} icon w-5 text-center text-gray-400 group-hover:text-blue-500 transition-colors shrink-0"></i>
                <span class="label-text text-sm">{{ $item['label'] }}</span>
            </span>
            <i class="chevron-icon fa-solid fa-chevron-down text-[10px] text-gray-300 shrink-0"></i>
        </a>
        @endforeach

    </div>
</aside>