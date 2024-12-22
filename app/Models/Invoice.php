<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'business_id',
        'due_date',
        'total_amount',
        'discount_id',
        'tax_rate',
        'is_sent'
    ];

    protected $cast = [
        'is_sent' => 'boolean'
    ];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
