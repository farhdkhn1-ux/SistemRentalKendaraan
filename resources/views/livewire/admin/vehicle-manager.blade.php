<div>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Data Kendaraan</h3>
            <button wire:click="openCreateModal"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Kendaraan
            </button>
        </div>

        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Plat</th>
                    <th class="px-4 py-2">Merek</th>
                    <th class="px-4 py-2">Model</th>
                    <th class="px-4 py-2">Tipe</th>
                    <th class="px-4 py-2">Tahun</th>
                    <th class="px-4 py-2">Tarif/Hari</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $v)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $v->plate_number }}</td>
                    <td class="px-4 py-2">{{ $v->brand }}</td>
                    <td class="px-4 py-2">{{ $v->model }}</td>
                    <td class="px-4 py-2">{{ $v->type }}</td>
                    <td class="px-4 py-2">{{ $v->year }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($v->daily_rate, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            {{ $v->status === 'available' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $v->status === 'rented' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $v->status === 'maintenance' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst($v->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 flex gap-2">
                        <button wire:click="openEditModal({{ $v->id }})"
                            class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-xs">
                            Edit
                        </button>
                        <button wire:click="delete({{ $v->id }})"
                            wire:confirm="Yakin hapus kendaraan ini?"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center px-4 py-6 text-gray-400">Belum ada data kendaraan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $vehicles->links() }}
        </div>
    </div>

    {{-- MODAL --}}
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">
                    {{ $isEditing ? 'Edit Kendaraan' : 'Tambah Kendaraan' }}
                </h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
            </div>

            <form wire:submit="save">
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Plat Nomor</label>
                        <input type="text" wire:model="plate_number" class="w-full border rounded px-3 py-2">
                        @error('plate_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Merek</label>
                        <input type="text" wire:model="brand" class="w-full border rounded px-3 py-2">
                        @error('brand') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Model</label>
                        <input type="text" wire:model="model" class="w-full border rounded px-3 py-2">
                        @error('model') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tipe</label>
                        <select wire:model="type" class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Tipe --</option>
                            @foreach(['Sedan','SUV','MPV','Motor','Pickup'] as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                        @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tahun</label>
                        <input type="number" wire:model="year" class="w-full border rounded px-3 py-2">
                        @error('year') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Warna</label>
                        <input type="text" wire:model="color" class="w-full border rounded px-3 py-2">
                        @error('color') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Tarif Per Hari (Rp)</label>
                        <input type="number" wire:model="daily_rate" class="w-full border rounded px-3 py-2">
                        @error('daily_rate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Status</label>
                        <select wire:model="status" class="w-full border rounded px-3 py-2">
                            @foreach(['available','rented','maintenance'] as $s)
                                <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        {{ $isEditing ? 'Update' : 'Simpan' }}
                    </button>
                    <button type="button" wire:click="closeModal"
                        class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">
                        Batal
                    </button>
                </div>
            </form>

        </div>
    </div>
    @endif
</div>