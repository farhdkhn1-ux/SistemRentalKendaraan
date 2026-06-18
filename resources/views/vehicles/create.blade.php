<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Kendaraan
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

                <form action="{{ route('vehicles.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Plat Nomor</label>
                            <input type="text" name="plate_number" value="{{ old('plate_number') }}"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Merek</label>
                            <input type="text" name="brand" value="{{ old('brand') }}"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Model</label>
                            <input type="text" name="model" value="{{ old('model') }}"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Tipe</label>
                            <select name="type" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                                <option value="">-- Pilih Tipe --</option>
                                @foreach(['Sedan','SUV','MPV','Motor','Pickup'] as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                            <input type="number" name="year" value="{{ old('year') }}"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Warna</label>
                            <input type="text" name="color" value="{{ old('color') }}"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Tarif Per Hari (Rp)</label>
                            <input type="number" name="daily_rate" value="{{ old('daily_rate') }}"
                                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                                @foreach(['available','rented','maintenance'] as $status)
                                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan</button>
                        <a href="{{ route('vehicles.index') }}"
                            class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>