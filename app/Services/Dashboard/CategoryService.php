<?php

namespace App\Services\Dashboard;

use App\Models\Category;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryService
{
    use ImageTrait;

    public function index()
    {
        return $categories = CategoryResource::collection(Category::all());
    }

    public function store($request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'image' => 'required|image|mimes:jpg,jpeg,png',
        // ]);
        $category = Category::create([
            'name'=>$request->name,
            'image'=> $this->uploadImage($request->image ,'category'),
        ]);
        return $category;
    }

    public function show($id)
    {
        return $category = new CategoryResource(Category::findorFail($id));
    }

    public function update($request , $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable'
        ]);

        //$category->fill($request->post())->update();
        $category = Category::findorFail($id);
        $category->update([
            'name' => ($request->name) ? $request->name : $category->name,
        ]);

        if ($request->hasFile('image')) {
            if ($category->image) {
                $this->destroyCategoryImage($category->image,'category');
            }
            $category->image = $this->uploadImage($request->image,'category');
            $category->save();
        }
        return $category;
    }

    public function destroy($id)
    {
        $category = Category::findorFail($id);

        if ($category->image) {
            $this->destroyCategoryImage($category->image,'category');
        }
        $category->delete();
    }
}
