<x-app-layout>
    <div class="bg-gray-100 text-gray-700 font-sans min-h-screen">
        <main class="flex-1 p-8">
            <nav class="text-xs text-gray-500 flex items-center space-x-2 mb-6">
                <i class="fa-solid fa-house"></i>
                <span>Administrasi Platform</span>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <a href="{{ route('admin.courses.index') }}" class="hover:text-blue-500 transition">Manajemen Mata Kuliah</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-blue-500 font-medium">Edit Mata Kuliah</span>
            </nav>

            <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-8 max-w-3xl">
                
                <h2 class="text-xl font-bold text-gray-800 mb-8">Edit Mata Kuliah: {{ $course->name }}</h2>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2" for="name">Nama Mata Kuliah</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $course->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2" for="description">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $course->description) }}</textarea>
                    </div>

                    <div class="flex items-center space-x-4 pt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-6 py-2.5 rounded-lg flex items-center shadow-xs transition">
                            <i class="fa-solid fa-save mr-2 text-xs"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.courses.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">Batal</a>
                    </div>
                </form>

            </div>
            
        </main>
    </div>
</x-app-layout>
