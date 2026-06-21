<div>
    {{-- Step Indicator --}}
    <div class="flex items-center justify-between mb-8 max-w-2xl mx-auto">
        @php
            $steps = ['Vehicle', 'Dates', 'Documents', 'Summary', 'Confirm'];
        @endphp
        @foreach($steps as $index => $label)
            @php $stepNum = $index + 1; @endphp
            <div class="flex items-center {{ $index < count($steps) - 1 ? 'flex-1' : '' }}">
                <button
                    wire:click="goToStep({{ $stepNum }})"
                    @if($stepNum >= $currentStep) disabled @endif
                    class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0
                    {{ $stepNum < $currentStep ? 'bg-blue-600 text-white cursor-pointer' : '' }}
                    {{ $stepNum === $currentStep ? 'bg-blue-600 text-white ring-4 ring-blue-100' : '' }}
                    {{ $stepNum > $currentStep ? 'bg-gray-200 text-gray-400' : '' }}">
                    {{ $stepNum }}
                </button>
                @if($index < count($steps) - 1)
                    <div class="flex-1 h-1 mx-2 rounded {{ $stepNum < $currentStep ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                @endif
            </div>
        @endforeach
    </div>
    <div class="flex justify-between max-w-2xl mx-auto mb-8 px-1 text-xs text-gray-500">
        @foreach($steps as $label)
            <span>{{ $label }}</span>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8 max-w-2xl mx-auto">

        {{-- STEP 1: VEHICLE --}}
        @if($currentStep === 1)
            @php
                $typeConfig = [
                    'Sedan'  => ['icon' => '🚗', 'gradient' => 'from-slate-700 to-slate-900'],
                    'SUV'    => ['icon' => '🚙', 'gradient' => 'from-emerald-600 to-emerald-900'],
                    'MPV'    => ['icon' => '🚐', 'gradient' => 'from-indigo-600 to-indigo-900'],
                    'Motor'  => ['icon' => '🏍️', 'gradient' => 'from-orange-500 to-red-700'],
                    'Pickup' => ['icon' => '🛻', 'gradient' => 'from-amber-600 to-amber-900'],
                ];
                $config = $typeConfig[$vehicle->type] ?? ['icon' => '🚘', 'gradient' => 'from-gray-600 to-gray-900'];
            @endphp
            <h2 class="text-xl font-bold text-gray-900 mb-4">Konfirmasi Kendaraan</h2>

            <div class="relative h-48 rounded-2xl bg-gradient-to-br {{ $config['gradient'] }} flex items-center justify-center mb-4">
                <span class="text-7xl">{{ $config['icon'] }}</span>
            </div>

            <h3 class="text-lg font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
            <p class="text-sm text-gray-500 mb-4">{{ $vehicle->plate_number }} • {{ $vehicle->type }} • {{ $vehicle->year }}</p>

            <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                <div class="bg-gray-50 rounded-xl p-3">
                    <span class="text-gray-500">Transmisi</span>
                    <p class="font-semibold text-gray-900">{{ $vehicle->transmission ?? 'Manual' }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <span class="text-gray-500">Tarif/Hari</span>
                    <p class="font-semibold text-blue-600">Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button wire:click="nextStep"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                    Lanjut →
                </button>
            </div>
        @endif

        {{-- STEP 2: DATES --}}
        @if($currentStep === 2)
            <h2 class="text-xl font-bold text-gray-900 mb-4">Pilih Tanggal & Layanan Tambahan</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" wire:model="start_date"
                        class="w-full rounded-xl border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    @error('start_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input type="date" wire:model="end_date"
                        class="w-full rounded-xl border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    @error('end_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            @if($this->totalDays > 0)
                <div class="bg-blue-50 rounded-xl p-4 mb-4 text-sm text-blue-800 font-semibold">
                    Durasi sewa: {{ $this->totalDays }} hari
                </div>
            @endif

            <h3 class="text-sm font-semibold text-gray-900 mb-3">Layanan Tambahan (Opsional)</h3>
            <div class="space-y-3 mb-4">
                <label class="flex items-center justify-between p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50">
                    <span class="text-sm text-gray-700">✈️ Penjemputan Bandara</span>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-400">+Rp 50.000</span>
                        <input type="checkbox" wire:model="airport_pickup" class="rounded text-blue-600">
                    </div>
                </label>
                <label class="flex items-center justify-between p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50">
                    <span class="text-sm text-gray-700">🧑‍✈️ Dengan Pengemudi</span>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-400">+Rp 150.000</span>
                        <input type="checkbox" wire:model="with_driver" class="rounded text-blue-600">
                    </div>
                </label>
                <label class="flex items-center justify-between p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50">
                    <span class="text-sm text-gray-700">🔑 Akses Keyless</span>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-400">+Rp 30.000</span>
                        <input type="checkbox" wire:model="keyless" class="rounded text-blue-600">
                    </div>
                </label>
            </div>

            <div class="flex justify-between mt-6">
                <button wire:click="previousStep"
                    class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">
                    ← Kembali
                </button>
                <button wire:click="nextStep"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                    Lanjut →
                </button>
            </div>
        @endif
        @if($currentStep === 3)
<div class="bg-white rounded-2xl p-6 shadow space-y-6">

    <h2 class="text-xl font-bold">Upload Required Documents</h2>

    <div>
        <label class="block text-sm font-medium">Full Name</label>
        <input type="text"
            wire:model="customer_name"
            class="w-full mt-2 rounded-xl border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium">ID Number</label>
        <input type="text"
            wire:model="id_number"
            class="w-full mt-2 rounded-xl border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium">Phone Number</label>
        <input type="text"
            wire:model="phone"
            class="w-full mt-2 rounded-xl border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium">Upload KTP</label>
        <input type="file"
            wire:model="ktp_file"
            class="w-full mt-2">
    </div>

    <div>
        <label class="block text-sm font-medium">Upload SIM</label>
        <input type="file"
            wire:model="sim_file"
            class="w-full mt-2">
    </div>

    <div class="flex justify-between">
        <button wire:click="previousStep"
            class="px-4 py-2 bg-gray-200 rounded-xl">
            Back
        </button>

        <button wire:click="nextStep"
            class="px-4 py-2 bg-blue-600 text-white rounded-xl">
            Continue
        </button>
    </div>

</div>
@endif
@if($currentStep === 4)
<div class="bg-white rounded-2xl p-6 shadow space-y-6">

    <h2 class="text-xl font-bold">Booking Summary</h2>

    <p><strong>Vehicle:</strong> {{ $vehicle->brand }} {{ $vehicle->model }}</p>
    <p><strong>Start Date:</strong> {{ $start_date }}</p>
    <p><strong>End Date:</strong> {{ $end_date }}</p>
    <p><strong>Total Days:</strong> {{ $this->totalDays }}</p>

    <div>
        <h3 class="font-semibold">Add-ons:</h3>
        @if($airport_pickup) <p>✔ Airport Pickup</p> @endif
        @if($with_driver) <p>✔ Driver Service</p> @endif
        @if($keyless) <p>✔ Keyless Access</p> @endif
    </div>

    <p><strong>Add-on Fees:</strong> Rp {{ number_format($this->addonFees) }}</p>

    <p class="text-lg font-bold text-blue-600">
        Total: Rp {{ number_format($this->totalCost) }}
    </p>

    

<div class="bg-white rounded-2xl border p-6 mt-6y-4">
    <h3 class="font-bold mb-4">Pembayaran DP 20%</h3>

    <img src="{{ asset('images/qr.jpeg') }}"
         class="w-64 mx-auto rounded-xl shadow">

    <div class="text-center mt-4">
        <p class="text-sm text-gray-500">Total DP yang harus dibayar</p>
        <p class="text-2xl font-bold text-blue-600">
            Rp {{ number_format($this->totalCost * 0.2, 0, ',', '.') }}
        </p>
    </div>

    <div class="mt-6" class="space-y-6">
        <label class="block text-sm font-medium mb-2">
            Upload Bukti Transfer
        </label>

        <input type="file" wire:model="payment_proof"
               class="w-full rounded-xl border-gray-300">
    </div>
    

    <div class="flex justify-between">
        <button wire:click="previousStep"
            class="px-4 py-2 bg-gray-200 rounded-xl">
            Back
        </button>

        <button wire:click="confirmBooking"
    class="px-4 py-2 bg-blue-600 text-white rounded-xl">
    Confirm Booking
</button>
    </div>

</div>
@endif
@if($currentStep === 5)
<div class="bg-white rounded-2xl p-10 shadow text-center">

    <div class="text-5xl mb-4">✅</div>

    <h2 class="text-2xl font-bold">Booking Confirmed</h2>

    <p class="text-gray-600 mt-2">
        Your booking request has been submitted successfully.
    </p>

    <a href="{{ route('customer.my-rentals') }}"
        class="inline-block mt-6 px-6 py-3 bg-blue-600 text-white rounded-xl">
        View My Rentals
    </a>

</div>
@endif

    </div>
</div>