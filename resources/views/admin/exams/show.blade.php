<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.courses.index') }}" class="hover:text-blue-600 transition">Mata Kuliah</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <a href="{{ route('admin.courses.show', $exam->course_id) }}" class="hover:text-blue-600 transition">{{ $exam->course->name }}</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-gray-700 font-medium">Detail Ujian</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $exam->title }}</h1>
            <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                <span class="flex items-center gap-1"><i class="fa-regular fa-clock"></i> Durasi: {{ $exam->duration_minutes }} mnt</span>
                <span class="flex items-center gap-1"><i class="fa-solid fa-bullseye"></i> Batas Lulus: {{ $exam->passing_score }}</span>
            </div>
        </div>
        <a href="{{ route('admin.courses.show', $exam->course_id) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Soal List (2/3 width) -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-800">Daftar Soal ({{ $exam->questions->count() }})</h2>
                <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow-sm" onclick="document.getElementById('addQuestionModal').classList.remove('hidden')">
                    + Tambah Soal
                </button>
            </div>

            @forelse($exam->questions as $index => $question)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 relative group">
                    <div class="absolute right-4 top-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="inline" onsubmit="return confirm('Hapus soal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"><i class="fa-solid fa-trash w-4 h-4"></i></button>
                        </form>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold shrink-0">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-800 font-medium mb-3">{!! nl2br(e($question->question_text)) !!}</p>
                            
                            <div class="space-y-2">
                                @foreach($question->options as $optIndex => $option)
                                    <div class="flex items-center gap-3 p-2.5 rounded-lg border {{ $option->is_correct ? 'border-green-200 bg-green-50/50' : 'border-gray-100 bg-gray-50/50' }}">
                                        <div class="w-5 h-5 rounded-full border {{ $option->is_correct ? 'border-green-500 bg-green-500 text-white' : 'border-gray-300' }} flex items-center justify-center text-[10px] font-bold">
                                            {{ chr(65 + $optIndex) }}
                                        </div>
                                        <span class="text-sm {{ $option->is_correct ? 'text-green-700 font-medium' : 'text-gray-600' }}">
                                            {{ $option->option_text }}
                                        </span>
                                        @if($option->is_correct)
                                            <i class="fa-solid fa-check text-green-500 ml-auto"></i>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-gray-400 font-semibold">
                                Bobot Poin: <span class="text-gray-600">{{ $question->points }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-dashed border-gray-300 p-8 text-center">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                        <i class="fa-solid fa-clipboard-question text-xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm mb-3">Belum ada soal untuk ujian ini.</p>
                    <button type="button" class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-semibold hover:bg-blue-100 transition" onclick="document.getElementById('addQuestionModal').classList.remove('hidden')">
                        Buat Soal Pertama
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Info Sidebar (1/3 width) -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <h3 class="font-bold text-gray-800 mb-4">Pengaturan Ujian</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase mb-1">Status Publikasi</p>
                        @if($exam->is_published)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-green-50 text-green-700 text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Dipublikasikan
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Draft
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase mb-1">Total Poin Maksimal</p>
                        <p class="text-lg font-bold text-gray-800">{{ $exam->questions->sum('points') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Question Modal -->
    <div id="addQuestionModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-gray-900/50" onclick="document.getElementById('addQuestionModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-bold mb-4">Tambah Soal Pilihan Ganda</h3>
            <form action="{{ route('admin.exams.questions.store', $exam) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Teks Pertanyaan</label>
                    <textarea name="question_text" rows="3" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Bobot Poin</label>
                    <input type="number" name="points" value="10" required class="w-1/3 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilihan Jawaban</label>
                    <div class="space-y-3">
                        @for($i = 0; $i < 4; $i++)
                            <div class="flex items-start gap-3">
                                <div class="mt-2">
                                    <input type="radio" name="correct_option" value="{{ $i }}" {{ $i == 0 ? 'checked' : '' }} class="w-4 h-4 text-green-600 focus:ring-green-500 cursor-pointer">
                                </div>
                                <div class="flex-1 relative">
                                    <span class="absolute left-3 top-2.5 text-xs font-bold text-gray-400">{{ chr(65 + $i) }}</span>
                                    <input type="text" name="options[]" required placeholder="Teks pilihan {{ chr(65 + $i) }}..." class="w-full pl-8 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        @endfor
                    </div>
                    <p class="text-xs text-gray-500 mt-2"><i class="fa-solid fa-circle-info text-blue-500 mr-1"></i>Pilih tombol radio di sebelah kiri untuk menandai jawaban yang benar.</p>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                    <button type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-200" onclick="document.getElementById('addQuestionModal').classList.add('hidden')">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">Simpan Soal</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
