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


function wordwrap_special($t, $limit, $after, $insert) {
    $r = '';
    $count = 0;
    for($i = 0; $i < strlen($t); $i++) {
      if($count >= $limit && $t[$i] === $after) {
         $count = 0;
         $r .= $insert;
      }
      else {
         $count++;
         $r .= $t[$i];
      }
    }
    return $r;
}


function string_2_array_sep_nsplit($str, $sep, $n) {
    $l = strlen($str);
    $arr = array();
    $ac = 0;
    $count = 0;
    $acc_str = '';
    $n = $n - 1;
    $last_counter;

    if($l >= $n) {
        for($i = 0; $i < $l; $i++) {
            $count += 1;
            $acc_str .= $str[$i];
            if($str[$i] == $sep && $count > $n) {
                $arr[$ac++] = $acc_str;
                $acc_str = '';
                $count = 0;
                $last_counter = $i;
            }
        }
        $arr[$ac++] = ltrim(substr($str, $last_counter, $l), $sep);
    }
    else {
        $arr[0] = $str;
    }
    return $arr;
}

function random_password($l = 8) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $pass = array(); 
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $l; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}


function indent_content($content, $tab="\t") {
    $content = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $content); // add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
    $token = strtok($content, "\n"); // now indent the tags
    $result = ''; // holds formatted version as it is built
    $pad = 0; // initial indent
    $matches = array(); // returns from preg_matches()
    // scan each line and adjust indent based on opening/closing tags
    while ($token !== false && strlen($token)>0){
        $padPrev = $padPrev ?: $pad; // previous padding //Artis
        $token = trim($token);
        // test for the various tag states
        if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)){// 1. open and closing tags on same line - no change
            $indent=0;
        }elseif(preg_match('/^<\/\w/', $token, $matches)){// 2. closing tag - outdent now
            $pad--;
            if($indent>0) $indent=0;
        }elseif(preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)){// 3. opening tag - don't pad this one, only subsequent tags (only if it isn't a void tag)
            foreach($matches as $m){
                if (preg_match('/^<(area|base|br|col|command|embed|hr|img|input|keygen|link|meta|param|source|track|wbr)/im', $m)){// Void elements according to http://www.htmlandcsswebdesign.com/articles/voidel.php
                    $voidTag=true;
                    break;
                }
            }
            $indent = 1;
        }else{// 4. no indentation needed
            $indent = 0;
        }

        if ($token == "<textarea>") {
            $line = str_pad($token, strlen($token) + $pad, $tab, STR_PAD_LEFT); // pad the line with the required number of leading spaces
            $result .= $line; // add to the cumulative result, with linefeed
            $token = strtok("\n"); // get the next token
            $pad += $indent; // update the pad size for subsequent lines
        } elseif ($token == "</textarea>") {
            $line = $token; // pad the line with the required number of leading spaces
            $result .= $line . "\n"; // add to the cumulative result, with linefeed
            $token = strtok("\n"); // get the next token
            $pad += $indent; // update the pad size for subsequent lines
        } else {
            $line = str_pad($token, strlen($token) + $pad, $tab, STR_PAD_LEFT); // pad the line with the required number of leading spaces
            $result .= $line . "\n"; // add to the cumulative result, with linefeed
            $token = strtok("\n"); // get the next token
            $pad += $indent; // update the pad size for subsequent lines
            if ($voidTag) {
                $voidTag = false;
                $pad--;
            }
        }           

    }
    return $result;
}

function remove_dups_array($arr) {
    return array_keys(array_flip($arr));
}

function validate_email($email) {
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

 
?>
