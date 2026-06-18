<x-app-layout>
<style>
    /* Force hide native select arrow to prevent double-chevron */
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


    <div class="">

        <main class="flex-1 ">
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

                <form action="{{ route('admin.user.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    @include('users.form')
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
</x-app-layout>