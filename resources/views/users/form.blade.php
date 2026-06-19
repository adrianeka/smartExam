<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-xs font-bold text-gray-700 mb-2">Nama Depan <span class="text-red-500">*</span></label>
        <input type="text" name="first_name" dusk="first_name" placeholder="Masukkan nama depan" value="{{ old('first_name', $user->name ?? '') }}"
            class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-700 mb-2">Nama Belakang <span
                class="text-red-500">*</span></label>
        <input type="text" name="last_name" dusk="last_name" placeholder="Masukkan nama belakang" value="{{ old('last_name', $user->name ?? '') }}"
            class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
    </div>
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Kode</label>
    <input type="text" name="code" placeholder="Masukkan kode"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-xs font-bold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
        <input type="email" name="email" dusk="email" value="{{ old('email', $user->email ?? '') }}" placeholder="Masukkan email"
            class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-700 mb-2">Nomor Telepon</label>
        <input type="text" name="phone" placeholder="Masukkan nomor telepon"
            class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
    </div>
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">File</label>
    <div class="flex items-center justify-between border border-gray-200 bg-gray-50/50 rounded-lg p-1.5 pl-4">
        <span id="file-name-display" class="text-sm text-gray-400">Upload your document</span>
        <label
            class="bg-white border border-gray-200 text-blue-600 font-semibold text-xs px-4 py-2 rounded-md shadow-2xs hover:bg-gray-50 cursor-pointer transition">
            Upload
            <input type="file" name="image" id="file-upload-input" class="hidden" onchange="
                                    const display = document.getElementById('file-name-display');
                                    if (this.files[0]) {
                                        display.innerText = this.files[0].name;
                                        display.classList.remove('text-gray-400');
                                        display.classList.add('text-gray-700');
                                    } else {
                                        display.innerText = 'Upload your document';
                                        display.classList.remove('text-gray-700');
                                        display.classList.add('text-gray-400');
                                    }
                                ">
        </label>
    </div>
    <p class="text-[11px] text-gray-400 mt-1.5"><i class="fa-solid fa-circle-info text-blue-500 mr-1"></i> Supported
        formats: PDF, DOC, DOCX (Max. 100MB)</p>
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Nama Pengguna <span class="text-red-500">*</span></label>
    <input type="text" name="username" dusk="username" placeholder="Masukkan nama pengguna" value="{{ old('username', $user->name ?? '') }}"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Kata Sandi <span class="text-red-500">*</span></label>
    <div class="flex items-center space-x-6 mb-3">
        <label class="flex items-center text-xs font-medium text-gray-600 cursor-pointer">
            <input type="radio" name="password_type" value="auto" class="mr-2 text-blue-600 focus:ring-blue-500"> Buat
            kata sandi baru secara otomatis
        </label>
        <label class="flex items-center text-xs font-medium text-gray-600 cursor-pointer">
            <input type="radio" name="password_type" value="manual" checked
                class="mr-2 text-blue-600 focus:ring-blue-500"> Masukkan kata sandi
        </label>
    </div>
    <input type="password" name="password" dusk="password" placeholder="Masukkan kata sandi"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">

    <div class="mt-3 space-y-1 text-xs">
        <p class="text-emerald-600 flex items-center"><i class="fa-solid fa-circle-check mr-1.5 text-[10px]"></i>
            Minimal 5 karakter secara keseluruhan</p>
        <p class="text-red-500 flex items-center"><i class="fa-solid fa-triangle-exclamation mr-1.5 text-[10px]"></i>
            Minimal 2 karakter angka (0-9)</p>
        <p class="text-red-500 flex items-center"><i class="fa-solid fa-triangle-exclamation mr-1.5 text-[10px]"></i>
            Minimal 1 karakter spesial</p>
    </div>
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Profil</label>
    <div class="relative">
        <select name="role"
            class="select-no-arrow w-full px-4 py-2.5 pr-10 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition text-gray-700">
            <option value="" disabled selected>Pilih profil...</option>
            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="teacher" {{ old('role', $user->role ?? '') == 'teacher' ? 'selected' : '' }}>Teacher</option>
            <option value="student" {{ old('role', $user->role ?? '') == 'student' ? 'selected' : '' }}>Student</option>
        </select>
        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
            <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
        </div>
    </div>
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Bahasa</label>
    <div class="relative">
        <select name="language"
            class="select-no-arrow w-full px-4 py-2.5 pr-10 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition text-gray-700">
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
        <label class="flex items-center text-xs text-gray-600 cursor-pointer"><input type="radio" name="send_email"
                value="yes" class="mr-2 text-blue-600"> Ya</label>
        <label class="flex items-center text-xs text-gray-600 cursor-pointer"><input type="radio" name="send_email"
                value="no" checked class="mr-2 text-blue-600"> Tidak</label>
    </div>
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Akun <span class="text-red-500">*</span></label>
    <div class="flex items-center space-x-6">
    <label class="flex items-center text-xs text-gray-600 cursor-pointer">
        <input type="radio"
               name="status"
               value="active"
              {{ old('status', $user->status ?? '' ?? 'active') == 'active' ? 'checked' : '' }}
               class="mr-2 text-blue-600">
        Aktif
    </label>

    <label class="flex items-center text-xs text-gray-600 cursor-pointer">
        <input type="radio"
               name="status"
               value="rejected"
               {{ old('status', $user->status ?? '' ?? 'active') != 'active' ? 'checked' : '' }}
               class="mr-2 text-blue-600">
        Tidak aktif
    </label>
