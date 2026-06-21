<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentalKu | Rental Mobil & Motor Padang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-white text-gray-900">
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">RentalKu</a>
           <nav class="flex items-center gap-4 text-sm font-medium">
                <a href="{{ route('vehicles.catalog') }}" class="text-gray-700 hover:text-blue-600">Kendaraan</a>
                @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                    @if(\Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded-full bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700 transition">Register</a>
                    @endif
                @endguest
                @auth
                    @if(auth()->user()->role === 'customer')
                        <span class="text-gray-700">Halo, {{ auth()->user()->name }}!</span>
                        <a href="{{ route('customer.my-rentals') }}" class="text-gray-700 hover:text-blue-600">Booking Saya</a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.vehicles.index') }}" class="text-gray-700 hover:text-blue-600">Dashboard Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline-block">
                        @csrf
                        <button type="submit" class="rounded-full bg-gray-900 px-4 py-2 text-white shadow hover:bg-gray-800 transition">Logout</button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        <section class="bg-gradient-to-br from-blue-500 via-sky-100 to-white py-20">
            <div class="mx-auto grid max-w-7xl gap-12 px-6 lg:grid-cols-2 lg:items-center">
                <div class="space-y-6">
                    <p class="inline-flex rounded-full bg-white/80 px-4 py-2 text-sm font-semibold text-blue-700 shadow-sm">Rental mobil & motor terbaik di Padang</p>
                    @auth
                        @if(auth()->user()->role === 'customer')
                            <p class="text-blue-600 font-semibold mb-2">Selamat datang kembali, {{ auth()->user()->name }}! 👋</p>
                        @endif
                    @endauth
                    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">Sewa Mobil & Motor Mudah, Cepat, Tanpa Ribet di Padang</h1>
                    <p class="max-w-2xl text-lg text-gray-700">RentalKu siap membantu perjalananmu dengan armada terawat, sistem booking online, dan layanan cepat untuk kebutuhan sewa mobil maupun motor di Sumatra Barat.</p>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a href="#kendaraan" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-base font-semibold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-700">Lihat Kendaraan</a>
                        <a href="https://wa.me/6283139980834" target="_blank" class="inline-flex items-center justify-center rounded-full border border-blue-600 bg-white px-6 py-3 text-base font-semibold text-blue-600 shadow-sm transition hover:bg-blue-50">Chat WhatsApp</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="mx-auto flex max-w-xl justify-center lg:justify-end">
                        <div class="relative overflow-hidden rounded-[2rem] bg-white p-8 shadow-2xl ring-1 ring-black/5">
                            <div class="space-y-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-blue-50 text-3xl">🚗</div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-500">Armada Mobil</p>
                                        <p class="text-lg font-semibold text-gray-900">Pilihan lengkap untuk perjalanan keluarga</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-sky-50 text-3xl">🏍️</div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-500">Armada Motor</p>
                                        <p class="text-lg font-semibold text-gray-900">Praktis untuk mobilitas harian</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-12 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Solusi Rental</p>
                    <h2 class="mt-4 text-3xl font-bold text-gray-900 sm:text-4xl">Masih Bingung Urus Transportasi?</h2>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-lg">
                        <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">📍</div>
                        <h3 class="text-xl font-semibold text-gray-900">Ribet cari rental terpercaya</h3>
                        <p class="mt-3 text-gray-600">Tidak perlu bingung, RentalKu menyediakan armada resmi dan layanan profesional untuk perjalanan nyaman.</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-lg">
                        <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">🛠️</div>
                        <h3 class="text-xl font-semibold text-gray-900">Takut kendaraan tidak terawat</h3>
                        <p class="mt-3 text-gray-600">Semua kendaraan kami rutin service dan diperiksa sebelum diserahkan ke pelanggan.</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-lg">
                        <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">⏱️</div>
                        <h3 class="text-xl font-semibold text-gray-900">Proses booking lambat</h3>
                        <p class="mt-3 text-gray-600">Booking online cepat tanpa harus datang langsung, langsung dari ponselmu.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-12 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Kenapa Pilih RentalKu</p>
                    <h2 class="mt-4 text-3xl font-bold text-gray-900 sm:text-4xl">RentalKu Hadir Sebagai Solusinya</h2>
                </div>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-lg">
                        <div class="mb-5 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">✅</div>
                        <h3 class="text-xl font-semibold text-gray-900">Kendaraan Terawat</h3>
                        <p class="mt-3 text-gray-600">Armada selalu dicek rutin sehingga kamu dapat perjalanan aman dan nyaman.</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-lg">
                        <div class="mb-5 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">🕒</div>
                        <h3 class="text-xl font-semibold text-gray-900">Booking 24 Jam</h3>
                        <p class="mt-3 text-gray-600">Pesan kapan saja tanpa batasan jam kerja—langsung dari layar ponselmu.</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-lg">
                        <div class="mb-5 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">💎</div>
                        <h3 class="text-xl font-semibold text-gray-900">Harga Transparan</h3>
                        <p class="mt-3 text-gray-600">Tidak ada biaya tersembunyi, semua harga jelas sejak awal.</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-lg">
                        <div class="mb-5 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">⚡</div>
                        <h3 class="text-xl font-semibold text-gray-900">Approval Cepat</h3>
                        <p class="mt-3 text-gray-600">Proses sewa cepat dengan persetujuan admin yang sigap.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="kendaraan" class="bg-blue-50 py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-12 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Pilihan Kendaraan</p>
                    <h2 class="mt-4 text-3xl font-bold text-gray-900 sm:text-4xl">Pilihan Kendaraan Tersedia</h2>
                </div>
                <div class="grid gap-6 lg:grid-cols-3">
                    @forelse($vehicles as $vehicle)
                        <div class="rounded-3xl border border-white bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="mb-4 flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                                    <span class="mt-2 inline-flex rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">{{ ucfirst($vehicle->type) }}</span>
                                </div>
                            </div>
                            <div class="space-y-3 text-sm text-gray-600">
                                <p><span class="font-semibold text-gray-900">Plat:</span> {{ $vehicle->plate_number }}</p>
                                <p><span class="font-semibold text-gray-900">Tahun:</span> {{ $vehicle->year }}</p>
                                <p><span class="font-semibold text-gray-900">Warna:</span> {{ $vehicle->color }}</p>
                                <p class="text-lg font-semibold text-blue-600">Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }}/hari</p>
                            </div>
                            <div class="mt-6">
                                @guest
                                    <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">Login untuk Booking</a>
                                @else
                                    @if(auth()->user()->role === 'customer')
                                        <a href="{{ route('customer.booking', $vehicle) }}" class="inline-flex w-full items-center justify-center rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-blue-700 transition">Booking Sekarang</a>
                                    @else
                                        <span class="inline-flex w-full items-center justify-center rounded-full bg-gray-100 px-5 py-3 text-sm font-semibold text-gray-500">Halaman ini untuk customer</span>
                                    @endif
                                @endguest
                            </div>
                        </div>
                    @empty
                        <div class="lg:col-span-3 rounded-3xl border border-dashed border-blue-200 bg-white p-10 text-center text-gray-600 shadow-sm">
                            Belum ada kendaraan tersedia saat ini.
                        </div>
                    @endforelse
                </div>
                <div class="mt-12 flex justify-center">
                    @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-white px-7 py-3 text-sm font-semibold text-blue-600 shadow hover:bg-blue-50 transition">Lihat Semua Kendaraan</a>
                    @else
                        @if(optional(auth()->user())->role === 'customer')
                            <a href="{{ route('vehicles.catalog') }}" class="inline-flex items-center justify-center rounded-full bg-white px-7 py-3 text-sm font-semibold text-blue-600 shadow hover:bg-blue-50 transition">Lihat Semua Kendaraan</a>
                        @else
                            <a href="{{ route('admin.vehicles.index') }}" class="inline-flex items-center justify-center rounded-full bg-white px-7 py-3 text-sm font-semibold text-blue-600 shadow hover:bg-blue-50 transition">Lihat Dashboard Admin</a>
                        @endif
                    @endguest
                </div>
            </div>
        </section>

        <section class="py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-12 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Testimoni</p>
                    <h2 class="mt-4 text-3xl font-bold text-gray-900 sm:text-4xl">Apa Kata Pelanggan Kami</h2>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-lg font-bold text-blue-700">AR</div>
                            <div>
                                <p class="font-semibold text-gray-900">Ari Rahman</p>
                                <p class="text-sm text-gray-500">★★★★★</p>
                            </div>
                        </div>
                        <p class="mt-6 text-gray-600">Proses booking cepat dan armadanya terawat. Sangat membantu saat butuh kendaraan mendadak.</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-lg font-bold text-blue-700">MP</div>
                            <div>
                                <p class="font-semibold text-gray-900">Maya Putri</p>
                                <p class="text-sm text-gray-500">★★★★★</p>
                            </div>
                        </div>
                        <p class="mt-6 text-gray-600">Pelayanan ramah dan transparan. Harga jelas, mobil bersih, dan perjalanan jadi lebih tenang.</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-lg font-bold text-blue-700">RS</div>
                            <div>
                                <p class="font-semibold text-gray-900">Rian Saputra</p>
                                <p class="text-sm text-gray-500">★★★★★</p>
                            </div>
                        </div>
                        <p class="mt-6 text-gray-600">Rekomendasi buat yang ingin sewa mobil atau motor di Padang. Prosesnya simpel dan cepat.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-blue-600 py-20 text-white">
            <div class="mx-auto max-w-7xl px-6 text-center">
                <h2 class="text-3xl font-bold sm:text-4xl">Siap Sewa Kendaraan Sekarang?</h2>
                <p class="mt-4 mx-auto max-w-2xl text-base text-blue-100">Daftar sekarang dan nikmati pengalaman rental tanpa repot bersama RentalKu.</p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-white px-8 py-3 text-sm font-semibold text-blue-700 shadow-lg transition hover:bg-blue-50">Daftar Sekarang</a>
                    @endguest
                    <a href="https://wa.me/6283139980834" target="_blank" class="inline-flex items-center justify-center rounded-full border border-white px-8 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-white hover:text-blue-700">Hubungi Kami via WhatsApp</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-gray-200">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 py-14 md:grid-cols-3">
            <div>
                <p class="text-xl font-bold text-white">RentalKu</p>
                <p class="mt-3 text-sm text-gray-400">Rental mobil & motor terpercaya di Padang, Sumatra Barat.</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-400">Kontak Kami</p>
                <p class="mt-4 text-sm">Padang, Sumatra Barat</p>
                <p class="mt-2 text-sm">WhatsApp: <a href="https://wa.me/6283139980834" class="text-blue-400 hover:text-blue-300">083139980834</a></p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-400">Info</p>
                <p class="mt-4 text-sm">© 2026 RentalKu. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/6283139980834" target="_blank" class="fixed bottom-6 right-6 z-50 inline-flex h-16 w-16 items-center justify-center rounded-full bg-[#25D366] text-white shadow-2xl transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg">
        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20.52 3.48C18.59 1.55 15.97 0.5 13.2 0.5C7.98 0.5 3.7 4.78 3.7 9.99C3.7 11.69 4.18 13.29 5.05 14.66L3 21.5L9.18 19.57C10.59 20.32 12.16 20.75 13.8 20.75H13.81C18.03 20.75 22.3 16.47 22.3 11.26C22.3 8.49 21.25 5.87 19.32 3.94L20.52 3.48Z" fill="white" opacity="0.12"/>
            <path d="M13.2 1.5C15.57 1.5 17.9 2.35 19.68 4.13C21.48 5.92 22.33 8.25 22.33 10.62C22.33 15.46 18.18 19.61 13.33 19.61H13.32C11.34 19.61 9.44 19.09 7.75 18.13L5.55 17.04L4.09 20.34L7.38 18.89C8.72 19.72 10.28 20.19 11.92 20.19H11.93C16.04 20.19 19.47 16.76 19.47 12.65C19.47 10.67 18.7 8.82 17.29 7.4C15.89 5.99 14.04 5.22 12.06 5.22C9.11 5.22 6.46 6.83 5.14 9.39L4.74 10.18L4.61 10.58L4.61 11.07L4.5 12.42L4.43 13.19L4.5 13.34L4.79 14.03L5.18 14.42L5.2 14.45C5.7 15.1 6.34 15.63 7.07 16.01L7.1 16.03C8.56 16.76 10.2 17.12 11.84 17.12H11.85C12.85 17.12 13.85 16.95 14.78 16.62L14.97 16.54L15.22 16.44C15.73 16.23 16.19 15.9 16.57 15.47C16.72 15.29 16.92 15.11 17.06 14.9L17.24 14.64L17.29 14.53L17.3 14.47C17.47 13.94 17.55 13.38 17.55 12.82C17.55 9.41 15.12 6.34 11.78 5.57C10.95 5.34 10.03 5.25 9.22 5.31C8.4 5.37 7.3 5.58 6.55 6.16C5.96 6.6 5.28 7.53 5.1 8.03C4.85 8.71 4.86 9.05 5.1 9.38C5.34 9.72 5.9 10.15 6.11 10.29C6.3 10.42 6.5 10.46 6.71 10.38C6.93 10.3 7.64 10.02 8.18 9.85C8.73 9.69 9.03 9.62 9.41 9.76C9.78 9.89 10.4 10.31 10.72 10.53C11.05 10.74 11.24 10.85 11.45 10.84C11.66 10.84 12.16 10.7 12.91 10.44C13.66 10.18 14.4 9.92 14.85 9.8C15.31 9.68 15.55 9.65 15.78 9.74C16.01 9.83 16.16 10.05 16.28 10.32C16.41 10.59 16.41 11.03 16.41 11.53C16.41 12.03 16.41 12.55 16.39 13.06C16.37 13.56 16.25 13.84 16.05 13.94C15.88 14.03 15.68 14.03 15.46 13.97C15.24 13.91 14.3 13.61 13.75 13.43C13.2 13.25 12.94 13.18 12.75 13.17C12.56 13.16 12.39 13.2 12.12 13.33C11.85 13.45 11.05 13.8 10.63 14.02C10.21 14.23 9.7 14.56 9.17 14.56C8.64 14.56 8.22 14.41 7.75 14.19C7.28 13.96 6.63 13.55 6.24 13.18C5.86 12.81 5.26 12.11 5.03 11.85C4.8 11.6 4.68 11.37 4.69 11.15C4.7 10.93 4.78 10.63 4.97 10.27C5.17 9.91 5.45 9.53 5.59 9.35C5.73 9.17 5.97 8.96 6.28 8.9C6.6 8.84 7.36 8.93 7.65 9.05C7.94 9.17 8.32 9.32 8.5 9.38C8.68 9.44 9.03 9.68 9.28 9.96C9.53 10.24 9.72 10.59 9.84 10.74C9.95 10.9 10.12 11.14 10.32 11.19C10.54 11.24 10.94 11.33 11.1 11.36C11.27 11.39 11.46 11.4 11.63 11.32C11.81 11.24 12.07 11.07 12.22 10.97C12.38 10.87 12.67 10.68 12.89 10.64C13.11 10.6 13.42 10.63 13.73 10.7C14.04 10.77 14.31 10.86 14.52 10.97C14.73 11.08 15.02 11.22 15.22 11.29C15.41 11.36 15.63 11.36 15.75 11.32C15.86 11.27 16.01 11.18 16.11 11.09"
                fill="white"/>
        </svg>
    </a>
</body>
</html>
