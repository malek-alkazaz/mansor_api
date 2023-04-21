<?php

namespace App\Services\Dashboard\Invoice;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Resources\InvoiceResource;

class InvoiceService
{
    public function index()
    {
        return $invoices = InvoiceResource::collection(Invoice::all());
    }

    public function store($request)
    {
        $request->validate([
            'client_name' => 'required',
            'total_price' => 'required',
        ]);
        $invoice = Invoice::create([
            'client_name' => $request->client_name,
            'total_price' => $request->total_price
        ]);
        return $invoice;
    }

    public function show($id)
    {
        return $invoice = new InvoiceResource(Invoice::findorFail($id));
    }

    public function update($request , $id)
    {
        // $request->validate([
        //     'client_name' => 'required|string|max:255'
        // ]);

        $invoice = Invoice::findorFail($id);
        $invoice->update([
            'client_name' => ($request->client_name) ? $request->client_name : $invoice->client_name,
            'total_price' => ($request->total_price) ? $request->total_price : $invoice->total_price
        ]);
        return $invoice;
    }

    public function destroy($id)
    {
        $invoice = Invoice::findorFail($id);
        $invoice->delete();
    }
}
