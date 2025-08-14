<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use BelongsToCompany, HasFactory;

    protected $fillable = [
        'company_id',
        'client_id',
        'number',
        'currency',
        'status',
        'public_hash',
        'deposit_percent',
        'payment_method',
        'due_at',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function versions()
    {
        return $this->hasMany(QuoteVersion::class);
    }

    public function acceptances()
    {
        return $this->hasMany(QuoteAcceptance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function events()
    {
        return $this->hasMany(QuoteEvent::class);
    }

    public function views()
    {
        return $this->hasMany(QuoteView::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
}
