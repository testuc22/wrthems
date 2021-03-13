<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
	public function __construct(CategoryRepository $categoryRepository)
	{
	    $this->middleware('auth:admin');
	    $this->categoryRepository=$categoryRepository;
	}

    public function listCategories()
    {
        $categories=$this->categoryRepository->getAllCategories();
        return view('admin/categories/list')->with(['categories'=>$categories]);
    }

    public function getAddCategoryPage()
    {
        return view('admin/categories/create');
    }

    public function addCategory(Request $request)
    {
        $result=$this->categoryRepository->addCategory($request);
        return $result;
    }

    public function getEditCategoryPage($id)
    {
        $category=$this->categoryRepository->getCategoryById($id);
        return view('admin/categories/edit')->with(['category'=>$category]);
    }

    public function updateCategory(Request $request,$id)
    {
        $result=$this->categoryRepository->updateCategory($request,$id);
        return $result;
    }

    public function UpdateCategoryStatus(Request $request)
    {
        $result=$this->categoryRepository->UpdateCategoryStatus($request);
        return $result;
    }

    public function deleteCategory(Request $request)
    {
        $result=$this->categoryRepository->deleteCategory($request);
        return $result;
    }
}
