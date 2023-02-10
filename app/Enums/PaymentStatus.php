<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PENDING()
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
            'PENDING' => 'pending',
            'EXPIRED' => 'expired',
            'FAILED' => 'failed',
            'SUCCESS' => 'success',
            'VERIFIED' => 'verified',
        ];
    }

    protected static function labels(): array
    {
        return [
            'PENDING' => 'در انتظار پرداخت',
            'EXPIRED' => 'منقضی شده',
            'FAILED' => 'ناموفق',
            'SUCCESS' => 'موفق',
            'VERIFIED' => 'تایید شده',
        ];
    }
}
