<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'description',
        'price',
        'quantity',
        'image',
        'discount_id',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
