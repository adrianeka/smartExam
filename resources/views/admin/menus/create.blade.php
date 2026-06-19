<x-app-layout>
    <div class="p-6">
        <div class="mb-6 flex items-center gap-3 text-sm">
            <a href="{{ route('admin.menus.index') }}" class="text-gray-500 hover:text-blue-600 transition"><i class="fa-solid fa-arrow-left mr-2"></i>Kembali</a>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Menu Baru</h2>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl" 
             x-data="{ 
                 itemType: '{{ request('item_type', 'menu') }}', 
                 pageType: 'article',
                 parentId: '{{ request('parent_id', '') }}'
             }">
            <form action="{{ route('admin.menus.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    
                    {{-- Pilihan Jenis --}}
                    {{-- Pilihan Jenis (Selalu Ditampilkan) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Apa yang ingin Anda buat?</label>
                        <div class="flex flex-col gap-3">
                            <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition" :class="itemType == 'category' ? 'border-blue-500 bg-blue-50/30' : 'border-gray-200'">
                                <input type="radio" name="item_type" value="category" x-model="itemType" class="mt-1 text-blue-600 focus:ring-blue-500">
                                <div class="flex-1">
                                    <span class="block text-sm font-bold text-gray-800">Grup / Kategori Pembatas</span>
                                    <span class="block text-xs text-gray-500">Teks pembatas di sidebar (Contoh: PEMBELAJARAN)</span>
                                    
                                    @if(request('parent_id'))
                                    <div x-show="itemType == 'category'" class="mt-2 text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded border border-blue-100 flex items-center gap-1.5 inline-flex">
                                        <i class="fa-solid fa-arrow-down-short-wide"></i> Akan dibuat SETARA & DI BAWAH grup yang Anda klik.
                                    </div>
                                    @endif
                                </div>
                            </label>
                            
                            <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition" :class="itemType == 'menu' ? 'border-blue-500 bg-blue-50/30' : 'border-gray-200'">
                                <input type="radio" name="item_type" value="menu" x-model="itemType" class="mt-1 text-blue-600 focus:ring-blue-500">
                                <div class="flex-1">
                                    <span class="block text-sm font-bold text-gray-800">Halaman / Ruang Materi</span>
                                    <span class="block text-xs text-gray-500">Halaman yang bisa diklik untuk membaca artikel, materi, dll.</span>
                                    
                                    @if(request('parent_id'))
                                    <div x-show="itemType == 'menu'" class="mt-2 text-xs text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100 flex items-center gap-1.5 inline-flex">
                                        <i class="fa-solid fa-folder-tree"></i> Akan dimasukkan ke DALAM grup yang Anda klik.
                                    </div>
                                    @endif
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    @if(request('parent_id'))
                        <input type="hidden" name="parent_id" value="{{ request('parent_id') }}">
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span x-text="itemType == 'category' ? 'Grup' : 'Halaman'"></span></label>
                        <input type="text" name="name" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-lg font-medium py-3" required placeholder="Ketik nama di sini...">
                    </div>

                    {{-- Khusus Menu (Bukan Kategori) --}}
                    <div x-show="itemType == 'menu'" x-transition class="space-y-5 bg-gray-50 p-5 rounded-xl border border-gray-100">
                        
                        @if(!request('parent_id'))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Lokasi (Grup Induk)</label>
                            <select name="parent_id" x-model="parentId" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Berada di Luar (Berdiri Sendiri) --</option>
                                @foreach($parentMenus as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Tipe Fitur</label>
                            <select name="type" x-model="pageType" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 bg-white">
                                <option value="article">📝 Artikel / Pengumuman / Modul</option>
                                <option value="link">🔗 Link Tautan Eksternal</option>
                                <option value="chat" disabled>💬 Diskusi Khusus (Segera Hadir)</option>
                                <option value="form" disabled>📋 Tugas / Evaluasi (Segera Hadir)</option>
                            </select>
                        </div>

                        <div x-show="pageType == 'link'" x-transition>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Masukkan URL Tautan</label>
                            <input type="text" name="url" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="https://youtube.com/...">
                        </div>

                        <div x-show="pageType != 'link'">
                            <div x-data="{
                                iconList: [
                                    'fa-solid fa-file-lines', 'fa-solid fa-book', 'fa-solid fa-book-open', 'fa-solid fa-graduation-cap', 
                                    'fa-solid fa-chalkboard-user', 'fa-solid fa-video', 'fa-solid fa-headphones', 'fa-solid fa-image', 
                                    'fa-solid fa-folder', 'fa-solid fa-clipboard-list', 'fa-solid fa-pen-to-square', 'fa-solid fa-chart-pie', 
                                    'fa-solid fa-bullhorn', 'fa-solid fa-message', 'fa-solid fa-users', 'fa-solid fa-award', 
                                    'fa-solid fa-star', 'fa-solid fa-bell', 'fa-solid fa-calendar-days', 'fa-solid fa-circle-play', 
                                    'fa-solid fa-link', 'fa-solid fa-download', 'fa-solid fa-check', 'fa-solid fa-circle-info', 
                                    'fa-solid fa-gamepad', 'fa-solid fa-lightbulb', 'fa-solid fa-flask', 'fa-solid fa-heart',
                                    'fa-solid fa-music', 'fa-solid fa-camera', 'fa-solid fa-calculator', 'fa-solid fa-globe'
                                ],
                                selectedIcon: 'fa-solid fa-file-lines',
                                showPicker: false
                            }">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Ikon Halaman</label>
                                <div class="relative">
                                    <div class="flex items-center gap-3">
                                        <button type="button" @click="showPicker = !showPicker" class="w-12 h-12 rounded-lg bg-white border-2 border-gray-200 hover:border-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 flex items-center justify-center shrink-0 transition-all cursor-pointer shadow-sm">
                                            <i :class="selectedIcon + ' text-blue-500 text-lg'"></i>
                                        </button>
                                        <div class="flex-1">
                                            <input type="hidden" name="icon" x-model="selectedIcon">
                                            <div class="text-sm font-medium text-gray-700" x-text="selectedIcon.replace('fa-solid ', '')"></div>
                                            <div class="text-xs text-blue-500 mt-0.5 cursor-pointer hover:underline" @click="showPicker = !showPicker">Ubah Ikon</div>
                                        </div>
                                    </div>

                                    <!-- Icon Picker Popup -->
                                    <div x-show="showPicker" @click.away="showPicker = false" x-transition.opacity.duration.200ms
                                         class="absolute left-0 mt-2 w-[320px] bg-white border border-gray-200 rounded-xl shadow-xl p-4 z-50" style="display: none;">
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Koleksi Ikon</p>
                                        <div class="grid grid-cols-6 gap-2">
                                            <template x-for="icon in iconList" :key="icon">
                                                <button type="button" @click="selectedIcon = icon; showPicker = false" 
                                                        class="w-10 h-10 rounded-lg flex items-center justify-center transition-all"
                                                        :class="selectedIcon === icon ? 'bg-blue-100 text-blue-600 border border-blue-200 shadow-inner' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800'">
                                                    <i :class="icon + ' text-lg'"></i>
                                                </button>
                                            </template>
                                        </div>
                                        <p class="text-[10px] text-gray-400 mt-3 text-center border-t border-gray-100 pt-2">Powered by FontAwesome</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Informasi Permission disederhanakan --}}
                    <div x-show="itemType == 'menu'" x-transition class="bg-amber-50 border border-amber-100 p-4 rounded-xl flex gap-3">
                        <div class="text-amber-500 mt-0.5"><i class="fa-solid fa-shield-halved"></i></div>
                        <div>
                            <p class="text-sm font-bold text-amber-800">Sistem Keamanan Otomatis</p>
                            <p class="text-xs text-amber-700 mt-1">Sistem akan secara otomatis memblokir halaman ini agar tidak terlihat oleh Siswa/Guru hingga Anda memberikan izin melalui tombol <strong>Atur Akses (Members)</strong> setelah halaman dibuat.</p>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-sm hover:shadow flex items-center gap-2">
                            <i class="fa-solid fa-wand-magic-sparkles"></i> Buat Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
