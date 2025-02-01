<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'is_sent',
        'customer_id',
        'business_id',
        'due_date',
        'total_amount',
        'total_paid',
        'tax_rate',
        'payment_status',
        'currency',
        'discount_id',
    ];

    protected $cast = [
        'is_sent' => 'boolean'
    ];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function addedAt()
    {
        return Carbon::parse($this->created_at)->format('d M, Y');
    }

    public function dueDate()
    {
        return $this->due_date ? Carbon::parse($this->due_date)->format('d M, Y') : 'None';
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function business(){
        return $this->belongsTo(Business::class);
    }
}
