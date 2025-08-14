<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteView extends Model
{
    use HasFactory;

    protected $table = 'views';

    protected $fillable = [
        'quote_id',
        'ip',
        'user_agent',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
