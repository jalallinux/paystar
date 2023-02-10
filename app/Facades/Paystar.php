<?php

namespace App\Facades;

use App\Services\Paystar\PaystarGateway;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection create(int $amount, string $paymentId, array $additional = [])
 * @method static Collection verify(int $amount, string $ref_num, string $card_number, int $tracking_code)
 *
 * @see PaystarGateway
 */
class Paystar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'paystar';
    }
}
