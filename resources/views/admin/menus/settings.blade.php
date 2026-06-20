<x-app-layout>
<div class="fixed inset-0 z-[100] flex bg-gray-100 overflow-hidden" x-data="{ tab: '{{ $tab }}' }">
    {{-- Left Sidebar --}}
    <div class="w-64 md:w-72 bg-gray-100/50 border-r border-gray-200 flex flex-col justify-between py-8 px-4 h-full overflow-y-auto">
        <div>
            <div class="mb-6 px-3">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">{{ $menu->type === 'category' ? 'Kategori' : 'Menu' }} Settings</p>
                <h2 class="text-lg font-bold text-gray-800 truncate" title="{{ $menu->name }}">{{ $menu->name }}</h2>
            </div>
            
            <nav class="space-y-1">
                <a href="{{ route('admin.menus.settings', ['menu' => $menu->id, 'tab' => 'overview']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition-colors {{ $tab === 'overview' ? 'bg-gray-200/70 text-gray-900' : 'text-gray-600 hover:bg-gray-200/50 hover:text-gray-900' }}">
                    <i class="fa-solid fa-circle-info w-5 text-center"></i> Overview
                </a>
                
                @if($menu->type !== 'category')
                <a href="{{ route('admin.menus.settings', ['menu' => $menu->id, 'tab' => 'permissions']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition-colors {{ $tab === 'permissions' ? 'bg-gray-200/70 text-gray-900' : 'text-gray-600 hover:bg-gray-200/50 hover:text-gray-900' }}">
                    <i class="fa-solid fa-user-lock w-5 text-center"></i> Permissions
                </a>
                @endif
            </nav>
            <div class="my-4 border-t border-gray-300"></div>
            <nav class="space-y-1">
                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus {{ $menu->type === 'category' ? 'Kategori' : 'Menu' }} ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg font-medium text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors text-left">
                        <i class="fa-solid fa-trash w-5 text-center"></i> Delete {{ $menu->type === 'category' ? 'Category' : 'Channel' }}
                    </button>
                </form>
            </nav>
        </div>
    </div>

    {{-- Main Content Area --}}
    <div class="flex-1 flex flex-col h-full bg-white relative">
        {{-- Close Button --}}
        <div class="absolute top-6 right-6 z-10">
            <a href="{{ route('dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300 text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors group">
                <i class="fa-solid fa-xmark text-lg group-hover:scale-110 transition-transform"></i>
            </a>
            <p class="text-[10px] font-bold text-gray-400 uppercase text-center mt-1">ESC</p>
        </div>

        <div class="flex-1 overflow-y-auto p-8 md:p-12 lg:px-24">
            <div class="max-w-3xl">
                
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-6 flex items-center gap-3">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-6 flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if($tab === 'overview')
                    <h1 class="text-2xl font-bold text-gray-900 mb-8">Overview</h1>
                    
                    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">{{ $menu->type === 'category' ? 'Category Name' : 'Channel Name' }}</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" class="block w-full px-4 py-3 bg-gray-100 border-transparent focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 rounded-lg transition-colors text-gray-800 font-medium" required>
                                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>

                            @if($menu->type !== 'category')
                            <div x-data="{
                                iconList: [
                                    'fa-solid fa-file-lines', 'fa-solid fa-book', 'fa-solid fa-book-open', 'fa-solid fa-graduation-cap', 
                                    'fa-solid fa-chalkboard-user', 'fa-solid fa-video', 'fa-solid fa-headphones', 'fa-solid fa-image', 
                                    'fa-solid fa-folder', 'fa-solid fa-clipboard-list', 'fa-solid fa-pen-to-square', 'fa-solid fa-chart-pie', 
                                    'fa-solid fa-bullhorn', 'fa-solid fa-message', 'fa-solid fa-users', 'fa-solid fa-award', 
                                    'fa-solid fa-star', 'fa-solid fa-bell', 'fa-solid fa-calendar-days', 'fa-solid fa-circle-play', 
                                    'fa-solid fa-link', 'fa-solid fa-download', 'fa-solid fa-check', 'fa-solid fa-circle-info', 
                                    'fa-solid fa-gamepad', 'fa-solid fa-lightbulb', 'fa-solid fa-flask', 'fa-solid fa-heart',
                                    'fa-solid fa-music', 'fa-solid fa-camera', 'fa-solid fa-calculator', 'fa-solid fa-globe'
                                ],
                                selectedIcon: '{{ old('icon', $menu->icon) ?: 'fa-solid fa-file-lines' }}',
                                showPicker: false
                            }">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Icon (Ikon Halaman)</label>
                                <div class="relative">
                                    <div class="flex items-center gap-3">
                                        <button type="button" @click="showPicker = !showPicker" class="w-12 h-12 rounded-lg bg-gray-100 border-2 border-transparent hover:border-blue-400 hover:bg-white focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 flex items-center justify-center shrink-0 transition-all cursor-pointer">
                                            <i :class="selectedIcon + ' text-blue-500 text-lg'"></i>
                                        </button>
                                        <div class="flex-1">
                                            <input type="hidden" name="icon" x-model="selectedIcon">
                                            <div class="text-sm font-medium text-gray-800" x-text="selectedIcon.replace('fa-solid ', '')"></div>
                                            <div class="text-xs text-blue-500 mt-0.5 cursor-pointer hover:underline" @click="showPicker = !showPicker">Ubah Ikon</div>
                                        </div>
                                    </div>

                                    <!-- Icon Picker Popup -->
                                    <div x-show="showPicker" @click.away="showPicker = false" x-transition.opacity.duration.200ms
                                         class="absolute left-0 mt-2 w-[320px] bg-white border border-gray-200 rounded-xl shadow-xl p-4 z-50" style="display: none;">
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Koleksi Ikon</p>
                                        <div class="grid grid-cols-6 gap-2">
                                            <template x-for="icon in iconList" :key="icon">
                                                <button type="button" @click="selectedIcon = icon; showPicker = false" 
                                                        class="w-10 h-10 rounded-lg flex items-center justify-center transition-all"
                                                        :class="selectedIcon === icon ? 'bg-blue-100 text-blue-600 border border-blue-200 shadow-inner' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800'">
                                                    <i :class="icon + ' text-lg'"></i>
                                                </button>
                                            </template>
                                        </div>
                                        <p class="text-[10px] text-gray-400 mt-3 text-center border-t border-gray-100 pt-2">Powered by FontAwesome</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="parent_id" class="block text-sm font-semibold text-gray-700 mb-2">Kategori Induk</label>
                                <select name="parent_id" id="parent_id" class="block w-full px-4 py-3 bg-gray-100 border-transparent focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 rounded-lg transition-colors text-gray-800 font-medium">
                                    <option value="">-- Tidak Ada (Menu Utama) --</option>
                                    @foreach($parentMenus as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <input type="hidden" name="url" value="{{ $menu->url }}">
                            @else
                            <input type="hidden" name="url" value="#">
                            <input type="hidden" name="icon" value="fa-solid fa-circle">
                            @endif

                            <div class="pt-6 border-t border-gray-100">
                                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>

                @elseif($tab === 'permissions' && $menu->type !== 'category')
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-1">Advanced Permissions</h1>
                            <p class="text-sm text-gray-500">Use permissions to customise who can do what in this channel.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.menus.access.update', $menu->id) }}" method="POST"
                          x-data="{
                              activeRole: null,
                              roles: [
                                  @foreach($allRoles as $role)
                                      { 
                                          id: {{ $role->id }}, 
                                          name: '{{ addslashes(ucfirst($role->name)) }}', 
                                          view: {{ $role->hasPermissionTo($viewPermissionName) ? 'true' : 'false' }}, 
                                          edit: {{ $role->hasPermissionTo($editPermissionName) ? 'true' : 'false' }},
                                          users: [
                                              @foreach($role->users as $user)
                                                  {
                                                      id: {{ $user->id }},
                                                      name: '{{ addslashes($user->name) }}',
                                                      view: {{ $user->hasDirectPermission($viewPermissionName) ? 'true' : 'false' }},
                                                      edit: {{ $user->hasDirectPermission($editPermissionName) ? 'true' : 'false' }}
                                                  },
                                              @endforeach
                                          ]
                                      },
                                  @endforeach
                              ]
                          }"
                          x-init="if(roles.length > 0) activeRole = roles[0]"
                    >
                        @csrf
                        <input type="hidden" name="source" value="settings_roles">
                        
                        <template x-for="role in roles" :key="'role-'+role.id">
                            <div>
                                <input type="hidden" :name="'roles[' + role.id + '][view]'" :value="role.view ? 1 : 0">
                                <input type="hidden" :name="'roles[' + role.id + '][edit]'" :value="role.edit ? 1 : 0">
                                <template x-for="user in role.users" :key="'user-'+user.id">
                                    <div>
                                        <input type="hidden" :name="'users[' + user.id + '][view]'" :value="user.view ? 1 : 0">
                                        <input type="hidden" :name="'users[' + user.id + '][edit]'" :value="user.edit ? 1 : 0">
                                    </div>
                                </template>
                            </div>
                        </template>

                        <div class="flex flex-col md:flex-row bg-white border border-gray-200 rounded-xl shadow-sm min-h-[500px]">
                            
                            {{-- Left Sidebar: Roles List --}}
                            <div class="w-full md:w-64 bg-gray-50/50 border-r border-gray-200 p-4 flex flex-col rounded-l-xl">
                                <div class="mb-4 px-2">
                                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Select Role</h3>
                                </div>

                                <div class="flex-1 space-y-1">
                                    <template x-for="role in roles" :key="'nav-'+role.id">
                                        <button type="button" @click="activeRole = role" 
                                                class="w-full text-left px-3 py-2.5 rounded-md text-sm transition-colors flex items-center justify-between"
                                                :class="activeRole === role ? 'bg-blue-100/50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-200/50 hover:text-gray-900'">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-circle text-[8px]" :class="activeRole === role ? 'text-blue-500' : 'text-gray-400'"></i>
                                                <span class="truncate" x-text="role.name"></span>
                                            </div>
                                            <span class="text-[10px] bg-white px-2 py-0.5 rounded-full border border-gray-200 text-gray-400" x-text="role.users.length"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            {{-- Right Panel: Permission Toggles --}}
                            <div class="flex-1 p-6 md:p-8 bg-white rounded-r-xl max-h-[600px] overflow-y-auto">
                                <template x-if="!activeRole">
                                    <div class="h-full flex flex-col items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-user-lock text-4xl mb-3 opacity-30"></i>
                                        <p class="text-sm font-medium">Select a role to edit permissions</p>
                                    </div>
                                </template>

                                <template x-if="activeRole">
                                    <div>
                                        <div class="mb-8 pb-6 border-b border-gray-100">
                                            <h3 class="text-xl font-bold text-gray-900 mb-1">
                                                <span x-text="activeRole.name"></span> Role
                                            </h3>
                                            <p class="text-sm text-gray-500 mb-6">Set permissions for all users with this role.</p>

                                            <div class="space-y-4">
                                                {{-- View Permission for Role --}}
                                                <div class="flex items-center justify-between bg-gray-50/50 p-4 rounded-lg border border-gray-100">
                                                    <div>
                                                        <h4 class="text-sm font-bold text-gray-800">View Channel</h4>
                                                        <p class="text-xs text-gray-500 mt-0.5">Allows role members to view this channel.</p>
                                                    </div>
                                                    <div class="flex items-center gap-1 bg-white border border-gray-200 rounded-md p-1 shadow-sm">
                                                        <button type="button" @click="activeRole.view = false" class="w-10 h-8 rounded flex items-center justify-center transition-colors" :class="!activeRole.view ? 'bg-red-500 text-white' : 'text-gray-400 hover:bg-gray-100'">
                                                            <i class="fa-solid fa-xmark text-sm"></i>
                                                        </button>
                                                        <button type="button" @click="activeRole.view = true" class="w-10 h-8 rounded flex items-center justify-center transition-colors" :class="activeRole.view ? 'bg-green-500 text-white' : 'text-gray-400 hover:bg-gray-100'">
                                                            <i class="fa-solid fa-check text-sm"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                {{-- Edit Permission for Role --}}
                                                <div class="flex items-center justify-between bg-gray-50/50 p-4 rounded-lg border border-gray-100">
                                                    <div>
                                                        <h4 class="text-sm font-bold text-gray-800">Manage Channel</h4>
                                                        <p class="text-xs text-gray-500 mt-0.5">Allows role members to edit this channel.</p>
                                                    </div>
                                                    <div class="flex items-center gap-1 bg-white border border-gray-200 rounded-md p-1 shadow-sm">
                                                        <button type="button" @click="activeRole.edit = false" class="w-10 h-8 rounded flex items-center justify-center transition-colors" :class="!activeRole.edit ? 'bg-red-500 text-white' : 'text-gray-400 hover:bg-gray-100'">
                                                            <i class="fa-solid fa-xmark text-sm"></i>
                                                        </button>
                                                        <button type="button" @click="activeRole.edit = true" class="w-10 h-8 rounded flex items-center justify-center transition-colors" :class="activeRole.edit ? 'bg-green-500 text-white' : 'text-gray-400 hover:bg-gray-100'">
                                                            <i class="fa-solid fa-check text-sm"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Exceptions for Individual Users --}}
                                        <div class="mt-8">
                                            <h3 class="text-sm font-bold text-gray-800 mb-1 uppercase tracking-wider">Member Exceptions</h3>
                                            <p class="text-xs text-gray-500 mb-4">
                                                By default, members inherit the permissions of their role. You can grant direct access here if the role is denied.
                                            </p>
                                            
                                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                <table class="w-full text-left text-sm">
                                                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-500">
                                                        <tr>
                                                            <th class="py-2.5 px-4 font-medium">Member Name</th>
                                                            <th class="py-2.5 px-4 text-center font-medium w-32">View</th>
                                                            <th class="py-2.5 px-4 text-center font-medium w-32">Edit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-gray-100">
                                                        <template x-for="user in activeRole.users" :key="'utable-'+user.id">
                                                            <tr class="hover:bg-gray-50/50 transition-colors">
                                                                <td class="py-3 px-4">
                                                                    <div class="flex items-center gap-3">
                                                                        <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-[10px]">
                                                                            <span x-text="user.name.charAt(0)"></span>
                                                                        </div>
                                                                        <span class="font-medium text-gray-700" x-text="user.name"></span>
                                                                    </div>
                                                                </td>
                                                                <td class="py-3 px-4">
                                                                    <div class="flex flex-col items-center justify-center gap-1">
                                                                        <label class="relative inline-flex items-center" :class="activeRole.view ? 'cursor-not-allowed opacity-50' : 'cursor-pointer'">
                                                                            <input type="checkbox" x-model="user.view" class="sr-only peer" :disabled="activeRole.view">
                                                                            <div class="w-8 h-4 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all" :class="(user.view || activeRole.view) ? 'bg-green-500 after:translate-x-full after:border-white' : ''"></div>
                                                                        </label>
                                                                        <span x-show="activeRole.view" class="text-[9px] text-gray-400 uppercase tracking-widest">Inherited</span>
                                                                    </div>
                                                                </td>
                                                                <td class="py-3 px-4">
                                                                    <div class="flex flex-col items-center justify-center gap-1">
                                                                        <label class="relative inline-flex items-center" :class="activeRole.edit ? 'cursor-not-allowed opacity-50' : 'cursor-pointer'">
                                                                            <input type="checkbox" x-model="user.edit" class="sr-only peer" :disabled="activeRole.edit">
                                                                            <div class="w-8 h-4 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all" :class="(user.edit || activeRole.edit) ? 'bg-green-500 after:translate-x-full after:border-white' : ''"></div>
                                                                        </label>
                                                                        <span x-show="activeRole.edit" class="text-[9px] text-gray-400 uppercase tracking-widest">Inherited</span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                        <template x-if="activeRole.users.length === 0">
                                                            <tr>
                                                                <td colspan="3" class="py-4 text-center text-xs text-gray-400">No members found with this role.</td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Save Changes Button Bar --}}
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors shadow-sm shadow-green-600/20">
                                Save Changes
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
</div>

{{-- Script for handling Escape key to close --}}
<script>
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            window.location.href = "{{ route('dashboard') }}";
        }
    });
</script>
</x-app-layout>
