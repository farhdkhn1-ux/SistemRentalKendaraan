<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|unique:vehicles|max:20',
            'brand'        => 'required|max:50',
            'model'        => 'required|max:100',
            'type'         => 'required|in:Sedan,SUV,MPV,Motor,Pickup',
            'year'         => 'required|integer|min:1900|max:2100',
            'color'        => 'nullable|max:30',
            'daily_rate'   => 'required|numeric|min:0',
            'status'       => 'required|in:available,rented,maintenance',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'plate_number' => 'required|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'brand'        => 'required|max:50',
            'model'        => 'required|max:100',
            'type'         => 'required|in:Sedan,SUV,MPV,Motor,Pickup',
            'year'         => 'required|integer|min:1900|max:2100',
            'color'        => 'nullable|max:30',
            'daily_rate'   => 'required|numeric|min:0',
            'status'       => 'required|in:available,rented,maintenance',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil diupdate!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Kendaraan berhasil dihapus!');
    }
}