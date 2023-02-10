<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PENDING()
 * @method static self FAILED()
 * @method static self SUCCESS()
 * @method static self VERIFIED()
 * @method static self UNVERIFIED()
 */
final class PaymentStatus extends Enum
{
    protected static function values(): array
    {
        return [
            'PENDING' => 'pending',
            'FAILED' => 'failed',
            'SUCCESS' => 'success',
            'VERIFIED' => 'verified',
            'UNVERIFIED' => 'unverified',
        ];
    }

    protected static function labels(): array
    {
        return [
            'PENDING' => 'در انتظار پرداخت',
            'FAILED' => 'ناموفق',
            'SUCCESS' => 'موفق',
            'VERIFIED' => 'تایید شده',
            'UNVERIFIED' => 'تایید نشده',
        ];
    }
}
