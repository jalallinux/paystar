<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\RedirectResponse;

class Payment extends Model
{
    protected $fillable = ['user_id', 'amount', 'token', 'ref_num', 'transaction_id', 'status'];
    protected $casts = [
        'amount' => 'integer',
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

    public function pay(): RedirectResponse
    {
        return redirect()->away($this->getUrlAttribute());
    }
}
