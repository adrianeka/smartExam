<x-app-layout>
    <div class="bg-gray-50 text-gray-700 font-sans min-h-screen">
        <main class="flex-1 p-8">
            <!-- Breadcrumbs -->
            <nav class="text-xs text-gray-500 flex items-center space-x-2 mb-6">
                <i class="fa-solid fa-house"></i>
                <span>Administrasi Platform</span>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <a href="{{ route('admin.users.index') }}" class="hover:text-blue-500 transition">Daftar Pengguna</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-blue-500 font-medium">{{ $user->name }}</span>
            </nav>

            <!-- User Header Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8 relative">
                
                <!-- Dropdown Top Right -->
                <div x-data="{ open: false }" class="absolute top-6 right-6">
                    <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div x-show="open" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-20" style="display: none;">
                        <div class="px-4 py-2 text-xs font-semibold text-gray-400 mb-1">Dropdown Export Option</div>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"><i class="fa-solid fa-print w-5 text-center mr-2 text-blue-500"></i> Cetak</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"><i class="fa-solid fa-file-csv w-5 text-center mr-2 text-blue-500"></i> Ekspor Sebagai File CSV</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"><i class="fa-solid fa-file-excel w-5 text-center mr-2 text-blue-500"></i> Ekspor Sebagai File XLS</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"><i class="fa-solid fa-file-pdf w-5 text-center mr-2 text-blue-500"></i> Ekspor Sebagai File PDF</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"><i class="fa-regular fa-envelope w-5 text-center mr-2 text-blue-500"></i> Kirim Email</a>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Left: Profile Info -->
                    <div class="flex items-center gap-6 md:w-1/3">
                        <div class="w-24 h-24 rounded-full bg-gray-200 overflow-hidden shrink-0 border-4 border-white shadow-sm">
                            @if($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="Profile" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold tracking-wide uppercase border border-emerald-200">Daring</span>
                            </div>
                            <p class="text-gray-500 font-medium text-sm">{{ ucfirst($user->roleName() ?? 'Pengguna') }}</p>
                        </div>
                    </div>

                    <!-- Right: Details Grid -->
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 border-t md:border-t-0 md:border-l border-gray-100 pt-6 md:pt-0 md:pl-8">
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Kode:</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $user->user_code ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">No. Telp:</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $user->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Email:</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Login Pertama Kali di Platform:</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $user->first_login_at ? $user->first_login_at->format('d M y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Login Terakhir di Platform:</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $user->last_login_at ? $user->last_login_at->format('d M y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Login Terakhir di Mata Kuliah:</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $user->last_course_login_at ? $user->last_course_login_at->format('d M y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->hasRole('teacher'))
            <!-- List Sesi Table Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 flex-1">List Sesi <span class="ml-4 flex-1 h-px bg-gray-100 inline-block align-middle w-48"></span></h3>
                    <div class="flex items-center gap-2 text-xs text-gray-500 cursor-pointer hover:text-gray-700 transition">
                        <span>Tampilkan 10 Data</span>
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-blue-500 text-xs font-semibold bg-gray-50/50">
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Kode Mata Kuliah</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Judul <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Status <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Waktu Dihabiskan<br>Dalam Mata Kuliah <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Total Post Di<br>Semua Forum <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                            @forelse($user->courses as $course)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 font-bold text-gray-800">{{ $course->code ?? '-' }}</td>
                                <td class="py-4 px-6 font-medium text-gray-600">{{ $course->name }}</td>
                                <td class="py-4 px-6">{{ ucfirst($user->roleName() ?? 'Pengajar') }}</td>
                                <td class="py-4 px-6">
                                    @php
                                        $seconds = $course->pivot->time_spent_seconds ?? 0;
                                        echo sprintf('%02d:%02d:%02d', ($seconds/3600),($seconds/60%60), $seconds%60);
                                    @endphp
                                </td>
                                <td class="py-4 px-6">{{ $course->pivot->total_posts ?? '0' }}</td>
                                <td class="py-4 px-6 text-center">
                                    <div x-data="{ open: false }" class="relative inline-block">
                                        <button @click="open = !open" @click.away="open = false" class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 hover:bg-blue-100 hover:text-blue-600 transition flex items-center justify-center">
                                            <i class="fa-regular fa-eye"></i>
                                            <i class="fa-solid fa-chevron-down text-[8px] ml-1"></i>
                                        </button>
                                        
                                        <!-- Action Dropdown -->
                                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-20 text-left" style="display: none;">
                                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 mb-1">Dropdown Export Option</div>
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"><i class="fa-solid fa-book-open w-5 text-center mr-2 text-blue-500"></i> Situs Mata Kuliah</a>
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"><i class="fa-solid fa-chart-pie w-5 text-center mr-2 text-blue-500"></i> Statistik</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">Belum ada sesi mengajar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Footer -->
                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 text-xs text-gray-500">
                    <div class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-1.5 hover:bg-gray-50 cursor-pointer transition">
                        Tampilkan 1 s.d. 10 <i class="fa-solid fa-chevron-down ml-2 text-[10px]"></i>
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="w-7 h-7 rounded bg-teal-100 text-teal-600 font-semibold flex items-center justify-center">1</button>
                    </div>
                </div>
            </div>

            <!-- List Mata Kuliah Table Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 flex-1">List Mata Kuliah <span class="ml-4 flex-1 h-px bg-gray-100 inline-block align-middle w-48"></span></h3>
                    <div class="flex items-center gap-2 text-xs text-gray-500 cursor-pointer hover:text-gray-700 transition">
                        <span>Tampilkan 10 Data</span>
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-blue-500 text-xs font-semibold bg-gray-50/50">
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Kode Mata Kuliah</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Judul <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Status <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Waktu Dihabiskan<br>Dalam Mata Kuliah <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Total Post Di<br>Semua Forum <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                            @forelse($user->courses as $course)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 font-bold text-gray-800">{{ $course->code ?? '-' }}</td>
                                <td class="py-4 px-6 font-medium text-gray-600">{{ $course->name }}</td>
                                <td class="py-4 px-6">{{ ucfirst($user->roleName() ?? 'Pengajar') }}</td>
                                <td class="py-4 px-6">
                                    @php
                                        $seconds = $course->pivot->time_spent_seconds ?? 0;
                                        echo sprintf('%02d:%02d:%02d', ($seconds/3600),($seconds/60%60), $seconds%60);
                                    @endphp
                                </td>
                                <td class="py-4 px-6">{{ $course->pivot->total_posts ?? '0' }}</td>
                                <td class="py-4 px-6 text-center">
                                    <div x-data="{ open: false }" class="relative inline-block">
                                        <button @click="open = !open" @click.away="open = false" class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 hover:bg-blue-100 hover:text-blue-600 transition flex items-center justify-center">
                                            <i class="fa-regular fa-eye"></i>
                                            <i class="fa-solid fa-chevron-down text-[8px] ml-1"></i>
                                        </button>
                                        
                                        <!-- Action Dropdown -->
                                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-20 text-left" style="display: none;">
                                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 mb-1">Dropdown Export Option</div>
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"><i class="fa-solid fa-book-open w-5 text-center mr-2 text-blue-500"></i> Situs Mata Kuliah</a>
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"><i class="fa-solid fa-chart-pie w-5 text-center mr-2 text-blue-500"></i> Statistik</a>
                                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition"><i class="fa-regular fa-trash-can w-5 text-center mr-2"></i> Hapus Mata Kuliah</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">Belum ada mata kuliah.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Footer -->
                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 text-xs text-gray-500">
                    <div class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-1.5 hover:bg-gray-50 cursor-pointer transition">
                        Tampilkan 1 s.d. 10 <i class="fa-solid fa-chevron-down ml-2 text-[10px]"></i>
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="w-7 h-7 rounded bg-teal-100 text-teal-600 font-semibold flex items-center justify-center">1</button>
                    </div>
                </div>
            </div>
            @else
            <!-- Laporan Peserta Didik Table Card (For Admin/Student) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-800">Mata Kuliah</h3>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 transition">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-20 text-left" style="display: none;">
                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 mb-1">Dropdown Export Option</div>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"><i class="fa-solid fa-file-csv w-5 text-center mr-2 text-blue-500"></i> Ekspor Sebagai File CSV</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"><i class="fa-solid fa-file-excel w-5 text-center mr-2 text-blue-500"></i> Ekspor Sebagai File XLS</a>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-blue-500 text-xs font-semibold bg-gray-50/50">
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Mata Kuliah</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Waktu</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Progres</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Nilai</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Tidak Hadir</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap">Evaluasi</th>
                                <th class="py-4 px-6 font-semibold whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                            @forelse($user->courses as $course)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 font-medium text-gray-600">{{ $course->name }}</td>
                                <td class="py-4 px-6">
                                    @php
                                        $seconds = $course->pivot->time_spent_seconds ?? 0;
                                        echo sprintf('%02d:%02d:%02d', ($seconds/3600),($seconds/60%60), $seconds%60);
                                    @endphp
                                </td>
                                <td class="py-4 px-6">{{ $course->pivot->progress ?? '0' }}%</td>
                                <td class="py-4 px-6">{{ $course->pivot->result ?? '0' }}%</td>
                                <td class="py-4 px-6 text-gray-400">0/0 (0%)</td>
                                <td class="py-4 px-6 text-gray-400">0/0 (0%)</td>
                                <td class="py-4 px-6 text-center">
                                    <button class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 hover:bg-blue-100 hover:text-blue-600 transition flex items-center justify-center mx-auto">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400">Belum ada mata kuliah yang diikuti.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($user->courses->count() > 0)
                        <tfoot>
                            <tr class="font-bold text-gray-800 bg-gray-50/50">
                                <td class="py-4 px-6">Total</td>
                                <td class="py-4 px-6">
                                    @php
                                        $totalSeconds = $user->courses->sum('pivot.time_spent_seconds');
                                        echo sprintf('%02d:%02d:%02d', ($totalSeconds/3600),($totalSeconds/60%60), $totalSeconds%60);
                                    @endphp
                                </td>
                                <td class="py-4 px-6">{{ number_format($user->courses->avg('pivot.progress') ?? 0, 0) }}%</td>
                                <td class="py-4 px-6">{{ number_format($user->courses->avg('pivot.result') ?? 0, 0) }}%</td>
                                <td class="py-4 px-6">0/0 (0%)</td>
                                <td class="py-4 px-6">0/0 (0%)</td>
                                <td class="py-4 px-6"></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
            @endif

            <footer class="mt-8 text-xs text-gray-400 flex justify-between">
                <p>&copy; 2026 Smart Exam | All rights reserved.</p>
                <div class="space-x-4">
                    <a href="#" class="hover:underline">Cara Kerja</a>
                    <a href="#" class="hover:underline">Pusat Bantuan</a>
                    <a href="#" class="hover:underline">Hubungi Kami</a>
                </div>
            </footer>
        </main>
    </div>
</x-app-layout>
