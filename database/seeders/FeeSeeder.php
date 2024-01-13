<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Fee;

class FeeSeeder extends BaseSeeder
{
    public function run(): void
    {
        $data = $this->getData('fees');

        Fee::query()->insert($data);
    }
}
