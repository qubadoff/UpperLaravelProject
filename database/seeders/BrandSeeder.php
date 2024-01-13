<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Brand;

class BrandSeeder extends BaseSeeder
{
    public function run(): void
    {
        $data = $this->getData('brands');

        Brand::query()->insert($data);
    }
}
