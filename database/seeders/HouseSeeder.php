<?php

namespace Database\Seeders;

use App\Models\House;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HouseSeeder extends Seeder
{
    /**
     * Seed a sample renter/house with a few monthly bills.
     */
    public function run(): void
    {
        $house = House::create([
            'name' => 'Brandon Jacob',
            'phone' => '01712-345678',
            'email' => 'brandon@example.com',
            'unit' => 'House A-12',
            'rent_amount' => 650,
            'water_amount' => 20,
            'security_deposit' => 650,
            'electric_meter_number' => 'EM-0098-4521',
            'electric_account_number' => 'ACC-77310-002',
            'gas_meter_number' => 'GM-5530-118',
            'lease_start' => '2026-01-01',
            'lease_end' => '2026-12-31',
            'status' => 'active',
        ]);

        // period => [electricity, status]
        $months = [
            '2026-04-01' => [52, 'paid'],
            '2026-05-01' => [38, 'paid'],
            '2026-06-01' => [45, 'paid'],
            '2026-07-01' => [48, 'unpaid'],
        ];

        foreach ($months as $period => [$electricity, $status]) {
            $period = Carbon::parse($period);

            $house->bills()->create([
                'period' => $period,
                'rent' => $house->rent_amount,
                'water' => $house->water_amount,
                'electricity' => $electricity,
                'due_date' => $period->copy()->addDays(20),
                'status' => $status,
                'method' => $status === 'paid' ? 'M-Pesa' : null,
                'paid_at' => $status === 'paid' ? $period->copy()->addDays(3) : null,
            ]);
        }
    }
}
