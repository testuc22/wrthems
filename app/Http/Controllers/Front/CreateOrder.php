<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Front\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Auth;
class CreateOrder
{

  public static function createOrder($debug=false)
  {
    $request = new OrdersCreateRequest();
    $request->prefer('return=representation');
    $user=Auth::user();
    $userCartItems=$user->userCart->cartItems;
        $totalPrice=$userCartItems->sum(function($item){
            return $item->price;
        });
    $request->body = self::buildRequestBody($totalPrice);
    $client = PayPalClient::client();
    $response = $client->execute($request);
    return $response;
  }


    private static function buildRequestBody($totalPrice)
    {
        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => 'http://127.0.0.1:8000/checkout',
                    'cancel_url' => 'http://127.0.0.1:8000/checkout'
                ),
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'amount' =>
                                array(
                                    'currency_code' => 'USD',
                                    'value' => $totalPrice
                                )
                        )
                )
        );
    }
}

?>