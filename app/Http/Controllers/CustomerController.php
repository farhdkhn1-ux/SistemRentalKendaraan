<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
   public function vehicles(Request $request)
{
    $query = Vehicle::query();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('brand', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%");
        });
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('price_range')) {
        switch ($request->price_range) {
            case 'low':
                $query->where('daily_rate', '<', 200000);
                break;
            case 'mid':
                $query->whereBetween('daily_rate', [200000, 500000]);
                break;
            case 'high':
                $query->where('daily_rate', '>', 500000);
                break;
        }
    }

    $vehicles = $query->latest()->paginate(9)->withQueryString();

    return view('customer.vehicles', compact('vehicles'));
}
public function show(Vehicle $vehicle)
{
    return view('customer.vehicle-detail', compact('vehicle'));
}

    public function bookingForm(Vehicle $vehicle)
    {
        if ($vehicle->status !== 'available') {
            return redirect()->route('customer.vehicles')->with('error', 'Kendaraan tidak tersedia.');
        }
        return view('customer.booking', compact('vehicle'));
    }

    public function bookingStore(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'customer_name' => 'required|max:100',
            'id_number'     => 'required|max:20',
            'phone'         => 'required|max:20',
            'start_date'    => 'required|date|after_or_equal:today',
            'end_date'      => 'required|date|after:start_date',
            'notes'         => 'nullable',
        ]);

        $days = \Carbon\Carbon::parse($request->start_date)->diffInDays($request->end_date);
        $totalCost = $days * $vehicle->daily_rate;

        Rental::create([
            'vehicle_id'    => $vehicle->id,
            'user_id'       => Auth::id(),
            'customer_name' => $request->customer_name,
            'id_number'     => $request->id_number,
            'phone'         => $request->phone,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'total_cost'    => $totalCost,
            'status'        => 'pending',
            'notes'         => $request->notes,
        ]);

        return redirect()->route('customer.my-rentals')->with('success', 'Booking berhasil! Menunggu approval admin.');
    }

    public function myRentals()
{
    $rentals = Rental::with('vehicle')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('customer.my-rentals', compact('rentals'));
}
}