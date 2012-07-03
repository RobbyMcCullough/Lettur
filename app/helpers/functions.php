<?
/**
 * Makes a user friendly time from a MySQL datetime value.
 * 
 * @param $time MySQL datetime value
 */
function makeTime($time) {
    return date(TIMEFORMAT,strtotime($time));
}

/**
 * Builds HTML page
 * 
 * @param $blocks string or array of strings that represent template block files.
 * @param $tmpl is the template accessible data.
 */
function build($blocks, $tmpl=null) {
	global $meta;
    require_once(ROOT . '/app/views/header.tpl.php');
    
    if (!is_array($blocks)) {
        require_once(ROOT . '/app/views/' . $blocks . '.tpl.php');
    } else {
        foreach($blocks as $block) {
            require_once(ROOT . '/app/views/' . $block . '.tpl.php');
        }
    }

    require_once(ROOT . '/app/views/footer.tpl.php');
}

/**
 * Translates a number to a short alhanumeric version
 *
 * @param mixed   $in    String or long input to translate
 * @param boolean $to_num  Reverses translation when true
 * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
 * @param string  $passKey Supplying a password makes it harder to calculate the original ID
 *
 * @return mixed string or long
 */
function alphaID($in, $to_num = false, $pad_up = false, $passKey = null)
{
  $index = "bcdfghjklmnpqrstvwxyz0123456789BCDFGHJKLMNPQRSTVWXYZ";
  if ($passKey !== null) {
    // Although this function's purpose is to just make the
    // ID short - and not so much secure,
    // with this patch by Simon Franz (http://blog.snaky.org/)
    // you can optionally supply a password to make it harder
    // to calculate the corresponding numeric ID
 
    for ($n = 0; $n<strlen($index); $n++) {
      $i[] = substr( $index,$n ,1);
    }
 
    $passhash = hash('sha256',$passKey);
    $passhash = (strlen($passhash) < strlen($index))
      ? hash('sha512',$passKey)
      : $passhash;
 
    for ($n=0; $n < strlen($index); $n++) {
      $p[] =  substr($passhash, $n ,1);
    }
 
    array_multisort($p,  SORT_DESC, $i);
    $index = implode($i);
  }
 
  $base  = strlen($index);
 
  if ($to_num) {
    // Digital number  <<--  alphabet letter code
    $in  = strrev($in);
    $out = 0;
    $len = strlen($in) - 1;
    for ($t = 0; $t <= $len; $t++) {
      $bcpow = bcpow($base, $len - $t);
      $out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
    }
 
    if (is_numeric($pad_up)) {
      $pad_up--;
      if ($pad_up > 0) {
        $out -= pow($base, $pad_up);
      }
    }
    $out = sprintf('%F', $out);
    $out = substr($out, 0, strpos($out, '.'));
  } else {
    // Digital number  -->>  alphabet letter code
    if (is_numeric($pad_up)) {
      $pad_up--;
      if ($pad_up > 0) {
        $in += pow($base, $pad_up);
      }
    }
 
    $out = "";
    for ($t = floor(log($in, $base)); $t >= 0; $t--) {
      $bcp = bcpow($base, $t);
      $a   = floor($in / $bcp) % $base;
      $out = $out . substr($index, $a, 1);
      $in  = $in - ($a * $bcp);
    }
    $out = strrev($out); // reverse
  }
 
  return $out;
}


/**
 * Uses CURL to get contents/UTF8 encode a URL
 * @param $url the URL to fetch
 * @param $isImage Boolean for image or no
 */
function curl_get_contents($url, $isImage) {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,             // return web page
        CURLOPT_HEADER         => false,            // don't return headers
        CURLOPT_FOLLOWLOCATION => true,             // follow redirects
        CURLOPT_ENCODING       => "",               // handle all encodings
        CURLOPT_USERAGENT      => "CleanTab-Bot",   // who am i
        CURLOPT_CONNECTTIMEOUT => 120,              // timeout on connect
        CURLOPT_TIMEOUT        => 120,              // timeout on response
        CURLOPT_MAXREDIRS      => 3                 // stop after 10 redirects
    );
    
    // If isImage = true set binary transfer mode
    if ($isImage == 1) $options['CURLOPT_BINARYTRANSFER'] = 1;
    
    // Set Curl Options
    $myCurl = curl_init();
    curl_setopt($myCurl, CURLOPT_URL, $url);
    curl_setopt_array($myCurl, $options);
    
    // Grab File -> Grab error if any -> Close connection
    $rawData = curl_exec($myCurl);
    $curlError = curl_errno($myCurl);
    curl_close($myCurl);
    
    // If sucessful && not an image verify/re-encode to UTF8
    if (!$curlError && $isImage == 0) {
        $rawData = mb_convert_encoding($rawData, 'UTF-8', 
                  mb_detect_encoding($rawData, 'UTF-8, ISO-8859-1', true)); 
        return $rawData;
    // If it is an image return the raw data
    } else if (!$curlError && $isImage == 1){
         return $rawData;
    }
}

function xss_clean($data)
{
	// Fix &entity\n;
	$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
	$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
	
	// Remove any attribute starting with "on" or xmlns
	$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
	
	// Remove javascript: and vbscript: protocols
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
	
	// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
	
	// Remove namespaced elements (we do not need them)
	$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
	
	do
	{
	        // Remove really unwanted tags
	        $old_data = $data;
	        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	}
	while ($old_data !== $data);
	
	// we are done...
	return $data;
}
?>