<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'description',
        'business_id',
        'item_type_id',
        'image'
    ];


    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function discountType()
    {
        return $this->belongsTo(DiscountType::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function addedAt()
    {
        return Carbon::parse($this->created_at)->format('d M, Y');
    }
}
