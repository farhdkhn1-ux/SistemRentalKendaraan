@extends('layouts.admin')

@section('title', 'Vehicles')

@section('content')

@if(session('success'))
    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="mb-6 flex flex-col gap-3 justify-between items-start md:flex-row md:items-center">
    <div>
        <h3 class="text-2xl font-bold text-slate-900">Manajemen Kendaraan</h3>
        <p class="mt-1 text-sm text-slate-500">
            Total: {{ $vehicles->total() }} kendaraan
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <a href="{{ route('admin.rentals.index') }}"
           class="px-4 py-2 rounded-lg border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100">
            Lihat Rental
        </a>

        <a href="{{ route('admin.vehicles.create') }}"
           class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium">
            + Tambah Kendaraan
        </a>
    </div>
</div>

<div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    @forelse($vehicles as $v)
        <div class="rounded-2xl bg-white shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition">

            <div class="bg-gradient-to-r from-slate-600 to-slate-700 h-40 flex items-center justify-center">
                <div class="text-center text-white">
                    <div class="text-4xl font-bold">
                        {{ strtoupper(substr($v->plate_number, 0, 2)) }}
                    </div>
                    <div class="text-xs mt-2 opacity-75">
                        {{ strtoupper($v->type) }}
                    </div>
                </div>
            </div>

            <div class="p-4">
                <div class="mb-3">
                    <h4 class="font-semibold text-lg text-gray-900">
                        {{ $v->brand }} {{ $v->model }}
                    </h4>
                    <p class="text-sm text-gray-500">
                        {{ $v->plate_number }}
                    </p>
                </div>

                <div class="mb-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Tahun</span>
                        <span class="font-semibold">{{ $v->year }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Warna</span>
                        <span class="font-semibold">{{ $v->color ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Tarif/Hari</span>
                        <span class="font-bold text-blue-600">
                            Rp {{ number_format($v->daily_rate, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="mb-4 flex justify-between items-center">
                    <span class="text-xs font-semibold">Status</span>

                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $v->status == 'available' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $v->status == 'rented' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $v->status == 'maintenance' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($v->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('admin.vehicles.edit', $v) }}"
                       class="w-full bg-blue-600 text-white text-sm py-2 rounded-lg hover:bg-blue-700 text-center">
                        Edit
                    </a>

                    <form action="{{ route('admin.vehicles.destroy', $v) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus kendaraan ini?')">
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
    @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500">Belum ada data kendaraan.</p>
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $vehicles->links() }}
</div>

@endsection