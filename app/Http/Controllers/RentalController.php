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
        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        return view('rentals.create', compact('vehicles'));
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

        return redirect()->route('rentals.index')->with('success', 'Rental berhasil ditambahkan!');
    }

    public function edit(Rental $rental)
    {
        $vehicles = Vehicle::all();
        return view('rentals.edit', compact('rental', 'vehicles'));
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

        return redirect()->route('rentals.index')->with('success', 'Rental berhasil diupdate!');
    }

    public function destroy(Rental $rental)
    {
        $rental->vehicle->update(['status' => 'available']);
        $rental->delete();
        return redirect()->route('rentals.index')->with('success', 'Rental berhasil dihapus!');
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
}