<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'address', 'note', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addedAt()
    {
        return Carbon::parse($this->created_at)->format('d M, Y');
    }
}
