<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Smart Exam') }}</title>

        <!-- Fonts & Icons -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 flex h-screen overflow-hidden">
        
        <!-- Left Side: Branding / Image -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-cyan-500 relative items-center justify-center overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 right-12 w-64 h-64 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-24 left-1/4 w-80 h-80 bg-blue-400 opacity-20 rounded-full blur-3xl"></div>

            <div class="relative z-10 text-center px-12 text-white">
                <div class="mb-6 inline-flex items-center justify-center w-24 h-24 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/20 shadow-xl">
                    <i class="fa-solid fa-graduation-cap text-5xl drop-shadow-lg"></i>
                </div>
                <h1 class="text-5xl font-bold mb-4 tracking-tight">Smart Exam</h1>
                <p class="text-xl text-blue-50 font-light leading-relaxed max-w-lg mx-auto">
                    Platform Pembelajaran dan Evaluasi Digital Terintegrasi.
                </p>
            </div>
        </div>

        <!-- Right Side: Form Content -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative overflow-y-auto">
            <!-- Mobile decorative bg -->
            <div class="lg:hidden absolute top-0 left-0 w-full h-72 bg-gradient-to-br from-blue-600 to-cyan-500 z-0"></div>

            <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sm:p-10 relative z-10">
                <!-- Mobile Header -->
                <div class="flex lg:hidden justify-center mb-6 text-blue-600">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-2xl">
                        <i class="fa-solid fa-graduation-cap text-3xl"></i>
                    </div>
                </div>
                
                {{ $slot }}
            </div>
        </div>
        
    </body>
</html>
