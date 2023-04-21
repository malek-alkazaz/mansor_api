<?php

namespace App\Http\Controllers\Dashboard;

use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\Dashboard\ProductService;

class ProductController extends Controller
{

    use ResponseAPI;
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->index();
        if($products){
            return $this->success($products);
        }
        return $this->error();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productService->store($request);
        if($product){
            return $this->created($product);
        }
        return $this->error();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->show($id);
        if($product){
            return $this->success($product);
        }
        return $this->error();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = $this->productService->update($request , $id);
        if($product){
            return $this->success($product);
        }
        return $this->error();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id){
            $product = $this->productService->destroy($id);
            return $this->deleted($product);
        }
        return $this->notFound();
    }

    /**
     * Remove the specified resource from storage.
    */
    public function search(Request $request)
    {
        // $products = $this->productService->search($request->search);

    }

    /**
     * Remove the specified resource from storage.
    */
    public function getProductByCategory(Request $request)
    {
        // $products = $this->productService->getProductByCategory($request->search);
    }
}
