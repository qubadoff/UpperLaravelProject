<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;

class UserSeeder extends BaseSeeder
{
    public function run(): void
    {
        $data = $this->getData('users');

        User::query()->insert($data);
    }
}
