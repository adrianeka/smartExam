<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">User Pending Approval</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Tanggal Daftar</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-t">
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="p-3 flex gap-2">
                        <form action="{{ route('admin.users.approve', $user) }}" method="POST">
                            @csrf
                            <button class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                Approve
                            </button>
                        </form>
                        <form action="{{ route('admin.users.reject', $user) }}" method="POST">
                            @csrf
                            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                Tolak
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-3 text-center text-gray-500">Tidak ada user pending</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>