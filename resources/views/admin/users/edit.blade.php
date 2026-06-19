<x-app-layout>
<style>
    select.select-no-arrow {
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
        background-image: none !important;
    }
    select.select-no-arrow::-ms-expand {
        display: none;
    }
</style>
<body class="bg-gray-100 text-gray-700 font-sans">
    <div>
        <main class="flex-1">
            <nav class="text-xs text-gray-500 flex items-center space-x-2 mb-6">
                <i class="fa-solid fa-house"></i>
                <span>Administrasi Platform</span>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <a href="{{ route('admin.users.index') }}" class="hover:text-blue-500 transition-colors">Daftar Pengguna</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-blue-500 font-medium">Edit Pengguna: {{ $user->name }}</span>
            </nav>

            <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-8 max-w-5xl">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                        {{ session('error') }}
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
                
                <h2 class="text-xl font-bold text-gray-800 mb-8">Edit Profil Pengguna</h2>

                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            $parts = explode(' ', $user->name, 2);
                            $firstName = $parts[0] ?? '';
                            $lastName = $parts[1] ?? '';
                        @endphp
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Nama Depan <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $firstName) }}" required class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Nama Belakang <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $lastName) }}" required class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Ubah Kata Sandi (Kosongkan jika tidak ingin diubah)</label>
                        <input type="password" name="password" placeholder="Minimal 5 karakter" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Profil (Role) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="roles[]" required class="select-no-arrow w-full px-4 py-2.5 pr-10 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition text-gray-700">
                                    <option value="" disabled>Pilih profil...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ in_array($role->id, old('roles', $userRoleIds)) ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Status Akun <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="status" required class="select-no-arrow w-full px-4 py-2.5 pr-10 bg-gray-50/50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition text-gray-700">
                                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Pending (Menunggu Persetujuan)</option>
                                    <option value="rejected" {{ old('status', $user->status) == 'rejected' ? 'selected' : '' }}>Nonaktif (Ditolak/Diblokir)</option>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 pt-6 border-t border-gray-100">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-lg flex items-center shadow-xs transition cursor-pointer">
                            <i class="fa-solid fa-save mr-2 text-xs"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold text-sm px-5 py-2.5 rounded-lg flex items-center shadow-xs transition cursor-pointer">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</x-app-layout>
