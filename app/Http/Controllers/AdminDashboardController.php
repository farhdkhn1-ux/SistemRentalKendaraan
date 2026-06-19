<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Rental;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalVehicles = Vehicle::count();

        $activeRentals = Rental::whereIn('status', ['pending', 'active'])->count();

        $completedRentals = Rental::where('status', 'returned')->count();

        $monthlyRevenue = Rental::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_cost');

        $availableVehicles = Vehicle::where('status', 'available')->count();
        $rentedVehicles = Vehicle::where('status', 'rented')->count();
        $maintenanceVehicles = Vehicle::where('status', 'maintenance')->count();

        $recentActivity = Rental::with('vehicle')
            ->latest()
            ->limit(5)
            ->get();

        $revenueTrend = Rental::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(total_cost) as revenue')
        )
        ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
        ->orderBy('month')
        ->pluck('revenue', 'month');

        return view('admin.dashboard.index', compact(
            'totalVehicles',
            'activeRentals',
            'completedRentals',
            'monthlyRevenue',
            'availableVehicles',
            'rentedVehicles',
            'maintenanceVehicles',
            'recentActivity',
            'revenueTrend'
        ));
    }
}