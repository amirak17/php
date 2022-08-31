<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Utilities_Library {


	public function send_email($from_email, $from_name, $to_email, $to_name, $subject, $message_html) {
		$message_html_updated = '';
		$message_html_updated .= '<img src="' . SITE_HTTP_LOGO . '" border="0" /><br /><br />';
		$message_html_updated .= 'Hi ' . $to_name . '<br /><br />' . $message_html;
		$message_html_updated .= '<br /><br />Thank you,<br />' . SITE_NAME . ' Team';
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= 'From: '	.$from_name.' <'.$from_email.'>' . "\r\n";    
		$headers .= 'To: '		.$to_name.	' <'.$to_email.'>'	 . "\r\n";    
		$headers .= 'Reply-To: '.$from_name.' <'.$from_email.'>' . "\r\n";
		//echo $to_email.' - '.$to_name.' - '.$from_email.' - '.$from_name.' - '.$subject.' - '.$message_html_updated .' - '.$headers;

		mail($to_email, $subject, $message_html_updated, $headers);
	}

    // codeigniter
    public function send_email($from_email, $from_name, $to_email, $to_name, $subject, $message_html) {

        $message_html_updated = '';
        $message_html_updated .= '<img src="' . SITE_HTTP_LOGO . '" border="0" /><br /><br />';
        $message_html_updated .= 'Hi ' . $to_name . '<br /><br />' . $message_html;
		$message_html_updated .= '<br /><br />Thank you,<br />' . SITE_NAME . ' Team';

        $CI =& get_instance();

        $CI->load->library('email');
        $CI->email->set_newline("\r\n");
        $CI->email->from($from_email, $from_name);
        $CI->email->to($to_email, $to_name);
        $CI->email->subject($subject);
        $email_body = $message_html_updated;
        $CI->email->message($email_body);

        $CI->email->set_mailtype("html");
        $CI->email->send(); // echo $this->email->print_debugger(); exit();
    }

    public function print_array($arr, $cols=75, $rows=75) {
        echo "<textarea cols=$cols rows=$rows>";
        print_r($arr);
        echo "</textarea>";
    }
    
    public function object_rows_2_arrays($r) {
        for($i = 0; $i < count($r); $i++) {
            foreach($r[$i] as $key => $value) {
                $rows[$i][$key] = $value;
            }
        } // echo '<pre>'; print_r($rows);echo '</pre>'; 
        return $rows;
    }    
	
    public function decrypt($var) {

        $cypher = array('Q','q','W','w','E','e','R','r','T','t','Y','y','U','u','I','i','O','o','P','p','A','a','S','s','D','d','F','f','G','g','H','h','J','j','K','k','L','l','Z','z','X','x','C','c','V','v','B','b','N','n','M','m','0','1','2','3','4','5','6','7','8','9','_','!','@','$','*','(',')','-','.',' ');
        $cypherLength = count($cypher);
        $cypherOffset = 17;		
        
        $decryptedString = '';
        $uniqueCypherOffset = $cypherOffset + strlen($var);
        $var = strrev($var);

        for ($i = 0; $i < strlen($var); $i++) {
            $pos = array_keys($cypher, $var[$i]);
            #if the character cannot be found in the cypher string, just add it as is
            if (count($pos) == 0) {
                $decryptedString = $decryptedString . $var[$i];
            } else {
                $newPos = $pos[0] - $uniqueCypherOffset;
                if ($newPos < 0) {
                        $newPos = $cypherLength + $newPos;
                }
                $decryptedString = $decryptedString . $cypher[$newPos];
            }						
        }			
        return $decryptedString;		
    }
    
    public function encrypt($var) {
        
        $cypher = array('Q','q','W','w','E','e','R','r','T','t','Y','y','U','u','I','i','O','o','P','p','A','a','S','s','D','d','F','f','G','g','H','h','J','j','K','k','L','l','Z','z','X','x','C','c','V','v','B','b','N','n','M','m','0','1','2','3','4','5','6','7','8','9','_','!','@','$','*','(',')','-','.',' ');
        $cypherLength = count($cypher);
        $cypherOffset = 17;		
        
        $encryptedString = '';
        $uniqueCypherOffset = $cypherOffset + strlen($var);

        for ($i = 0; $i < strlen($var); $i++) {
            $pos = array_keys($cypher, $var[$i]);
            #if the character cannot be found in the cypher string, just add it as is
            if (count($pos) == 0) {
                $encryptedString = $encryptedString . $var[$i];
            } else {
                $newPos = $pos[0] + $uniqueCypherOffset;
                if ($newPos >= $cypherLength) {
                        $newPos = $newPos - $cypherLength;
                }
                $encryptedString = $encryptedString . $cypher[$newPos];
            }
        }

        $encryptedString = strrev($encryptedString);
        return $encryptedString;
    }
	
    function visitor_location() {
	    $provider_url = 'http://www.ipgetinfo.com/?ip=' . $_SERVER['REMOTE_ADDR'];
        $location  = "";
        $str       = file_get_contents($provider_url); 

        $city      = $this->get_string_between($str, "<br /><b>City</b>:", "<br /><b>latitude</b>:");
        if(stristr($city, 'Postal code') == TRUE) {
            $city  = $this->get_string_between($str, "<br /><b>City</b>:", "<br /><b>Postal code</b>:");
        }
        $state_reg = $this->get_string_between($str, "<br /><b>Area</b>: ", "<br /><b>City</b>:");
        $country   = $this->get_string_between($str, "Country name</b>:", "Area</b>:");
        $country   = $this->get_string_between($str, "/>&nbsp;", "<br /><b>");

        $location .= $city . ", " . $state_reg . ", " . $country;
        return $location;
    }

    function get_string_between($string, $start, $end) {
        $string = " " . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) 
          return "";
        $ini += strlen($start);   
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }

    function get_page_url() {
        $host = $_SERVER['HTTP_HOST'];
        $self = $_SERVER['PHP_SELF'];
        $query = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
        $url = !empty($query) ? "http://$host$self?$query" : "http://$host$self";
        return $url;
    }	

    // Devices detection functions
    function device_type() {
        if(preg_match("/(android|webos|avantgo|iphone|ipad|ipod|blackbe‌​rry|iemobile|bolt|bo‌​ost|cricket|docomo|f‌​one|hiptop|mini|oper‌​a mini|kitkat|symbian|mobi|palm|phone|pie|tablet|up\.browser|up\.link|‌​webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
            return 'Mobile';
        }
        else {
            return 'Desktop';
        }
    }
    function device_name() {
        $CI =& get_instance();
        $CI->load->library('user_agent');
        return $CI->agent->mobile();
    }
    function device_os() {
        $CI =& get_instance();
        $CI->load->library('user_agent');
        return $CI->agent->platform();
    }    
    function device_browser() {
        $CI =& get_instance();
        $CI->load->library('user_agent');
        return $CI->agent->browser();
    }    
    function device_browser_version() {
        $CI =& get_instance();
        $CI->load->library('user_agent');
        return $CI->agent->version();
    }    
    function device_stats() {
        $CI =& get_instance();
        $CI->load->library('user_agent');
        echo $this->device_type();
        echo $CI->agent->mobile() . '|';
        echo $CI->agent->platform() . '|';
        echo $CI->agent->browser() . '|';
        echo $CI->agent->version() . '|';
    }

    function password_generate($c=5) {
      return substr(str_shuffle('1234567890abcefghijklmnopqrstuvwxyz'), 0, $c);
    }

    function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds') {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';

        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];

        $password = str_shuffle($password);

        if(!$add_dashes)
            return $password;

        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }


    public function get_folders_recursively($dir, &$results = array()) {
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
        @array_push($arr2, $arr[$i]);
    }

    return $arr2;
}

	
}

/* End of file */