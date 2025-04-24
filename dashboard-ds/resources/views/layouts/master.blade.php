<!-- layout.master.html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Sidebar */
        #sidebar {
            transition: transform 0.3s ease-in-out;
            position: fixed;
            top: 64px;
            /* Sesuaikan dengan tinggi navbar */
            left: 0;
            width: 16rem;
            height: 100vh;
            background-color: #E11D48;
            /* Warna merah */
            color: white;
            z-index: 40;
        }

        /* Sidebar dalam kondisi terbuka */
        .sidebar-open #sidebar {
            transform: translateX(0);
        }

        /* Sidebar dalam kondisi tertutup */
        .sidebar-closed #sidebar {
            transform: translateX(-100%);
        }

        /* Responsif untuk desktop */
        @media (min-width: 768px) {
            main {
                transition: margin-left 0.3s ease-in-out;
                /* Animasi transisi untuk main */
                margin-left: 0;
                /* Konten akan dimulai di 0 */
            }

            /* Ketika sidebar terbuka, geser konten ke kanan */
            .sidebar-open main {
                margin-left: 16rem;
                /* Pindahkan konten ke kanan saat sidebar terbuka */
            }
        }

        /* Responsif untuk mobile */
        @media (max-width: 767px) {
            main {
                margin-left: 0;
                /* Konten utama tetap full-screen tanpa margin */
            }

            /* Saat sidebar terbuka, konten tetap ikut bergerak ke kanan */
            .sidebar-open main {
                margin-left: 16rem;
                /* Sidebar width untuk tampilan mobile */
            }
        }
    </style>
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
            <!-- Main content will be injected here -->
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const app = document.getElementById('app');
            app.classList.toggle('sidebar-open');
            app.classList.toggle('sidebar-closed');
        }
    </script>

</body>

</html>
