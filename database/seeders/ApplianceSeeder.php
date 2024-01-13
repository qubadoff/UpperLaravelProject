<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Appliance;

class ApplianceSeeder extends BaseSeeder
{
    public function run(): void
    {
        $data = $this->getData('appliances');

        Appliance::query()->insert($data);
    }
}
