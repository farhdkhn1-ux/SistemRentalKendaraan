<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vehicle Catalog
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-xl">{{ session('error') }}</div>
            @endif

            {{-- SEARCH & FILTER BAR --}}
            <form method="GET" action="{{ route('vehicles.catalog') }}" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 mb-8">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1 relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari brand atau model..."
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>

                    <select name="type" class="rounded-xl border border-gray-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Tipe</option>
                        @foreach(['Sedan','SUV','MPV','Motor','Pickup'] as $t)
                            <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>

                    <select name="price_range" class="rounded-xl border border-gray-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Harga</option>
                        <option value="low" {{ request('price_range') == 'low' ? 'selected' : '' }}>&lt; Rp 200rb/hari</option>
                        <option value="mid" {{ request('price_range') == 'mid' ? 'selected' : '' }}>Rp 200rb - 500rb/hari</option>
                        <option value="high" {{ request('price_range') == 'high' ? 'selected' : '' }}>&gt; Rp 500rb/hari</option>
                    </select>

                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold text-sm hover:bg-blue-700 transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Apply Filters
                    </button>

                    @if(request()->anyFilled(['search','type','price_range']))
                        <a href="{{ route('vehicles.catalog') }}"
                            class="px-4 py-3 rounded-xl text-sm font-semibold text-gray-500 hover:text-gray-700 text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            {{-- GRID KENDARAAN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($vehicles as $vehicle)
                    @include('customer.partials.vehicle-card', ['vehicle' => $vehicle])
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-dashed border-gray-300">
                        <p class="text-gray-500">Tidak ada kendaraan yang cocok dengan pencarian kamu.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>