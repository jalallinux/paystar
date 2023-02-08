<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

trait WithUuidColumn
{
    protected static function bootWithUuidColumn()
    {
        static::creating(function (self $model) {
            if (! $model->getKey()) {
                $uuid = @$model->{$model->getUuidKeyName()};
                $model->{$model->getUuidKeyName()} = (!is_null($uuid) && Str::isUuid($uuid)) ? $uuid : Str::uuid()->toString();
            }
        });
    }

    #[Pure]
    public function getRouteKeyName(): string
    {
        return $this->getUuidKeyName();
    }

    public function getUuidKeyName(): string
    {
        return 'uuid';
    }
}
