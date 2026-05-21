<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Smart Exam</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link class="blueprint" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-700 font-sans">

    <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center fixed w-full top-0 z-50">
        <div class="flex items-center space-x-2">
            <div class="bg-blue-600 text-white p-2 rounded font-bold text-xs tracking-wider">SMART EXAM</div>
        </div>
        <div class="flex items-center space-x-6">
            <div class="relative">
                <i class="fa-regular fa-bell text-gray-500 text-xl"></i>
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] px-1 rounded-full font-bold">99+</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-gray-300"></div>
                <div class="text-left">
                    <p class="text-sm font-semibold text-gray-800">User Name</p>
                    <p class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded text-center font-medium">Admin</p>
                </div>
                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
            </div>
        </div>
    </header>

    <div class="flex pt-16">
        
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen p-4 fixed left-0 h-[calc(100vh-4rem)] overflow-y-auto">
            <div class="mb-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider px-3 mb-2">Menu</p>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-4 mb-2">Pembelajaran</p>
                <nav class="space-y-1">
                    <a href="#" class="flex justify-between items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded">
                        <span class="flex items-center"><i class="fa-solid fa-book w-5 text-gray-400"></i> Mata Kuliah Saya</span>
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </a>
                    <a href="#" class="flex justify-between items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded">
                        <span class="flex items-center"><i class="fa-regular fa-calendar w-5 text-gray-400"></i> Aktivitas Pembelajaran</span>
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </a>
                </nav>

                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-6 mb-2">Administrasi Platform</p>
                <nav class="space-y-1">
                    <div>
                        <button class="w-full flex justify-between items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50/50 rounded">
                            <span class="flex items-center"><i class="fa-solid fa-users w-5 text-blue-500"></i> Manajemen Pengguna</span>
                            <i class="fa-solid fa-chevron-up text-[10px]"></i>
                        </button>
                        <div class="pl-8 pr-3 py-1 space-y-1 mt-1 border-l-2 border-blue-500 ml-5">
                            <a href="#" class="block py-1.5 text-sm text-blue-600 font-medium">Daftar Pengguna</a>
                            <a href="#" class="block py-1.5 text-sm text-gray-500 hover:text-gray-800">Impor Pengguna (XML/CSV)</a>
                            <a href="#" class="block py-1.5 text-sm text-gray-500 hover:text-gray-800">Ekspor Pengguna</a>
                            <a href="#" class="block py-1.5 text-sm text-gray-500 hover:text-gray-800">Profiling</a>
                            <a href="#" class="block py-1.5 text-sm text-gray-500 hover:text-gray-800">Kelas</a>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <main class="flex-1 ml-64 p-8">
            <nav class="text-xs text-gray-500 flex items-center space-x-2 mb-6">
                <i class="fa-solid fa-house"></i>
                <span>Administrasi Platform</span>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span>Daftar Pengguna</span>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-blue-500 font-medium">Tambah Pengguna</span>
            </nav>

            <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-8 max-w-5xl">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <h2 class="text-xl font-bold text-gray-800 mb-8">Tambah Pengguna</h2>

                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Nama Depan <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" placeholder="Masukkan nama depan" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Nama Belakang <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" placeholder="Masukkan nama belakang" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Kode</label>
                        <input type="text" name="code" placeholder="Masukkan kode" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" placeholder="Masukkan email" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="phone" placeholder="Masukkan nomor telepon" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Gambar</label>
                        <div class="flex items-center justify-between border border-gray-200 bg-gray-50/50 rounded-lg p-1.5 pl-4">
                            <span class="text-sm text-gray-400">Upload your document</span>
                            <label class="bg-white border border-gray-200 text-blue-600 font-semibold text-xs px-4 py-2 rounded-md shadow-2xs hover:bg-gray-50 cursor-pointer transition">
                                Upload
                                <input type="file" name="image" class="hidden">
                            </label>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-1.5"><i class="fa-solid fa-circle-info text-blue-500 mr-1"></i> Supported formats: PDF, DOC, DOCX (Max. 100MB)</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Nama Pengguna <span class="text-red-500">*</span></label>
                        <input type="text" name="username" placeholder="Masukkan nama pengguna" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Kata Sandi <span class="text-red-500">*</span></label>
                        <div class="flex items-center space-x-6 mb-3">
                            <label class="flex items-center text-xs font-medium text-gray-600 cursor-pointer">
                                <input type="radio" name="password_type" value="auto" class="mr-2 text-blue-600 focus:ring-blue-500"> Buat kata sandi baru secara otomatis
                            </label>
                            <label class="flex items-center text-xs font-medium text-gray-600 cursor-pointer">
                                <input type="radio" name="password_type" value="manual" checked class="mr-2 text-blue-600 focus:ring-blue-500"> Masukkan kata sandi
                            </label>
                        </div>
                        <input type="password" name="password" placeholder="Masukkan kata sandi" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        
                        <div class="mt-3 space-y-1 text-xs">
                            <p class="text-emerald-600 flex items-center"><i class="fa-solid fa-circle-check mr-1.5 text-[10px]"></i> Minimal 5 karakter secara keseluruhan</p>
                            <p class="text-red-500 flex items-center"><i class="fa-solid fa-triangle-exclamation mr-1.5 text-[10px]"></i> Minimal 2 karakter angka (0-9)</p>
                            <p class="text-red-500 flex items-center"><i class="fa-solid fa-triangle-exclamation mr-1.5 text-[10px]"></i> Minimal 1 karakter spesial</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Profil</label>
                        <div class="relative">
                            <select name="role" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition appearance-none">
                                <option value="" disabled selected>Pilih profil...</option>
                                <option value="admin">Admin</option>
                                <option value="teacher">Teacher</option>
                                <option value="student">Student</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Bahasa</label>
                        <div class="relative">
                            <select name="language" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition appearance-none">
                                <option value="" disabled selected>Pilih bahasa...</option>
                                <option value="id">Bahasa Indonesia</option>
                                <option value="en">English</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Kirim Email Ke Pengguna Baru</label>
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center text-xs text-gray-600 cursor-pointer"><input type="radio" name="send_email" value="yes" class="mr-2 text-blue-600"> Ya</label>
                            <label class="flex items-center text-xs text-gray-600 cursor-pointer"><input type="radio" name="send_email" value="no" checked class="mr-2 text-blue-600"> Tidak</label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Akun <span class="text-red-500">*</span></label>
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center text-xs text-gray-600 cursor-pointer"><input type="radio" name="status" value="active" class="mr-2 text-blue-600"> Aktif</label>
                            <label class="flex items-center text-xs text-gray-600 cursor-pointer"><input type="radio" name="status" value="inactive" checked class="mr-2 text-blue-600"> Tidak aktif</label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Tanggal Kadaluwarsa</label>
                        <div class="flex items-center space-x-6 mb-3">
                            <label class="flex items-center text-xs font-medium text-gray-600 cursor-pointer">
                                <input type="radio" name="expiry_type" value="never" checked class="mr-2 text-blue-600 focus:ring-blue-500"> Tidak pernah kedaluwarsa
                            </label>
                            <label class="flex items-center text-xs font-medium text-gray-600 cursor-pointer">
                                <input type="radio" name="expiry_type" value="active" class="mr-2 text-blue-600 focus:ring-blue-500"> Aktif
                            </label>
                        </div>
                        <input type="text" name="expiry_date" placeholder="Masukkan tanggal kedaluwarsa" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Legal</label>
                        <input type="text" name="legal" placeholder="Masukkan informasi legal" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Anda sudah berhasil masuk</label>
                        <input type="text" name="login_success_msg" placeholder="Masukkan pesan sukses masuk" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Tipe skrip pembaruan</label>
                        <input type="text" name="update_script_type" placeholder="Masukkan tipe skrip pembaruan" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Tags</label>
                        <input type="text" name="tags" placeholder="Mulai mengetik, lalu klik batang ini untuk memvalidasi tag" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">RSS</label>
                        <input type="text" name="rss" placeholder="Masukkan RSS" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Dashboard</label>
                        <input type="text" name="dashboard" placeholder="Masukkan link dashboard kustom" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Zona Waktu</label>
                        <div class="relative">
                            <select name="timezone" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition appearance-none text-gray-400">
                                <option value="" disabled selected>Pilih zona waktu...</option>
                                <option value="Asia/Jakarta">Asia/Jakarta (WIB)</option>
                                <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
                                <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Beri tahu melalui email jika ada undangan baru yang diterima</label>
                        <div class="relative">
                            <select name="notify_invitation" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition appearance-none text-gray-400">
                                <option value="" disabled selected>Pilih pemberitahuan...</option>
                                <option value="yes">Ya</option>
                                <option value="no">Tidak</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Beri tahu melalui email jika ada pesan pribadi baru yang diterima</label>
                        <div class="relative">
                            <select name="notify_private_message" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition appearance-none text-gray-400">
                                <option value="" disabled selected>Pilih pemberitahuan...</option>
                                <option value="yes">Ya</option>
                                <option value="no">Tidak</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Beri tahu melalui email jika ada pesan baru yang diterima di grup</label>
                        <div class="relative">
                            <select name="notify_group_message" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition appearance-none text-gray-400">
                                <option value="" disabled selected>Pilih pemberitahuan...</option>
                                <option value="yes">Ya</option>
                                <option value="no">Tidak</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Status Obrolan Pengguna</label>
                        <input type="text" name="chat_status" placeholder="Masukkan status obrolan pengguna" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">URL Google Calendar</label>
                        <input type="text" name="google_calendar_url" placeholder="Masukkan url google calendar" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Akun terkunci sampai</label>
                        <input type="text" name="locked_until" placeholder="Masukkan masa penguncian akun" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Skype</label>
                            <input type="text" name="skype" placeholder="Masukkan skype" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">URL Profil LinkedIn</label>
                            <input type="text" name="linkedin" placeholder="Masukkan url profil linkedin" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 pt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-lg flex items-center shadow-xs transition cursor-pointer">
                            <i class="fa-solid fa-plus mr-2 text-xs"></i> Simpan
                        </button>
                        <button type="submit" name="action" value="save_and_add_more" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-lg flex items-center shadow-xs transition cursor-pointer">
                            <i class="fa-solid fa-plus mr-2 text-xs"></i> Simpan dan Tambah Baru
                        </button>
                    </div>

                </form>
            </div>
            
            <footer class="mt-12 text-xs text-gray-400 flex justify-between max-w-5xl">
                <p>&copy; 2026 Smart Exam | All rights reserved.</p>
                <div class="space-x-4">
                    <a href="#" class="hover:underline">Cara Kerja</a>
                    <a href="#" class="hover:underline">Pusat Bantuan</a>
                    <a href="#" class="hover:underline">Hubungi Kami</a>
                </div>
            </footer>
        </main>
    </div>

</body>
</html>