<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ['user_id', 'amount', 'token', 'ref_num', 'transaction_id', 'tracking_code', 'card_number', 'status', 'error_code'];
    protected $casts = [
        'amount' => 'integer',
        'tracking_code' => 'integer',
        'error_code' => 'integer',
        'status' => PaymentStatus::class,
    ];

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

    public function getErrorMessageAttribute(): ?string
    {
        return match ($this->attributes['error_code']) {
            -101 => "درخواست نامعتبر (خطا در پارامترهای ورودی)",
            -102 => "درگاه فعال نیست",
            -103 => "توکن تکراری است",
            -104 => "مبلغ بیشتر از سقف مجاز درگاه است",
            -105 => "شناسه ref_num معتبر نیست",
            -106 => "تراکنش قبلا وریفای شده است",
            -107 => "پارامترهای ارسال شده نامعتبر است",
            -108 => "تراکنش را نمیتوان وریفای کرد",
            -109 => "تراکنش وریفای نشد",
            -198 => "تراکنش ناموفق",
            -199 => "خطای سامانه",
            default => null,
        };
    }
}
