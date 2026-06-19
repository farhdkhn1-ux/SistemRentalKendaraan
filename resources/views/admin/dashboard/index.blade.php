@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<!-- KPI Cards -->
<div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mb-8">

    <!-- Total Vehicles -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                🚘
            </div>
            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                +4.2%
            </span>
        </div>

        <p class="text-sm text-slate-500 mb-2">Total Vehicles</p>
        <h3 class="text-3xl font-bold text-slate-900">{{ $totalVehicles }}</h3>
        <p class="text-xs text-slate-400 mt-2">
            {{ $availableVehicles }} available • {{ $rentedVehicles }} rented
        </p>
    </div>

    <!-- Active Rentals -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                📊
            </div>
            <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-semibold rounded-full">
                +12%
            </span>
        </div>

        <p class="text-sm text-slate-500 mb-2">Active Rentals</p>
        <h3 class="text-3xl font-bold text-slate-900">{{ $activeRentals }}</h3>
        <p class="text-xs text-slate-400 mt-2">Pending & Active transactions</p>
    </div>

    <!-- Completed Rentals -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                ✅
            </div>
            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                +8.1%
            </span>
        </div>

        <p class="text-sm text-slate-500 mb-2">Completed Rentals</p>
        <h3 class="text-3xl font-bold text-slate-900">{{ $completedRentals }}</h3>
        <p class="text-xs text-slate-400 mt-2">Successfully completed</p>
    </div>

    <!-- Revenue -->
    <div class="bg-black text-white rounded-2xl p-6 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center">
                💰
            </div>
            <span class="px-3 py-1 bg-green-600 text-white text-xs font-semibold rounded-full">
                +24.5%
            </span>
        </div>

        <p class="text-sm text-slate-300 mb-2">Monthly Revenue</p>
        <h3 class="text-3xl font-bold">
            Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}
        </h3>
    </div>

</div>

<!-- Charts -->
<div class="grid gap-6 grid-cols-1 lg:grid-cols-3 mb-8">

    <!-- Revenue Chart -->
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="font-bold text-lg text-slate-900">Revenue Performance</h3>
                <p class="text-sm text-slate-500">Monthly distribution</p>
            </div>
        </div>

        <div class="h-72 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
            Chart Area
        </div>
    </div>

    <!-- Fleet Availability -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h3 class="font-bold text-lg text-slate-900 mb-6">Fleet Availability</h3>

        <div class="space-y-4">
            <div class="flex justify-between">
                <span>Available</span>
                <span class="font-bold text-green-600">{{ $availableVehicles }}</span>
            </div>

            <div class="flex justify-between">
                <span>Rented</span>
                <span class="font-bold text-orange-600">{{ $rentedVehicles }}</span>
            </div>

            <div class="flex justify-between">
                <span>Maintenance</span>
                <span class="font-bold text-red-600">{{ $maintenanceVehicles }}</span>
            </div>
        </div>
    </div>

</div>

<!-- Recent Activity -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-lg text-slate-900">Recent Fleet Activity</h3>
            <p class="text-sm text-slate-500">Latest rental updates</p>
        </div>

        <a href="{{ route('admin.rentals.index') }}"
           class="text-blue-600 font-medium text-sm">
            View All →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left">Vehicle</th>
                    <th class="px-6 py-4 text-left">Customer</th>
                    <th class="px-6 py-4 text-left">Start Date</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-right">Amount</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recentActivity as $rental)
                <tr class="border-t">
                    <td class="px-6 py-4">
                        {{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $rental->customer_name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $rental->start_date->format('d M Y') }}
                    </td>

                    <td class="px-6 py-4">
                        {{ ucfirst($rental->status) }}
                    </td>

                    <td class="px-6 py-4 text-right font-bold">
                        Rp {{ number_format($rental->total_cost, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-slate-500">
                        No recent activity
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection