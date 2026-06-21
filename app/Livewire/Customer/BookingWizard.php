<?php

namespace App\Livewire\Customer;

use App\Models\Rental;
use App\Models\Vehicle;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookingWizard extends Component
{
    use WithFileUploads;

    public Vehicle $vehicle;

    public $currentStep = 1;
    public $totalSteps = 5;

    // Step 2: Dates
    public $start_date;
    public $end_date;
    public $airport_pickup = false;
    public $with_driver = false;
    public $keyless = false;

    // Step 3: Documents
    public $customer_name;
    public $id_number;
    public $phone;
    public $ktp_file;
    public $sim_file;
    public $notes;
    public $payment_proof;

    public function mount(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function getTotalDaysProperty()
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }
        return Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date));
    }

    public function getAddonFeesProperty()
    {
        $fee = 0;
        if ($this->airport_pickup) $fee += 50000;
        if ($this->with_driver) $fee += 150000;
        if ($this->keyless) $fee += 30000;
        return $fee;
    }

    public function getTotalCostProperty()
    {
        $rentalCost = $this->totalDays * $this->vehicle->daily_rate;
        return $rentalCost + $this->addonFees;
    }

    public function nextStep()
    {
        $this->validateStep();
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep($step)
    {
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
        }
    }

    protected function validateStep()
    {
        if ($this->currentStep === 2) {
            $this->validate([
                'start_date' => 'required|date|after_or_equal:today',
                'end_date'   => 'required|date|after:start_date',
            ]);
        }

        if ($this->currentStep === 3) {
            $this->validate([
                'customer_name' => 'required|max:100',
                'id_number'     => 'required|max:20',
                'phone'         => 'required|max:20',
                'ktp_file'      => 'required|image|max:2048',
                'sim_file'      => 'required|image|max:2048',
            ]);
        }
    }

   public function confirmBooking()
{
    try {
        $this->validate([
            'customer_name' => 'required|max:100',
            'id_number'     => 'required|max:20',
            'phone'         => 'required|max:20',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after:start_date',
            'ktp_file'      => 'required|image|max:2048',
            'sim_file'      => 'required|image|max:2048',
            'payment_proof' => 'required|image|max:2048',
        ]);

        $ktpPath = $this->ktp_file->store('documents/ktp', 'public');
        $simPath = $this->sim_file->store('documents/sim', 'public');
        $paymentProofPath = $this->payment_proof->store('payments', 'public');

        $rental = Rental::create([
            'vehicle_id'      => $this->vehicle->id,
            'user_id'         => auth()->id(),
            'customer_name'   => $this->customer_name,
            'id_number'       => $this->id_number,
            'phone'           => $this->phone,
            'ktp_file'        => $ktpPath,
            'sim_file'        => $simPath,
            'start_date'      => $this->start_date,
            'end_date'        => $this->end_date,
            
            'airport_pickup'  => $this->airport_pickup,
            'with_driver'     => $this->with_driver,
            'keyless'         => $this->keyless,
            'addon_fees'      => $this->addonFees,
            'pickup_location' => $this->vehicle->pick_up_location,
            'total_cost'      => $this->totalCost,
            'status'          => 'pending',
            'notes'           => $this->notes,
            'dp_amount' => $this->totalCost * 0.2,
'remaining_amount' => $this->totalCost - ($this->totalCost * 0.2),
'payment_proof' => $paymentProofPath,
'payment_status' => 'pending',
            
        ]);

        session()->flash('success', 'Booking berhasil diajukan!');
$this->currentStep = 5;

return redirect()->route('customer.my-rentals');

    } catch (\Exception $e) {
        dd($e->getMessage());
    }
}

    public function render()
    {
        return view('livewire.customer.booking-wizard');
    }
}