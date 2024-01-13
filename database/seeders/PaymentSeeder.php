<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Payment;

class PaymentSeeder extends BaseSeeder
{
    public function run(): void
    {
        $data = $this->getData('payments');

        Payment::query()->insert($data);
    }
}
