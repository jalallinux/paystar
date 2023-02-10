<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ['user_id', 'amount', 'token', 'ref_num', 'transaction_id', 'tracking_code', 'card_number', 'status'];
    protected $casts = [
        'amount' => 'integer',
        'tracking_code' => 'integer',
        'status' => PaymentStatus::class,
    ];

    public function changeStatus(PaymentStatus $status): bool
    {
        return $this->update(['status' => $status]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        if (!str_ends_with($uri = config('services.paystar.base_url'), '/')) {
            $uri = "{$uri}/";
        }
        return "{$uri}payment?token={$this->token}";
    }
}
