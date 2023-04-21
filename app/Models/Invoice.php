<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['client_name','total_price'];

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetails::class,'invoice_id');
    }
}
