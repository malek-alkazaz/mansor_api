<?php

namespace App\Http\Controllers\Dashboard;

use stdClass;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Services\Dashboard\Invoice\InvoiceService;
use App\Services\Dashboard\Invoice\InvoiceDetailService;

class InvoiceController extends Controller
{
    use ResponseAPI;
    private $invoiceService;
    private $invoiceDetailService;

    public function __construct(InvoiceService $invoiceService , InvoiceDetailService $invoiceDetailService)
    {
        $this->invoiceService = $invoiceService;
        $this->invoiceDetailService = $invoiceDetailService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = $this->invoiceService->index();
        if($invoices){
            return $this->success($invoices);
        }
        return $this->error();
    }

    public function fullInvoice($invoice , $invoiceDetails){
        $fullInvoice = new stdClass();
        $fullInvoice->id = $invoice->id;
        $fullInvoice->client_name = $invoice->client_name;
        $fullInvoice->total_price = $invoice->total_price;

        $fullInvoice->items = $invoiceDetails;
        return $fullInvoice;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $invoice = $this->invoiceService->store($request);
        if($invoice){
            $invoiceDetails = $this->invoiceDetailService->store($request , $invoice->id);
            $fullInvoice = $this->fullInvoice($invoice,$invoiceDetails);
            return $this->created($fullInvoice);
        }
        return $this->error();
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = $this->invoiceService->show($id);
        if($invoice){
            return $this->success($invoice);
        }
        return $this->notFound();
    }

    /**
     * Display the specified resource.
     */
    public function showDetails(string $invoice_id)
    {
        $invoiceDetails = $this->invoiceDetailService->show($invoice_id);
        if($invoiceDetails){
            return $this->success($invoiceDetails);
        }
        return $this->notFound();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $invoice = $this->invoiceService->update($request,$id);
        $invoiceDetails = $this->invoiceDetailService->update($request , $invoice->id);
        return $invoiceDetails;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id){
            $invoice = $this->invoiceService->destroy($id);
            return $this->deleted();
        }
        return $this->notFound();
    }
}
