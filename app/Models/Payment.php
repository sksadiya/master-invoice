<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['invoice_id','payment_date','payment_mode','due_payment','amount','notes'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }


}
