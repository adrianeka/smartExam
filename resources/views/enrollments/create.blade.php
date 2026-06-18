<x-app-layout>
    <div class="bg-gray-50 text-gray-700 font-sans min-h-screen pb-12">
        <main class="flex-1 p-8">
            <!-- Breadcrumbs -->
            <nav class="text-xs text-gray-500 flex items-center space-x-2 mb-6">
                <a href="#" class="hover:text-blue-500 transition"><i class="fa-solid fa-home"></i></a>
                <span>&gt;</span>
                <a href="#" class="hover:text-blue-500 transition">Administrasi Platform</a>
                <span>&gt;</span>
                <span class="text-blue-500 font-semibold">Tambah Pengguna ke Mata Kuliah</span>
            </nav>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <!-- Header -->
                <div class="mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-bold text-gray-800">Tambah Pengguna ke Mata Kuliah</h2>
                </div>

                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-8" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                <form action="{{ route('admin.enroll.store') }}" method="POST">
                    @csrf
                    
                    <div class="flex flex-col md:flex-row items-end gap-6">
                        
                        <!-- Pilih Pengguna -->
                        <div class="flex-1 w-full" x-data="{ 
                            open: false, 
                            search: '', 
                            selected: [],
                            users: {{ $users->map(fn($u) => ['id' => $u->id, 'name' => $u->name])->toJson() }},
                            toggleSelection(user) {
                                if (this.selected.some(u => u.id === user.id)) {
                                    this.selected = this.selected.filter(u => u.id !== user.id);
                                } else {
                                    this.selected.push(user);
                                }
                            }
                        }">
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Pilih Pengguna</label>
                            <div class="relative">
                                <div @click="open = !open" class="min-h-[46px] w-full border border-gray-200 rounded-2xl px-4 py-2 text-sm text-gray-700 cursor-text flex flex-wrap gap-2 items-center bg-white transition focus-within:ring-2 focus-within:ring-blue-500">
                                    <template x-for="s in selected" :key="s.id">
                                        <span class="inline-flex items-center gap-1.5 border border-gray-600 rounded-full pl-3 pr-2 py-1 text-xs font-medium text-gray-700 bg-white shadow-sm">
                                            <span x-text="s.name"></span>
                                            <button type="button" @click.stop="toggleSelection(s)" class="text-gray-500 hover:text-gray-800">
                                                <i class="fa-regular fa-circle-xmark text-[11px]"></i>
                                            </button>
                                            <input type="hidden" name="users[]" :value="s.id">
                                        </span>
                                    </template>
                                    <input type="text" x-model="search" @click.stop="open = true" placeholder="Pilih pengguna..." class="flex-1 min-w-[100px] bg-transparent border-none outline-none focus:ring-0 p-0 text-sm">
                                </div>
                                
                                <div x-show="open" @click.away="open = false" x-transition class="absolute z-20 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto" style="display: none;">
                                    <template x-for="user in users.filter(u => u.name.toLowerCase().includes(search.toLowerCase()))" :key="user.id">
                                        <div @click="toggleSelection(user)" class="px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm text-gray-700 flex items-center justify-between">
                                            <span x-text="user.name"></span>
                                            <i x-show="selected.some(u => u.id === user.id)" class="fa-solid fa-check text-blue-500"></i>
                                        </div>
                                    </template>
                                    <div x-show="users.filter(u => u.name.toLowerCase().includes(search.toLowerCase())).length === 0" class="px-4 py-2 text-sm text-gray-500">Tidak ada pengguna ditemukan.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="mb-0.5 shrink-0">
                            <button type="submit" class="bg-[#0070d2] hover:bg-blue-700 text-white px-6 py-[11px] rounded-full text-sm font-semibold transition flex items-center justify-center gap-2 shadow-sm w-full md:w-auto">
                                <i class="fa-solid fa-plus"></i> Tambah ke Mata Kuliah
                            </button>
                        </div>

                        <!-- Pilih Mata Kuliah -->
                        <div class="flex-1 w-full" x-data="{ 
                            open: false, 
                            search: '', 
                            selected: [],
                            courses: {{ $courses->map(fn($c) => ['id' => $c->id, 'name' => $c->name])->toJson() }},
                            toggleSelection(course) {
                                if (this.selected.some(c => c.id === course.id)) {
                                    this.selected = this.selected.filter(c => c.id !== course.id);
                                } else {
                                    this.selected.push(course);
                                }
                            }
                        }">
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Pilih Mata Kuliah</label>
                            <div class="relative">
                                <div @click="open = !open" class="min-h-[46px] w-full border border-gray-200 rounded-2xl px-4 py-2 text-sm text-gray-700 cursor-text flex flex-wrap gap-2 items-center bg-white transition focus-within:ring-2 focus-within:ring-blue-500">
                                    <template x-for="s in selected" :key="s.id">
                                        <span class="inline-flex items-center gap-1.5 border border-gray-600 rounded-full pl-3 pr-2 py-1 text-xs font-medium text-gray-700 bg-white shadow-sm">
                                            <span x-text="s.name"></span>
                                            <button type="button" @click.stop="toggleSelection(s)" class="text-gray-500 hover:text-gray-800">
                                                <i class="fa-regular fa-circle-xmark text-[11px]"></i>
                                            </button>
                                            <input type="hidden" name="courses[]" :value="s.id">
                                        </span>
                                    </template>
                                    <input type="text" x-model="search" @click.stop="open = true" placeholder="Pilih mata kuliah..." class="flex-1 min-w-[100px] bg-transparent border-none outline-none focus:ring-0 p-0 text-sm">
                                </div>
                                
                                <div x-show="open" @click.away="open = false" x-transition class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto" style="display: none;">
                                    <template x-for="course in courses.filter(c => c.name.toLowerCase().includes(search.toLowerCase()))" :key="course.id">
                                        <div @click="toggleSelection(course)" class="px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm text-gray-700 flex items-center justify-between">
                                            <span x-text="course.name"></span>
                                            <i x-show="selected.some(c => c.id === course.id)" class="fa-solid fa-check text-blue-500"></i>
                                        </div>
                                    </template>
                                    <div x-show="courses.filter(c => c.name.toLowerCase().includes(search.toLowerCase())).length === 0" class="px-4 py-2 text-sm text-gray-500">Tidak ada mata kuliah ditemukan.</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
            
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
</x-app-layout>
