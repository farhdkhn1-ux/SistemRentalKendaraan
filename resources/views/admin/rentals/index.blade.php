@extends('layouts.admin')

@section('title', 'Rentals')

@section('content')

@if(session('success'))
    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="mb-6 flex flex-col gap-3 justify-between items-start md:flex-row md:items-center">
    <div>
        <h3 class="text-2xl font-bold text-gray-900">Manajemen Rental</h3>
        <p class="mt-1 text-sm text-gray-500">
            Total: {{ $rentals->total() }} rental
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <a href="{{ route('admin.vehicles.index') }}"
           class="px-4 py-2 rounded-lg border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100">
            Lihat Kendaraan
        </a>

        <a href="{{ route('admin.rentals.create') }}"
           class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium">
            + Tambah Rental
        </a>
    </div>
</div>

<div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    @forelse($rentals as $r)
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition">

        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 text-white">
            <h4 class="font-bold text-lg">{{ $r->customer_name }}</h4>
            <p class="text-sm opacity-90">
                {{ $r->vehicle->brand }} {{ $r->vehicle->model }}
            </p>
        </div>

        <div class="p-4">
            <div class="mb-4 space-y-2 text-sm">

                <div class="flex justify-between">
                    <span>Kendaraan</span>
                    <span class="font-semibold">{{ $r->vehicle->plate_number }}</span>
                </div>

                <div class="flex justify-between">
                    <span>No. KTP</span>
                    <span class="font-semibold">{{ $r->id_number }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Telepon</span>
                    <span class="font-semibold">{{ $r->phone }}</span>
                </div>

                <div class="border-t pt-2 mt-2"></div>

                <div class="flex justify-between">
                    <span>Mulai</span>
                    <span class="font-semibold">{{ $r->start_date->format('d M Y') }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Selesai</span>
                    <span class="font-semibold">{{ $r->end_date->format('d M Y') }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Durasi</span>
                    <span class="font-semibold">{{ $r->total_days }} hari</span>
                </div>

                <div class="flex justify-between">
                    <span>Total</span>
                    <span class="font-bold text-blue-600">
                        Rp {{ number_format($r->total_cost, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="mb-4 flex items-center justify-between">
                <span class="text-xs font-semibold">Status</span>

                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $r->status === 'pending' ? 'bg-gray-100 text-gray-700' : '' }}
                    {{ $r->status === 'active' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $r->status === 'returned' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $r->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ ucfirst($r->status) }}
                </span>
            </div>

            <div class="flex flex-col gap-2">

                {{-- Pending --}}
                @if($r->status === 'pending')
                    <button
                        onclick="openRentalModal(
                            {{ $r->id }},
                            '{{ $r->customer_name }}',
                            '{{ $r->id_number }}',
                            '{{ $r->phone }}',
                            '{{ $r->vehicle->brand }} {{ $r->vehicle->model }}',
                            '{{ $r->start_date->format('d M Y') }}',
                            '{{ $r->end_date->format('d M Y') }}',
                            '{{ $r->total_days }}',
                            '{{ $r->total_cost }}',
                            '{{ $r->addon_fees }}',
                            '{{ asset('storage/' . $r->ktp_file) }}',
                            '{{ asset('storage/' . $r->sim_file) }}',
                            '{{ asset('storage/' . $r->payment_proof) }}'
                        )"
                        class="w-full bg-blue-600 text-white text-sm py-2 rounded-lg hover:bg-blue-700">
                        Detail
                    </button>
                @endif

                {{-- Active --}}
                @if($r->status === 'active')
                    <a href="{{ route('admin.rentals.return', $r) }}"
                       class="w-full bg-emerald-600 text-white text-sm py-2 rounded-lg hover:bg-emerald-700 text-center font-medium">
                        🔄 Proses Pengembalian
                    </a>
                @endif

                {{-- Edit + Delete --}}
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('admin.rentals.edit', $r) }}"
                       class="w-full bg-blue-600 text-white text-sm py-2 rounded-lg hover:bg-blue-700 text-center">
                        Edit
                    </a>

                    <form action="{{ route('admin.rentals.destroy', $r) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus rental ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="w-full bg-red-600 text-white text-sm py-2 rounded-lg hover:bg-red-700">
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500">Belum ada data rental.</p>
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $rentals->links() }}
</div>

<!-- Modal -->
<div id="rentalModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="bg-white rounded-2xl w-full max-w-2xl p-6 relative">

        <button onclick="closeRentalModal()"
                class="absolute top-4 right-4 text-xl text-gray-500">
            ✕
        </button>

        <h3 class="text-xl font-bold mb-6">Detail Rental</h3>

        <div id="rentalContent"></div>

    </div>
</div>

<script>
function openRentalModal(
    id, customer, ktp, phone, vehicle,
    start, end, days, total, addon,
    ktpFile, simFile, paymentProof
) {
    document.getElementById('rentalContent').innerHTML = `
        <div class="space-y-4 text-sm">
            <div><strong>Customer:</strong> ${customer}</div>
            <div><strong>No. KTP:</strong> ${ktp}</div>
            <div><strong>Phone:</strong> ${phone}</div>
            <div><strong>Kendaraan:</strong> ${vehicle}</div>

            <div><strong>Mulai:</strong> ${start}</div>
            <div><strong>Selesai:</strong> ${end}</div>
            <div><strong>Total Hari:</strong> ${days} hari</div>

            <div><strong>Total:</strong> Rp ${Number(total).toLocaleString('id-ID')}</div>
            <div><strong>Addon Fee:</strong> Rp ${Number(addon).toLocaleString('id-ID')}</div>

            <div class="grid grid-cols-3 gap-4 mt-4">
                <a href="${ktpFile}" target="_blank" class="text-blue-600 underline">Lihat KTP</a>
                <a href="${simFile}" target="_blank" class="text-blue-600 underline">Lihat SIM</a>
                <a href="${paymentProof}" target="_blank" class="text-blue-600 underline">Bukti DP</a>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <form method="POST" action="/admin/rentals/${id}/approve">
                    @csrf
                    @method('PATCH')
                    <button class="w-full bg-green-600 text-white py-2 rounded-lg">
                        Approve
                    </button>
                </form>

                <form method="POST" action="/admin/rentals/${id}/reject">
                    @csrf
                    @method('PATCH')
                    <button class="w-full bg-red-600 text-white py-2 rounded-lg">
                        Reject
                    </button>
                </form>
            </div>
        </div>
    `;

    document.getElementById('rentalModal').classList.remove('hidden');
    document.getElementById('rentalModal').classList.add('flex');
}

function closeRentalModal() {
    document.getElementById('rentalModal').classList.add('hidden');
    document.getElementById('rentalModal').classList.remove('flex');
}
</script>

@endsection