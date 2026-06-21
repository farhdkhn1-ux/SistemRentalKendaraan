<?php

namespace App\Livewire\Admin;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;

class VehicleManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $isEditing = false;
    public $vehicleId;

    public $plate_number;
    public $brand;
    public $model;
    public $type;
    public $year;
    public $color;
    public $daily_rate;
    public $status = 'available';

    protected function rules()
    {
        return [
            'plate_number' => 'required|max:20|unique:vehicles,plate_number,' . $this->vehicleId,
            'brand'        => 'required|max:50',
            'model'        => 'required|max:100',
            'type'         => 'required|in:Sedan,SUV,MPV,Motor,Pickup',
            'year'         => 'required|integer|min:1900|max:2100',
            'color'        => 'nullable|max:30',
            'daily_rate'   => 'required|numeric|min:0',
            'status'       => 'required|in:available,rented,maintenance',
        ];
    }

    public function render()
    {
        $vehicles = Vehicle::latest()->paginate(10);
        return view('livewire.admin.vehicle-manager', compact('vehicles'));
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $this->vehicleId    = $vehicle->id;
        $this->plate_number = $vehicle->plate_number;
        $this->brand        = $vehicle->brand;
        $this->model        = $vehicle->model;
        $this->type         = $vehicle->type;
        $this->year         = $vehicle->year;
        $this->color        = $vehicle->color;
        $this->daily_rate   = $vehicle->daily_rate;
        $this->status       = $vehicle->status;

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'plate_number' => $this->plate_number,
            'brand'        => $this->brand,
            'model'        => $this->model,
            'type'         => $this->type,
            'year'         => $this->year,
            'color'        => $this->color,
            'daily_rate'   => $this->daily_rate,
            'status'       => $this->status,
        ];

        if ($this->isEditing) {
            Vehicle::findOrFail($this->vehicleId)->update($data);
            session()->flash('success', 'Kendaraan berhasil diupdate!');
        } else {
            Vehicle::create($data);
            session()->flash('success', 'Kendaraan berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        Vehicle::findOrFail($id)->delete();
        session()->flash('success', 'Kendaraan berhasil dihapus!');
    }

    private function resetForm()
    {
        $this->vehicleId    = null;
        $this->plate_number = null;
        $this->brand        = null;
        $this->model        = null;
        $this->type         = null;
        $this->year         = null;
        $this->color        = null;
        $this->daily_rate   = null;
        $this->status       = 'available';
        $this->resetErrorBag();
    }
}