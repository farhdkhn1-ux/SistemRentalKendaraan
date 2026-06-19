@extends('layouts.admin')

@section('title', 'Pengembalian Kendaraan')

@section('content')

<div class="max-w-2xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('admin.rentals.index') }}"
           class="text-blue-600 hover:underline text-sm">&larr; Kembali ke Daftar Rental</a>
    </div>

    <div class="rounded-2xl bg-white shadow-sm border border-slate-200 overflow-hidden">

        {{-- Title Bar --}}
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4 text-white">
            <h3 class="text-xl font-bold">Proses Pengembalian</h3>
            <p class="text-sm opacity-90">{{ $rental->customer_name }} — {{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}</p>
        </div>

        <div class="p-6">

            {{-- Info Rental --}}
            <div class="mb-6 grid grid-cols-2 gap-4 text-sm">
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-slate-500 mb-1">Kendaraan</p>
                    <p class="font-bold">{{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}</p>
                    <p class="text-slate-500">{{ $rental->vehicle->plate_number }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-slate-500 mb-1">Pelanggan</p>
                    <p class="font-bold">{{ $rental->customer_name }}</p>
                    <p class="text-slate-500">{{ $rental->phone }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-slate-500 mb-1">Tanggal Sewa</p>
                    <p class="font-bold">{{ $rental->start_date->format('d M Y') }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-slate-500 mb-1">Tanggal Harus Kembali</p>
                    <p class="font-bold">{{ $rental->end_date->format('d M Y') }}</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-blue-500 mb-1">Biaya Sewa</p>
                    <p class="font-bold text-blue-700">Rp {{ number_format($rental->total_cost, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl p-4 {{ $lateDays > 0 ? 'bg-red-50' : 'bg-green-50' }}">
                    <p class="{{ $lateDays > 0 ? 'text-red-500' : 'text-green-500' }} mb-1">Status Keterlambatan</p>
                    @if($lateDays > 0)
                        <p class="font-bold text-red-700">Terlambat {{ $lateDays }} hari</p>
                    @else
                        <p class="font-bold text-green-700">Tepat waktu</p>
                    @endif
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.rentals.return.process', $rental) }}" method="POST" id="returnForm">
                @csrf

                <div class="space-y-4">

                    {{-- Tanggal Pengembalian --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Pengembalian</label>
                        <input type="date"
                               name="returned_date"
                               id="returned_date"
                               value="{{ old('returned_date', now()->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                               required>
                        @error('returned_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Denda Info --}}
                    <div id="lateInfo" class="{{ $lateDays > 0 ? '' : 'hidden' }}">
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                <span class="font-semibold text-amber-800">Keterlambatan Terdeteksi</span>
                            </div>
                            <p class="text-sm text-amber-700">
                                Terlambat <strong id="lateDaysDisplay">{{ $lateDays }}</strong> hari.
                                Denda per hari: <strong>Rp {{ number_format($lateFeePerDay, 0, ',', '.') }}</strong>
                                (50% dari tarif harian Rp {{ number_format($rental->vehicle->daily_rate, 0, ',', '.') }})
                            </p>
                        </div>
                    </div>

                    {{-- Denda Keterlambatan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Denda Keterlambatan (Rp)</label>
                        <input type="number"
                               name="late_fee"
                               id="late_fee"
                               value="{{ old('late_fee', $suggestedLateFee) }}"
                               min="0"
                               step="1000"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                               required>
                        <p class="text-xs text-slate-500 mt-1">Dihitung otomatis atau sesuaikan kebutuhan.</p>
                        @error('late_fee')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Denda Tambahan Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
                        {{-- Kunci Hilang --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kunci Hilang?</label>
                            <select name="fee_lost_key"
                                    id="fee_lost_key"
                                    class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500"
                                    required>
                                <option value="0" {{ old('fee_lost_key') == 0 ? 'selected' : '' }}>Tidak</option>
                                <option value="200000" {{ old('fee_lost_key') == 200000 ? 'selected' : '' }}>Ya (Denda Rp 200.000)</option>
                            </select>
                            @error('fee_lost_key')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Baret / Penyok --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Baret / Penyok</label>
                            <div class="flex gap-2">
                                <input type="number"
                                       id="scratch_dent_count"
                                       value="0"
                                       min="0"
                                       class="w-20 px-3 py-2 rounded-xl border border-slate-200 text-sm text-center focus:ring-2 focus:ring-emerald-500"
                                       required>
                                <div class="flex-1 relative">
                                    <input type="number"
                                           name="fee_scratch_dent"
                                           id="fee_scratch_dent"
                                           value="{{ old('fee_scratch_dent', 0) }}"
                                           min="0"
                                           readonly
                                           class="w-full px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 text-sm focus:outline-none"
                                           required>
                                    <span class="absolute right-3 top-2 text-xs text-slate-400">Rp</span>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-500 mt-1">Denda: Rp 500.000 / baret</p>
                            @error('fee_scratch_dent')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- STNK Hilang --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">STNK Hilang?</label>
                            <select name="fee_lost_stnk"
                                    id="fee_lost_stnk"
                                    class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500"
                                    required>
                                <option value="0" {{ old('fee_lost_stnk') == 0 ? 'selected' : '' }}>Tidak</option>
                                <option value="200000" {{ old('fee_lost_stnk') == 200000 ? 'selected' : '' }}>Ya (Denda Rp 200.000)</option>
                            </select>
                            @error('fee_lost_stnk')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- E-toll Hilang --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">E-Toll Hilang?</label>
                            <select name="fee_lost_etoll"
                                    id="fee_lost_etoll"
                                    class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500"
                                    required>
                                <option value="0" {{ old('fee_lost_etoll') == 0 ? 'selected' : '' }}>Tidak</option>
                                <option value="200000" {{ old('fee_lost_etoll') == 200000 ? 'selected' : '' }}>Ya (Denda Rp 200.000)</option>
                            </select>
                            @error('fee_lost_etoll')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Total Akhir --}}
                    <div class="bg-slate-900 text-white rounded-xl p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-slate-300 text-sm">Biaya Sewa</span>
                            <span class="text-sm">Rp {{ number_format($rental->total_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-slate-300 text-sm">Denda Keterlambatan</span>
                            <span id="lateFeeDisplay" class="text-sm">Rp {{ number_format($suggestedLateFee, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-1 text-slate-400 text-xs pl-4">
                            <span>Denda Kunci Hilang</span>
                            <span id="feeLostKeyDisplay">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center mb-1 text-slate-400 text-xs pl-4">
                            <span>Denda Baret/Penyok</span>
                            <span id="feeScratchDentDisplay">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center mb-1 text-slate-400 text-xs pl-4">
                            <span>Denda STNK Hilang</span>
                            <span id="feeLostStnkDisplay">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center mb-1 text-slate-400 text-xs pl-4">
                            <span>Denda E-Toll Hilang</span>
                            <span id="feeLostEtollDisplay">Rp 0</span>
                        </div>
                        <div class="border-t border-slate-700 pt-2 mt-2 flex justify-between items-center">
                            <span class="font-bold text-lg">Total Akhir</span>
                            <span class="font-bold text-lg text-emerald-400" id="totalFinalDisplay">
                                Rp {{ number_format($rental->total_cost + $suggestedLateFee, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan (Opsional)</label>
                        <textarea name="notes"
                                  rows="3"
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                  placeholder="Catatan tentang kondisi kendaraan, kerusakan, dll...">{{ old('notes', $rental->notes) }}</textarea>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('admin.rentals.index') }}"
                           class="flex-1 text-center px-4 py-3 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium">
                            Batal
                        </a>
                        <button type="submit"
                                onclick="return confirm('Konfirmasi pengembalian kendaraan?')"
                                class="flex-1 px-4 py-3 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 font-medium">
                            Proses Pengembalian
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const totalCost = {{ $rental->total_cost }};
    const dailyRate = {{ $rental->vehicle->daily_rate }};
    const lateFeePerDay = {{ $lateFeePerDay }};
    const endDate = new Date('{{ $rental->end_date->format("Y-m-d") }}');

    const returnedDateInput = document.getElementById('returned_date');
    const lateFeeInput = document.getElementById('late_fee');
    const feeLostKeyInput = document.getElementById('fee_lost_key');
    const scratchDentCountInput = document.getElementById('scratch_dent_count');
    const feeScratchDentInput = document.getElementById('fee_scratch_dent');
    const feeLostStnkInput = document.getElementById('fee_lost_stnk');
    const feeLostEtollInput = document.getElementById('fee_lost_etoll');

    const lateInfo = document.getElementById('lateInfo');
    const lateDaysDisplay = document.getElementById('lateDaysDisplay');
    const lateFeeDisplay = document.getElementById('lateFeeDisplay');
    const feeLostKeyDisplay = document.getElementById('feeLostKeyDisplay');
    const feeScratchDentDisplay = document.getElementById('feeScratchDentDisplay');
    const feeLostStnkDisplay = document.getElementById('feeLostStnkDisplay');
    const feeLostEtollDisplay = document.getElementById('feeLostEtollDisplay');
    const totalFinalDisplay = document.getElementById('totalFinalDisplay');

    function formatRupiah(num) {
        return 'Rp ' + Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function recalculate() {
        const returnedDate = new Date(returnedDateInput.value);
        let lateDays = 0;

        if (returnedDate > endDate) {
            const diffTime = returnedDate - endDate;
            lateDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        }

        const suggestedFee = lateDays * lateFeePerDay;
        lateFeeInput.value = suggestedFee;

        if (lateDays > 0) {
            lateInfo.classList.remove('hidden');
            lateDaysDisplay.textContent = lateDays;
        } else {
            lateInfo.classList.add('hidden');
        }

        updateDisplay();
    }

    function updateDisplay() {
        // Calculate Scratch & Dent Fee: count * 500000
        const scratchCount = parseInt(scratchDentCountInput.value) || 0;
        const calculatedScratchFee = scratchCount * 500000;
        feeScratchDentInput.value = calculatedScratchFee;

        const lateFee = parseFloat(lateFeeInput.value) || 0;
        const feeKey = parseFloat(feeLostKeyInput.value) || 0;
        const feeScratch = calculatedScratchFee;
        const feeStnk = parseFloat(feeLostStnkInput.value) || 0;
        const feeEtoll = parseFloat(feeLostEtollInput.value) || 0;

        lateFeeDisplay.textContent = formatRupiah(lateFee);
        feeLostKeyDisplay.textContent = formatRupiah(feeKey);
        feeScratchDentDisplay.textContent = formatRupiah(feeScratch);
        feeLostStnkDisplay.textContent = formatRupiah(feeStnk);
        feeLostEtollDisplay.textContent = formatRupiah(feeEtoll);

        const grandTotal = totalCost + lateFee + feeKey + feeScratch + feeStnk + feeEtoll;
        totalFinalDisplay.textContent = formatRupiah(grandTotal);
    }

    returnedDateInput.addEventListener('change', recalculate);
    lateFeeInput.addEventListener('input', updateDisplay);
    feeLostKeyInput.addEventListener('change', updateDisplay);
    scratchDentCountInput.addEventListener('input', updateDisplay);
    feeLostStnkInput.addEventListener('change', updateDisplay);
    feeLostEtollInput.addEventListener('change', updateDisplay);

    // Initial update to reflect old/default values on load
    updateDisplay();
</script>

@endsection
