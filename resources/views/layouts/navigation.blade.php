<nav id="topNav" class="bg-white border-b border-gray-200 fixed top-0 right-0 z-40 h-16 w-full flex items-center justify-between px-5 transition-all duration-250"
     style="">

    {{-- Logo  --}}
    <div class="h-16 flex items-center px-5 border-b border-gray-100 shrink-0 gap-3">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
    </div>


    {{-- Right: Bell + User --}}
    <div class="flex items-center gap-4">
        {{-- Notification Bell --}}
        <div class="relative">
            <button class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition">
                <i class="fa-regular fa-bell text-base"></i>
            </button>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1">99+</span>
        </div>

        {{-- User Avatar + Info + Dropdown --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                    class="flex items-center gap-3 px-2 py-1.5 rounded-lg hover:bg-gray-50 transition">
                <div class="w-9 h-9 rounded-full bg-gray-200 overflow-hidden flex items-center justify-center">
                    <i class="fa-regular fa-user text-gray-400 text-base"></i>
                </div>
                <div class="hidden sm:flex flex-col items-start leading-tight">
                    <span class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</span>
                    <span class="text-[11px] text-white bg-blue-500 rounded px-1.5 py-0.5 font-medium mt-0.5">{{ ucfirst(Auth::user()->roles->first()?->name ?? Auth::user()->role ?? 'siswa') }}</span>
                </div>
                <i class="fa-solid fa-chevron-down text-gray-400 text-xs hidden sm:block"></i>
            </button>

            {{-- Dropdown --}}
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.outside="open = false"
                 class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                    <i class="fa-regular fa-user w-4 text-gray-400"></i> Profile
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50">
                        <i class="fa-solid fa-right-from-bracket w-4"></i> Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>