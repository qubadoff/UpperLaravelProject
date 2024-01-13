<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminSeeder::class);

        if (! app()->isProduction()) {
            $this->call([
                UserSeeder::class,
                BrandSeeder::class,
                ApplianceSeeder::class,
                FeeSeeder::class,
                PaymentSeeder::class,
            ]);

            Ticket::factory(500)->create();
        }
    }
}
