<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-expanded {
            width: 260px;
        }

        .sidebar-collapsed {
            width: 64px;
        }

        .sidebar {
            transition: width 0.25s ease;
        }

        .label-text {
            transition: opacity 0.2s ease, width 0.2s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-collapsed .label-text {
            opacity: 0;
            width: 0;
        }

        .sidebar-collapsed .section-label {
            opacity: 0;
            height: 0;
            margin: 0;
            overflow: hidden;
        }

        .sidebar-collapsed .chevron-icon {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar-collapsed .submenu {
            display: none !important;
        }

        .sidebar-collapsed .nav-item {
            justify-content: center;
        }

        .sidebar-collapsed .nav-item .icon {
            margin-right: 0;
        }

        .main-content {
            transition: margin-left 0.25s ease;
        }

        .submenu {
            overflow: hidden;
            transition: max-height 0.25s ease;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        @include('layouts.navigation')
        @include('layouts.sidebar')

        <!-- Page Heading -->
        @isset($header)
            <header class="">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main id="mainContent" class="main-content pt-16 min-h-screen" style="margin-left: 260px;">
            <div class="p-6 sm:p-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const topNav = document.getElementById('topNav');
        const mainContent = document.getElementById('mainContent');
        const btn = document.getElementById('sidebarToggle');
        const navbarHeight = topNav.offsetHeight;
        let expanded = true;
        sidebar.style.top = `${navbarHeight}px`;
        sidebar.style.height = `calc(100vh - ${navbarHeight}px)`;

        btn.addEventListener('click', () => {
            expanded = !expanded;

            if (expanded) {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
                // topNav.style.left = '260px';
                mainContent.style.marginLeft = '260px';
            } else {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
                // topNav.style.left = '64px';
                mainContent.style.marginLeft = '64px';
            }
        });
    </script>
</body>

</html>