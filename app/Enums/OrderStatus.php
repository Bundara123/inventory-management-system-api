<?php

namespace App\Enums;

enum OrderStatus: init
{
    case PENDING = 0;
    case COMPLETE = 1;
    public function label(): string
    {
        return match ($this) {
            self::PENDING => __('Pending'),
            self::COMPLETE => __('Complete'),
        };
    }
}
