<?php

namespace App\Services\Dashboard;

use App\Models\Product;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductService{
    use ImageTrait;

    public function index()
    {
        return $products = ProductResource::collection(Product::all());
    }

    public function store($request)
    {
        $images = [];
        if($request->hasfile('image'))
        {
           foreach($request->file('image') as $image)
           {
                $images[] = $this->uploadImage($image,'product');
           }
           $QR_image = $this->Qr_Image($request->name);

           $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'image' => $images,
                'image_qr' => $QR_image,
                'category_id' => $request->category_id
            ]);
        }
        return $product;
    }

    public function show($id)
    {
        return $products = new ProductResource(Product::findorFail($id));
    }

    public function update($request , $id)
    {
        $product = Product::findorFail($id);
        $images = [];
        if ($request->hasFile('image')) {
            if ($product->image) {
                $this->destroyImage($product ,'product');
                foreach($request->file('image') as $image)
                {
                    $images[] = $this->uploadImage($image,'product');
                }
            }else{
                foreach($request->file('image') as $image)
                {
                    $images[] = $this->uploadImage($image,'product');
                }
            }
        }

        $product->update([
            'name' => ($request->name) ? $request->name : $product->name ,
            'price' => ($request->price) ? $request->price : $product->price,
            'description' => ($request->description) ? $request->description : $product->description,
            'quantity' => ($request->quantity) ? $request->quantity : $product->quantity,
            'image' => ($images) ? $images : $product->image,
            'category_id' => ($request->category_id) ? $request->category_id : $product->category_id,
        ]);

        return $product;
    }

    public function destroy($id)
    {
        $product = Product::findorFail($id);
        if($product->image) {
            $this->destroyImage($product ,'product');
        }
        $product->delete();
    }

}
