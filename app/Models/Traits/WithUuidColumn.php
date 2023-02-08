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
                $uuid = @$model->{$model->getUuidKey()};
                $model->{$model->getUuidKey()} = (!is_null($uuid) && Str::isUuid($uuid)) ? $uuid : Str::uuid()->toString();
            }
        });
    }

    #[Pure]
    public function getRouteKeyName(): string
    {
        return $this->getUuidKey();
    }

    public function getUuidKey(): string
    {
        return 'uuid';
    }
}
