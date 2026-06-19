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
                ['icon' => 'fa-solid fa-book', 'label' => 'Mata Kuliah Saya', 'route' => 'learning.courses'],
                ['icon' => 'fa-regular fa-calendar', 'label' => 'Aktivitas Pembelajaran', 'route' => 'learning.activities'],
                ['icon' => 'fa-solid fa-clipboard-check', 'label' => 'Evaluasi', 'route' => 'learning.evaluations'],
                ['icon' => 'fa-solid fa-file-lines', 'label' => 'Laporan', 'route' => 'learning.reports'],
            ]; @endphp

            @foreach($pembelajaranItems as $item)
            <a href="{{ route($item['route']) }}"
               class="nav-item flex items-center justify-between px-2 py-2.5 rounded-lg {{ request()->routeIs($item['route']) ? 'bg-blue-50 text-blue-600 font-medium relative before:absolute before:left-0 before:top-2 before:bottom-2 before:w-1 before:bg-blue-600 before:rounded-r-full' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group transition-colors mb-0.5">
                <span class="flex items-center gap-3">
                    <i class="{{ $item['icon'] }} icon w-5 text-center {{ request()->routeIs($item['route']) ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors shrink-0"></i>
                    <span class="label-text text-sm">{{ $item['label'] }}</span>
                </span>
                <i class="chevron-icon fa-solid fa-chevron-right text-[10px] text-gray-300 shrink-0"></i>
            </a>
            @endforeach
        </div>



        {{-- Divider --}}
        @role('admin')
        <div class="my-3 border-t border-gray-100"></div>

        {{-- Section: Administrasi Platform --}}
        <p class="section-label text-[10px] font-bold text-gray-400 uppercase tracking-widest px-2 mb-2 transition-all duration-200">Administrasi Platform</p>

        {{-- Manajemen Pengguna --}}
        <div x-data="{ open: {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.user.*') || request()->routeIs('admin.roles.*') ? 'true' : 'false' }} }" class="mb-0.5">
            <button @click="open = !open"
                    class="nav-item w-full flex items-center justify-between px-2 py-2.5 rounded-lg {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.user.*') || request()->routeIs('admin.roles.*') ? 'text-blue-600 bg-blue-50/60 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} group transition-colors">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-layer-group icon w-5 text-center {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.user.*') || request()->routeIs('admin.roles.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} shrink-0 transition-colors"></i>
                    <span class="label-text text-sm">Manajemen Pengguna</span>
                </span>
                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                   class="chevron-icon fa-solid text-[10px] {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.user.*') || request()->routeIs('admin.roles.*') ? 'text-blue-400' : 'text-gray-300' }} shrink-0"></i>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="submenu mt-1 mb-1 space-y-0.5 label-text">
                <a href="{{ route('admin.users.index') }}" class="block py-2 pr-2 pl-[42px] text-sm {{ request()->routeIs('admin.users.index') ? 'text-[#0eb0e6] font-medium bg-[#f0f9fa] border-l-2 border-[#0eb0e6]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800 border-l-2 border-transparent' }} transition">Daftar Pengguna</a>
                <a href="{{ route('admin.roles.index') }}" class="block py-2 pr-2 pl-[42px] text-sm {{ request()->routeIs('admin.roles.index') ? 'text-[#0eb0e6] font-medium bg-[#f0f9fa] border-l-2 border-[#0eb0e6]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800 border-l-2 border-transparent' }} transition">Daftar Role</a>
                <a href="{{ route('admin.user.create') ?? '#' }}" class="block py-2 pr-2 pl-[42px] text-sm {{ request()->routeIs('admin.user.create') ? 'text-[#0eb0e6] font-medium bg-[#f0f9fa] border-l-2 border-[#0eb0e6]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800 border-l-2 border-transparent' }} transition">Tambah Pengguna</a>
            </div>
        </div>

        {{-- Manajemen Mata Kuliah --}}
        <div x-data="{ open: {{ request()->routeIs('admin.courses.*') || request()->routeIs('admin.enroll.*') || request()->routeIs('admin.session-categories.*') ? 'true' : 'false' }} }" class="mb-0.5">
            <button @click="open = !open"
                    class="nav-item w-full flex items-center justify-between px-2 py-2.5 rounded-lg {{ request()->routeIs('admin.courses.*') || request()->routeIs('admin.enroll.*') || request()->routeIs('admin.session-categories.*') ? 'text-blue-600 bg-blue-50/60 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} group transition-colors">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-folder-open icon w-5 text-center {{ request()->routeIs('admin.courses.*') || request()->routeIs('admin.enroll.*') || request()->routeIs('admin.session-categories.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} shrink-0 transition-colors"></i>
                    <span class="label-text text-sm">Manajemen Mata Kuliah</span>
                </span>
                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                   class="chevron-icon fa-solid text-[10px] {{ request()->routeIs('admin.courses.*') || request()->routeIs('admin.enroll.*') || request()->routeIs('admin.session-categories.*') ? 'text-blue-400' : 'text-gray-300' }} shrink-0"></i>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="submenu mt-1 mb-1 space-y-0.5 label-text">
                <a href="{{ route('admin.courses.index') }}" class="block py-2 pr-2 pl-[42px] text-sm {{ request()->routeIs('admin.courses.index') ? 'text-[#0eb0e6] font-medium bg-[#f0f9fa] border-l-2 border-[#0eb0e6]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800 border-l-2 border-transparent' }} transition">Daftar Mata Kuliah</a>
                <a href="{{ route('admin.enroll.create') }}" class="block py-2 pr-2 pl-[42px] text-sm {{ request()->routeIs('admin.enroll.create') ? 'text-[#0eb0e6] font-medium bg-[#f0f9fa] border-l-2 border-[#0eb0e6]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800 border-l-2 border-transparent' }} transition">Daftar Sesi</a>
                <a href="{{ route('admin.session-categories.index') }}" class="block py-2 pr-2 pl-[42px] text-sm {{ request()->routeIs('admin.session-categories.index') ? 'text-[#0eb0e6] font-medium bg-[#f0f9fa] border-l-2 border-[#0eb0e6]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800 border-l-2 border-transparent' }} transition">Kategori Sesi</a>
            </div>
        </div>

        {{-- Pengaturan Platform --}}
        <div x-data="{ open: {{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }} }" class="mb-0.5">
            <button @click="open = !open"
                    class="nav-item w-full flex items-center justify-between px-2 py-2.5 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'text-blue-600 bg-blue-50/60 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} group transition-colors">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-gear icon w-5 text-center {{ request()->routeIs('admin.reports.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} shrink-0 transition-colors"></i>
                    <span class="label-text text-sm">Pengaturan Platform</span>
                </span>
                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                   class="chevron-icon fa-solid text-[10px] {{ request()->routeIs('admin.reports.*') ? 'text-blue-400' : 'text-gray-300' }} shrink-0"></i>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="submenu mt-1 mb-1 space-y-0.5 label-text">
                <a href="{{ route('admin.reports.index') }}" class="block py-2 pr-2 pl-[42px] text-sm {{ request()->routeIs('admin.reports.index') ? 'text-[#0eb0e6] font-medium bg-[#f0f9fa] border-l-2 border-[#0eb0e6]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800 border-l-2 border-transparent' }} transition">Laporan</a>
            </div>
        </div>

        {{-- Sistem & Keamanan --}}
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