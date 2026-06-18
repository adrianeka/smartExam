<x-app-layout>
    <div class="bg-gray-100 text-gray-700 font-sans min-h-screen">
        <main class="flex-1 p-8">
            <nav class="text-xs text-gray-500 flex items-center space-x-2 mb-6">
                <i class="fa-solid fa-house"></i>
                <span>Administrasi Platform</span>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-blue-500 font-medium">Manajemen Mata Kuliah</span>
            </nav>

            <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-8 max-w-6xl">
                
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-2">Manajemen Mata Kuliah</h2>
                        <p class="text-sm text-gray-500">Kelola daftar mata kuliah yang tersedia di platform.</p>
                    </div>
                    <a href="{{ route('admin.courses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-6 py-2.5 rounded-lg flex items-center shadow-xs transition">
                        <i class="fa-solid fa-plus mr-2 text-xs"></i> Buat Mata Kuliah
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-blue-500 text-xs font-semibold border-b border-gray-100">
                                <th class="py-4 px-4 font-semibold whitespace-nowrap">ID</th>
                                <th class="py-4 px-4 font-semibold whitespace-nowrap">Nama Mata Kuliah</th>
                                <th class="py-4 px-4 font-semibold whitespace-nowrap">Deskripsi</th>
                                <th class="py-4 px-4 font-semibold whitespace-nowrap text-center">Jumlah Siswa</th>
                                <th class="py-4 px-4 font-semibold whitespace-nowrap text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                            @forelse($courses as $course)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-4">#{{ $course->id }}</td>
                                <td class="py-4 px-4 font-medium">{{ $course->name }}</td>
                                <td class="py-4 px-4 max-w-xs truncate" title="{{ $course->description }}">{{ $course->description ?: '-' }}</td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-blue-100 bg-blue-600 rounded-full">
                                        {{ $course->users_count }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right space-x-2">
                                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah kamu yakin ingin menghapus mata kuliah ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400">Belum ada mata kuliah yang terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            
            <footer class="mt-12 text-xs text-gray-400 flex justify-between max-w-6xl">
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
