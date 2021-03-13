<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Auth;
use App\Repositories\ProductRepository;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use App\Http\Controllers\Front\PayPalClient;
use App\Http\Controllers\Front\CreateOrder;
use App\Http\Controllers\Front\CaptureOrder;
class UserController extends Controller
{
	public function __construct(ProductRepository $productRepository)
	{
	    $this->productRepository=$productRepository;
	}

    public function registerUser(Request $request)
    {
        $validator=Validator::make($request->all(),[
        	'firstName'=>'required',
        	'lastName'=>'required',
        	'email'=>'required|email|unique:users',
        	'password'=>'required'
        ]);

        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()],401);
        }
        else {
        	$data=$request->all();
        	$data['password']=bcrypt($data['password']);
        	$user=User::create($data);
        	$success=[
        		'user'=>$user,
        		'token'=>$user->createToken('userToken')->accessToken
        	];
        	return response()->json($success,200);
        }
    }

    public function loginUser(Request $request)
    {
        $validator=Validator::make($request->all(),[
        	'email'=>'required|email',
        	'password'=>'required'
        ]);

        if ($validator->fails()) {
        	return response()->json(['error'=>$validator->errors()],401);
        }
        else {
        	$credentials=[
        		'email'=>$request->email,
        		'password'=>$request->password
        	];
        	$status = 401;
	        $response = ['error' => 'Unauthorised'];
	        
	        if (Auth::attempt($credentials)) {
	            $status = 200;
	            $response = [
	                'token' => Auth::user()->createToken('userToken')->accessToken,
	                'user' => Auth::user()
	            ];
	        }
	        
	        return response()->json($response, $status);
        }
    }

    public function addToCart(Request $request)
    {
        $result=$this->productRepository->addToCart($request);
        return response()->json($result,200);
    }

    public function getUserCartItems()
    {
        $result=$this->productRepository->getUserCartItems();
        return response()->json($result,200);
    }

    public function removeFromCart($id)
    {
        $result=$this->productRepository->removeFromCart($id);
        return response()->json($result,200);
    }

    public function placeOrder(Request $request)
    {
    	$response=CreateOrder::createOrder(true);
    	// dump($response);
        /*$result=$this->productRepository->placeOrder();*/
        return response()->json($response,200);
    }

    public function capturePaypalTransaction(Request $request)
    {
        $orderid=$request->orderid;
        $result=CaptureOrder::captureOrder($orderid, true);
        if ($result->statusCode == 201) {
        	$this->productRepository->placeOrder($result);
        }
        return response()->json($result,200);
    }

    public function downloadTemplate(Request $request)
    {
        $result=$this->productRepository->downloadTemplate($request);
        return response()->download($result);
    }

    public function getUserOrders()
    {
        $result=$this->productRepository->getUserOrders();
        return response()->json($result,200);
    }

    public function searchTemplates(Request $request)
    {
        $result=$this->productRepository->searchTemplates($request);
        return response()->json($result,200);
    }
}
