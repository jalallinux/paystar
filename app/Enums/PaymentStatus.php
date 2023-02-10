<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self CREATED()
 * @method static self GATEWAY()
 * @method static self EXPIRED()
 * @method static self FAILED()
 * @method static self SUCCESS()
 * @method static self VERIFIED()
 */
final class PaymentStatus extends Enum
{
    protected static function values(): array
    {
        return [
            'CREATED' => 'created',
            'GATEWAY' => 'gateway',
            'EXPIRED' => 'expired',
            'FAILED' => 'failed',
            'SUCCESS' => 'success',
            'VERIFIED' => 'verified',
        ];
    }

    protected static function labels(): array
    {
        return [
            'CREATED' => 'ایجاد شده',
            'GATEWAY' => 'در حال پرداخت',
            'EXPIRED' => 'منقضی شده',
            'FAILED' => 'ناموفق',
            'SUCCESS' => 'موفق',
            'VERIFIED' => 'تایید شده',
        ];
    }
}
