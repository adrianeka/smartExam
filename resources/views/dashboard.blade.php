<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl shadow-lg p-8 mb-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-2">Selamat datang, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-blue-50 text-lg">
                        @role('admin')
                            Anda login sebagai <span class="font-semibold bg-white/20 px-2 py-1 rounded">Administrator</span>. Berikut ringkasan sistem hari ini.
                        @elserole('teacher')
                            Anda login sebagai <span class="font-semibold bg-white/20 px-2 py-1 rounded">Dosen</span>. Pantau terus perkembangan mata kuliah Anda.
                        @elserole('student')
                            Anda login sebagai <span class="font-semibold bg-white/20 px-2 py-1 rounded">Siswa</span>. Mari lanjutkan proses belajarmu hari ini!
                        @else
                            Akun Anda belum mendapatkan hak akses penuh.
                        @endrole
                    </p>
                </div>
                {{-- Decorative circles --}}
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-2xl"></div>
                <div class="absolute top-12 right-12 w-32 h-32 bg-white opacity-10 rounded-full blur-xl"></div>
            </div>

            {{-- Dashboard Stats (RBAC Logic) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @role('admin')
                    {{-- Admin Stats --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition">
                        <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center text-blue-500 text-2xl">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pengguna</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['users_count'] ?? 0 }}</h3>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition">
                        <div class="w-14 h-14 bg-orange-50 rounded-full flex items-center justify-center text-orange-500 text-2xl">
                            <i class="fa-solid fa-user-clock"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Menunggu Persetujuan</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['pending_count'] ?? 0 }}</h3>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition">
                        <div class="w-14 h-14 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-500 text-2xl">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Mata Kuliah</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['courses_count'] ?? 0 }}</h3>
                        </div>
                    </div>
                @elserole('teacher')
                    {{-- Teacher Stats --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition">
                        <div class="w-14 h-14 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-500 text-2xl">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Mata Kuliah Diampu</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['courses_count'] ?? 0 }}</h3>
                        </div>
                    </div>
                @elserole('student')
                    {{-- Student Stats --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition">
                        <div class="w-14 h-14 bg-green-50 rounded-full flex items-center justify-center text-green-500 text-2xl">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Mata Kuliah Diikuti</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['courses_count'] ?? 0 }}</h3>
                        </div>
                    </div>
                @endrole
            </div>
            
            {{-- Extra Layout Space --}}
            <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center text-gray-400">
                <i class="fa-solid fa-chart-line text-4xl mb-3 text-gray-200"></i>
                <p>Aktivitas terbaru akan muncul di sini</p>
            </div>

        </div>
    </div>
</x-app-layout>
