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
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow duration-300 group">

    <a href="{{ route('vehicles.show', $vehicle) }}" class="block">
        {{-- Image / Gradient Placeholder --}}
        <div class="relative h-48 bg-gradient-to-br {{ $config['gradient'] }} flex items-center justify-center overflow-hidden">
            <span class="text-7xl opacity-90 group-hover:scale-110 transition-transform duration-300">{{ $config['icon'] }}</span>

            <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-semibold
                {{ $isAvailable ? 'bg-white/90 text-gray-800' : 'bg-red-500/90 text-white' }}">
                {{ $vehicle->type }}
            </span>

            @if(!$isAvailable)
                <span class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold bg-gray-900/80 text-white">
                    {{ $vehicle->status === 'rented' ? 'Booked' : 'Maintenance' }}
                </span>
            @endif
        </div>

        {{-- Info --}}
        <div class="p-5 pb-0">
            <div class="flex items-start justify-between mb-1">
                <h3 class="text-lg font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
            </div>
            <p class="text-xs text-gray-500 mb-3">{{ $vehicle->plate_number }} • {{ $vehicle->year }} • {{ $vehicle->color ?? '-' }}</p>

            <div class="flex items-center gap-4 text-xs text-gray-600 mb-4">
                <span class="flex items-center gap-1">
                    ⚙️ {{ $vehicle->transmission ?? 'Manual' }}
                </span>
                <span class="flex items-center gap-1">
                    🧳 {{ $vehicle->luggage_capacity ?? 2 }} Bags
                </span>
            </div>

            <div class="flex items-center justify-between mb-4">
                <div>
                    <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }}</span>
                    <span class="text-xs text-gray-400">/hari</span>
                </div>
            </div>
        </div>
    </a>

    {{-- Action Button (outside link to avoid nested anchors) --}}
    <div class="px-5 pb-5">
        @guest
            <a href="{{ route('login') }}"
                class="block text-center bg-blue-600 text-white px-4 py-3 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                Login untuk Booking
            </a>
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
    </div>
</div>