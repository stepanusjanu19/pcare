<?php
namespace Rscharitas\MVCPCARE\Controller;
use Rscharitas\MVCPCARE\App\RestClient;
use LZCompressor\LZString as LZ;
use Symfony\Component\Dotenv\Dotenv;

class PesertaController
{

    function getpeserta(string $nokartu): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/peserta/" . $nokartu;

        $response = $rest->callAPI('GET', $url, false);

        // echo $response;

        try {
            if($response != "")
            {
                $decodejson1 = json_decode($response, true);

                if($decodejson1 == null)
                {
                    $pesan = [
                        "message" => "Gagal Response",
                        "status" => 400,
                        "data" => $decodejson1
                    ];

                    // echo json_encode($pesan);
                }
                else{
                    $stringdecrypt = $rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
                    $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
                    $decodejson = json_decode($decompressed,true);
            
                    $pesan = [
                        "message" => "Berhasil Response",
                        "status" => 200,
                        "data" => $decodejson
                    ];
            
                    // echo json_encode($pesan);
                }
            }
        } catch (\Throwable $pesan) {
            $pesan = [
                "message" => "Data not found for no content",
                "code" => 204
            ];
        }
        catch (Exception $e) {
            if ($e->getCode() === 500) {
                $pesan = "Fatal Server response error";
                
            } else {
                $pesan = "Fatal Problem Other" . $e->getMessage();
            }
        }
        echo json_encode($pesan);

    }
    


}