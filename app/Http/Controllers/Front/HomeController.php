<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

class HomeController extends Controller
{
	public function __construct(CategoryRepository $categoryRepository,ProductRepository $productRepository)
	{
	    $this->categoryRepository=$categoryRepository;
	    $this->productRepository=$productRepository;
	}

    public function getHomePage()
    {    	
        return view('front/home');
    }

    public function getCategories()
    {
        $categories=$this->categoryRepository->getActiveCategories();
        return response($categories,200);
    }

    public function getWebTemplates()
    {
        $products=$this->productRepository->getAllActiveProducts();
        return response($products,200);
    }

    public function getWebTemplatesByCategory(Request $request)
    {
    	// return $request->category;
        $products=$this->productRepository->getAllActiveProductsByCategory($request);
        return response($products,200);
    }

    public function getWebTemplateDetails(Request $request)
    {
        $product=$this->productRepository->getWebTemplateDetails($request);
        return response($product,200);
    }

    public function getWebTemplatesByTag(Request $request)
    {
        // dd($request);
        $products=$this->productRepository->getAllActiveProductsByTag($request);
        return response($products,200);
    }
}
