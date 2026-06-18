<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-6">Booking - {{ $vehicle->brand }} {{ $vehicle->model }}</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="mb-4">
                <p class="text-sm text-gray-600">Plate: <span class="font-medium">{{ $vehicle->plate_number }}</span></p>
                <p class="text-sm text-gray-600">Tipe: <span class="font-medium">{{ $vehicle->type }}</span></p>
                <p class="text-sm text-gray-600">Tahun: <span class="font-medium">{{ $vehicle->year }}</span></p>
                <p class="text-sm text-gray-600">Warna: <span class="font-medium">{{ $vehicle->color }}</span></p>
                <p class="text-lg font-bold text-indigo-600 mt-2">Harga per hari: Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }}</p>
            </div>

            <form method="POST" action="{{ route('customer.booking.store', $vehicle) }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('customer_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Identitas</label>
                        <input type="text" name="id_number" value="{{ old('id_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('id_number') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('start_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('end_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Catatan (opsional)</label>
                        <textarea name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        @error('notes') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Booking Sekarang</button>
                    <a href="{{ route('customer.vehicles') }}" class="ml-3 text-sm text-gray-600">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
