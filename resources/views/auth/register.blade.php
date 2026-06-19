<x-guest-layout>
    <div class="mb-6 text-center lg:text-left">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Buat Akun Baru ✨</h2>
        <p class="text-gray-500 mt-2 text-sm">Bergabunglah dan mulai tingkatkan kompetensimu hari ini.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-regular fa-user"></i>
                </div>
                <input id="name" class="block w-full pl-11 pr-3 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow text-sm" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-xs" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <input id="email" class="block w-full pl-11 pr-3 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow text-sm" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="contoh@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <input id="password" class="block w-full pl-11 pr-3 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow text-sm"
                                type="password"
                                name="password"
                                required autocomplete="new-password" placeholder="Minimal 8 karakter">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Sandi</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <input id="password_confirmation" class="block w-full pl-11 pr-3 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow text-sm"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi sandi">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 text-xs" />
        </div>

        <!-- Role Selection -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Mendaftar Sebagai</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-user-tag"></i>
                </div>
                <select id="role" name="role" required class="block w-full pl-11 pr-3 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow text-sm appearance-none bg-none bg-white">
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih peran Anda...</option>
                    <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Siswa / Mahasiswa</option>
                    <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Guru / Dosen</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-1 text-red-500 text-xs" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i class="fa-solid fa-user-plus"></i>
                Daftar Sekarang
            </button>
        </div>

        <div class="mt-4 text-center text-sm text-gray-600">
            Sudah memiliki akun? 
            <a class="font-medium text-blue-600 hover:text-blue-800 hover:underline transition" href="{{ route('login') }}">
                Masuk di sini
            </a>
        </div>
    </form>
</x-guest-layout>
