<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center gap-4">
                <a href="{{ route('admin.roles.index') }}" class="p-2 bg-white rounded-full shadow-sm hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Role: <span class="text-blue-600 capitalize">{{ $role->name }}</span></h2>
                    <p class="text-sm text-gray-500">Sesuaikan nama role dan hak aksesnya.</p>
                </div>
            </div>

            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Nama Role -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">Nama Role</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" {{ in_array($role->name, ['teacher', 'student']) ? 'readonly title="Nama role bawaan tidak bisa diubah"' : '' }} required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if(in_array($role->name, ['teacher', 'student']))
                        <p class="mt-2 text-xs text-amber-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Nama role bawaan sistem tidak dapat diubah.
                        </p>
                    @endif
                </div>

                <!-- Permissions Checklist (Discord Style) -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-900">Hak Akses (Permissions)</h3>
                        <p class="text-sm text-gray-500 mt-1">Centang tindakan apa saja yang diizinkan untuk role ini.</p>
                    </div>

                    <div class="p-6 space-y-8">
                        @foreach($permissions as $group => $perms)
                            <div>
                                <h4 class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">{{ $group }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($perms as $permission)
                                        <label class="flex items-start space-x-3 p-3 rounded-xl border border-transparent hover:border-gray-200 hover:bg-gray-50 cursor-pointer transition-all">
                                            <div class="flex items-center h-5">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-semibold text-gray-900 capitalize">{{ $permission->name }}</span>
                                                <span class="text-xs text-gray-500 font-normal">Mengizinkan pengguna untuk {{ strtolower($permission->name) }} di dalam sistem.</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
