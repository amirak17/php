<?php 

require_once('config.php');
require_once('vendor/autoload.php');

// echo '<pre>'; print_r($_POST); echo '</pre>';
$name = $_POST['cname'];
$email = $_POST['email'];
$token = $_POST['stripeToken'];

$stripe = new \Stripe\StripeClient($s_key);


// create customer
$customer = $stripe->customers->create([
    'name' => $name,
    'email' => $email,
    'source' => $token
]);
// echo '<pre>'; print_r($customer); echo '</pre>';
$customerid = $customer->id;

// create subscription
$subscription = $stripe->subscriptions->create([
	'customer' => $customerid,
	'items' => [
    	['price' => $price_code],
  	],	
]);
// echo '<pre>'; print_r($subscription); echo '</pre>';

// response status
if($subscription->status == 'active' ) {
	echo 'You have successfully subscribed.';
}
else {
	echo 'Problem subscribing!' ;
}

?>