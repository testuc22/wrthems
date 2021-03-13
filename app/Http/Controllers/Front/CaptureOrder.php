<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class CaptureOrder
{

  public static function captureOrder($orderId, $debug=false)
  {
    $request = new OrdersCaptureRequest($orderId);

    $client = PayPalClient::client();
    $response = $client->execute($request);
    return $response;
  }
}

?>