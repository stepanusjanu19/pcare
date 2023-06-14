<?php
namespace Rscharitas\MVCPCARE\Controller;
use Rscharitas\MVCPCARE\App\RestClient;
// use Rscharitas\MVCPCARE\Model\PendaftaranModel;
use LZCompressor\LZString as LZ;
use Symfony\Component\Dotenv\Dotenv;

class KunjunganController
{
    public $rest;
    public $dotenv;
    // public $model;

    public function __construct() {
        
        $this->dotenv = new Dotenv();
        $this->rest = new RestClient();
    }
    function postkunjungan(): void
    {

        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $this->dotenv->load( __DIR__ . '/.env');

        $post = file_get_contents('php://input') ?? $_POST;
        $post = json_decode($post, true);

        $url = $_ENV['URL_API'] . "/kunjungan";
        
        //dummy kunjungan
        // $request = [
        //     //json first
        //     "noKunjungan" => isset($post['nokunjungan']) ? $post['nokunjungan'] : null,
        //     "noKartu" => isset($post['nokartu']) ? $post['nokartu'] : null,
        //     "tglDaftar" => isset($post['tgldaftar']) ? $post['tgldaftar'] : null,
        //     "kdPoli" => isset($post['kdpoli']) ? $post['kdpoli'] : null,
        //     "keluhan" => isset($post['keluhan']) ? $post['keluhan'] : null,
        //     "kdSadar" => isset($post['kdsadar']) ? $post['kdsadar'] : null,
        //     "sistole" => isset($post['sistole']) ? $post['sistole'] : 0,
        //     "diastole" => isset($post['diastole']) ? $post['diastole'] : 0,
        //     "beratBadan" => isset($post['beratbadan']) ? $post['beratbadan'] : 0,
        //     "tinggiBadan" => isset($post['tinggibadan']) ? $post['tinggibadan'] : 0,
        //     "respRate" => isset($post['resprate']) ? $post['resprate'] : 0,
        //     "heartRate" => isset($post['heartrate']) ? $post['heartrate'] : 0,
        //     "lingkarPerut" => isset($post['lingkarperut']) ? $post['lingkarperut'] : 0,

        //     //json two
        //     "kdStatusPulang" => isset($post['kdstatuspulang']) ? $post['kdstatuspulang'] : null,
        //     "tglPulang" => isset($post['tglpulang']) ? $post['tglpulang'] : null,
        //     "kdDokter" => isset($post['kddokter']) ? $post['kddokter'] : null,
        //     "kdDiag1" => isset($post['kdiag1']) ? $post['kdiag1'] : null,
        //     "kdDiag2" => isset($post['kdiag2']) ? $post['kdiag2'] : null,
        //     "kdDiag3" => isset($post['kdiag3']) ? $post['kdiag3'] : null,
        //     "kdPoliRujukInternal" => isset($post['kdpolirujukinternal']) ? $post['kdpolirujukinternal'] : null,
            
        //     "rujukLanjut" => [
        //         "tglEstRujuk" => isset($post['tglestrujuk']) ? $post['tglestrujuk'] : null,
        //         "kdppk" => isset($post['kdppk']) ? $post['kdppk'] : null,
        //         "subSpesialis" => isset($post['subspesialis']) ? $post['subspesialis'] : null,
        //         "khusus" => [
        //             "kdKhusus" => isset($post['kdkhusus']) ? $post['kdkhusus'] : null,
        //             "kdSubSpesialis" => isset($post['kdsubspesialis']) ? $post['kdsubspesialis'] : null,
        //             "catatan" => isset($post['catatan']) ? $post['catatan'] : null,
        //         ]
        //     ],
        //     "kdTacc" => isset($post['kdtacc']) ? $post['kdtacc'] : null,
        //     "alasanTacc" => isset($post['alasantacc']) ? $post['alasantacc'] : null
        // ];

        //post kunjungan
        $request = [
            //json first
            "noKunjungan" => isset($post['nokunjungan']) ? $post['nokunjungan'] : null,
            "noKartu" => isset($post['nokartu']) ? $post['nokartu'] : null,
            "tglDaftar" => isset($post['tgldaftar']) ? $post['tgldaftar'] : null,
            "kdPoli" => isset($post['kdpoli']) ? $post['kdpoli'] : null,
            "keluhan" => isset($post['keluhan']) ? $post['keluhan'] : null,
            "kdSadar" => isset($post['kdsadar']) ? $post['kdsadar'] : null,
            "sistole" => isset($post['sistole']) ? $post['sistole'] : 0,
            "diastole" => isset($post['diastole']) ? $post['diastole'] : 0,
            "beratBadan" => isset($post['beratbadan']) ? $post['beratbadan'] : 0,
            "tinggiBadan" => isset($post['tinggibadan']) ? $post['tinggibadan'] : 0,
            "respRate" => isset($post['resprate']) ? $post['resprate'] : 0,
            "heartRate" => isset($post['heartrate']) ? $post['heartrate'] : 0,
            "lingkarPerut" => isset($post['lingkarperut']) ? $post['lingkarperut'] : 0,

            //json two
            "kdStatusPulang" => isset($post['kdstatuspulang']) ? $post['kdstatuspulang'] : null,
            "tglPulang" => isset($post['tglpulang']) ? $post['tglpulang'] : null,
            "kdDokter" => isset($post['kddokter']) ? $post['kddokter'] : null,
            "kdDiag1" => isset($post['kddiag1']) ? $post['kddiag1'] : null,
            "kdDiag2" => isset($post['kddiag2']) ? $post['kddiag2'] : null,
            "kdDiag3" => isset($post['kddiag3']) ? $post['kddiag3'] : null,
            "kdPoliRujukInternal" => isset($post['kdpolirujukinternal']) ? $post['kdpolirujukinternal'] : null,
            
            "rujukLanjut" => [
                "kdppk" => isset($post['kdppk']) ? $post['kdppk'] : null,
                "tglEstRujuk" => isset($post['tglestrujuk']) ? $post['tglestrujuk'] : null,
                "subSpesialis" => [
                    "kdSubSpesialis1" => isset($post['kdsubspesialis1']) ? $post['kdsubspesialis1'] : null,
                    "kdSarana" => isset($post['kdsarana']) ? $post['kdsarana'] : null,
                ],
                "khusus" => null
            ],
            "kdTacc" => isset($post['kdtacc']) ? $post['kdtacc'] : null,
            "alasanTacc" => isset($post['alasantacc']) ? $post['alasantacc'] : null
        ];

        $response = $this->rest->callAPI('POST', $url, json_encode($request));
        $decodejson1 = json_decode($response, true);
        

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
                    "message" => "Failed Post",
                    "code" => 412,
                    "data" => $decodejson1
                ];

