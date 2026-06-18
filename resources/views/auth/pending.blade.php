<x-guest-layout>
    <div class="text-center py-6">
        <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-hourglass-half text-3xl text-orange-400"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Pendaftaran Berhasil! 🎉</h2>
        <p class="text-gray-600 mb-6 leading-relaxed">
            Akun Anda saat ini <span class="font-semibold text-orange-500">sedang ditinjau</span> oleh Administrator.<br>
            Anda akan dapat mengakses sistem segera setelah akun disetujui.
        </p>
        
        <div class="bg-gray-50 border border-gray-100 rounded-lg p-4 text-sm text-gray-500">
            <i class="fa-solid fa-circle-info mr-2 text-blue-500"></i>
            Silakan cek kembali secara berkala.
        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-8">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-900 underline transition">
                Keluar dari Akun
            </button>
        </form>
    </div>
</x-guest-layout>