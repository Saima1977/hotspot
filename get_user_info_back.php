<?php
//$last_name = $_POST['lname'];
//$room_no = $_POST['room_no'];
$room_no = 6501;

$url = "https://ggws.meriton.com.au";
$postData = array("room" => $room_no);

$Web_Service_URL = 'https://ggws.meriton.com.au';
$debug = false;
$proto = 'https'; // e.g. str 'https'
$agent = 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0';
$download = false; // just to make a call and fetch nothing set to false
//$download = '/location/my_file.html';  to fetch content and save to file set the file location

// Init the cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $Web_Service_URL);

/** 
 * 
 * Start Fix SSLv3/TLS connectivity problems
 * 
 * CURLOPT_SSL_VERIFYHOST and CURLOPT_SSL_VERIFYPEER prevent MITM attacks
 * WARNING: Disabling this would prevent curl from detecting Man-in-the-middle (MITM) attack
 * 
 */

/**
 * @param CURLOPT_SSL_VERIFYPEER
 * 
 * FALSE to stop CURL from verifying the peer's certificate.
 * Alternate certificates to verify against can be specified with the CURLOPT_CAINFO option or a certificate directory can be specified with the CURLOPT_CAPATH option.
 * CURLOPT_SSL_VERIFYHOST may also need to be TRUE or FALSE if CURLOPT_SSL_VERIFYPEER is disabled (it defaults to 2).
 * Setting CURLOPT_SSL_VERIFYHOST to 2 (This is the default value) will garantee that the certificate being presented to you have a 'common name' matching the URN you are using to access the remote resource.
 * This is a healthy check but it doesn't guarantee your program is not being decieved.
 * 
 */
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

/**
 * @param CURLOPT_VERBOSE
 * Set the on/off parameter to 1 to make the library display a lot of verbose information about its operations on this handle. 
 * Very useful for libcurl and/or protocol debugging and understanding. The verbose information will be sent to stderr, 
 * or the stream set with CURLOPT_STDERR.
 * You hardly ever want this set in production use, you will almost always want this when you debug/report problems.
 */ 
curl_setopt($ch, CURLOPT_VERBOSE, $debug);

/**
 *  
 * @param CURLOPT_SSL_VERIFYHOST
 * 
 * Check the existence of a common name in the SSL peer certificate.
 * Check the existence of a common name and also verify that it matches the hostname provided.
 * 
 * @value 1 to check the existence of a common name in the SSL peer certificate. 
 * @value 2 to check the existence of a common name and also verify that it matches the hostname provided.
 * In production environments the value of this option should be kept at 2 (default value).
 * Support for value 1 removed in cURL 7.28.1 
 */
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

/**
 * 
 * Force use of TLS
 * 
 */
if($proto == 'https')
{
    /**
     *
     * Let's explain the magic of comparing your TLS certificate to the verified CA Authorities and how does that affect MITM attacks
     *  
     * Man in the middle (MITM)
     * Your program could be misleaded into talking to another server instead. This can be achieved through several mechanisms, like dns or arp poisoning.
     * The intruder can also self-sign a certificate with the same 'comon name' your program is expecting. 
     * The communication would still be encrypted but you would be giving away your secrets to an impostor.
     * This kind of attack is called 'man-in-the-middle'
     * Defeating the 'man-in-the-middle'
     * We need to to verify the certificate being presented to us is good for real. We do this by comparing it against a certificate we reasonable* trust.
     * If the remote resource is protected by a certificate issued by one of the main CA's like Verisign, GeoTrust et al, you can safely compare against Mozilla's CA certificate bundle, 
     * which you can get from http://curl.haxx.se/docs/caextract.html
     *
     */
    //TODO: If TLSv1_1 found insecure and/or unreliable change to TLSv1_1 or TLS1_2
    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2); // CURL_SSLVERSION_TLSv1_1; CURL_SSLVERSION_TLSv1_2
    curl_setopt($ch, CURLOPT_HEADER, 0); // Don’t return the header, just the html

    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
        //$crt = substr(__FILE__, 0, strrpos( __FILE__, '\\'))."\crt\cacert.crt"; // WIN
		$crt = "c:\\tmp\cacert.pem"; // WIN
    }
    else {
        $crt = str_replace('\\', '/', substr(__FILE__, 0, strrpos( __FILE__, '/')))."/crt/cacert.crt"; // *NIX
    }

    // The cert path is relative to this file
    curl_setopt($ch, CURLOPT_CAINFO, $crt); // Set the location of the CA-bundle

    /** 
     * Fix Error: 35 - Unknown SSL protocol error in connections
     * 
     * Improve maximum forward secrecy
     */
    // Please keep in mind that this list has been checked against the SSL Labs' WEAK ciphers list in 2014.
    $arrayCiphers = array(
    'DHE-RSA-AES256-SHA',
    'DHE-DSS-AES256-SHA',
    'AES256-SHA',
    'ADH-AES256-SHA',
    'KRB5-DES-CBC3-SHA',
    'EDH-RSA-DES-CBC3-SHA',
    'EDH-DSS-DES-CBC3-SHA',
    'DHE-RSA-AES128-SHA',
    'DHE-DSS-AES128-SHA',
    'ADH-AES128-SHA',
    'AES128-SHA',
    'KRB5-DES-CBC-SHA',
    'EDH-RSA-DES-CBC-SHA',
    'EDH-DSS-DES-CBC-SHA:DES-CBC-SHA',
    'EXP-KRB5-DES-CBC-SHA',
    'EXP-EDH-RSA-DES-CBC-SHA',
    'EXP-EDH-DSS-DES-CBC-SHA',
    'EXP-DES-CBC-SHA'
    );

    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, implode(':', $arrayCiphers));
}

curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

if($debug == true)
{curl_setopt($ch, CURLOPT_HEADER, 1);} // Get HTTP Headers Code
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

// ini_set('user_agent', 'NameOfAgent (http://www.example.net)');
curl_setopt($ch, CURLOPT_USERAGENT, $agent);

/**
 * DEBUG cURL Call
 * Don't forget to uncomment the CURLOPT_HEADER'
 */
    // Get HTTP Headers Code
    // Show Http Header
if($debug == true)
{
    echo "<pre>";
    echo curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

// TODO:Check if any cURL connection error occurred
// see http://php.net/manual/en/function.curl-errno.php
/** 
if(curl_errno($ch))
{
    echo 'Curl error: ' . curl_error($ch);
}
*/

// Send the request and check the response

if (($result = curl_exec($ch)) === FALSE) {
    die('cURL error: '.curl_error($ch)."<br />");
} else {
    //echo "Success!<br />";
}

/** 
 * @function cURL_GetInfo
 * other debug info, if needed
 * 
 * The var_dump output:
 * array(26) { 
 *          ["url"]=> string(61) "https://www.example.com" 
 *          ["content_type"]=> string(24) "text/html; charset=UTF-8" 
 *          ["http_code"]=> int(200) 
 *          ["header_size"]=> int(2462) 
 *          ["request_size"]=> int(493) 
 *          ["filetime"]=> int(-1) 
 *          ["ssl_verify_result"]=> int(0) 
 *          ["redirect_count"]=> int(2) 
 *          ["total_time"]=> float(0.286363) 
 *          ["namelookup_time"]=> float(7.1E-5) 
 *          ["connect_time"]=> float(0.011754) 
 *          ["pretransfer_time"]=> float(0.082954) 
 *          ["size_upload"]=> float(0) 
 *          ["size_download"]=> float(119772) 
 *          ["speed_download"]=> float(418252) 
 *          ["speed_upload"]=> float(0) 
 *          ["download_content_length"]=> float(262) 
 *          ["upload_content_length"]=> float(0) 
 *          ["starttransfer_time"]=> float(0.156201) 
 *          ["redirect_time"]=> float(0.076769) 
 *          ["certinfo"]=> array(0) { } 
 *          ["primary_ip"]=> string(14) "xxx.xxx.xxx.xxx." 
 *          ["primary_port"]=> int(443) 
 *          ["local_ip"]=> string(12) "192.168.0.15" 
 *          ["local_port"]=> int(54606) 
 *          ["redirect_url"]=> string(0) ""
 * }
 */ 
$info = curl_getinfo($ch);
$arrCodes = array(
    "client_error" => array("400", "401", "402", "403", "404", "405", "406", "407", "408", "409", "410", "411", "412", "413", "414", "415", "416", "417"),
    "server_error" => array("500", "502", "503", "504", "505")
);

// Return the error code, if any and exit
if(in_multi_array($info['http_code'], $arrCodes))
{
    file_put_contents("logs/dberror.log", "Date: " . date('M j Y - G:i:s') . " --- Error: " . $info['http_code'].' URL: '.$info['url'].PHP_EOL, FILE_APPEND);
    return $info['http_code']; exit;
}

curl_close($ch);

// If download is defined download to the specified file
if($download!= false)
{
    $f = fopen($download, "w");
    fwrite($f, $result);
    fclose($f);
    echo 'Web content downloaded to a file';
}
echo $result;
?>