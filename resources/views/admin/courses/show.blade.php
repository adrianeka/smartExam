<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $course->name }}</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola Modul Pembelajaran dan Ujian untuk mata kuliah ini.</p>
        </div>
        <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Modul & Materi (2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-800">Modul Pembelajaran</h2>
                    <button type="button" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-semibold hover:bg-blue-100 transition" onclick="document.getElementById('addModuleModal').classList.remove('hidden')">
                        + Tambah Modul
                    </button>
                </div>

                @forelse($course->modules as $module)
                    <div class="border border-gray-100 rounded-xl mb-4 overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 flex items-center justify-between border-b border-gray-100">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $module->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $module->description }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" class="text-blue-500 hover:text-blue-700 text-sm font-semibold" onclick="openAddLessonModal({{ $module->id }})">+ Materi</button>
                                <form action="{{ route('admin.modules.destroy', $module) }}" method="POST" class="inline" onsubmit="return confirm('Hapus modul ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash w-4 h-4"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="p-4 bg-white space-y-2">
                            @forelse($module->lessons as $lesson)
                                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:border-blue-200 transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-file-lines text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-700">{{ $lesson->title }}</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="inline" onsubmit="return confirm('Hapus materi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 p-2"><i class="fa-solid fa-xmark"></i></button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400 italic text-center py-2">Belum ada materi di modul ini.</p>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-sm mb-3">Belum ada modul yang dibuat.</p>
                        <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition" onclick="document.getElementById('addModuleModal').classList.remove('hidden')">
                            Buat Modul Pertama
                        </button>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Ujian & Kuis (1/3 width) -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-800">Ujian & Kuis</h2>
                    <button type="button" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-semibold hover:bg-blue-100 transition" onclick="document.getElementById('addExamModal').classList.remove('hidden')">
                        + Tambah
                    </button>
                </div>

                <div class="space-y-3">
                    @forelse($course->exams as $exam)
                        <div class="p-4 border border-gray-100 rounded-xl hover:border-blue-200 transition">
                            <h3 class="font-semibold text-gray-800">{{ $exam->title }}</h3>
                            <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                <span class="flex items-center gap-1"><i class="fa-regular fa-clock"></i> {{ $exam->duration_minutes }} mnt</span>
                                <span class="flex items-center gap-1"><i class="fa-solid fa-list-ol"></i> {{ $exam->questions->count() }} soal</span>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-50 flex gap-2">
                                <a href="{{ route('admin.exams.show', $exam) }}" class="flex-1 text-center py-1.5 bg-gray-50 text-gray-600 rounded-lg text-xs font-semibold hover:bg-gray-100">Kelola Soal</a>
                                <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="inline" onsubmit="return confirm('Hapus ujian ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100"><i class="fa-solid fa-trash text-xs"></i></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 italic text-center py-4">Belum ada ujian yang dibuat.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Add Module Modal -->
    <div id="addModuleModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-gray-900/50" onclick="document.getElementById('addModuleModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold mb-4">Tambah Modul Baru</h3>
            <form action="{{ route('admin.courses.modules.store', $course) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Modul</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="description" rows="2" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-200" onclick="document.getElementById('addModuleModal').classList.add('hidden')">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Lesson Modal -->
    <div id="addLessonModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-gray-900/50" onclick="document.getElementById('addLessonModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl w-full max-w-lg p-6">
            <h3 class="text-lg font-bold mb-4">Tambah Materi</h3>
            <form id="addLessonForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Materi</label>
                    <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Isi / Konten Materi</label>
                    <textarea name="content" rows="4" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">URL Video (Opsional)</label>
                    <input type="url" name="video_url" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-200" onclick="document.getElementById('addLessonModal').classList.add('hidden')">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">Simpan Materi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Exam Modal -->
    <div id="addExamModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-gray-900/50" onclick="document.getElementById('addExamModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold mb-4">Tambah Ujian/Kuis Baru</h3>
            <form action="{{ route('admin.courses.exams.store', $course) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Ujian</label>
                    <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Durasi (Menit)</label>
                        <input type="number" name="duration_minutes" value="60" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Batas Lulus (Score)</label>
                        <input type="number" name="passing_score" value="70" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-200" onclick="document.getElementById('addExamModal').classList.add('hidden')">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddLessonModal(moduleId) {
            document.getElementById('addLessonForm').action = `/admin/modules/${moduleId}/lessons`;
            document.getElementById('addLessonModal').classList.remove('hidden');
        }
    </script>
</x-app-layout>
