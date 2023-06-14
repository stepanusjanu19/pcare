<?php
namespace Rscharitas\MVCPCARE\Controller;
use Rscharitas\MVCPCARE\App\RestClient;
use LZCompressor\LZString as LZ;
use Symfony\Component\Dotenv\Dotenv;

class DiagnosaController
{

    function getdiagnosa(string $kodeDiag, int $start, int $limit): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/diagnosa/" . $kodeDiag . "/" . $start . "/" . $limit;

        $response = $rest->callAPI('GET', $url, false);
        $decodejson1 = json_decode($response, true);

        try {
            $stringdecrypt = $rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
            $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
            $decodejson = json_decode($decompressed,true);

            if($decodejson1["metaData"]["code"] == 412)
            {
                $pesan = [
                    "message" => "Not Found Data, Params is not null",
                    "code" => 412,
                    "data" => $decodejson
                ];

                // echo json_encode($pesan);
            }
            else if($decodejson1["metaData"]["code"] == 404)
            {
                $pesan = [
                    "message" => "Not Found URL",
                    "code" => 404
                ];

                // echo json_encode($pesan);
            }
            else{            
                $pesan = [
                    "message" => "Berhasil Response",
                    "code" => 200,
                    "data" => $decodejson
                ];
                // echo json_encode($pesan);
            }
        } catch (\Throwable $pesan) {
            $pesan = [
                "message" => "Data not found for no content",
                "code" => 204
            ];
        }
        catch (Exception $e) {
            if ($e->getCode() === 500) {
                $pesan =  [
                    "message" => "Fatal Server response error",
                    "code" => 500
                ];                
            }else if ($e->getCode() === 404) {
                $pesan =  [
                    "message" => "Not Found URL",
                    "code" => 404
                ];
                
            }
             else {
                $pesan = [
                    "message" => "Fatal Problem Other" . $e->getMessage(),
                    "code" => 512
                ];
                
            }
        }
        echo json_encode($pesan);

    }
    


}