<x-app-layout>
    <div class="p-6">
        <div class="mb-6 flex items-center gap-3 text-sm">
            <a href="{{ route('admin.menus.index') }}" class="text-gray-500 hover:text-blue-600 transition"><i class="fa-solid fa-arrow-left mr-2"></i>Kembali</a>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Menu: {{ $menu->name }}</h2>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
            <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama {{ $menu->type === 'category' ? 'Grup Pembatas' : 'Halaman' }}</label>
                        <input type="text" name="name" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-lg font-medium py-3" required value="{{ $menu->name }}">
                    </div>

                    @if($menu->type !== 'category')
                        @if($menu->type === 'link')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">URL / Route Tujuan</label>
                                <input type="text" name="url" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required value="{{ $menu->url }}">
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
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
                                selectedIcon: '{{ $menu->icon ?: 'fa-solid fa-file-lines' }}',
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

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pindah Lokasi (Pilih Grup Induk)</label>
                                <select name="parent_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 bg-white">
                                    <option value="">-- Berdiri Sendiri (Menu Utama) --</option>
                                    @foreach($parentMenus as $parent)
                                        <option value="{{ $parent->id }}" {{ $menu->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ubah Urutan Secara Manual (Opsional)</label>
                        <input type="number" name="order" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ $menu->order }}">
                        <p class="text-xs text-gray-500 mt-1">Sistem menyusun halaman secara otomatis, tapi Anda dapat menimpa urutannya di sini (angka lebih kecil akan tampil di atas).</p>
                    </div>

                    @if($menu->type !== 'category')
                    <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl flex gap-3 mt-4">
                        <div class="text-blue-500 mt-0.5"><i class="fa-solid fa-circle-info"></i></div>
                        <div>
                            <p class="text-sm font-bold text-blue-800">Manajemen Hak Akses</p>
                            <p class="text-xs text-blue-700 mt-1">Pengaturan hak akses siapa saja yang bisa melihat halaman ini dapat dilakukan di menu <strong>Pengaturan Platform > Manajemen Menu > klik ikon ⚙️ (Atur Akses)</strong> pada halaman tersebut.</p>
                        </div>
                    </div>
                    @endif

                    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('admin.menus.index') }}" class="px-6 py-2 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-sm hover:shadow">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
