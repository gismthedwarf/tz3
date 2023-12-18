<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'creds',
        'sum',
        'currency_id',
    ];

    public function currency(): belongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

}
