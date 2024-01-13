<?php

declare(strict_types=1);

namespace App\Enums;

enum Status: string
{
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';
    case PART_ORDERED = 'part_ordered';
    case RECALL = 'recall';
    case RESCHEDULE = 'reschedule';

    public static function values(bool $all = false): array
    {
        $statuses = array_column(self::cases(), 'value');

        return $all ? array_merge($statuses, ['all']) : $statuses;
    }
}
