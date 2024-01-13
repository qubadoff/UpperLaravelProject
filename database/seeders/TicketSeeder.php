<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        Ticket::query()->create([
            'ticket_number' => 2,
            'customer_address' => 'Customer address',
            'latitude' => 9.99,
            'longitude' => 9.999,
            'customer_name' => 'Customer name',
            'customer_phone' => '9941112233',
            'admin_id' => 1,
            'user_id' => 1,
            'brand_id' => 1,
            'appliance_id' => 1,
            'fee_id' => 1,
            'total_fee' => 100,
            'reschedule_date' => '2023-09-26',
            'start_time' => '20:00:00',
            'end_time' => '21:00:00',
        ]);
    }
}
