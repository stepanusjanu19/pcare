<?php 
declare(strict_types=1);

namespace Rscharitas\MVCPCARE\App;
// require_once __DIR__ . '/vendor/autoload.php';
use LZCompressor\LZString as LZ;
use Symfony\Component\Dotenv\Dotenv;

class RestClient {

    public function callAPI($method, $url, $data)
    {
        date_default_timezone_set('UTC');
        $dotenv = new Dotenv();
        $dotenv->load( __DIR__ . '/.env');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $signature = hash_hmac('sha256', $_ENV['CONST_ID']."&".$tStamp, $_ENV['SECRET_KEY'], true);
        $encodedSignature = base64_encode($signature);

        $encodedAuthorizatiobn = base64_encode($_ENV['USER_ID'].":L1dwina@:095");

        $xconsid= $_ENV['CONST_ID'];
        $xtimestamp= $tStamp;
        $xsignature= $encodedSignature;	


        try {   
            $ch = curl_init();
            switch ($method) {
                case "POST":
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Accept: application/json',
                        'Content-Type: text/plain',
                        'X-cons-id:'.$xconsid,
                        'X-timestamp:'.$xtimestamp,
                        'X-signature:'.$xsignature,
                        'user_key:'.$_ENV['USER_KEY'],
                        'X-authorization:Basic '.$encodedAuthorizatiobn
                    ));    
                    curl_setopt($ch, CURLOPT_POST, 1);
                    if ($data)
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    break;
                case "PUT":
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    if ($data)
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);			 					
                    break;
                case "DELETE":
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Accept: application/json',
                        'Content-Type: text/plain',
                        'X-cons-id:'.$xconsid,
                        'X-timestamp:'.$xtimestamp,
                        'X-signature:'.$xsignature,
                        'user_key:'.$_ENV['USER_KEY'],
                        'X-authorization:Basic '.$encodedAuthorizatiobn
                    ));    
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                    if ($data)
                        $url = sprintf("%s?%s", $url, http_build_query($data));
                    break;
                default:
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'X-cons-id:'.$xconsid,
                        'X-timestamp:'.$xtimestamp,
                        'X-signature:'.$xsignature,
                        'user_key:'.$_ENV['USER_KEY'],
                        'X-authorization:Basic '.$encodedAuthorizatiobn
                    ));    
                    if ($data)
                        $url = sprintf("%s?%s", $url, http_build_query($data));
            }        

            //set options 
            // curl_setopt($ch, CURLOPT_POSTREDIR, 3);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            $content = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($ch);
            curl_close($ch);    
            if($code === 404)
            {
                return json_encode([
                    "message" => "Fatal Error Server Url Not Found",
                    "status" => $code
                ]);
            }
            else{
                return $content;
            }
            // echo $xconsid . " " . $xtimestamp . " " . $xsignature ." ". $_ENV['USER_KEY'] . " " . $encodedAuthorizatiobn; 
        } catch (Exception $e) {
            echo "Fatal error message" . $e->getMessage();
        }
        
    }

    public function stringDecrypt($key, $string){
        $encrypt_method = 'AES-256-CBC';
        // hash
        $key_hash = hex2bin(hash('sha256', $key));
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        return $output;
    }

    public function decompress($string){
        return LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }		



}

?>