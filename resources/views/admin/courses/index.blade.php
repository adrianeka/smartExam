<x-app-layout>
    <div class="bg-gray-50 text-gray-700 font-sans min-h-screen pb-12" x-data="{ activeTab: 'standar', advancedSearch: false }">
        <main class="flex-1 p-8">
            <!-- Breadcrumbs -->
            <nav class="text-xs text-gray-500 flex items-center space-x-2 mb-6">
                <a href="#" class="hover:text-blue-500 transition"><i class="fa-solid fa-home"></i></a>
                <span>&gt;</span>
                <a href="#" class="hover:text-blue-500 transition">Administrasi Platform</a>
                <span>&gt;</span>
                <span class="text-blue-500 font-semibold">Daftar Mata Kuliah</span>
            </nav>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <!-- Header -->
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Daftar Mata Kuliah</h2>
                        <p class="text-sm text-gray-500 max-w-3xl">Kelola seluruh mata kuliah di Smart Exam.</p>
                    </div>
                    <a href="{{ route('admin.courses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-plus"></i> Tambah Mata Kuliah
                    </a>
                </div>

                <!-- Tabs -->
                <div class="flex border-b border-gray-200 mb-6">
                    <button @click="activeTab = 'standar'" :class="{'text-blue-600 border-blue-600': activeTab === 'standar', 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300': activeTab !== 'standar'}" class="px-6 py-3 font-semibold text-sm border-b-2 transition">
                        List Standar
                    </button>
                    <button @click="activeTab = 'manajemen'" :class="{'text-blue-600 border-blue-600': activeTab === 'manajemen', 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300': activeTab !== 'manajemen'}" class="px-6 py-3 font-semibold text-sm border-b-2 transition">
                        List Manajemen
                    </button>
                </div>

                <!-- Search Area -->
                <div class="mb-8">
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Telusuri</label>
                    <form action="{{ route('admin.courses.index') }}" method="GET" class="flex items-center gap-4">
                        <input type="hidden" name="activeTab" x-model="activeTab">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Masukkan nama mata kuliah" class="w-full border border-gray-200 rounded-lg pl-4 pr-10 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-gray-700 placeholder-gray-400">
                        </div>
                        <button type="button" @click="advancedSearch = !advancedSearch" class="w-10 h-10 rounded-lg border border-gray-200 bg-cyan-100/50 text-cyan-600 flex items-center justify-center hover:bg-cyan-100 transition shadow-sm" :class="{'bg-cyan-200 text-cyan-700': advancedSearch}">
                            <i class="fa-solid fa-sliders"></i>
                        </button>
                        <button type="submit" class="bg-cyan-100/50 hover:bg-cyan-100 text-cyan-600 px-6 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2 border border-cyan-100 shadow-sm">
                            <i class="fa-solid fa-magnifying-glass"></i> Telusuri
                        </button>
                    </form>
                </div>

                <!-- Advanced Search Form -->
                <div x-show="advancedSearch" x-transition class="mb-8 border border-gray-100 rounded-xl p-6 bg-gray-50/30" style="display: {{ request()->hasAny(['name','code','category','language','access_type']) ? 'block' : 'none' }};">
                    <form action="{{ route('admin.courses.index') }}" method="GET">
                        <input type="hidden" name="activeTab" x-model="activeTab">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center">
                            Advanced Search <span class="ml-4 flex-1 h-px bg-gray-200 inline-block align-middle"></span>
                        </h4>
                        <div class="grid grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-2">Judul</label>
                                <input type="text" name="name" value="{{ request('name') }}" placeholder="Masukkan judul mata kuliah" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-2">Kode</label>
                                <input type="text" name="code" value="{{ request('code') }}" placeholder="Masukkan kode mata kuliah" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-2">Kategori Mata Kuliah</label>
                                <select name="category" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white">
                                    <option value="">Pilih kategori mata kuliah</option>
                                    <option value="Programming" {{ request('category') == 'Programming' ? 'selected' : '' }}>Programming</option>
                                    <option value="Language" {{ request('category') == 'Language' ? 'selected' : '' }}>Language</option>
                                    <option value="Science" {{ request('category') == 'Science' ? 'selected' : '' }}>Science</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-2">Bahasa Mata Kuliah</label>
                                <select name="language" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white">
                                    <option value="">Semua</option>
                                    <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English</option>
                                    <option value="Bahasa Indonesia" {{ request('language') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-2">Akses Mata Kuliah</label>
                                <select name="access_type" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white">
                                    <option value="">Semua</option>
                                    <option value="public" {{ request('access_type') == 'public' ? 'selected' : '' }}>Publik</option>
                                    <option value="private" {{ request('access_type') == 'private' ? 'selected' : '' }}>Pribadi</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-2">Pendaftar</label>
                                <select class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white">
                                    <option value="">Semua</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-2">Berhenti Berlangganan</label>
                                <select class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white">
                                    <option value="">Semua</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin.courses.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 transition px-4 py-2 flex items-center gap-2">
                                <i class="fa-solid fa-rotate-right"></i> Atur Ulang
                            </a>
                            <button type="submit" class="bg-cyan-100/50 hover:bg-cyan-100 text-cyan-600 px-6 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2 border border-cyan-100 shadow-sm">
                                <i class="fa-solid fa-magnifying-glass"></i> Telusuri
                            </button>
                        </div>
                    </form>
                </div>

                <!-- List Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 mt-6 gap-4">
                    <div class="flex items-center gap-3">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center">List</h3>
                        <div class="h-4 w-px bg-gray-200"></div>
                        <div class="flex items-center gap-2">
                            <select id="bulkActionSelect" class="border border-gray-200 rounded-lg text-sm pl-3 pr-8 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700 bg-white">
                                <option value="">Aksi Massal...</option>
                                <option value="delete">Hapus Terpilih</option>
                            </select>
                            <button type="button" onclick="executeBulkAction()" id="bulkActionBtn" class="bg-gray-100 text-gray-500 px-3 py-1.5 rounded-lg text-sm font-semibold transition opacity-50 cursor-not-allowed">Terapkan</button>
                        </div>
                    </div>
                    <div class="ml-auto flex-1 h-px bg-gray-200 inline-block align-middle hidden sm:block mx-4"></div>
                    <div class="flex items-center gap-2 text-xs text-gray-500 cursor-pointer hover:text-gray-700 transition whitespace-nowrap bg-white px-3 py-1.5 border border-gray-200 rounded-lg shadow-sm">
                        <span>Tampilkan {{ $courses->perPage() }} Data</span>
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>

                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                <!-- List Standar Table -->
                <div x-show="activeTab === 'standar'" x-transition class="overflow-x-auto pb-4">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-blue-500 text-xs font-bold border-b border-gray-100">
                                <th class="py-4 px-4 w-10 text-center"><input type="checkbox" onclick="toggleAllCheckboxes(this)" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></th>
                                <th class="py-4 px-4 whitespace-nowrap cursor-pointer hover:text-blue-600">Judul</th>
                                <th class="py-4 px-4 whitespace-nowrap cursor-pointer hover:text-blue-600">Bahasa <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-4 whitespace-nowrap cursor-pointer hover:text-blue-600">Kategori <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-4 whitespace-nowrap cursor-pointer hover:text-blue-600 text-center">Terdaftar<br>Diizinkan <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-4 whitespace-nowrap cursor-pointer hover:text-blue-600 text-center">Tidak Terdaftar<br>Diizinkan <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-4 whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                            @forelse($courses as $course)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="py-3 px-4 text-center"><input type="checkbox" value="{{ $course->id }}" onchange="updateBulkActionButton()" class="rounded border-gray-300 text-blue-600 shadow-sm row-checkbox"></td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-gray-800">{{ $course->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-semibold uppercase">{{ $course->code }}</div>
                                </td>
                                <td class="py-3 px-4">{{ $course->language ?? '-' }}</td>
                                <td class="py-3 px-4">{{ $course->category ?? '-' }}</td>
                                <td class="py-3 px-4 text-center">
                                    @if($course->is_registered_allowed)
                                    <span class="bg-green-100/50 text-green-600 px-3 py-1 rounded-full text-xs font-semibold border border-green-200">Ya</span>
                                    @else
                                    <span class="bg-red-100/50 text-red-500 px-3 py-1 rounded-full text-xs font-semibold border border-red-200">Tidak</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($course->is_unregistered_allowed)
                                    <span class="bg-green-100/50 text-green-600 px-3 py-1 rounded-full text-xs font-semibold border border-green-200">Ya</span>
                                    @else
                                    <span class="bg-red-100/50 text-red-500 px-3 py-1 rounded-full text-xs font-semibold border border-red-200">Tidak</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                        <div class="flex items-center justify-center bg-blue-50 text-blue-500 rounded-full px-2 py-1 cursor-pointer hover:bg-blue-100 transition" @click="open = !open" @click.away="open = false">
                                            <i class="fa-regular fa-eye text-xs"></i>
                                            <i class="fa-solid fa-chevron-down text-[8px] ml-1.5"></i>
                                        </div>
                                        
                                        <!-- Action Dropdown -->
                                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] border border-gray-100 py-2 z-20" style="display: none;">
                                            <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition font-medium"><i class="fa-solid fa-arrow-up-right-from-square w-5 text-center mr-2 text-blue-500"></i> Situs Mata Kuliah</a>
                                            <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition font-medium"><i class="fa-solid fa-magnifying-glass w-5 text-center mr-2 text-blue-500"></i> Penelusuran</a>
                                            <a href="{{ route('admin.courses.show', $course) }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition font-medium"><i class="fa-solid fa-book-open w-5 text-center mr-2 text-blue-500"></i> Kelola Konten & Ujian</a>
                                            <a href="{{ route('admin.courses.edit', $course) }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition font-medium"><i class="fa-regular fa-pen-to-square w-5 text-center mr-2 text-blue-500"></i> Ubah Mata Kuliah</a>
                                            <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition font-medium"><i class="fa-solid fa-box-archive w-5 text-center mr-2 text-blue-500"></i> Buat Cadangan</a>
                                            <div class="h-px bg-gray-100 my-1"></div>
                                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full text-left block px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition font-medium"><i class="fa-regular fa-trash-can w-5 text-center mr-2"></i> Hapus Mata Kuliah</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-500">Tidak ada mata kuliah yang ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- List Manajemen Table -->
                <div x-show="activeTab === 'manajemen'" x-transition class="overflow-x-auto pb-4" style="display: none;">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-blue-500 text-xs font-bold border-b border-gray-100">
                                <th class="py-4 px-4 w-10 text-center"><input type="checkbox" onclick="toggleAllCheckboxes(this)" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></th>
                                <th class="py-4 px-4 whitespace-nowrap cursor-pointer hover:text-blue-600">Judul</th>
                                <th class="py-4 px-4 whitespace-nowrap cursor-pointer hover:text-blue-600">Guru</th>
                                <th class="py-4 px-4 whitespace-nowrap cursor-pointer hover:text-blue-600">Tanggal<br>Pembuatan <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-4 whitespace-nowrap cursor-pointer hover:text-blue-600">Akses<br>Terakhir <i class="fa-solid fa-arrow-down-short-wide ml-1 text-[10px]"></i></th>
                                <th class="py-4 px-4 whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                            @forelse($courses as $course)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="py-4 px-4 text-center align-top"><input type="checkbox" value="{{ $course->id }}" onchange="updateBulkActionButton()" class="rounded border-gray-300 text-blue-600 shadow-sm mt-1 row-checkbox"></td>
                                <td class="py-4 px-4 align-top">
                                    <div class="font-bold text-gray-800">{{ $course->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-semibold uppercase">{{ $course->code }}</div>
                                </td>
                                <td class="py-4 px-4 align-top">
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($course->users as $teacher)
                                        <span class="inline-flex items-center gap-1.5 border border-gray-200 rounded-full pl-2 pr-3 py-1 text-xs font-medium text-gray-600 bg-white shadow-sm hover:border-blue-300 hover:text-blue-600 cursor-pointer transition">
                                            <i class="fa-regular fa-user text-gray-400"></i> {{ $teacher->name }}
                                        </span>
                                        @empty
                                        <span class="text-xs text-gray-400">-</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="py-4 px-4 align-top text-xs text-gray-500">
                                    {{ $course->created_at ? $course->created_at->format('d F Y, H:i') : '-' }}
                                </td>
                                <td class="py-4 px-4 align-top text-xs text-gray-500">
                                    {{ $course->last_accessed_at ? \Carbon\Carbon::parse($course->last_accessed_at)->format('d F Y, H:i') : '-' }}
                                </td>
                                <td class="py-4 px-4 text-center align-top">
                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                        <div class="flex items-center justify-center bg-blue-50 text-blue-500 rounded-full px-2 py-1 cursor-pointer hover:bg-blue-100 transition" @click="open = !open" @click.away="open = false">
                                            <i class="fa-regular fa-eye text-xs"></i>
                                            <i class="fa-solid fa-chevron-down text-[8px] ml-1.5"></i>
                                        </div>
                                        
                                        <!-- Action Dropdown -->
                                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] border border-gray-100 py-2 z-20" style="display: none;">
                                            <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition font-medium"><i class="fa-solid fa-magnifying-glass w-5 text-center mr-2 text-blue-500"></i> Penelusuran</a>
                                            <a href="{{ route('admin.courses.show', $course) }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition font-medium"><i class="fa-solid fa-book-open w-5 text-center mr-2 text-blue-500"></i> Kelola Konten & Ujian</a>
                                            <a href="{{ route('admin.courses.edit', $course) }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition font-medium"><i class="fa-regular fa-pen-to-square w-5 text-center mr-2 text-blue-500"></i> Ubah Mata Kuliah</a>
                                            <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition font-medium"><i class="fa-solid fa-box-archive w-5 text-center mr-2 text-blue-500"></i> Buat Cadangan</a>
                                            <div class="h-px bg-gray-100 my-1"></div>
                                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full text-left block px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition font-medium"><i class="fa-regular fa-trash-can w-5 text-center mr-2"></i> Hapus Mata Kuliah</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500">Tidak ada mata kuliah yang ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Footer -->
                <div class="mt-8">
                    {{ $courses->links() }}
                </div>
            </div>
            
            <form id="realBulkActionForm" action="{{ route('admin.courses.bulk') }}" method="POST" class="hidden">
                @csrf
            </form>

            <footer class="mt-8 text-xs text-gray-400 flex justify-between px-2">
                <p>&copy; 2026 Smart Exam | All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-gray-600 transition">Cara Kerja</a>
                    <a href="#" class="hover:text-gray-600 transition">Pusat Bantuan</a>
                    <a href="#" class="hover:text-gray-600 transition">Hubungi Kami</a>
                </div>
            </footer>
        </main>
    </div>
    
    <script>
        function toggleAllCheckboxes(source) {
            // Get checkboxes visible in the active tab
            const activeTab = document.querySelector('[x-show="activeTab === \'standar\'"]').style.display !== 'none' ? 'standar' : 'manajemen';
            const tableContainer = document.querySelector(`[x-show="activeTab === '${activeTab}'"]`);
            
            const checkboxes = tableContainer.querySelectorAll('.row-checkbox');
            checkboxes.forEach(cb => cb.checked = source.checked);
            updateBulkActionButton();
        }

        function updateBulkActionButton() {
            const anyChecked = document.querySelectorAll('.row-checkbox:checked').length > 0;
            const selectVal = document.getElementById('bulkActionSelect').value;
            const btn = document.getElementById('bulkActionBtn');
            
            // Remove all dynamic classes
            btn.classList.remove('bg-gray-100', 'text-gray-500', 'opacity-50', 'cursor-not-allowed', 'bg-blue-600', 'hover:bg-blue-700', 'bg-red-600', 'hover:bg-red-700', 'text-white');
            
            if (anyChecked && selectVal) {
                btn.classList.add('text-white');
                if (selectVal === 'delete') {
                    btn.classList.add('bg-red-600', 'hover:bg-red-700');
                } else {
                    btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }
            } else {
                btn.classList.add('bg-gray-100', 'text-gray-500', 'opacity-50', 'cursor-not-allowed');
            }
        }

        document.getElementById('bulkActionSelect').addEventListener('change', updateBulkActionButton);

        function executeBulkAction() {
            const selectVal = document.getElementById('bulkActionSelect').value;
            const checkboxes = document.querySelectorAll('.row-checkbox:checked');
            
            if (!selectVal || checkboxes.length === 0) return;
            
            if (!confirm(`Apakah Anda yakin ingin menghapus ${checkboxes.length} mata kuliah terpilih?`)) {
                return;
            }

            const form = document.getElementById('realBulkActionForm');
            form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = selectVal;
            form.appendChild(actionInput);

            checkboxes.forEach(cb => {
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'ids[]';
                idInput.value = cb.value;
                form.appendChild(idInput);
            });

            form.submit();
        }
    </script>
</x-app-layout>
