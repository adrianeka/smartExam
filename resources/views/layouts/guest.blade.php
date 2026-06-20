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
        <div id="matrix-container" class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-900 via-blue-700 to-cyan-600 relative items-center justify-center overflow-hidden">
            <!-- Canvas for Matrix Animation -->
            <canvas id="matrixCanvas" class="absolute inset-0 z-0 opacity-60 mix-blend-color-dodge"></canvas>
            
            <!-- Decorative circles -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/2 right-12 w-64 h-64 bg-cyan-300 opacity-10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-24 left-1/4 w-80 h-80 bg-blue-400 opacity-20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 text-center px-12 text-white pointer-events-none">
                <div class="mb-6 inline-flex items-center justify-center w-24 h-24 bg-white/10 rounded-2xl backdrop-blur-md border border-white/20 shadow-[0_0_30px_rgba(0,255,255,0.3)]">
                    <i class="fa-solid fa-graduation-cap text-5xl drop-shadow-[0_0_10px_rgba(255,255,255,0.8)]"></i>
                </div>
                <h1 class="text-5xl font-bold mb-4 tracking-tight drop-shadow-lg">Smart Exam</h1>
                <p class="text-xl text-blue-50 font-light leading-relaxed max-w-lg mx-auto drop-shadow-md">
                    Platform Pembelajaran dan Evaluasi Digital Terintegrasi.
                </p>
            </div>
        </div>

        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob {
                animation: blob 10s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>

        <!-- Right Side: Form Content -->
        <div id="right-container" class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative overflow-y-auto overflow-x-hidden bg-gray-50/50">
            
            <!-- Aurora Glows Wrapper (Prevents Scrollbar) -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
                <!-- Subtle Ambient Glows (Aurora / Floating Orbs) -->
                <div class="absolute top-10 right-10 w-[30rem] h-[30rem] bg-blue-200/50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
                <div class="absolute top-20 -left-10 w-[30rem] h-[30rem] bg-cyan-200/50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-20 left-20 w-[30rem] h-[30rem] bg-indigo-200/50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
            </div>

            <!-- Mobile decorative bg -->
            <div class="lg:hidden absolute top-0 left-0 w-full h-72 bg-gradient-to-br from-blue-800 to-cyan-500 z-0"></div>

            <div class="w-full max-w-md bg-white/70 backdrop-blur-2xl rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/60 p-8 sm:p-10 relative z-10">
                <!-- Mobile Header -->
                <div class="flex lg:hidden justify-center mb-6 text-blue-600">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-2xl shadow-inner">
                        <i class="fa-solid fa-graduation-cap text-3xl"></i>
                    </div>
                </div>
                
                {{ $slot }}
            </div>
        </div>
        
        <script>
            // Edu-Matrix Rain Animation (Left Side Only)
            document.addEventListener('DOMContentLoaded', () => {
                const canvas = document.getElementById('matrixCanvas');
                if (!canvas) return;
                
                const ctx = canvas.getContext('2d');
                const container = document.getElementById('matrix-container');

                // Resize canvas to fit container
                function resizeCanvas() {
                    canvas.width = container.offsetWidth;
                    canvas.height = container.offsetHeight;
                }
                resizeCanvas();
                window.addEventListener('resize', resizeCanvas);

                // Characters: Mix of Binary, Math symbols, and letters to fit LMS theme
                const chars = '01∑∫π∞√∆Ωαβγλµθ0101E=mc²';
                const charArray = chars.split('');

                const fontSize = 16;
                let columns = Math.floor(canvas.width / fontSize);
                let drops = [];

                // Initialize drops
                for (let x = 0; x < columns; x++) {
                    drops[x] = Math.random() * canvas.height; 
                }

                function draw() {
                    // Update columns if resized
                    const newColumns = Math.floor(canvas.width / fontSize);
                    if (newColumns !== columns) {
                        columns = newColumns;
                        drops = [];
                        for (let x = 0; x < columns; x++) {
                            drops[x] = Math.random() * canvas.height;
                        }
                    }

                    // Black background with 0.1 opacity for trailing effect
                    // Because of mix-blend-mode: color-dodge, black is invisible, only the trails show!
                    ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    // Bright Cyan text
                    ctx.fillStyle = '#00ffff';
                    ctx.font = fontSize + 'px monospace';

                    for (let i = 0; i < drops.length; i++) {
                        const text = charArray[Math.floor(Math.random() * charArray.length)];
                        
                        ctx.fillText(text, i * fontSize, drops[i] * fontSize);

                        // Reset drop to top randomly after it passes the screen
                        if (drops[i] * fontSize > canvas.height && Math.random() > 0.98) {
                            drops[i] = 0;
                        }
                        drops[i]++;
                    }
                }

                // Run animation at ~30 FPS
                setInterval(draw, 33);
            });
        </script>
    </body>
</html>
