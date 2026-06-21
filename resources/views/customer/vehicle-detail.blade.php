<x-app-layout>
   <x-slot name="header">
    <div class="flex items-center justify-between">

        <div class="flex items-center gap-3 text-sm">
            <a href="{{ route('vehicles.catalog') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition shadow-sm">
                ← Kembali
            </a>

            
        </div>

    </div>
</x-slot>

    @php
        $typeConfig = [
            'Sedan'  => ['icon' => '🚗', 'gradient' => 'from-slate-700 to-slate-900'],
            'SUV'    => ['icon' => '🚙', 'gradient' => 'from-emerald-600 to-emerald-900'],
            'MPV'    => ['icon' => '🚐', 'gradient' => 'from-indigo-600 to-indigo-900'],
            'Motor'  => ['icon' => '🏍️', 'gradient' => 'from-orange-500 to-red-700'],
            'Pickup' => ['icon' => '🛻', 'gradient' => 'from-amber-600 to-amber-900'],
        ];
        $config = $typeConfig[$vehicle->type] ?? ['icon' => '🚘', 'gradient' => 'from-gray-600 to-gray-900'];
        $isAvailable = $vehicle->status === 'available';
        $featuresList = $vehicle->features ? array_map('trim', explode(',', $vehicle->features)) : [];
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT: Photo + Details --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Photo --}}
                    <div class="relative h-80 rounded-3xl bg-gradient-to-br {{ $config['gradient'] }} flex items-center justify-center overflow-hidden shadow-lg">
                        <span class="text-9xl opacity-90">{{ $config['icon'] }}</span>
                        <span class="absolute top-4 left-4 px-4 py-1.5 rounded-full text-xs font-semibold bg-white/90 text-gray-800">
                            {{ $vehicle->type }}
                        </span>
                        @if(!$isAvailable)
                            <span class="absolute top-4 right-4 px-4 py-1.5 rounded-full text-xs font-bold bg-gray-900/80 text-white">
                                {{ $vehicle->status === 'rented' ? 'Sedang Disewa' : 'Maintenance' }}
                            </span>
                        @endif
                    </div>

                    {{-- Title & basic info --}}
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h1>
                        <p class="text-gray-500 mt-1">
                            📍 {{ $vehicle->pick_up_location ?? 'Padang, Sumatra Barat' }} • {{ $vehicle->plate_number }}
                        </p>
                    </div>

                    {{-- Specs --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="bg-white rounded-2xl border border-gray-200 p-4 text-center">
                            <p class="text-2xl mb-1">⚙️</p>
                            <p class="text-xs text-gray-500">Transmisi</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $vehicle->transmission ?? 'Manual' }}</p>
                        </div>
                        <div class="bg-white rounded-2xl border border-gray-200 p-4 text-center">
                            <p class="text-2xl mb-1">👥</p>
                            <p class="text-xs text-gray-500">Tahun</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $vehicle->year }}</p>
                        </div>
                        <div class="bg-white rounded-2xl border border-gray-200 p-4 text-center">
                            <p class="text-2xl mb-1">🧳</p>
                            <p class="text-xs text-gray-500">Bagasi</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $vehicle->luggage_capacity ?? 2 }} tas</p>
                        </div>
                        <div class="bg-white rounded-2xl border border-gray-200 p-4 text-center">
                            <p class="text-2xl mb-1">🎨</p>
                            <p class="text-xs text-gray-500">Warna</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $vehicle->color ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Features --}}
                    @if(count($featuresList) > 0)
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Fitur Unggulan</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($featuresList as $feature)
                                <div class="flex items-center gap-2 text-sm text-gray-700">
                                    <span class="text-green-500">✓</span> {{ $feature }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Pickup Location --}}
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <h3 class="font-bold text-gray-900 mb-2">Lokasi Pengambilan</h3>
                        <p class="text-sm text-gray-600">📍 {{ $vehicle->pick_up_location ?? 'Padang, Sumatra Barat' }}</p>
                    </div>

                    {{-- Reviews (placeholder) --}}
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Ulasan Pelanggan</h3>
                        <div class="space-y-4">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-sm font-bold text-blue-700 flex-shrink-0">AR</div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Ari Rahman <span class="text-yellow-500 ml-1">★★★★★</span></p>
                                    <p class="text-sm text-gray-600 mt-1">Mobil bersih dan nyaman, proses sewa cepat. Recommended!</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-sm font-bold text-blue-700 flex-shrink-0">MP</div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Maya Putri <span class="text-yellow-500 ml-1">★★★★★</span></p>
                                    <p class="text-sm text-gray-600 mt-1">Sangat membantu untuk perjalanan keluarga. Akan sewa lagi.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- RIGHT: Booking Card --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm sticky top-24">
                        <p class="text-sm text-gray-500 mb-1">Tarif Sewa</p>
                        <p class="text-3xl font-bold text-blue-600 mb-1">Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400 mb-6">per hari</p>

                        @guest
                            <a href="{{ route('login') }}"
                                class="block text-center bg-blue-600 text-white px-4 py-3 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                                Login untuk Booking
                            </a>
                            <p class="text-xs text-gray-400 text-center mt-3">Masuk ke akun kamu untuk melanjutkan booking</p>
                        @else
                            @if(auth()->user()->role === 'customer')
                                @if($isAvailable)
                                    <a href="{{ route('customer.booking', $vehicle) }}"
                                        class="block text-center bg-blue-600 text-white px-4 py-3 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                                        Book Now
                                    </a>
                                @else
                                    <span class="block text-center bg-gray-100 text-gray-400 px-4 py-3 rounded-xl text-sm font-semibold cursor-not-allowed">
                                        Tidak Tersedia
                                    </span>
                                @endif
                            @else
                                <span class="block text-center bg-gray-100 text-gray-500 px-4 py-3 rounded-xl text-sm font-semibold">
                                    Halaman ini untuk customer
                                </span>
                            @endif
                        @endguest

                        <div class="mt-6 pt-6 border-t border-gray-100 space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Status</span>
                                <span class="font-semibold {{ $isAvailable ? 'text-green-600' : 'text-red-500' }}">
                                    {{ ucfirst($vehicle->status) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span>Plat Nomor</span>
                                <span class="font-semibold text-gray-900">{{ $vehicle->plate_number }}</span>
                            </div>
                        </div>

                        <a href="https://wa.me/6283139980834" target="_blank"
                            class="block text-center mt-4 text-sm text-green-600 font-semibold hover:underline">
                            💬 Tanya via WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>