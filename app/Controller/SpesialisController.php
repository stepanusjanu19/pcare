<?php
namespace Rscharitas\MVCPCARE\Controller;
use Rscharitas\MVCPCARE\App\RestClient;
use LZCompressor\LZString as LZ;
use Symfony\Component\Dotenv\Dotenv;

class SpesialisController
{

    function getspesialis(): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/spesialis";

        $response = $rest->callAPI('GET', $url, false);
        $decodejson1 = json_decode($response, true);
        // echo $response;

        try {
            if($decodejson1 == null || $decodejson1["status"] === 404)
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
        } catch (\Throwable $pesan) {
            $pesan = [
                "message" => "Data not found for no content",
                "code" => 204
            ];
        }
        echo json_encode($pesan);

    }

    function getspesialiskhusus(): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/spesialis/khusus";

        $response = $rest->callAPI('GET', $url, false);

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
        echo json_encode($pesan);

    }

    function getspesialissarana(): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/spesialis/sarana";

        $response = $rest->callAPI('GET', $url, false);

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
        echo json_encode($pesan);

    }

    function getsubspesialis(string $kodeSpes): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/spesialis/" . $kodeSpes . "/subspesialis";

        $response = $rest->callAPI('GET', $url, false);

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
        echo json_encode($pesan);

    }

    function getfaskesrujukansubspes(string $kodesub, string $kodesarana, $date): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/spesialis/rujuk/subspesialis/" . $kodesub . '/sarana/' . $kodesarana . '/tglEstRujuk/' . $date ;

        $response = $rest->callAPI('GET', $url, false);
        $decodejson1 = json_decode($response, true);

        if($response)
        {
            try {
                if($decodejson1["metaData"]["code"] == 404)
                    {
                        $pesan = [
                            "message" => "Not Found Url",
                            "code" => 404,
                        ];
    
                        // echo json_encode($pesan);
                }
                else if($decodejson1["metaData"]["code"] == 412)
                {
                    $pesan = [
                        "message" => "Not Found Data, Params is not null",
                        "code" => 412,
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
            catch (Exception $e) {
                if ($e->getCode() === 500) {
                    $pesan = "Fatal Server response error";
                    
                } else {
                    $pesan = "Fatal Problem Other" . $e->getMessage();
                }
            }
        }
        else{
            $pesan = [
                "message" => "Gagal Response",
                "code" => 500
            ];
        }
        echo json_encode($pesan);
    }

    function getfaskesrujukankhusus(string $kodekhusus, string $nokartu, $date): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/spesialis/rujuk/khusus/" . $kodekhusus . '/noKartu/' . $nokartu . '/tglEstRujuk/' . $date ;

        $response = $rest->callAPI('GET', $url, false);
        $decodejson1 = json_decode($response, true);

        if($response)
        {
            try {
                if($decodejson1["metaData"]["code"] == 404)
                    {
                        $pesan = [
                            "message" => "Not Found Url",
                            "code" => 404,
                        ];
    
                        // echo json_encode($pesan);
                }
                else if($decodejson1["metaData"]["code"] == 412)
                {
                    $pesan = [
                        "message" => "Not Found Data, Params is Wrong",
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
            catch (Exception $e) {
                if ($e->getCode() === 500) {
                    $pesan = "Fatal Server response error";
                    
                } else {
                    $pesan = "Fatal Problem Other" . $e->getMessage();
                }
            }
        }
        else{
            $pesan = [
                "message" => "Gagal Response",
                "code" => 500
            ];
        }
        echo json_encode($pesan);
    }

    function getfaskesrujukankhusus2(string $kodekhusus, string $kodesubspes, string $nokartu, $date): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/spesialis/rujuk/khusus/" . $kodekhusus . '/subspesialis/' . $kodesubspes  .'/noKartu/' . $nokartu . '/tglEstRujuk/' . $date ;

        $response = $rest->callAPI('GET', $url, false);
        $decodejson1 = json_decode($response, true);

        if($response)
        {
            try {
                if($decodejson1["metaData"]["code"] == 404)
                    {
                        $pesan = [
                            "message" => "Not Found Url",
                            "code" => 404,
                        ];
    
                        // echo json_encode($pesan);
                }
                else if($decodejson1["metaData"]["code"] == 412)
                {
                    $pesan = [
                        "message" => "Not Found Data, Params is Wrong",
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
            catch (Exception $e) {
                if ($e->getCode() === 500) {
                    $pesan = "Fatal Server response error";
                    
                } else {
                    $pesan = "Fatal Problem Other" . $e->getMessage();
                }
            }
        }
        else{
            $pesan = [
                "message" => "Gagal Response",
                "code" => 500
            ];
        }
        echo json_encode($pesan);
    }
    


}