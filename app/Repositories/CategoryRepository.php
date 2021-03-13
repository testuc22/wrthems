<?php 
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\{
	ProductCategory
};
use App\Http\Resources\ProductCategory as CategoryResource;
use Session;
class CategoryRepository
{
    public function getAllCategories()
    {
        return ProductCategory::withCount('categoryProducts')->get();
    }

    public function getActiveCategories()
    {
        return new CategoryResource(ProductCategory::withCount('categoryProducts')->get());
    }

    public function getCategoryById($id)
    {
        return ProductCategory::find($id);
    }

    public function addCategory($request)
    {
        $this->validateCategoryData($request);
        $categoryData=$this->getCategoryData($request);
        ProductCategory::create($categoryData);
        return $this->getMessage($request,'Product Category Created Successfully');
    }

    public function validateCategoryData($request)
    {
        $request->validate([
        	'categoryName'=>'required'
        ]);
    }

    public function getCategoryData($request)
    {
        return [
        	'categoryName'=>$request->categoryName,
        	'status'=>$request->has('status') ? 1 : 0
        ];
    }

    public function updateCategory($request,$id)
    {
        $this->validateCategoryData($request);
        $categoryData=$this->getCategoryData($request);
        $this->getCategoryById($id)->update($categoryData);
        return $this->getMessage($request,'Product Category Updated Successfully');
    }

    public function getMessage($request,$message)
    {
        $request->session()->flash('success',$message);
        return redirect()->route('list-product-categories');
    }

    public function UpdateCategoryStatus($request)
    {
        $this->getCategoryById($request->category)->update(['status'=>$request->status]);
        return response(['message'=>'Category Status Updated Successfully',200]);
    }

    public function deleteCategory($request)
    {
        $this->getCategoryById($request->category)->delete();
        return response()->json(['message'=>'Category Deleted Successfully'],200);
    }
}
