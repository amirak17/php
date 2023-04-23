<?php 

function get_string_between($string, $start, $end) {
   $string = " " . $string;
   $ini = strpos($string, $start);
   if ($ini == 0)
    return "";
   $ini += strlen($start);  
   $len = strpos($string, $end, $ini) - $ini;
   return substr($string, $ini, $len);
}
 
 
function get_array_strings_between($string, $start, $end) {
  $arr = array();
  $arr2 = array();
  $arr3 = array();
  $arr = explode($start, $string);
  for($i = 1; $i < count($arr); $i++) {
    $arr2[$i] = explode($end, $arr[$i]);
  }
  for($i = 1; $i <= count($arr2); $i++) {
    $arr3[$i-1] = $arr2[$i][0];
  }
  return $arr3;
}
 
 
 
function file_get_contents_https($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
 
function remove_wierd($Str) { 
  $StrArr = str_split($Str); $NewStr = '';
  foreach ($StrArr as $Char) {   
    $CharNo = ord($Char);
    if ($CharNo == 163) { $NewStr .= $Char; continue; } // keep £
    if ($CharNo > 31 && $CharNo < 127) {
      $NewStr .= $Char;   
    }
  } 
  return $NewStr;
}
 
function file_get_put_image($url, $save_img) {
  $ch = curl_init($url);
  $fp = fopen($save_img, 'wb');
 
  curl_setopt($ch, CURLOPT_FILE, $fp);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_exec($ch);
  curl_close($ch);
  fclose($fp);
}
 
function echo_textarea($x, $rows=20, $cols=70) {
  echo '<textarea cols="'.$cols.'" rows="'.$rows.'">'.$x.'</textarea><br /><br />';
}
 
function print_r_textarea($x, $rows=20, $cols=70) {
  echo '<textarea cols="'.$cols.'" rows="'.$rows.'">'; print_r($x); echo '</textarea><br /><br />';
}
 
function pt($x, $rows=20, $cols=70) {
  echo '<textarea cols="'.$cols.'" rows="'.$rows.'">'; print_r($x); echo '</textarea><br /><br />';
}
 
function get_web_page( $url ) {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
    );
 
    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );
 
    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    // return $header;
    return $content;
 
}
 
function clean_get_string_between($str, $start, $end) {
  return trim(strip_tags(get_string_between($str, $start, $end)));
}
 
function match_found($needles, $haystack) {
    foreach($needles as $needle) {
        if (strpos($haystack, $needle) !== false) {
            return true;
        }
    }
    return false;
}
 
function match_all_found($needles, $haystack) {
    if(empty($needles)) {
        return false;
    }
  
    foreach($needles as $needle) {
        if (strpos($haystack, $needle) == false) {
            return false;
        }
    }
    return true;
}
 
function match_one($str, $sub) {
  if (strpos($str, $sub) !== false) {
      return 'true';
  } 
  return false;
}
 
 
function get_float($str) {
    return filter_var( $str, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
}
 
function get_number($str) {
    return  filter_var($str, FILTER_SANITIZE_NUMBER_INT);
}
 



?>
