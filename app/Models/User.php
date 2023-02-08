<?php

namespace App\Models;

use App\Models\Traits\WithUuidColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, WithUuidColumn;

    protected $fillable = ['name', 'email', 'password', 'card_number', 'balance',];
    protected $hidden = ['password', 'card_number',];
    protected $casts = [
        'balance' => 'integer',
        'created_at' => 'timestamp',
    ];

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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
