<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteAcceptance extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'version',
        'signer_name',
        'ip',
        'signed_at',
        'pdf_path',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
