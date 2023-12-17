<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'login',
        'creds',
        'sum',
        'currency_id',
    ];

    public function currency(): belongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get formatted sum
     */
//    public function getSumAttribute($value): string
//    {
//        return number_format(((int) $value * 0.01), 2, '.', '');
//    }
}
