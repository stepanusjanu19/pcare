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
        $decodejson1 = json_decode($response, true);

        if(isset($decodejson1["status"]) === 404)
        {
            $pesan = [
                "message" => $decodejson1["message"],
                "code" => $decodejson1["status"] 
            ];
        }
        else{
            try {
                if($decodejson1["metaData"]["code"] === 412)
                {
                    $pesan = [
                        "message" => "Gagal Response, Params its not valid",
                        "code" => 412,
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
        }

        echo json_encode($pesan);

        // if($response)
        // {
        //     try {
        //         if($decodejson1["metaData"]["code"] == 404)
        //             {
        //                 $pesan = [
        //                     "message" => "Not Found Url",
        //                     "code" => 404,
        //                 ];
    
        //                 // echo json_encode($pesan);
        //         }
        //         else if($decodejson1["metaData"]["code"] == 412)
        //         {
        //             $pesan = [
        //                 "message" => "Not Found Data, Params is not null",
        //                 "code" => 412,
        //             ];

        //             // echo json_encode($pesan);
        //         }
        //         else{
        //             $stringdecrypt = $rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
        //             $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
        //             $decodejson = json_decode($decompressed,true);
            
        //             $pesan = [
        //                 "message" => "Berhasil Response",
        //                 "code" => 200,
        //                 "data" => $decodejson
        //             ];
            
        //             // echo json_encode($pesan);
        //         }
        //     } catch (\Throwable $pesan) {
        //         $pesan = [
        //             "message" => "Data not found for no content",
        //             "code" => 204
        //         ];
        //     }
        //     catch (\Exception $e) {
        //         if ($e->getCode() === 500) {
        //             $pesan = "Fatal Server response error";
                    
        //         } else {
        //             $pesan = "Fatal Problem Other" . $e->getMessage();
        //         }
        //     }
        // }
        // else{
        //     $pesan = [
        //         "message" => "Gagal Response",
        //         "code" => 500
        //     ];
        // }

        // echo $response;
        
        // print_r($decodejson1);

    }

    function getpesertabyjeniskartu(string $jeniskartu, string $nokartu): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/peserta/" . $jeniskartu . '/' . $nokartu;

        $response = $rest->callAPI('GET', $url, false);
        // echo $response;
        $decodejson1 = json_decode($response, true);

        if(isset($decodejson1["status"]) === 404)
        {
            $pesan = [
                "message" => $decodejson1["message"],
                "code" => $decodejson1["status"] 
            ];
        }
        else{
            try {
                if($decodejson1["metaData"]["code"] === 412)
                {
                    $pesan = [
                        "message" => "Gagal Response, Params its not valid",
                        "code" => 412,
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
        }

        echo json_encode($pesan);

        // if($response)
        // {
        //     try {
        //         if($decodejson1["metaData"]["code"] == 404)
        //             {
        //                 $pesan = [
        //                     "message" => "Not Found Url",
        //                     "code" => 404,
        //                 ];
    
        //                 // echo json_encode($pesan);
        //         }
        //         else if($decodejson1["metaData"]["code"] == 412)
        //         {
        //             $pesan = [
        //                 "message" => "Not Found Data, Params is not null",
        //                 "code" => 412,
        //             ];

        //             // echo json_encode($pesan);
        //         }
        //         else{
        //             $stringdecrypt = $rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
        //             $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
        //             $decodejson = json_decode($decompressed,true);
            
        //             $pesan = [
        //                 "message" => "Berhasil Response",
        //                 "code" => 200,
        //                 "data" => $decodejson
        //             ];
            
        //             // echo json_encode($pesan);
        //         }
        //     } catch (\Throwable $pesan) {
        //         $pesan = [
        //             "message" => "Data not found for no content",
        //             "code" => 204
        //         ];
        //     }
        //     catch (\Exception $e) {
        //         if ($e->getCode() === 500) {
        //             $pesan = "Fatal Server response error";
                    
        //         } else {
        //             $pesan = "Fatal Problem Other" . $e->getMessage();
        //         }
        //     }
        // }
        // else{
        //     $pesan = [
        //         "message" => "Gagal Response",
        //         "code" => 500
        //     ];
        // }

        // echo $response;
        
        // print_r($decodejson1);

    }
    


}