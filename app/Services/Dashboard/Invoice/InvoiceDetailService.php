<?php

namespace App\Services\Dashboard\Invoice;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceDetails;
use App\Http\Resources\InvoiceResource;

class InvoiceDetailService
{
    public function show($id)
    {
        return $invoiceDetails = InvoiceDetails::where('invoice_id',$id)->get();
    }

    public function store($invoice , $id)
    {
        $details = [];
        foreach($invoice->products as $product){
            $details[] =InvoiceDetails::create([
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'product_id' => $product['id'],
                'invoice_id' => $id
            ]);
        }
        return $details;
    }

    public function update($invoice , $id)
    {
        $details = [];
        foreach($invoice->items as $product){
            $invoiceDetails = InvoiceDetails::where('product_id',$product['id']);
            $invoiceDetails->update([
                'quantity' => $product['quantity']
            ]);
        }
        return $invoice->items;
    }
}
