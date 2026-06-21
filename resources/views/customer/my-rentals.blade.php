<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Booking Saya</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($rentals->count())

                <div class="space-y-6">
                    @foreach($rentals as $rental)

                        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6">

                            {{-- Top --}}
                            <div class="flex justify-between items-start mb-6">

                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">
                                        {{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $rental->start_date->format('d M Y') }}
                                        -
                                        {{ $rental->end_date->format('d M Y') }}
                                    </p>
                                </div>

                                {{-- Status --}}
                                <span class="px-4 py-2 rounded-full text-xs font-bold
                                    @if($rental->status === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($rental->status === 'active') bg-blue-100 text-blue-700
                                    @elseif($rental->status === 'returned') bg-green-100 text-green-700
                                    @else bg-red-100 text-red-700
                                    @endif
                                ">
                                    {{ ucfirst($rental->status) }}
                                </span>

                            </div>

                            {{-- Info Grid --}}
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

                                <div class="bg-gray-50 rounded-2xl p-4">
                                    <p class="text-xs text-gray-500">Total Hari</p>
                                    <p class="font-bold text-gray-900">{{ $rental->total_days }} hari</p>
                                </div>

                                <div class="bg-gray-50 rounded-2xl p-4">
                                    <p class="text-xs text-gray-500">Total Biaya</p>
                                    <p class="font-bold text-blue-600">
                                        Rp {{ number_format($rental->total_cost, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-2xl p-4">
                                    <p class="text-xs text-gray-500">Pickup</p>
                                    <p class="font-bold text-gray-900">
                                        {{ $rental->pickup_location }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-2xl p-4">
                                    <p class="text-xs text-gray-500">Addon Fee</p>
                                    <p class="font-bold text-gray-900">
                                        Rp {{ number_format($rental->addon_fees, 0, ',', '.') }}
                                    </p>
                                </div>

                            </div>

                            {{-- Addons --}}
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-900 mb-2">Addon</h4>

                                <div class="flex flex-wrap gap-2">

                                    @if($rental->airport_pickup)
                                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">
                                            Airport Pickup
                                        </span>
                                    @endif

                                    @if($rental->with_driver)
                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">
                                            Driver
                                        </span>
                                    @endif

                                    @if($rental->keyless)
                                        <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-xs">
                                            Keyless
                                        </span>
                                    @endif

                                </div>
                            </div>

                            {{-- Documents --}}
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-900 mb-2">Dokumen</h4>

                                <div class="flex gap-4 text-sm">

                                    <a href="{{ asset('storage/' . $rental->ktp_file) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline">
                                        Lihat KTP
                                    </a>

                                    <a href="{{ asset('storage/' . $rental->sim_file) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline">
                                        Lihat SIM
                                    </a>

                                </div>
                            </div>

                            {{-- Action --}}
                            @if($rental->status === 'pending')
                                <form action="#" method="POST">
                                    @csrf
                                    <button
                                        class="px-4 py-2 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition">
                                        Batalkan Booking
                                    </button>
                                </form>
                            @endif

                        </div>

                    @endforeach
                </div>

            @else
                <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-12 text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        Belum Ada Booking
                    </h3>
                    <p class="text-gray-500 mb-6">
                        Kamu belum melakukan booking kendaraan.
                    </p>

                    <a href="{{ route('vehicles.catalog') }}"
                       class="inline-flex px-6 py-3 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                        Cari Kendaraan
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>