<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('vehicle')->latest()->paginate(10);
        return view('admin.rentals.index', compact('rentals'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        return view('admin.rentals.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id'    => 'required|exists:vehicles,id',
            'customer_name' => 'required|max:100',
            'id_number'     => 'required|max:20',
            'phone'         => 'required|max:20',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after:start_date',
            'notes'         => 'nullable',
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $days = \Carbon\Carbon::parse($request->start_date)->diffInDays($request->end_date);
        $totalCost = $days * $vehicle->daily_rate;

        Rental::create([
            ...$request->all(),
            'total_cost' => $totalCost,
            'status'     => 'active',
        ]);

        $vehicle->update(['status' => 'rented']);

        return redirect()->route('admin.rentals.index')->with('success', 'Rental berhasil ditambahkan!');
    }

    public function edit(Rental $rental)
    {
        $vehicles = Vehicle::all();
        return view('admin.rentals.edit', compact('rental', 'vehicles'));
    }

    public function update(Request $request, Rental $rental)
    {
        $request->validate([
            'customer_name' => 'required|max:100',
            'id_number'     => 'required|max:20',
            'phone'         => 'required|max:20',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after:start_date',
            'status'        => 'required|in:active,returned,cancelled',
            'notes'         => 'nullable',
        ]);

        $vehicle = Vehicle::findOrFail($rental->vehicle_id);
        $days = \Carbon\Carbon::parse($request->start_date)->diffInDays($request->end_date);
        $totalCost = $days * $vehicle->daily_rate;

        $rental->update([
            ...$request->all(),
            'total_cost' => $totalCost,
        ]);

        if ($request->status === 'returned' || $request->status === 'cancelled') {
            $vehicle->update(['status' => 'available']);
        }

        return redirect()->route('admin.rentals.index')->with('success', 'Rental berhasil diupdate!');
    }

    public function destroy(Rental $rental)
    {
        $rental->vehicle->update(['status' => 'available']);
        $rental->delete();
        return redirect()->route('admin.rentals.index')->with('success', 'Rental berhasil dihapus!');
    }
    public function approve(Rental $rental)
    {
        $rental->update(['status' => 'active']);
        $rental->vehicle->update(['status' => 'rented']);

        return redirect()->route('admin.rentals.index')->with('success', 'Rental disetujui!');
    }

    public function reject(Rental $rental)
    {
        $rental->update(['status' => 'cancelled']);

        return redirect()->route('admin.rentals.index')->with('success', 'Rental ditolak!');
    }

    public function returnForm(Rental $rental)
    {
        $rental->load('vehicle');

        // Calculate late days
        $endDate = $rental->end_date;
        $today = now()->startOfDay();
        $lateDays = 0;

        if ($today->gt($endDate)) {
            $lateDays = $endDate->diffInDays($today);
        }

        // Default late fee = daily_rate * 1.5 * late_days (150% penalty per day)
        $dailyRate = $rental->vehicle->daily_rate;
        $lateFeePerDay = $dailyRate * 0.5;
        $suggestedLateFee = $lateDays * $lateFeePerDay;

        return view('admin.rentals.return', compact('rental', 'lateDays', 'suggestedLateFee', 'lateFeePerDay'));
    }

    public function returnProcess(Request $request, Rental $rental)
    {
        $request->validate([
            'returned_date'     => 'required|date',
            'late_fee'          => 'required|numeric|min:0',
            'fee_lost_key'      => 'required|numeric|min:0',
            'fee_scratch_dent'  => 'required|numeric|min:0',
            'fee_lost_stnk'     => 'required|numeric|min:0',
            'fee_lost_etoll'    => 'required|numeric|min:0',
            'notes'             => 'nullable',
        ]);

        $returnedDate = \Carbon\Carbon::parse($request->returned_date);
        $endDate = $rental->end_date;

        $lateDays = 0;
        if ($returnedDate->gt($endDate)) {
            $lateDays = $endDate->diffInDays($returnedDate);
        }

        $totalFinal = $rental->total_cost 
            + $request->late_fee 
            + $request->fee_lost_key 
            + $request->fee_scratch_dent 
            + $request->fee_lost_stnk 
            + $request->fee_lost_etoll;

        $rental->update([
            'returned_date'     => $request->returned_date,
            'late_days'         => $lateDays,
            'late_fee'          => $request->late_fee,
            'fee_lost_key'      => $request->fee_lost_key,
            'fee_scratch_dent'  => $request->fee_scratch_dent,
            'fee_lost_stnk'     => $request->fee_lost_stnk,
            'fee_lost_etoll'    => $request->fee_lost_etoll,
            'total_final'       => $totalFinal,
            'status'            => 'returned',
            'notes'             => $request->notes ?? $rental->notes,
        ]);

        $rental->vehicle->update(['status' => 'available']);

        return redirect()->route('admin.rentals.index')->with('success', 'Kendaraan berhasil dikembalikan!');
    }
}