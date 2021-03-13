<?php 
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\{
	ProductCategory,
	Product,File,Cart,CartItem,Order,OrderItem
};
use File as SystemFile;
use Auth,Str;
use Session;
use Illuminate\Support\Facades\Crypt;

class ProductRepository
{
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository=$categoryRepository;
    }

    public function getAllProducts()
    {
        return Product::all();
    }

    public function getAllActiveProducts()
    {
        return Product::with(['productFiles'])->get();
    }

    public function getAllActiveProductsByCategory($request)
    {
        $categories=$request->has('category') ? $request->category : [];
        if (count($categories)>0) {
            return Product::with(['productFiles'])->whereIn('product_category_id',$categories)->get();
        }
        else {
            return $this->getAllActiveProducts();
        }
    }

    public function getAllActiveProductsByTag($request)
    {
        $id=$request->id;
        return Product::whereHas('productTags',function($query) use ($id){
            $query->where('tag_id','=',$id);
        })->with(['productFiles'])->get();
    }

    public function getProductById($id)
    {
        return Product::find($id);
    }

    public function getWebTemplateDetails($request)
    {
        return Product::with(['productFiles'=>function($query){
            $query->where('fileType','<>','zip');
        },'productTags'])->where('id',$request->id)->first();
    }

    public function getProductWithZip($id)
    {
        return Product::with(['productZipFiles'=>function($query){
            $query->where('fileType','=','zip');
        }])->where('id','=',$id)->first();
    }

    public function createProduct($request)
    {
        $this->validateData($request);
        $productData=$this->getProductData($request);
        $product=Product::create($productData);
        if ($request->product_tags!=null) {
            $this->assignTagsToProduct($request,$product);
        }
        if ($request->has('zipFile')) {
             $this->uploadZipFile($request,$product);
        }
        return $this->getMessage($request,'Product Created Successfully');
    }

    public function validateData($request)
    {
        $request->validate([
            'productName'=>'required',
            'category'=>'required',
            'productPrice'=>'required|numeric',
            'description'=>'required'
        ]);
    }

    public function getProductData($request)
    {
        return [
            'productName'=>$request->productName,
            'product_category_id'=>$request->category,
            'status'=>$request->has('status') ? 1 : 0,
            'price'=>$request->productPrice,
            'description'=>$request->description
        ];
    }

    public function getMessage($request,$message)
    {
        $request->session()->flash('success',$message);
        return redirect()->route('list-products');
    }

    public function assignTagsToProduct($request,$product)
    {
        $productTags=explode(',',$request->product_tags);
        $data=[];
        foreach ($productTags as $productTag) {
            $data[]=['product_id'=>$product->id,'tag_id'=>$productTag];
        }
        $product->productTags()->sync($productTags);
    }

    public function updateProduct($request,$id)
    {
        $this->validateData($request);
        $productData=$this->getProductData($request);
        $product=$this->getProductById($id);
        $product->update($productData);
        if ($request->product_tags!=null) {
            $this->assignTagsToProduct($request,$product);
        }
        if ($request->has('zipFile')) {
            $this->checkIfZipExists($product->id);
            $this->uploadZipFile($request,$product);
        }
        return $this->getMessage($request,'Product Updated Successfully');
    }

    public function uploadProductImages($request,$id)
    {
        if ($request->has('file')) {
            $file=$request->file;
            $destinationPath = public_path() . '/product-files/';
            $fileName = date('Y.m.d') . time(). $file->getClientOriginalName();
            $fileType=$file->getClientOriginalExtension();
            $upload_image = $file->move($destinationPath, $fileName);
        }
        $model=$this->getModelName($request->model);
        $findProductType=$model::find($id);
        return $this->saveFileToDb($findProductType,$fileName,$fileType);
    }

    public function saveFileToDb($product,$fileName,$fileType)
    {
        $productFile= new File;
        $productFile->file=$fileName;
        $productFile->fileType=$fileType;
        $productFile->fileable()->associate($product);
        $productFile->save();
        return $productFile->id;
    }

    public function checkIfZipExists($id)
    {
        $product=$this->getProductWithZip($id);
        if(count($product->productZipFiles) >0) {
            $productFile=File::find($product->productZipFiles[0]->id);
            SystemFile::delete(public_path() . '/product-templates/'.$productFile->file);
            $productFile->delete();
        }
    }

    public function uploadZipFile($request,$product)
    {
        $file=$request->zipFile;
        $destinationPath = public_path() . '/product-templates/';
        $fileName = date('Y.m.d') . time(). $file->getClientOriginalName();
        $fileType=$file->getClientOriginalExtension();
        $upload_image = $file->move($destinationPath, $fileName);
        $this->saveFileToDb($product,$fileName,$fileType);
    }

    public function getModelName($model):string
    {
        return "App\\Models\\".$model;      
    }

    public function deleteProductImage($request)
    {
        $productFile=File::find($request->image);
        SystemFile::delete(public_path() . '/product-files/'.$productFile->file);
        $productFile->delete();
    }

    public function UpdateProductStatus($request)
    {
        $this->getProductById($request->product)->update(['status'=>$request->status]);
        return response(['message'=>'Product Status Updated Successfully',200]);
    }

    public function deleteProduct($request)
    {
        $this->getProductById($request->product)->delete();
        return response()->json(['message'=>'Product Deleted Successfully'],200);
    }

    public function addToCart($request)
    {
        $user=Auth::user();
        if ($user->userCart()->exists()) {
            $userCart=$user->userCart;
            $product=$request->product;
            $cartItem=CartItem::where('product_id','=',$product)
                    ->where('cart_id','=',$userCart->id)->first();
            if ($cartItem==null) {
                $this->addNewCartItem($request,$userCart);
            }        
        }
        else {
            $cart=Cart::create([
                'sessionId'=>Session::getId(),
                'status'=>1,
                'firstName'=>$user->firstName,
                'lastName'=>$user->lastName,
                'email'=>$user->email,
                'user_id'=>$user->id,
                'content'=>serialize($request->all())
            ]);
            $this->addNewCartItem($request,$cart);
        }
    }

    public function addNewCartItem($request,$cart)
    {
        $product=$this->getProductById($request->product);
        $cartItems=$cart->cartItems()->create([
            'price'=>$product->price,
            'cart_id'=>$cart->id,
            'product_id'=>$request->product
        ]);
    }

    public function getUserCartItems()
    {
        $user=Auth::user();
        $userCart=$user->userCart->cartItems;
        $userCart->map(function($cart){
            $cart->cartItemProduct;
            $cart->imagePath=$cart->cartItemProduct->productFiles->first();
        });
        return $userCart;
    }

    public function removeFromCart($id)
    {
        $user=Auth::user();
        return CartItem::find($id)->delete();
    }

    public function placeOrder($transaction)
    {
        $user=Auth::user();
        $userCartItems=$user->userCart->cartItems;
        $totalPrice=$userCartItems->sum(function($item){
            return $item->price;
        });
        
        $order=Order::create([
            'sessionId'=>Session::getId(),
            'status'=>0,
            'total'=>$totalPrice,
            'user_id'=>$user->id,
            'content'=>serialize($transaction)
        ]);
        $data=[];
        // $encOrder= Crypt::encrypt($order->id);
        foreach ($userCartItems as $cartItem) {
            $token= Crypt::encrypt(Str::random(20));
            $tempUrl=route('download-file',['token'=>$token]);
            $url=str_replace('/api', '', $tempUrl);
            $data[]=[
                'price'=>$cartItem->price,
                'product_id'=>$cartItem->product_id,
                'order_id'=>$order->id,
                'download_url'=>$url,
                'download_token'=>$token
            ];
        }
        $order->orderItems()->createMany($data);
        // return $order;
    }

    public function downloadTemplate($request)
    {
        // $order=$request->order;
        $user=Auth::user();
        $token=$request->token;
        $order=OrderItem::where('download_token','=',$token)->first();
        $file=File::where('fileable_id','=',$order->product_id)->where('fileType','=','zip')->first();
        return public_path().'/product-templates/'.$file->file;
        # return response()->download(public_path().'/product-templates/'.$file->file);
    }

    public function getUserOrders()
    {
        $user=Auth::user();
        $orders=$user->userOrders->pluck('id')->toArray();
        $orderItems=OrderItem::with('order')->whereIn('order_id',$orders)->get();
        return $orderItems;
    }

    public function searchTemplates($request)
    {
        $search=$request->search;
        $products=Product::with(['productFiles'])
        ->orWhereHas('productCategory',function($query) use ($search){
            $query->where('categoryName','like','%'.$search.'%');
        })
        ->orWhereHas('productTags',function($query) use ($search){
            $query->where('tag_name','like','%'.$search.'%');
        })
        ->orWhere('productName','like','%'.$search.'%')
        ->get();
        return $products;
    }
}
