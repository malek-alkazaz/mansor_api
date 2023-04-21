<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\CategoryService;

class CategoryControllery extends Controller
{
    use ResponseAPI;
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->index();
        if($categories){
            return $this->success($categories);
        }
        return $this->error();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = $this->categoryService->store($request);
        if($category){
            return $this->created($category);
        }
        return $this->error();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->categoryService->show($id);
        if($category){
            return $this->success($category);
        }
        return $this->notFound();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = $this->categoryService->update($request , $id);
        if($category){
            return $this->success($category);
        }
        return $this->error();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id){
            $category = $this->categoryService->destroy($id);
            return $this->deleted();
        }
        return $this->notFound();
    }
}
