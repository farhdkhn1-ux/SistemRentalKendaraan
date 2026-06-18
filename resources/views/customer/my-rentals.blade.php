<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-6">Riwayat Booking Saya</h1>

        <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Hari</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($rentals as $rental)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $rental->vehicle->brand }} {{ $rental->vehicle->model }} • {{ $rental->vehicle->plate_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($rental->start_date)->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($rental->end_date)->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($rental->start_date && $rental->end_date)
                                    {{ $rental->start_date->diffInDays($rental->end_date) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($rental->total_cost, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $status = $rental->status;
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                    {{ $status == 'pending' ? 'bg-gray-200 text-gray-800' : (
                                        $status == 'active' ? 'bg-yellow-100 text-yellow-800' : (
                                        $status == 'returned' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                    )) }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            @if(method_exists($rentals, 'links'))
                {{ $rentals->links() }}
            @endif
        </div>
    </div>
</x-app-layout>