                // echo json_encode($pesan);
            }
            else{

                $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
                $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
                $decodejson = json_decode($decompressed,true);
                
                $pesan = [
                    "message" => "Berhasil Response, Add Kunjungan Success",
                    "code" => 201,
                    "data" => $decodejson
                ];

    
            // echo json_encode($pesan);
            }
        } catch (\Exception $e) {
            if ($e->getCode() === 500) {
                $pesan = "Fatal Server response error";
                
            } else {
                $pesan = "Fatal Problem Other" . $e->getMessage();
            }
        }
        echo json_encode($pesan);

    }

    function editkunjungan(): void 
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $this->dotenv->load( __DIR__ . '/.env');

        $post = file_get_contents('php://input') ?? $_POST;
        $post = json_decode($post, true);

        $url = $_ENV['URL_API'] . "/kunjungan";

        $request = [
            //json first
            "noKunjungan" => isset($post['nokunjungan']) ? $post['nokunjungan'] : null,
            "noKartu" => isset($post['nokartu']) ? $post['nokartu'] : null,
            "tglDaftar" => isset($post['tgldaftar']) ? $post['tgldaftar'] : null,
            "kdPoli" => isset($post['kdpoli']) ? $post['kdpoli'] : null,
            "keluhan" => isset($post['keluhan']) ? $post['keluhan'] : null,
            "kdSadar" => isset($post['kdsadar']) ? $post['kdsadar'] : null,
            "sistole" => isset($post['sistole']) ? $post['sistole'] : 0,
            "diastole" => isset($post['diastole']) ? $post['diastole'] : 0,
            "beratBadan" => isset($post['beratbadan']) ? $post['beratbadan'] : 0,
            "tinggiBadan" => isset($post['tinggibadan']) ? $post['tinggibadan'] : 0,
            "respRate" => isset($post['resprate']) ? $post['resprate'] : 0,
            "heartRate" => isset($post['heartrate']) ? $post['heartrate'] : 0,
            "lingkarPerut" => isset($post['lingkarperut']) ? $post['lingkarperut'] : 0,

            //json two
            "kdStatusPulang" => isset($post['kdstatuspulang']) ? $post['kdstatuspulang'] : null,
            "tglPulang" => isset($post['tglpulang']) ? $post['tglpulang'] : null,
            "kdDokter" => isset($post['kddokter']) ? $post['kddokter'] : null,
            "kdDiag1" => isset($post['kddiag1']) ? $post['kddiag1'] : null,
            "kdDiag2" => isset($post['kddiag2']) ? $post['kddiag2'] : null,
            "kdDiag3" => isset($post['kddiag3']) ? $post['kddiag3'] : null,
            "kdPoliRujukInternal" => isset($post['kdpolirujukinternal']) ? $post['kdpolirujukinternal'] : null,
            
            "rujukLanjut" => [
                "kdppk" => isset($post['kdppk']) ? $post['kdppk'] : null,
                "tglEstRujuk" => isset($post['tglestrujuk']) ? $post['tglestrujuk'] : null,
                "subSpesialis" => [
                    "kdSubSpesialis1" => isset($post['kdsubspesialis1']) ? $post['kdsubspesialis1'] : null,
                    "kdSarana" => isset($post['kdsarana']) ? $post['kdsarana'] : null,
                ],
                "khusus" => null
            ],
            "kdTacc" => isset($post['kdtacc']) ? $post['kdtacc'] : null,
            "alasanTacc" => isset($post['alasantacc']) ? $post['alasantacc'] : null
        ];

        $response = $this->rest->callAPI('PUT', $url, json_encode($request));
        $decodejson1 = json_decode($response, true);
        

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
                    "message" => "Failed Post",
                    "code" => 412,
                    "data" => $decodejson1
                ];

                // echo json_encode($pesan);
            }
            else{

                $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
                $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
                $decodejson = json_decode($decompressed,true);
                
                $pesan = [
                    "message" => "Berhasil Response, Edit Kunjungan Success",
                    "code" => 201,
                    "data" => $decodejson1["response"]
                ];

    
            // echo json_encode($pesan);
            }
        } catch (\Exception $e) {
            if ($e->getCode() === 500) {
                $pesan = "Fatal Server response error";
                
            } else {
                $pesan = "Fatal Problem Other" . $e->getMessage();
            }
        }
        echo json_encode($pesan);


    }


    function deletekunjungan(string $nokunjungan): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $this->dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/kunjungan/" . $nokunjungan;

        // echo $url;
        // echo $response;
        // echo $decodejson1["response"];
        //         $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
        //         $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
        //         $decodejson = json_decode($decompressed,true);
        
        $response = $this->rest->callAPI('DELETE', $url, false);
        $decodejson1 = json_decode($response);

        try {
            if($decodejson1->metaData->code == 412)
            {
                $pesan = [
                    "message" => "Failed Response, Delete Failed, Params is not null",
                    "code" => 412,
                ];
            }
            else if ($decodejson1->metaData->code == 200) {

                $pesan = [
                    "message" => "Success Response, Delete Kunjungan Success",
                    "code" => 200,
                ];
            }
            else{
                $pesan = [
                    "message" => "Failed Response, Delete Failed",
                    "code" => 400,
                ];
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


    function getrujukan(string $nokunjungan): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/kunjungan/rujukan/" . $nokunjungan ;

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


    function getriwayatkunjungan(string $nokartu): void
    {
        
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/kunjungan/peserta/" . $nokartu;

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