<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Gaji Pegawai')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <nav class="bg-blue-600 text-white px-6 py-4 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <h1 class="mb-4 text-4xl font-semibold">App Pegawai</h1>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('employees.index') }}" class="hover:underline font-semibold ">Pegawai</a>
                    <a href="{{ route('departments.index') }}" class="hover:underline font-semibold">Departemen</a>
                    <a href="{{ route('attendances.index') }}" class="hover:underline font-semibold">Attendances</a>
                    <a href="{{ route('salaries.index') }}" class="hover:underline font-semibold">Gaji Pegawai</a>
                    <a href="{{ url('/report') }}" class="hover:underline font-semibold">Report</a>
                    <a href="{{ url('/settings') }}" class="hover:underline font-semibold">Settings</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-6 px-4 flex-1">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white text-center py-3 mt-6">
        <p>&copy; 2025 App Pegawai</p>
    </footer>
</body>
</html>
