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
 
 
 
 
 
// ***** Other Functions *****
 
function wordwrap_ucwords_trim($x, $wrap_length) {
  return wordwrap(ucwords(strtolower(trim($x))), $wrap_length, '<br />');
}
 
function wordwrap_ucase_trim($x, $wrap_length) {
  return wordwrap(strtoupper(strtoupper(trim($x))), $wrap_length, '<br />');
}
 
function remove_period($x) {
return trim($x, ".");
}
 
function download_file( $fullPath ){
 
  // Must be fresh start
  if( headers_sent() )
    die('Headers Sent');
 
  // Required for some browsers
  if(ini_get('zlib.output_compression'))
    ini_set('zlib.output_compression', 'Off');
 
  // File Exists?
  if( file_exists($fullPath) ){
    
    // Parse Info / Get Extension
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    
    // Determine Content Type
    switch ($ext) {
      case "pdf": $ctype="application/pdf"; break;
      case "exe": $ctype="application/octet-stream"; break;
      case "zip": $ctype="application/zip"; break;
      case "doc": $ctype="application/msword"; break;
      case "xls": $ctype="application/vnd.ms-excel"; break;
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
      case "gif": $ctype="image/gif"; break;
      case "png": $ctype="image/png"; break;
      case "jpeg":
      case "jpg": $ctype="image/jpg"; break;
      default: $ctype="application/force-download";
    }
 
    header("Pragma: public"); // required
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false); // required for certain browsers
    header("Content-Type: $ctype");
    header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$fsize);
    ob_clean();
    flush();
    readfile( $fullPath );
 
  } else
    die('File Not Found');
 
}
 
function pad_titles_numbers($title_string, $number_string, $length, $num_length, $char = " ") {
    $fill_length = $length - ( strlen($title_string) + strlen($number_string) );
    return $title_string . ' ' . str_repeat($char, $fill_length) . ' ' . str_pad( $number_string, $num_length, " ", STR_PAD_LEFT);
}
 
function lr_trim_array($arr, $l_str, $r_str) {
  for($i = 0; $i < count($arr); $i++) {
    $arr[$i] = trim($arr[$i]);
    $arr[$i] = ltrim($arr[$i], $l_str);
    $arr[$i] = rtrim($arr[$i], $r_str);
  }
  return $arr;
}
 
function prepend_array_str($arr, $str) {
  for($i = 0; $i < count($arr); $i++) {
    $arr[$i] = $str . $arr[$i];
  }
  return $arr;
}
 
function append_array_str($arr, $str) {
  for($i = 0; $i < count($arr); $i++) {
    $arr[$i] = $arr[$i] . $str;
  }
  return $arr;
}
 
function ucfirst_array($arr) {
  for($i = 0; $i < count($arr); $i++) {
    $arr[$i] = ucfirst($arr[$i]);
  }
  return $arr;
}
 
function ucwords_array($arr) {
  for($i = 0; $i < count($arr); $i++) {
    $arr[$i] = ucwords($arr[$i]);
  }
  return $arr;
}
 
function remove_duplicate_words($s) {
    return implode(' ', array_unique(explode(' ', $s)));
}

function generate_password($length) {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}
 
function timestamp_microtime() {
  list($usec, $sec) = explode(" ", microtime());
  $usec = str_replace('0.', '.', $usec);
  return ($sec.$usec);
}

function scandir_files($path) {
  $arr = scandir($path);
  array_splice($arr, 0, 2);
  return $arr;
}

function get_dir_files($x) {
  $arr = scandir($x.'/');
  array_shift($arr);
  array_shift($arr);
  return $arr;
}

function get_directories_list($dir) {
  $files = glob($dir . "*");
  $dirs = array();
  foreach($files as $file) {
      if(is_dir($file)) {
          array_push($dirs, end(explode('/', $file)));
      }
  }
  sort($dirs);
  return $dirs;

  // usage
  // print_r(get_directories_list('')); // current
  // print_r(get_directories_list('uploads/'));
}

function get_integer_float($x) {
  return filter_var($x, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  // usage
  // echo get_number('some text25some text') . "<br />";
  // echo get_number('some text25.10some text');
}


function days_dates_diff($d1, $d2) {
  return round( ( strtotime($d2) - strtotime($d1) ) / (60 * 60 * 24) );
  // echo days_dates_diff('2020-01-10', '2020-01-01') // 9
}


function str_replace_first($search, $replace, $subject) {
    $search = '/'.preg_quote($search, '/').'/';
    return preg_replace($search, $replace, $subject, 1);
    // str_replace only first occurance
}

function remove_urls($x) {
    $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
    $s = preg_replace($regex, ' ', $x);
    return str_replace('   ', ' ', $s);
}

function match_string_array($str, $arr) {
  $str = strtolower($str);
  for($i = 0; $i < count($arr); $i++) {
      $arr[$i] = strtolower($arr[$i]);
      if(strpos($str, $arr[$i]) !== false) {
          return 'true';
      } 
  }
  return false;
}

function remove_weird_chars($s) {  
  $s_arr = str_split($s); 
  $new_s = '';
  foreach($s_arr as $c) {    
    $c_no = ord($c);
    if($c_no > 31 && $c_no < 127) {
      $new_s .= $c;    
    }
  }  
  return stripslashes($new_s);
}

function replace_accents($str) {
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
  return str_replace($a, $b, $str);
}


function get_folders_recursively($dir, &$results = array()) {
    $files = scandir($dir);
    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            get_folders_recursively($path, $results);
            $results[] = $path;
        }
        rsort($results);
    }

  $arr = array();
  for($i = 0; $i < count($results); $i++) {
    if(!is_file($results[$i])) {
      array_push($arr, $results[$i]);
    }
  }
  krsort($arr);
  $arr2 = array();
  for($i = count($arr)-1; $i >= 0; $i--) {
    if(!is_dir_empty($arr[$i])) {
      @array_push($arr2, $arr[$i]);
    }
  }
    return $arr2;
}



function is_dir_empty($dir) {
  if (!is_readable($dir)) return null; 
  return (count(scandir($dir)) == 2);
}

function formatBytes($size, $precision = 2) {
  if($size > 0) {
      $base = log($size, 1024);
      $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   
      return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
  }
  else {
    return '0 Bytes';
  }
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

?>
