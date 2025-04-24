<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap & Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>
<body class="bg-gray-100 min-h-screen sidebar-open" id="app">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white fixed-top shadow px-4 z-50">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <button id="sidebarToggle" class="btn" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-danger" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <a class="navbar-brand fw-bold text-danger ms-2" href="#">Dashboard Telkomsel</a>
        </div>
    </nav>

    <div class="flex pt-16 min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed top-16 left-0 w-64 bg-red-700 text-white p-6 z-40 h-[calc(100vh-64px)] transform -translate-x-full md:translate-x-0 md:relative md:top-0 md:h-auto transition-transform duration-300 ease-in-out">
            <h2 class="text-2xl font-bold mb-6">Telkomsel</h2>
            <nav class="space-y-4">
                <a href="/dashboard" class="block py-2 px-4 rounded hover:bg-red-600">Dashboard</a>
                <a href="/events" class="block py-2 px-4 rounded hover:bg-red-600">Data Event</a>
                <a href="/upload" class="block py-2 px-4 rounded hover:bg-red-600">Upload Report</a>
                <a href="/logout" class="block py-2 px-4 rounded hover:bg-red-600">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 transition-all">
            @yield('content')
        </main>
    </div>

    <!-- Custom JS -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>