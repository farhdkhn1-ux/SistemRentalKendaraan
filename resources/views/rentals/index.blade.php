<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Rental
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
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Data Rental</h3>
                        <a href="{{ route('admin.rentals.create') }}"
                    </a>
                </div>

                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Kendaraan</th>
                            <th class="px-4 py-2">Penyewa</th>
                            <th class="px-4 py-2">No. KTP</th>
                            <th class="px-4 py-2">Telepon</th>
                            <th class="px-4 py-2">Mulai</th>
                            <th class="px-4 py-2">Selesai</th>
                            <th class="px-4 py-2">Hari</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rentals as $r)
                        <tr class="border-b dark:border-gray-600">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $r->vehicle->brand }} {{ $r->vehicle->model }} ({{ $r->vehicle->plate_number }})</td>
                            <td class="px-4 py-2">{{ $r->customer_name }}</td>
                            <td class="px-4 py-2">{{ $r->id_number }}</td>
                            <td class="px-4 py-2">{{ $r->phone }}</td>
                            <td class="px-4 py-2">{{ $r->start_date->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $r->end_date->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $r->total_days }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($r->total_cost, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $r->status === 'pending' ? 'bg-gray-100 text-gray-700' : '' }}
                                    {{ $r->status === 'active' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $r->status === 'returned' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $r->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 flex flex-wrap gap-2">
                                @if($r->status === 'pending')
                                    <form action="{{ route('admin.rentals.approve', $r) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.rentals.reject', $r) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">Reject</button>
                                    </form>
                                @endif
+                                <a href="{{ route('admin.rentals.edit', $r) }}"
+                                    class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-xs">Edit</a>
+                                <form action="{{ route('admin.rentals.destroy', $r) }}" method="POST"
+                                    onsubmit="return confirm('Yakin hapus rental ini?')">
+                                    @csrf
+                                    @method('DELETE')
+                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">Hapus</button>
+                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center px-4 py-6 text-gray-400">Belum ada data rental.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $rentals->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>