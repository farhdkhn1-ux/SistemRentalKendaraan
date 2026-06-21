<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        User::factory()->create([
            'name' => 'Admin Farhad Khan',
            'email' => 'admin@rentalku.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Farhad Khan',
            'email' => 'customer@rentalku.test',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        User::factory()->create([
            'name' => 'Wisatawan Domestik',
            'email' => 'wisatawan@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Vehicles
        Vehicle::create([
            'plate_number' => 'BA 1234 FK',
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'type' => 'MPV',
            'year' => 2022,
            'color' => 'Silver',
            'transmission' => 'Manual',
            'luggage_capacity' => 4,
            'pick_up_location' => 'Bandara Minangkabau',
            'features' => 'AC, Bluetooth, Child Seat, USB Charger, Airbag',
            'photo' => 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=600&auto=format&fit=crop&q=60',
            'daily_rate' => 350000.00,
            'seasonal_price' => 450000.00,
            'seasonal_start' => now()->startOfMonth()->addDays(5)->format('Y-m-d'),
            'seasonal_end' => now()->startOfMonth()->addDays(15)->format('Y-m-d'),
            'status' => 'available',
            'stnk_expiration' => now()->addYears(2)->format('Y-m-d'),
            'insurance_expiration' => now()->addYear()->format('Y-m-d'),
            'service_schedule' => now()->addDays(10)->format('Y-m-d'),
        ]);

        Vehicle::create([
            'plate_number' => 'BA 5678 AA',
            'brand' => 'Mitsubishi',
            'model' => 'Xpander',
            'type' => 'MPV',
            'year' => 2023,
            'color' => 'Hitam',
            'transmission' => 'Matic',
            'luggage_capacity' => 4,
            'pick_up_location' => 'Kantor Pusat',
            'features' => 'AC, Bluetooth, Child Seat, GPS Navigation, Keyless Entry, USB Charger',
            'photo' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=600&auto=format&fit=crop&q=60',
            'daily_rate' => 450000.00,
            'seasonal_price' => 550000.00,
            'seasonal_start' => now()->startOfMonth()->format('Y-m-d'),
            'seasonal_end' => now()->startOfMonth()->addDays(10)->format('Y-m-d'),
            'status' => 'available',
            'stnk_expiration' => now()->addMonths(6)->format('Y-m-d'),
            'insurance_expiration' => now()->addMonths(12)->format('Y-m-d'),
            'service_schedule' => now()->addDays(20)->format('Y-m-d'),
        ]);

        Vehicle::create([
            'plate_number' => 'BA 4321 OK',
            'brand' => 'Honda',
            'model' => 'Brio',
            'type' => 'Sedan',
            'year' => 2021,
            'color' => 'Kuning',
            'transmission' => 'Matic',
            'luggage_capacity' => 2,
            'pick_up_location' => 'Bandara Minangkabau',
            'features' => 'AC, Bluetooth, USB Charger, Parking Sensors',
            'photo' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=600&auto=format&fit=crop&q=60',
            'daily_rate' => 300000.00,
            'status' => 'available',
            'stnk_expiration' => now()->addDays(15)->format('Y-m-d'), // Expiring soon warning!
            'insurance_expiration' => now()->addMonths(3)->format('Y-m-d'),
            'service_schedule' => now()->subDays(2)->format('Y-m-d'), // Service overdue warning!
        ]);

        Vehicle::create([
            'plate_number' => 'BA 9999 S',
            'brand' => 'Toyota',
            'model' => 'Fortuner',
            'type' => 'SUV',
            'year' => 2024,
            'color' => 'Putih',
            'transmission' => 'Matic',
            'luggage_capacity' => 6,
            'pick_up_location' => 'Kantor Pusat',
            'features' => 'AC, Bluetooth, Child Seat, GPS Navigation, Leather Seats, Rear Camera, Sunroof',
            'photo' => 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?w=600&auto=format&fit=crop&q=60',
            'daily_rate' => 900000.00,
            'seasonal_price' => 1200000.00,
            'seasonal_start' => now()->startOfMonth()->format('Y-m-d'),
            'seasonal_end' => now()->endOfMonth()->format('Y-m-d'),
            'status' => 'available',
            'stnk_expiration' => now()->addYears(3)->format('Y-m-d'),
            'insurance_expiration' => now()->addYears(2)->format('Y-m-d'),
            'service_schedule' => now()->addMonths(3)->format('Y-m-d'),
        ]);

        Vehicle::create([
            'plate_number' => 'BA 7777 BE',
            'brand' => 'Honda',
            'model' => 'Beat',
            'type' => 'Motor',
            'year' => 2022,
            'color' => 'Biru',
            'transmission' => 'Matic',
            'luggage_capacity' => 1,
            'pick_up_location' => 'Bandara Minangkabau',
            'features' => 'Helmet, Raincoat, Charger USB',
            'photo' => 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=600&auto=format&fit=crop&q=60',
            'daily_rate' => 80000.00, // Rp 80.000 / day
            'status' => 'available',
            'stnk_expiration' => now()->addYears(2)->format('Y-m-d'),
            'insurance_expiration' => now()->addYear()->format('Y-m-d'),
            'service_schedule' => now()->addDays(5)->format('Y-m-d'),
        ]);

        Vehicle::create([
            'plate_number' => 'BA 8888 NM',
            'brand' => 'Yamaha',
            'model' => 'NMax',
            'type' => 'Motor',
            'year' => 2023,
            'color' => 'Abu-abu',
            'transmission' => 'Matic',
            'luggage_capacity' => 1,
            'pick_up_location' => 'Kantor Pusat',
            'features' => 'Double Helmet, Raincoat, Phone Holder, Windshield',
            'photo' => 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=600&auto=format&fit=crop&q=60',
            'daily_rate' => 150000.00,
            'status' => 'available',
            'stnk_expiration' => now()->subDays(5)->format('Y-m-d'), // Expired STNK warning!
            'insurance_expiration' => now()->subDays(10)->format('Y-m-d'), // Expired Insurance!
            'service_schedule' => now()->addDays(12)->format('Y-m-d'),
        ]);
    }
}
