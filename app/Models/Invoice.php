<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'date',
        'from_name',
        'from_email',
        'to_name',
        'to_email',
        'logo',
        'items',
        'tax_rate',
        'discount_rate',
        'tax_amount',
        'discount_amount',
        'sub_total',
        'total_amount',
    ];

    protected $casts = [
        'items' => 'array',
        'date' => 'date',
    ];
}
