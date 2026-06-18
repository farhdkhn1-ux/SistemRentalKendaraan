<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Kendaraan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Data Kendaraan</h3>
                    <a href="{{ route('vehicles.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Tambah Kendaraan
                    </a>
                </div>

                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700">
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
                        <tr class="border-b dark:border-gray-600">
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
                                <a href="{{ route('vehicles.edit', $v) }}"
                                    class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-xs">Edit</a>
                                <form action="{{ route('vehicles.destroy', $v) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus kendaraan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">Hapus</button>
                                </form>
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
        </div>
    </div>
</x-app-layout>