<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeAccount extends Model
{
    use BelongsToCompany, HasFactory;

    protected $fillable = [
        'company_id',
        'stripe_account_id',
    ];
}
