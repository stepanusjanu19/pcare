<?php
namespace Rscharitas\MVCPCARE\Controller;
use Rscharitas\MVCPCARE\Model\PendaftaranModel;
use LZCompressor\LZString as LZ;
use Symfony\Component\Dotenv\Dotenv;
use Rscharitas\MVCPCARE\App\RestClient;
use Rscharitas\MVCPCARE\App\View;

class PendaftaranController
{
    public $model;
    public $dotenv;
    public $rest;
    public $tstamp;
    public $kodeprovider;

    public function __construct() { 

        $this->dotenv = new Dotenv();
        $this->rest = new RestClient();
        $this->model = new PendaftaranModel();
        $this->kodeprovider = "0090B094";

    }

    public function viewantrian()
    {
        $viewpath = 'resources/views';
        $template = 'template';
        $view = new View($viewpath, $template);
        $view->render('antriandaftar');
    }

    function getmodel()
    {
        $this->model->queryantrian(); 
    }

    function postantrian(): void
    {
        date_default_timezone_set('UTC');
        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $this->dotenv->load( __DIR__ . '/.env');

        $url = $_ENV['URL_API'] . "/pendaftaran";
        
        $post = file_get_contents('php://input') ?? $_POST;
        $post = json_decode($post, true);

        $request = array(
            // "kdProviderPeserta" => is_null($this->kodeprovider) ? null : $this->kodeprovider, //noted error : kdProviderPeserta tidak sesuai dengan referensi sistem (error: belum tau kode provider peserta nya) (kdprovider set data)
            "kdProviderPeserta" => isset($post['kdproviderpst']) ? $post['kdproviderpst'] : null, //noted error : kdProviderPeserta tidak sesuai dengan referensi sistem (error: belum tau kode provider peserta nya) (kdprovider set data)
            "tglDaftar" => date('d-m-Y'),
            "noKartu" => isset($post['nokartu']) ? $post['nokartu'] : null, //0002457745323(example) (noKartu peserta tidak ditemukan)
            "kdPoli" => "001", //kode poli harus diisi
            "keluhan" => "sakit kepala",
            "kunjSakit" => true,
            "sistole" =>  0,
            "diastole" =>  0,
            "beratBadan" => 0,
            "tinggiBadan" => 0,
            "respRate" => 0,
            "lingkarPerut" => 0,
            "heartRate" => 0,
            "rujukBalik" => 0,
            "kdTkp"=>"10"
        );

        

        // $request = array(
        //     "kdProviderPeserta" => "",
        //     "tglDaftar" => date('d-m-Y'),
        //     "noKartu" => $all["GuarantorCardNo"],
        //     "kdPoli" => "001", //kode poli harus diisi
        //     "keluhan" => null,
        //     "kunjSakit" => true,
        //     "sistole" =>  (int)$all["siastole"],
        //     "diastole" =>  (int)$all["diastole"],
        //     "beratBadan" => (int)$all["berat_badan"],
        //     "tinggiBadan" => (int)$all["tinggi_badan"],
        //     "respRate" => (int)$all["frekuensi_pernapasan"],
        //     "lingkarPerut" => (int)$all["lingkar_perut"],
        //     "heartRate" => (int)$all["detak_jantung"],
        //     "rujukBalik" => 0,
        //     "kdTkp"=>"10"
        // );

        $response = $this->rest->callAPI('POST', $url, json_encode($request));
        $decodejson1 = json_decode($response, true);

        if ($response != "")
        {
            try {
                if($decodejson1["response"] != "")
                {
                    $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
                    $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
                    $decodejson = json_decode($decompressed,true);
    
                    if ($decodejson1["metaData"]["code"] == 412) {
                        $pesan = [
                            "message" => "Failed Response, Post Failed",
                            "code" => 412,
                            "data" => $decodejson
                        ];
                    }
                    else{
                        $pesan = [
                            "message" => "Success Response, Post Success",
                            "code" => 200,
                            "data" => $decodejson
                        ];
                    }
                }
                else{
                    $pesan = [
                        "message" => "Failed Response, Post Failed",
                        "code" => 400,
                    ];
                }         
            }
            catch (Exception $e) {
                $pesan = [
                    "message" => "Fatal Problem Other" . $e->getMessage()
                ];
            }
        }
        else{
            $pesan = [
                "message" => "Not Found Url",
                "code" => 404
            ];
        }
        echo json_encode($pesan);

        // $decodejson1 = json_decode($response, true);

        // $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
        // $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
        // $decodejson = json_decode($decompressed,true);

        // echo $response;
        
    }

    function getbyantrianid(string $nourut, $date): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $this->dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/pendaftaran/noUrut/" . $nourut . "/tglDaftar/" . $date;

        // echo $url;

        $response = $this->rest->callAPI('GET', $url, false);

        $decodejson1 = json_decode($response, true);
        
        if ($decodejson1["status"] === 404)
        {
            $pesan = [
                "message" => "Not Found Url",
                "code" => 404
            ];
        }
        else{
                try {   
                    $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
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
                        $pesan = "Fatal Server response error";
                        
                    } else {
                        $pesan = "Fatal Problem Other" . $e->getMessage();
                    }
                }
        }
        
        echo json_encode($pesan);
        

        // try {
        //     if($response != "")
        //     {
        //         $decodejson1 = json_decode($response, true);

        //         if($decodejson1 == null)
        //         {
        //             $pesan = [
        //                 "message" => "Gagal Response",
        //                 "code" => 400,
        //                 "data" => $decodejson1
        //             ];

        //             // echo json_encode($pesan);
        //         }
        //         else{
        //             $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
        //             $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
        //             $decodejson = json_decode($decompressed,true);
            
        //             $pesan = [
        //                 "message" => "Berhasil Response",
        //                 "code" => 200,
        //                 "data" => $decodejson
        //             ];
        //             // echo json_encode($pesan);
        //         }
        //     }
        // } catch (\Throwable $pesan) {
        //     $pesan = [
        //         "message" => "Data not found for no content",
        //         "code" => 204
        //     ];
        // }
        // catch (Exception $e) {
        //     if ($e->getCode() === 500) {
        //         $pesan = "Fatal Server response error";
                
        //     } else {
        //         $pesan = "Fatal Problem Other" . $e->getMessage();
        //     }
        // }
        // echo json_encode($pesan);
    }

    function getantrianbyprovider($date, int $start, int $limit): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $this->dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/pendaftaran/tglDaftar/" . $date . "/" . $start . "/" . $limit;

        // echo $url;

        $response = $this->rest->callAPI('GET', $url, false);
        $decodejson1 = json_decode($response, true);
        
        if ($decodejson1["status"] === 404)
        {
            $pesan = [
                "message" => "Not Found Url",
                "code" => 404
            ];
        }
        else{
                try {   
                    $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
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
                        $pesan = "Fatal Server response error";
                        
                    } else {
                        $pesan = "Fatal Problem Other" . $e->getMessage();
                    }
                }
        }
        
        echo json_encode($pesan);
    }

    function deleteantrian(string $nokartu, $date, string $nourut, string $kode)
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $this->dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/pendaftaran/peserta/" . $nokartu . "/tglDaftar/" . $date . "/noUrut/" . $nourut . "/kdPoli/" . $kode;

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
                    "message" => "Success Response, Delete Success",
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
    


}