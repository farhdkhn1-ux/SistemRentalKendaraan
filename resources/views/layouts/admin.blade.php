<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Control</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f6f8fc]">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#0f172a] text-white flex flex-col justify-between">

        <div>
            <div class="p-6 border-b border-slate-800">
                <h1 class="text-xl font-bold">Fleet Control</h1>
            </div>

            <nav class="p-4 space-y-2">

                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-3 rounded-xl
                   {{ request()->routeIs('admin.dashboard*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.vehicles.index') }}"
                   class="block px-4 py-3 rounded-xl
                   {{ request()->routeIs('admin.vehicles.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800' }}">
                    Vehicles
                </a>

                <a href="{{ route('admin.rentals.index') }}"
                   class="block px-4 py-3 rounded-xl
                   {{ request()->routeIs('admin.rentals.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800' }}">
                    Rentals
                </a>

                <a href="#" class="block px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800">
                    Reports
                </a>

                <div class="mt-4 pt-4 border-t border-slate-800">
                    <a href="{{ route('home') }}" target="_blank"
                       class="flex items-center gap-2 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Visit Website
                    </a>
                </div>

            </nav>
        </div>

        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-500"></div>
                <div>
                    <p class="font-semibold text-sm">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400">Fleet Manager</p>
                </div>
            </div>
        </div>

    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Topbar -->
        <header class="bg-white border-b px-8 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-slate-800">
                @yield('title', 'Dashboard')
            </h2>

            <div class="flex items-center gap-4">
                <input type="text"
                       placeholder="Search..."
                       class="px-4 py-2 rounded-xl border text-sm">

                <a href="{{ route('admin.rentals.create') }}"
                   class="bg-black text-white px-4 py-2 rounded-xl text-sm">
                    + New Rental
                </a>
            </div>
        </header>

        <!-- Page -->
        <main class="p-8">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>