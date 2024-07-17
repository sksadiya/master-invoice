<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['client_id','invoice_number','invoice_date','due_date',
    'invoice_status','subtotal','discount','discount_type',
    'total','note','term','payment_method','tax_id','tax','tax_total','discount_total'];

    public function items()
    {
        return $this->hasMany(invoiceItem::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
