<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;

class AdminSeeder extends BaseSeeder
{
    public function run(): void
    {
        $data = $this->getData('admins');

        Admin::query()->insert($data);
    }
}
