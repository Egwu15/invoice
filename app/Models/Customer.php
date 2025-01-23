<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'address', 'note', 'business_id'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function addedAt()
    {
        return Carbon::parse($this->created_at)->format('d M, Y');
    }
}
