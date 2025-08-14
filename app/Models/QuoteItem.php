<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_version_id',
        'label',
        'qty',
        'unit_price_cents',
        'tax_rate',
        'discount_percent',
    ];

    public function version()
    {
        return $this->belongsTo(QuoteVersion::class, 'quote_version_id');
    }
}
