<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-6">Daftar Kendaraan</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($vehicles as $vehicle)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold">{{ $vehicle->brand }} {{ $vehicle->model }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $vehicle->plate_number }} • {{ $vehicle->type }} • {{ $vehicle->year }} • {{ $vehicle->color }}</p>

                        <div class="mt-4 flex items-center justify-between">
                            <div class="text-xl font-bold text-indigo-600">Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }}</div>
                            <a href="{{ route('customer.booking', $vehicle) }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Booking Sekarang</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            @if(method_exists($vehicles, 'links'))
                {{ $vehicles->links() }}
            @endif
        </div>
    </div>
</x-app-layout>
