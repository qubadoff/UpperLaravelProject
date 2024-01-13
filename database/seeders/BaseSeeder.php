<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

abstract class BaseSeeder extends Seeder
{
    protected function getData(string $file): array
    {
        return require_once __DIR__ . "/data/$file.php";
    }
}
