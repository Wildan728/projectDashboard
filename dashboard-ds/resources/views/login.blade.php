<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
</head>

<body class="bg-gradient-to-r from-red-600 to-white min-h-screen flex items-center justify-center">

    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-2xl flex overflow-hidden">
        <!-- Left side: Info with solid red background -->
        <div class="w-1/2 bg-red-600 text-white p-10 flex flex-col justify-center hidden md:flex">
            <h2 class="text-3xl font-bold mb-4">Selamat Datang Admin</h2>
            <p class="text-lg text-gray-100 drop-shadow-lg">Silakan login untuk mengakses dashboard Telkomsel Sales
                Event.</p>
        </div>

        <!-- Right side: Login form -->
        <div class="w-full md:w-1/2 bg-white p-10">
            <div class="mb-6 text-center">
                <img src="https://logowik.com/content/uploads/images/telkomsel-2021-icon4647.logowik.com.webp"
                    alt="Telkomsel Logo" class="h-20 mx-auto mb-2">
                <h2 class="text-2xl font-bold text-gray-800">Admin Login</h2>
            </div>

            <form method="POST" action="{{ 'login' }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm text-gray-600">Email</label>
                    <input id="email" type="email" name="email" required autofocus
                        class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm text-gray-600">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="h-4 w-4 text-red-600 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full py-2 px-4 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                    Login
                </button>
            </form>
        </div>
    </div>

</body>

</html>
