<x-app-layout>
    <div class="bg-gray-50 text-gray-700 font-sans min-h-screen pb-12">
        <main class="flex-1 p-8">
            <!-- Breadcrumbs -->
            <nav class="text-xs text-gray-500 flex items-center space-x-2 mb-6">
                <a href="#" class="hover:text-blue-500 transition"><i class="fa-solid fa-home"></i></a>
                <span>&gt;</span>
                <a href="#" class="hover:text-blue-500 transition">Administrasi Platform</a>
                <span>&gt;</span>
                <a href="{{ route('admin.courses.index') }}" class="hover:text-blue-500 transition">Daftar Mata Kuliah</a>
                <span>&gt;</span>
                <span class="text-blue-500 font-semibold">Ubah Mata Kuliah</span>
            </nav>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
                <!-- Header -->
                <div class="mb-8 border-b border-gray-100 pb-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Ubah Mata Kuliah: {{ $course->name }}</h2>
                    <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">
                        Kembali
                    </a>
                </div>

                <form action="{{ route('admin.courses.update', $course) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Judul -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Judul <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $course->name) }}" placeholder="Masukkan judul" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <!-- Kode -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Kode</label>
                            <input type="text" name="code" value="{{ old('code', $course->code) }}" placeholder="Masukkan kode" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition mb-1">
                            <p class="text-[10px] text-gray-400">Hanya huruf (a-z) dan angka (0-9)</p>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Kategori</label>
                            <select name="category" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white">
                                <option value="">Pilih kategori...</option>
                                <option value="Programming" {{ old('category', $course->category) == 'Programming' ? 'selected' : '' }}>Programming</option>
                                <option value="Language" {{ old('category', $course->category) == 'Language' ? 'selected' : '' }}>Language</option>
                                <option value="Science" {{ old('category', $course->category) == 'Science' ? 'selected' : '' }}>Science</option>
                            </select>
                        </div>

                        <!-- Guru (Alpine Multi-select Mockup) -->
                        <div x-data="{ 
                            open: false, 
                            search: '', 
                            selected: {{ $course->users->map(fn($t) => ['id' => $t->id, 'name' => $t->name])->toJson() }},
                            teachers: {{ $teachers->map(fn($t) => ['id' => $t->id, 'name' => $t->name])->toJson() }},
                            toggleSelection(teacher) {
                                if (this.selected.some(t => t.id === teacher.id)) {
                                    this.selected = this.selected.filter(t => t.id !== teacher.id);
                                } else {
                                    this.selected.push(teacher);
                                }
                            }
                        }">
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Guru</label>
                            <div class="relative">
                                <div @click="open = !open" class="min-h-[42px] w-full border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 cursor-text flex flex-wrap gap-2 items-center bg-white transition focus-within:ring-2 focus-within:ring-blue-500">
                                    <template x-for="s in selected" :key="s.id">
                                        <span class="inline-flex items-center gap-1.5 border border-gray-200 rounded-full pl-2 pr-2 py-0.5 text-xs font-medium text-gray-600 bg-gray-50">
                                            <span x-text="s.name"></span>
                                            <button type="button" @click.stop="toggleSelection(s)" class="text-gray-400 hover:text-red-500">
                                                <i class="fa-regular fa-circle-xmark text-[10px]"></i>
                                            </button>
                                            <input type="hidden" name="teachers[]" :value="s.id">
                                        </span>
                                    </template>
                                    <input type="text" x-model="search" @click.stop="open = true" placeholder="Pilih guru..." class="flex-1 min-w-[100px] bg-transparent border-none outline-none focus:ring-0 p-0 text-sm">
                                </div>
                                
                                <div x-show="open" @click.away="open = false" x-transition class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto" style="display: none;">
                                    <template x-for="teacher in teachers.filter(t => t.name.toLowerCase().includes(search.toLowerCase()))" :key="teacher.id">
                                        <div @click="toggleSelection(teacher)" class="px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm text-gray-700 flex items-center justify-between">
                                            <span x-text="teacher.name"></span>
                                            <i x-show="selected.some(t => t.id === teacher.id)" class="fa-solid fa-check text-blue-500"></i>
                                        </div>
                                    </template>
                                    <div x-show="teachers.filter(t => t.name.toLowerCase().includes(search.toLowerCase())).length === 0" class="px-4 py-2 text-sm text-gray-500">Tidak ada guru ditemukan.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Departemen -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Departemen</label>
                            <input type="text" name="department" value="{{ old('department', $course->department) }}" placeholder="Masukkan departemen" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <!-- URL Departemen -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">URL Departemen</label>
                            <input type="text" name="department_url" value="{{ old('department_url', $course->department_url) }}" placeholder="Masukkan url departemen" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <!-- Bahasa -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Bahasa</label>
                            <select name="language" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white">
                                <option value="">Pilih bahasa...</option>
                                <option value="English" {{ old('language', $course->language) == 'English' ? 'selected' : '' }}>English</option>
                                <option value="Bahasa Indonesia" {{ old('language', $course->language) == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            </select>
                        </div>

                        <!-- Akses Mata Kuliah -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Akses Mata Kuliah</label>
                            <select name="access_type" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition appearance-none bg-white">
                                <option value="">Pilih akses mata kuliah...</option>
                                <option value="public" {{ old('access_type', $course->access_type) == 'public' ? 'selected' : '' }}>Publik</option>
                                <option value="private" {{ old('access_type', $course->access_type) == 'private' ? 'selected' : '' }}>Pribadi</option>
                            </select>
                        </div>

                        <!-- Terdaftar Diizinkan -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-3">Terdaftar Diizinkan</label>
                            <div class="flex items-center gap-8">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="is_registered_allowed" value="1" class="text-blue-600 border-gray-300 focus:ring-blue-500 h-4 w-4" {{ old('is_registered_allowed', $course->is_registered_allowed) ? 'checked' : '' }}>
                                    <span class="text-xs text-gray-700 font-medium">Ya (Diizinkan)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="is_registered_allowed" value="0" class="text-blue-600 border-gray-300 focus:ring-blue-500 h-4 w-4" {{ !old('is_registered_allowed', $course->is_registered_allowed) ? 'checked' : '' }}>
                                    <span class="text-xs text-gray-700 font-medium">Tidak</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tidak Terdaftar Diizinkan -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-3">Tidak Terdaftar Diizinkan</label>
                            <div class="flex items-center gap-8">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="is_unregistered_allowed" value="1" class="text-blue-600 border-gray-300 focus:ring-blue-500 h-4 w-4" {{ old('is_unregistered_allowed', $course->is_unregistered_allowed) ? 'checked' : '' }}>
                                    <span class="text-xs text-gray-700 font-medium">Ya (Diizinkan)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="is_unregistered_allowed" value="0" class="text-blue-600 border-gray-300 focus:ring-blue-500 h-4 w-4" {{ !old('is_unregistered_allowed', $course->is_unregistered_allowed) ? 'checked' : '' }}>
                                    <span class="text-xs text-gray-700 font-medium">Tidak</span>
                                </label>
                            </div>
                        </div>

                        <!-- Ruang Penyimpanan -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Ruang Penyimpanan</label>
                            <div class="flex">
                                <input type="number" name="storage_limit_mb" value="{{ old('storage_limit_mb', $course->storage_limit_mb) }}" placeholder="Masukkan jumlah penyimpanan" class="w-full border border-gray-200 border-r-0 rounded-l-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <span class="inline-flex items-center px-4 bg-gray-50 border border-l-0 border-gray-200 text-gray-500 text-sm rounded-r-lg">MB</span>
                            </div>
                        </div>

                        <!-- Mata Kuliah Khusus -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Mata Kuliah Khusus</label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_special_course" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_special_course', $course->is_special_course) ? 'checked' : '' }}>
                                <span class="text-xs text-gray-700">Ya</span>
                            </label>
                        </div>

                        <!-- Tags -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Tags</label>
                            <input type="text" name="tags" value="{{ old('tags', $course->tags) }}" placeholder="Mulai mengetik, lalu klik batang ini untuk memvalidasi tag" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <!-- URL Video -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">URL Video</label>
                            <input type="url" name="video_url" value="{{ old('video_url', $course->video_url) }}" placeholder="Masukkan url video" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                            <i class="fa-solid fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
            
            <footer class="mt-8 text-xs text-gray-400 flex justify-between px-2 max-w-4xl">
                <p>&copy; 2026 Smart Exam | All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-gray-600 transition">Cara Kerja</a>
                    <a href="#" class="hover:text-gray-600 transition">Pusat Bantuan</a>
                    <a href="#" class="hover:text-gray-600 transition">Hubungi Kami</a>
                </div>
            </footer>
        </main>
    </div>
</x-app-layout>
