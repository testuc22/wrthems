<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\{
	ProductRepository,
	CategoryRepository,
	TagRepository
};


class ProductController extends Controller
{
	public function __construct(ProductRepository $productRepository,CategoryRepository $categoryRepository,TagRepository $tagRepository)
	{
	    $this->middleware('auth:admin');
	    $this->productRepository=$productRepository;
	    $this->categoryRepository=$categoryRepository;
	    $this->tagRepository=$tagRepository;
	}

    public function getAllProducts()
    {
        $products=$this->productRepository->getAllProducts();
        return view('admin/products/list')->with(['products'=>$products]);
    }

    public function getAddProductPage()
    {
        $categories=$this->categoryRepository->getAllCategories();
        $tags=$this->tagRepository->getAllTags();
        return view('admin/products/create')->with(['categories'=>$categories,'tags'=>$tags]);
    }

    public function getEditProductPage($id)
    {
        $categories=$this->categoryRepository->getAllCategories();
        $tags=$this->tagRepository->getAllTags();
        $product=$this->productRepository->getProductWithZip($id);
        return view('admin/products/edit')->with(['categories'=>$categories,'tags'=>$tags,'product'=>$product,'images'=>[]]);
    }

    public function createProduct(Request $request)
    {
        $result=$this->productRepository->createProduct($request);
        return $result;
    }

    public function updateProduct(Request $request,$id)
    {
        $result=$this->productRepository->updateProduct($request,$id);
        return $result;
    }

    public function uploadProductImages(Request $request,$id)
    {
        $result=$this->productRepository->uploadProductImages($request,$id);
        return $result;
    }

    public function deleteProductImage(Request $request)
    {
        $result=$this->productRepository->deleteProductImage($request);
        return $result;
    }

    public function UpdateProductStatus(Request $request)
    {
        $result=$this->productRepository->UpdateProductStatus($request);
        return $result;
    }

    public function deleteProduct(Request $request)
    {
        $result=$this->productRepository->deleteProduct($request);
        return $result;
    }
}
