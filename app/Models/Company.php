<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'iban',
        'bic',
        'payment_instructions',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function stripeAccount()
    {
        return $this->hasOne(StripeAccount::class);
    }
}
