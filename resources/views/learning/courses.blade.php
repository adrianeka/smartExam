<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Mata Kuliah Saya</h2>
                <p class="mt-2 text-sm text-gray-500">Daftar kelas dan mata kuliah yang Anda ikuti saat ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($courses as $course)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                        <div class="h-40 bg-gradient-to-br from-blue-500 to-cyan-400 relative">
                            <div class="absolute inset-0 bg-black/10"></div>
                            <!-- Icon -->
                            <div class="absolute top-4 left-4 w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white border border-white/30">
                                <i class="fa-solid fa-graduation-cap text-xl"></i>
                            </div>
                            <!-- Status Badge -->
                            <div class="absolute top-4 right-4">
                                @if($course->pivot->is_completed)
                                    <span class="px-3 py-1 bg-green-500/90 backdrop-blur-md text-white text-xs font-semibold rounded-full border border-green-400/50">Selesai</span>
                                @else
                                    <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-blue-600 text-xs font-semibold rounded-full shadow-sm">Sedang Berjalan</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="text-xs font-bold tracking-wider text-blue-600 uppercase mb-2">{{ $course->code ?? 'UMUM' }}</div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors line-clamp-1" title="{{ $course->name }}">{{ $course->name }}</h3>
                            <p class="text-sm text-gray-500 mb-6 line-clamp-2">{{ $course->description ?? 'Tidak ada deskripsi untuk mata kuliah ini.' }}</p>
                            
                            <!-- Progress Bar -->
                            <div class="mb-6">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="font-medium text-gray-700">Progres Belajar</span>
                                    <span class="text-blue-600 font-bold">{{ $course->pivot->progress ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-1000" style="width: {{ $course->pivot->progress ?? 0 }}%"></div>
                                </div>
                            </div>
                            
                            <div class="pt-4 border-t border-gray-100">
                                <a href="#" class="w-full block text-center py-2.5 px-4 bg-gray-50 hover:bg-blue-50 text-blue-600 font-semibold rounded-xl transition-colors border border-gray-200 hover:border-blue-200">
                                    Lanjutkan Belajar
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-16 bg-white rounded-3xl border border-gray-200 border-dashed">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 text-blue-500 rounded-full mb-4">
                                <i class="fa-solid fa-book-open text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Kelas</h3>
                            <p class="text-gray-500 max-w-md mx-auto">Anda belum terdaftar di mata kuliah manapun. Hubungi admin atau dosen untuk didaftarkan ke dalam kelas.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
