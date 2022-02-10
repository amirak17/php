<!--
Docs:
https://www.youtube.com/watch?v=QhoG_vkFWYY
https://github.com/stripe/stripe-php
https://stripe.com/docs/payments/accept-a-payment-charges 
https://stripe.com/docs/api/subscriptions/create?lang=php

Install:
composer require stripe/stripe-php
-->

<?php require_once('config.php'); ?>

<title>Stripe Seamless Subscription Checkput </title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="https://js.stripe.com/v3/"></script>
<h3>Stripe Seamless Subscription Checkput </h3>
<form name="form1" method="POST" action="process.php" id="payment-form" style="width: 300px">
	<span class="payment-errors"></span>
	Name <br /> <input type="text" name="cname" /><br /><br />
	Email <br /> <input type="text" name="email" /><br /><br />
	Payment Card <br />
	<div id="card-element"></div>
	<div id="card-errors" role="alert"></div><br /><br />
	<button type="submit">Submit</button>
</form>

<script type="text/javascript">
// Set your publishable key: remember to change this to your live publishable key in production
// See your keys here: https://dashboard.stripe.com/apikeys
var stripe = Stripe('<?php echo $p_key;?>');
var elements = stripe.elements();	

// Custom styling can be passed to options when creating an Element.
var style = {
  base: {
    // Add your base input styles here. For example:
    fontSize: '16px',
    color: '#32325d',
  },
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style, hidePostalCode: true });

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Create a token or display an error when the form is submitted.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the customer that there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}

</script>