<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'type',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
