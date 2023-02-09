<?php

namespace App\Models;

use App\Models\Traits\WithUuidColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\Pure;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, WithUuidColumn;

    protected $fillable = ['name', 'email', 'password', 'card_number', 'balance',];
    protected $hidden = ['password', 'card_number',];
    protected $casts = [
        'balance' => 'integer',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setCardNumberAttribute($value)
    {
        $this->attributes['card_number'] = Hash::make($value);
    }

    public function checkCardNumber(string $number): bool
    {
        return Hash::check($number, $this->attributes['card_number']);
    }

    #[Pure]
    public function getAuthIdentifierName(): string
    {
        return $this->getUuidKeyName();
    }

    public function getJWTIdentifier()
    {
        return $this->getAttribute($this->getUuidKeyName());
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