</div>
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Tanggal Kadaluwarsa</label>
    <div class="flex items-center space-x-6 mb-3">
        <label class="flex items-center text-xs font-medium text-gray-600 cursor-pointer">
            <input type="radio" name="expiry_type" value="never" checked class="mr-2 text-blue-600 focus:ring-blue-500">
            Tidak pernah kedaluwarsa
        </label>
        <label class="flex items-center text-xs font-medium text-gray-600 cursor-pointer">
            <input type="radio" name="expiry_type" value="active" class="mr-2 text-blue-600 focus:ring-blue-500"> Aktif
        </label>
    </div>
    <input type="text" name="expiry_date" placeholder="Masukkan tanggal kedaluwarsa"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Legal</label>
    <input type="text" name="legal" placeholder="Masukkan informasi legal"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Anda sudah berhasil masuk</label>
    <input type="text" name="login_success_msg" placeholder="Masukkan pesan sukses masuk"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Tipe skrip pembaruan</label>
    <input type="text" name="update_script_type" placeholder="Masukkan tipe skrip pembaruan"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Tags</label>
    <input type="text" name="tags" placeholder="Mulai mengetik, lalu klik batang ini untuk memvalidasi tag"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">RSS</label>
    <input type="text" name="rss" placeholder="Masukkan RSS"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Dashboard</label>
    <input type="text" name="dashboard" placeholder="Masukkan link dashboard kustom"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Zona Waktu</label>
    <div class="relative">
        <select name="timezone"
            class="select-no-arrow w-full px-4 py-2.5 pr-10 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition text-gray-700">
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
    <label class="block text-xs font-bold text-gray-700 mb-2">Beri tahu melalui email jika ada undangan baru yang
        diterima</label>
    <div class="relative">
        <select name="notify_invitation"
            class="select-no-arrow w-full px-4 py-2.5 pr-10 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition text-gray-700">
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
    <label class="block text-xs font-bold text-gray-700 mb-2">Beri tahu melalui email jika ada pesan pribadi baru yang
        diterima</label>
    <div class="relative">
        <select name="notify_private_message"
            class="select-no-arrow w-full px-4 py-2.5 pr-10 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition text-gray-700">
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
    <label class="block text-xs font-bold text-gray-700 mb-2">Beri tahu melalui email jika ada pesan baru yang diterima
        di grup</label>
    <div class="relative">
        <select name="notify_group_message"
            class="select-no-arrow w-full px-4 py-2.5 pr-10 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition text-gray-700">
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
    <input type="text" name="chat_status" placeholder="Masukkan status obrolan pengguna"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">URL Google Calendar</label>
    <input type="text" name="google_calendar_url" placeholder="Masukkan url google calendar"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 mb-2">Akun terkunci sampai</label>
    <input type="text" name="locked_until" placeholder="Masukkan masa penguncian akun"
        class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
    <div>
        <label class="block text-xs font-bold text-gray-700 mb-2">Skype</label>
        <input type="text" name="skype" placeholder="Masukkan skype"
            class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-700 mb-2">URL Profil LinkedIn</label>
        <input type="text" name="linkedin" placeholder="Masukkan url profil linkedin"
            class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
    </div>
</div>

<div class="flex items-center space-x-3 pt-6">
    <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-lg flex items-center shadow-xs transition cursor-pointer">
        <i class="fa-solid fa-plus mr-2 text-xs"></i> Simpan
    </button>
    <button type="submit" name="action" value="save_and_add_more"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-lg flex items-center shadow-xs transition cursor-pointer">
        <i class="fa-solid fa-plus mr-2 text-xs"></i> Simpan dan Tambah Baru
    </button>
</div>