<x-app-layout>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .dropdown-menu {
            animation: fadeSlideDown 0.18s ease;
        }

        @keyframes fadeSlideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .status-aktif {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-nonaktif {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .checkbox-custom {
            width: 18px;
            height: 18px;
            min-width: 18px;
            min-height: 18px;
            border-radius: 4px;
            border: 1.5px solid #d1d5db;
            background: #fff;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            vertical-align: middle;
            margin: 0;
            padding: 0;
            flex-shrink: 0;
        }

        .checkbox-custom:checked {
            background: #3b82f6;
            border-color: #3b82f6;
        }

        .checkbox-custom:checked::after {
            content: '';
            display: block;
            width: 5px;
            height: 9px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(45deg);
            margin-top: -2px;
        }

        /* Force hide native select arrow to prevent double-chevron */
        select.appearance-none,
        select.select-no-arrow {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            background-image: none !important;
        }
        select.appearance-none::-ms-expand,
        select.select-no-arrow::-ms-expand {
            display: none;
        }

        tr:hover td {
            background: #f8fafc;
        }
    </style>
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
        </svg>
        <span>Administrasi Platform</span>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-blue-600 font-medium">Daftar Pengguna</span>
    </nav>


    <!-- Search & Filters -->
    <form method="GET" action="{{ route('admin.users.index') }}" id="filterForm">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 mb-6">
        <!-- Header -->
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Daftar Pengguna</h1>
                <p class="text-sm text-gray-500 mt-1 max-w-xl">
                    Lorem ipsum dolor sit amet consectetur. Porttitor penatibus felis integer eget aliquam aliquam.
                    Natoque blandit id tellus risus in consectetur justo sit. Nulla et molestie in maecenas aliquet et.
                    Vitae at tellus nunc non viverra placerat pulvinar amet massa.
                </p>
            </div>
            <a href="{{ route('admin.user.create') }}"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengguna
            </a>
        </div>
        <p class="text-sm font-semibold text-gray-700 mb-3">Telusuri</p>
        <!-- Main Search -->
        <div class="flex gap-3 mb-4">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Masukkan nama atau email pengguna"
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700 placeholder-gray-400" />
            </div>
            <button type="submit" class="p-2.5 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
            </button>
        </div>

        <!-- Advanced Search -->
        <div class="border-t border-dashed border-gray-200 pt-4">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Advanced Search</p>
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="text-xs text-gray-600 font-medium mb-1 block">Nama Depan</label>
                    <input type="text" name="first_name" value="{{ request('first_name') }}" placeholder="Masukkan nama depan pengguna"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400" />
                </div>
                <div>
                    <label class="text-xs text-gray-600 font-medium mb-1 block">Nama Belakang</label>
                    <input type="text" name="last_name" value="{{ request('last_name') }}" placeholder="Masukkan nama belakang pengguna"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400" />
                </div>
                <div>
                    <label class="text-xs text-gray-600 font-medium mb-1 block">Nama Terdaftar</label>
                    <input type="text" name="username" value="{{ request('username') }}" placeholder="Masukkan terdaftar pengguna"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400" />
                </div>
                <div>
                    <label class="text-xs text-gray-600 font-medium mb-1 block">Email</label>
                    <input type="text" name="email" value="{{ request('email') }}" placeholder="Masukkan email pengguna"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400" />
                </div>
                <div>
                    <label class="text-xs text-gray-600 font-medium mb-1 block">Kode Pengguna</label>
                    <input type="text" name="user_id" value="{{ request('user_id') }}" placeholder="Masukkan kode pengguna"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400" />
                </div>
                <div>
                    <label class="text-xs text-gray-600 font-medium mb-1 block">Grup/Kelas</label>
                    <div class="relative">
                        <select name="group"
                            class="select-no-arrow w-full px-3 py-2 pr-10 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700 bg-white">
                            <option value="" class="text-gray-400">Masukkan grup/kelas pengguna</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="text-xs text-gray-600 font-medium mb-1 block">Profil</label>
                    <div class="relative">
                        <select name="role"
                            class="select-no-arrow w-full px-3 py-2 pr-10 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700 bg-white">
                            <option value="Semua" {{ request('role') == 'Semua' ? 'selected' : '' }}>Semua</option>
                            <option value="Mahasiswa" {{ request('role') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Dosen" {{ request('role') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <div class="col-span-2">
                    <label class="text-xs text-gray-600 font-medium mb-1 block">Status Akun</label>
                    <div class="flex gap-4 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="Aktif" {{ request('status') == 'Aktif' ? 'checked' : '' }} class="accent-blue-500" /> <span
                                class="text-sm text-gray-600">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'checked' : '' }} class="accent-blue-500" /> <span
                                class="text-sm text-gray-600">Nonaktif</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="weak_password" value="1" {{ request('weak_password') ? 'checked' : '' }} class="checkbox-custom" />
                    <span class="text-sm text-gray-600">Cari kata sandi yang lemah</span>
                </label>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Atur Ulang
                    </a>
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z" />
                        </svg>
                        Telusuri
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <span class="text-sm font-semibold text-gray-700">List</span>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">Tampilkan</span>
                <div class="relative">
                    <select name="limit" onchange="document.getElementById('filterForm').submit()"
                        class="select-no-arrow border border-gray-200 rounded-lg text-sm pl-3 pr-8 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700 bg-white">
                        <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10 Data</option>
                        <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25 Data</option>
                        <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50 Data</option>
                    </select>
                    <svg class="absolute right-2 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="w-10 px-4 py-3"><input type="checkbox" class="checkbox-custom" /></th>
                        <th class="px-4 py-3 text-left">
                            <button
                                class="flex items-center gap-1 text-blue-600 font-semibold text-xs uppercase tracking-wide hover:text-blue-800">
                                Nama
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </button>
                        </th>
                        <th class="px-4 py-3 text-left">
                            <button
                                class="flex items-center gap-1 text-blue-600 font-semibold text-xs uppercase tracking-wide hover:text-blue-800">
                                Status
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </th>
                        <th class="px-4 py-3 text-left">
                            <button
                                class="flex items-center gap-1 text-blue-600 font-semibold text-xs uppercase tracking-wide hover:text-blue-800">
                                Profil
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </th>
                        <th class="px-4 py-3 text-left text-blue-600 font-semibold text-xs uppercase tracking-wide">
                            Email</th>
                        <th class="px-4 py-3 text-left">
                            <button
                                class="flex items-center gap-1 text-blue-600 font-semibold text-xs uppercase tracking-wide hover:text-blue-800">
                                Tanggal Registrasi
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </button>
                        </th>
                        <th class="px-4 py-3 text-left">
                            <button
                                class="flex items-center gap-1 text-blue-600 font-semibold text-xs uppercase tracking-wide hover:text-blue-800">
                                Login Terakhir
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </button>
                        </th>
                        <th class="px-4 py-3 text-left text-blue-600 font-semibold text-xs uppercase tracking-wide">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $avatarColors = ['#3b82f6', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981', '#06b6d4'];
                    @endphp
                    @forelse($users as $index => $user)
                        @php
                            $initials = collect(explode(' ', $user->name))->take(2)->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))->join('');
                            $color = $avatarColors[$index % count($avatarColors)];
                            $statusClass = match($user->status) {
                                'active' => 'status-aktif',
                                'rejected' => 'status-nonaktif',
                                default => 'status-pending',
                            };
                            $statusLabel = match($user->status) {
                                'active' => 'Aktif',
                                'rejected' => 'Nonaktif',
                                default => 'Pending',
                            };
                            $roleName = $user->roles->first()?->name ?? $user->role ?? '-';
                        @endphp
                        <tr class="border-b border-gray-50 transition-colors">
                            <td class="px-4 py-3"><input type="checkbox" class="checkbox-custom" /></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                        style="background:{{ $color }}">{{ $initials }}</div>
                                    <div>
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="font-semibold text-gray-800 text-sm hover:text-blue-600 hover:underline transition">{{ $user->name }}</a>
                                        <p class="text-xs text-gray-400">{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($roleName) }}</td>
                            <td class="px-4 py-3 text-sm text-blue-500 hover:underline cursor-pointer">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $user->created_at?->format('d M Y, H:i') ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $user->updated_at?->format('d M Y, H:i') ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if($user->status === 'pending')
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick="document.getElementById('approve-form-{{ $user->id }}').submit();" class="p-1.5 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 transition" title="Setujui Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                        
                                        <button type="button" onclick="if(confirm('Apakah Anda yakin ingin menolak akun ini?')) document.getElementById('reject-form-{{ $user->id }}').submit();" class="p-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition" title="Tolak Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                @else
                                    <button class="action-btn p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors" data-user-id="{{ $user->id }}" title="Aksi lainnya">
                                        <svg class="w-5 h-5 pointer-events-none" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="5" r="1.5"/>
                                            <circle cx="12" cy="12" r="1.5"/>
                                            <circle cx="12" cy="19" r="1.5"/>
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center text-gray-400 text-sm">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Belum ada pengguna terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
    </form>

    {{-- Hidden Forms for Approve/Reject --}}
    @foreach($users as $user)
        @if($user->status === 'pending')
            <form id="approve-form-{{ $user->id }}" action="{{ route('admin.users.approve', $user) }}" method="POST" class="hidden">
                @csrf
            </form>
            <form id="reject-form-{{ $user->id }}" action="{{ route('admin.users.reject', $user) }}" method="POST" class="hidden">
                @csrf
            </form>
        @endif
    @endforeach

    <!-- Dropdown Action Card -->
    <div id="actionDropdown"
        class="hidden fixed z-50 bg-white rounded-2xl shadow-2xl border border-gray-100 w-56 py-2 dropdown-menu">
        <div class="px-2">
            <button
                class="flex items-center gap-3 w-full px-3 py-2.5 hover:bg-blue-50 rounded-xl text-gray-800 hover:text-blue-700 transition-colors text-sm">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                Daftar Mata Kuliah
            </button>
            <button
                class="flex items-center gap-3 w-full px-3 py-2.5 hover:bg-blue-50 rounded-xl text-gray-800 hover:text-blue-700 transition-colors text-sm">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
                Sesi Mata Kuliah
            </button>
            <button
                class="flex items-center gap-3 w-full px-3 py-2.5 hover:bg-blue-50 rounded-xl text-gray-800 hover:text-blue-700 transition-colors text-sm">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Masuk Sebagai
            </button>
            <button
                class="flex items-center gap-3 w-full px-3 py-2.5 hover:bg-blue-50 rounded-xl text-gray-800 hover:text-blue-700 transition-colors text-sm">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan Aktivitas
            </button>
            <a id="dropdownEditLink" href="#"
                class="flex items-center gap-3 w-full px-3 py-2.5 hover:bg-blue-50 rounded-xl text-gray-800 hover:text-blue-700 transition-colors text-sm">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Ubah Profil
            </a>
            <button
                class="flex items-center gap-3 w-full px-3 py-2.5 hover:bg-blue-50 rounded-xl text-gray-800 hover:text-blue-700 transition-colors text-sm">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Tambah Keahlian
            </button>
            <button
                class="flex items-center gap-3 w-full px-3 py-2.5 hover:bg-blue-50 rounded-xl text-gray-800 hover:text-blue-700 transition-colors text-sm">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Jadwal Kalender
            </button>
            <button
                class="flex items-center gap-3 w-full px-3 py-2.5 hover:bg-blue-50 rounded-xl text-gray-800 hover:text-blue-700 transition-colors text-sm">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
                Anonimkan Data
            </button>
            <div class="border-t border-gray-100 mt-1 pt-1">
                <button
                    class="flex items-center gap-3 w-full px-3 py-2.5 hover:bg-red-50 rounded-xl text-red-500 hover:text-red-600 transition-colors text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Pengguna
                </button>
            </div>
        </div>
    </div>


    <!-- Overlay -->
    <div id="overlay" class="hidden fixed inset-0 z-40"></div>

    <script>
        const dropdown = document.getElementById('actionDropdown');
        const overlay = document.getElementById('overlay');
        let activeBtn = null;

        function openDropdown(btn) {
            activeBtn = btn;
            const userId = btn.dataset.userId;

            // Update the edit link with the correct user id
            // Since there's no edit route yet, we keep it as '#' for now
            const editLink = document.getElementById('dropdownEditLink');
            if (editLink) {
                editLink.href = '/admin/user/${userId}/edit'; // Will be: /admin/users/{id}/edit when route exists
            }

            const rect = btn.getBoundingClientRect();
            const ddW = 224;

            // Position below the button, aligned to the right edge
            let top = rect.bottom + 4;
            let left = rect.right - ddW;

            // Keep within viewport horizontally
            if (left < 8) left = 8;
            if (left + ddW > window.innerWidth - 8) left = window.innerWidth - ddW - 8;

            // If not enough space below, show above the button
            dropdown.classList.remove('hidden');
            const ddH = dropdown.offsetHeight;

            if (top + ddH > window.innerHeight - 8) {
                top = rect.top - ddH - 4;
            }

            // If still out of viewport (above), force to top
            if (top < 8) top = 8;

            dropdown.style.position = 'fixed';
            dropdown.style.top = top + 'px';
            dropdown.style.left = left + 'px';
            overlay.classList.remove('hidden');

            // Re-trigger animation
            dropdown.classList.remove('dropdown-menu');
            void dropdown.offsetWidth;
            dropdown.classList.add('dropdown-menu');
        }

        function closeDropdown() {
            dropdown.classList.add('hidden');
            overlay.classList.remove('dropdown-menu');
            overlay.classList.add('hidden');
            activeBtn = null;
        }

        // Handle click on action buttons
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.action-btn');

            // If clicked outside the dropdown and outside action buttons, close
            if (!btn && !e.target.closest('#actionDropdown')) {
                closeDropdown();
                return;
            }

            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();

            // Toggle if clicking same button
            if (activeBtn === btn && !dropdown.classList.contains('hidden')) {
                closeDropdown();
                return;
            }

            openDropdown(btn);
        });

        // Close dropdown on overlay click
        overlay.addEventListener('click', closeDropdown);

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDropdown();
        });

        // Close on scroll or resize to prevent misaligned dropdown
        window.addEventListener('scroll', closeDropdown, true);
        window.addEventListener('resize', closeDropdown);
    </script>
</x-app-layout>