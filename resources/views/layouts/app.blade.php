<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RentalKu') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-white text-gray-900">

    <div class="min-h-screen">

        <!-- Navbar -->
        <header class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

                {{-- Left Side --}}
                <div class="flex items-center gap-6">

                    {{-- Logo --}}
                    <a href="{{ route('home') }}"
                       class="text-2xl font-bold text-blue-600">
                        RentalKu
                    </a>

                    @auth
                        @if(auth()->user()->role === 'customer')
                            {{-- User Greeting --}}
                            <span class="text-gray-700 font-medium">
                                Halo, {{ auth()->user()->name }} 👋
                            </span>
                        @endif
                    @endauth

                </div>

                {{-- Right Side Navigation --}}
                <nav class="flex items-center gap-6 text-sm font-medium">

                    {{-- Kendaraan --}}
                    <a href="{{ route('vehicles.catalog') }}"
                       class="relative px-2 py-1 transition
                       {{ request()->routeIs('vehicles.catalog')
                            || request()->routeIs('vehicles.show')
                            || request()->routeIs('customer.booking')
                            ? 'text-blue-600 font-semibold'
                            : 'text-gray-700 hover:text-blue-600' }}">
                        Kendaraan

                        @if(
                            request()->routeIs('vehicles.catalog')
                            || request()->routeIs('vehicles.show')
                            || request()->routeIs('customer.booking')
                        )
                            <span class="absolute left-0 -bottom-1 h-0.5 w-full bg-blue-600 rounded-full"></span>
                        @endif
                    </a>

                    @guest
                        {{-- Login --}}
                        <a href="{{ route('login') }}"
                           class="text-gray-700 hover:text-blue-600 transition">
                            Login
                        </a>

                        {{-- Register --}}
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="rounded-full bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700 transition">
                                Register
                            </a>
                        @endif
                    @endguest

                    @auth
                        @if(auth()->user()->role === 'customer')

                            {{-- Booking Saya --}}
                            <a href="{{ route('customer.my-rentals') }}"
                               class="relative px-2 py-1 transition
                               {{ request()->routeIs('customer.my-rentals')
                                    ? 'text-blue-600 font-semibold'
                                    : 'text-gray-700 hover:text-blue-600' }}">
                                Booking Saya

                                @if(request()->routeIs('customer.my-rentals'))
                                    <span class="absolute left-0 -bottom-1 h-0.5 w-full bg-blue-600 rounded-full"></span>
                                @endif
                            </a>

                        @elseif(auth()->user()->role === 'admin')

                            {{-- Dashboard Admin --}}
                            <a href="{{ route('admin.dashboard') }}"
                               class="relative px-2 py-1 transition
                               {{ request()->routeIs('admin.dashboard')
                                    ? 'text-blue-600 font-semibold'
                                    : 'text-gray-700 hover:text-blue-600' }}">
                                Dashboard Admin

                                @if(request()->routeIs('admin.dashboard'))
                                    <span class="absolute left-0 -bottom-1 h-0.5 w-full bg-blue-600 rounded-full"></span>
                                @endif
                            </a>

                        @endif

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}" class="inline-block">
                            @csrf
                            <button type="submit"
                                class="rounded-full bg-gray-900 px-4 py-2 text-white shadow hover:bg-gray-800 transition">
                                Logout
                            </button>
                        </form>
                    @endauth

                </nav>
            </div>
        </header>

        {{-- Optional Header --}}
        @if (isset($header))
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-6 py-6">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- Main Content --}}
        <main>
            {{ $slot }}
        </main>

    </div>

</body>
</html>