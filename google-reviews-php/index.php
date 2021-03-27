<?php 

$maps_key = 'MAP_KEY';
$places_key = 'PLACES_KEY';

$url = 'https://maps.googleapis.com/maps/api/place/details/json?key='.$maps_key.'&placeid='.$places_key;
$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec ($ch);

$res        = json_decode($result, true);
$reviews    = $res['result']['reviews'];

echo '<pre>'; print_r($reviews); echo '</pre>';

?>

