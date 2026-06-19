<x-app-layout>
    <div class="bg-gray-100 text-gray-700 font-sans min-h-screen">
        <main class="flex-1 p-8">
            <nav class="text-xs text-gray-500 flex items-center space-x-2 mb-6">
                <i class="fa-solid fa-house"></i>
                <span>Administrasi Platform</span>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-blue-500 font-medium">Laporan</span>
            </nav>

            <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-8 max-w-6xl">
                
                <h2 class="text-xl font-bold text-gray-800 mb-2">Laporan Perusahaan</h2>
                <p class="text-sm text-gray-500 mb-8 max-w-4xl">
                    Lorem ipsum dolor sit amet consectetur. Porttitor penatibus felis integer eget aliquam aliquam. Natoque blandit id tellus risus in consectetur justo sit. Nulla et molestie in maecenas aliquet et. Vitae at tellus nunc non viverra placerat pulvinar amet massa.
                </p>

                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4 w-full">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="text-xs text-gray-400">List</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>
                    <div class="ml-4 shrink-0">
                        <form method="GET" action="{{ route('admin.reports.index') }}" class="inline-block">
                            <select name="per_page" onchange="this.form.submit()" class="text-xs border-none bg-transparent text-gray-500 focus:ring-0 cursor-pointer outline-none">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>Tampilkan 10 Data</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>Tampilkan 25 Data</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>Tampilkan 50 Data</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-blue-500 text-xs font-semibold border-b border-gray-100">
                                <th class="py-4 px-4 font-semibold whitespace-nowrap">Mata Kuliah <i class="fa-solid fa-arrow-down-short-wide ml-1"></i></th>
                                <th class="py-4 px-4 font-semibold whitespace-nowrap">Pengguna</th>
                                <th class="py-4 px-4 font-semibold whitespace-nowrap">Email</th>
                                <th class="py-4 px-4 font-semibold whitespace-nowrap">Jam Kerja</th>
                                <th class="py-4 px-4 font-semibold whitespace-nowrap">Hasil</th>
                                <th class="py-4 px-4 font-semibold whitespace-nowrap">Selesai</th>
                                <th class="py-4 px-4 font-semibold whitespace-nowrap text-right">Progress</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                            @forelse($reports as $report)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-4">{{ $report->course_name }}</td>
                                <td class="py-4 px-4">{{ $report->user_name }}</td>
                                <td class="py-4 px-4">{{ $report->user_email }}</td>
                                <td class="py-4 px-4">{{ $report->working_time }}</td>
                                <td class="py-4 px-4">
                                    <span class="inline-block px-3 py-1 bg-gray-500 text-white text-[10px] rounded-full font-medium shadow-sm">
                                        {{ $report->result ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-block px-3 py-1 bg-gray-500 text-white text-[10px] rounded-full font-medium shadow-sm">
                                        {{ $report->is_completed ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">{{ $report->progress }}%</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400">Belum ada data laporan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    {{ $reports->links() }}
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
