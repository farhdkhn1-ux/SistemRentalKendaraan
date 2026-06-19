<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Rental
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.rentals.update', $rental) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4">

                        <div class="col-span-2">
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Kendaraan</label>
                            <select name="vehicle_id" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" disabled>
                                @foreach($vehicles as $v)
                                    <option value="{{ $v->id }}" {{ $rental->vehicle_id == $v->id ? 'selected' : '' }}>
                                        {{ $v->brand }} {{ $v->model }} ({{ $v->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-400 mt-1">Kendaraan tidak dapat diubah setelah rental dibuat.</p>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Nama Penyewa</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name', $rental->customer_name) }}"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">No. KTP</label>
                            <input type="text" name="id_number" value="{{ old('id_number', $rental->id_number) }}"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">No. Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $rental->phone) }}"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                                @foreach(['active','returned','cancelled'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $rental->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ old('start_date', $rental->start_date->format('Y-m-d')) }}"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai</label>
                            <input type="date" name="end_date" value="{{ old('end_date', $rental->end_date->format('Y-m-d')) }}"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                            <textarea name="notes" rows="3"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">{{ old('notes', $rental->notes) }}</textarea>
                        </div>

                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Update</button>
                        <a href="{{ route('admin.rentals.index') }}"
                            class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>