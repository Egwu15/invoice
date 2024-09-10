<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'quantity',
        'description',
        'business_id',
        'tax_rate',
        'discount_value',
        'discount_type_id',
        'item_type_id',
    ];


    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
