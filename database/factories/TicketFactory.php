<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Fee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TicketFactory extends Factory
{
    private static int $ticketNumber = 1;

    public function definition(): array
    {
        return [
            'customer_address' => $this->getCustomerAddress(),
            'longitude' => $this->getLongitude(),
            'latitude' => $this->getLatitude(),
            'customer_name' => $this->getCustomerName(),
            'customer_phone' => $this->getCustomerPhone(),
            'admin_id' => $this->getAdminId(),
            'user_id' => $this->getUserId(),
            'brand_id' => $this->getBrandId(),
            'appliance_id' => $this->getApplianceId(),
            'fee_id' => $feeId = $this->getFeeId(),
            'note' => $this->getNote(),
            'status' => $status = $this->getStatus(),
            'parts_fee' => $partsFee = $this->getPartsFee(),
            'fee_note' => $this->getFeeNote(),
            'total_fee' => $this->getTotalFee($feeId, $partsFee),
            'created_at' => $createdAt = $this->getCreatedAt(),
            'reschedule_date' => $rescheduleDate = $this->getRescheduleDate($createdAt),
            'start_time' => $startTime = $this->getStartTime(),
            'end_time' => $this->getEndTime($startTime),
            'executed_at' => $this->getExecutedAt($status, $rescheduleDate),
            'ticket_number' => $this->getTicketNumber($createdAt),
        ];
    }

    private function getAdminId(): int
    {
        return rand(1, 3);
    }

    private function getApplianceId(): int
    {
        return rand(1, 2);
    }

    private function getBrandId(): int
    {
        return rand(1, 2);
    }

    private function getCreatedAt(): Carbon
    {
        return now()->addDays(rand(0, 30));
    }

    private function getCustomerAddress(): string
    {
        return fake()->address();
    }

    private function getCustomerName(): string
    {
        return fake()->name();
    }

    private function getCustomerPhone(): int
    {
        return rand(9941000000, 9949999999);
    }

    private function getEndTime(string $startTime): string
    {
        return Carbon::make($startTime)
            ->addHours()
            ->format('H:i');
    }

    private function getExecutedAt(?string $status, string $executionDate): ?Carbon
    {
        if ($status !== Status::COMPLETED->value) {
            return null;
        }

        return Carbon::make($executionDate)->addDays(rand(1, 3));
    }

    private function getFeeId(): int
    {
        return rand(1, 4);
    }

    private function getFeeNote(): string
    {
        return fake()->realText(100);
    }

    private function getLatitude(): float
    {
        return fake()->latitude();
    }

    private function getLongitude(): float
    {
        return fake()->longitude();
    }

    private function getNote(): string
    {
        return fake()->realText(80);
    }

    private function getPartsFee(): int
    {
        return rand(0, 100);
    }

    private function getRescheduleDate(Carbon $createdAt): string
    {
        return Carbon::make($createdAt)
            ->addDays(rand(0, 2))
            ->format('Y-m-d');
    }

    private function getStartTime(): string
    {
        $hour = ($rand = rand(0, 22)) < 10 ? "0{$rand}" : $rand;

        return Carbon::createFromTime($hour)->format('H:i');
    }

    private function getStatus(): ?string
    {
        $status = array_merge(Status::values(), [null]);

        return $status[rand(0, 5)];
    }

    private function getTicketNumber(Carbon $createdAt): ?int
    {
        if (! Carbon::make($createdAt)->isToday()) {
            return null;
        }

        return self::$ticketNumber++;
    }

    private function getTotalFee(int $feeId, int $partsFee): float
    {
        $price = Fee::query()->find($feeId)->value('price');

        return $price + $partsFee;
    }

    private function getUserId(): ?int
    {
        $users = array_merge([1, 2], [null]);

        return $users[rand(0, 2)];
    }
}
