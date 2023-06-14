<?php
namespace Rscharitas\MVCPCARE\Controller;
use Rscharitas\MVCPCARE\Model\PendaftaranModel;
use LZCompressor\LZString as LZ;
use Symfony\Component\Dotenv\Dotenv;
use Rscharitas\MVCPCARE\App\RestClient;
use Rscharitas\MVCPCARE\App\View;
use Rscharitas\MVCPCARE\App\Configuration;


class PendaftaranController
{
    public $model;
    public $dotenv;
    public $rest;
    public $tstamp;
    public $kodeprovider;
    public $config;

    public function __construct() { 

        $this->dotenv = new Dotenv();
        $this->rest = new RestClient();
        $this->model = new PendaftaranModel();
        $this->kodeprovider = "0090B094";
        $this->config = new Configuration();
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
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $data = $this->model->queryantrian(); 
        $lendata = count($data);
        
        for ($i=0; $i<$lendata;$i++) { 
            $arr = $data[$i]['nokartu']." ";
            print_r($arr . "index-" . $i . " ");


            

            // if($this->config->checkexistnokartu(, $arr) == true)
            // {
            //     $pesan = [
            //         "message" => "Data Peserta Ada di database",
            //         "code" => 200,
            //         "data" => $arr
            //     ];

            //     // $request = array(
            // //     // "kdProviderPeserta" => is_null($this->kodeprovider) ? null : $this->kodeprovider, //noted error : kdProviderPeserta tidak sesuai dengan referensi sistem (error: belum tau kode provider peserta nya) (kdprovider set data)
            // //     "kdProviderPeserta" => isset($post['kdproviderpst']) ? $post['kdproviderpst'] : null, //noted error : kdProviderPeserta tidak sesuai dengan referensi sistem (error: belum tau kode provider peserta nya) (kdprovider set data)
            // //     "tglDaftar" => isset($post['tgldaftar']) ? $post['tgldaftar'] : null,
            // //     "noKartu" => isset($post['nokartu']) ? $post['nokartu'] : null, //0002457745323(example) (noKartu peserta tidak ditemukan)
            // //     "kdPoli" => isset($post['kdpoli']) ? $post['kdpoli'] : null, //kode poli harus diisi
            // //     "keluhan" => isset($post['keluhan']) ? $post['keluhan'] : null, // db
            // //     "kunjSakit" => isset($post['kunjsakit']) ? $post['kunjsakit'] : "false", //db
            // //     "sistole" =>  isset($post['sistole']) ? $post['sistole'] : 0, //db
            // //     "diastole" =>  isset($post['diastole']) ? $post['diastole'] : 0, //db
            // //     "beratBadan" => isset($post['beratbadan']) ? $post['beratbadan'] : 0, //db
            // //     "tinggiBadan" => isset($post['tinggibadan']) ? $post['tinggibadan'] : 0, //db
            // //     "respRate" => isset($post['resprate']) ? $post['resprate'] : 0, //db
            // //     "lingkarPerut" => isset($post['lingkarperut']) ? $post['lingkarperut'] : 0, //db
            // //     "heartRate" => isset($post['heartrate']) ? $post['heartrate'] : 0,//db
            // //     "rujukBalik" => isset($post['rujukbalik']) ? $post['rujukbalik'] : 0,//db
            // //     "kdTkp"=> isset($post['kdtkp']) ? $post['kdtkp'] : null
            // // );
            // }
            // else{
            //     $pesan = [
            //         "message" => "Data Peserta Tidak ada di database",
            //         "code" => 204,
            //         "data" => ""
            //     ];
            //     // $dotenv->load( __DIR__ . '/.env');
            //     // $url = $_ENV['URL_API'] . "/peserta/" . $arr;

            //     // $response = $rest->callAPI('GET', $url, false);
            //     // // echo $response;
            //     // $decodejson1 = json_decode($response, true);

            //     // if($decodejson1["status"] === 404)
            //     // {
            //     //     $pesan = [
            //     //         "message" => $decodejson1["message"],
            //     //         "code" => $decodejson1["status"] 
            //     //     ];
            //     // }
            //     // else{
            //     //     try {
            //     //         if($decodejson1["metaData"]["code"] === 412)
            //     //         {
            //     //             $pesan = [
            //     //                 "message" => "Gagal Response, Params its not valid",
            //     //                 "code" => 412,
            //     //                 "data" => $decodejson1
            //     //             ];
            //     //             // echo json_encode($pesan);
            //     //         }
            //     //         else{
            //     //             $stringdecrypt = $rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
            //     //             $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
            //     //             $decodejson = json_decode($decompressed,true);
                    
            //     //             $pesan = [
            //     //                 "message" => "Berhasil Response",
            //     //                 "code" => 200,
            //     //                 "data" => $decodejson
            //     //             ];
                    
            //     //             // echo json_encode($pesan);
            //     //         }
            //     //     } catch (\Throwable $pesan) {
            //     //         $pesan = [
            //     //             "message" => "Data not found for no content",
            //     //             "code" => 204
            //     //         ];
            //     //     }
            //     // }
            // }            
        }
        // echo json_encode($pesan);
        
           

        




        // $arrinsert = array();
        // print_r($data);
        // $jsonString = json_encode($data, JSON_PRETTY_PRINT);

        // echo $jsonString;
        


        // date_default_timezone_set('UTC');

        // $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        // $dotenv = new Dotenv();
        // $rest = new RestClient();

        // $dotenv->load( __DIR__ . '/.env');
        // $url = $_ENV['URL_API'] . "/peserta/" . $jeniskartu . '/' . $nokartu;

        // $response = $rest->callAPI('GET', $url, false);
        // // echo $response;
        // $decodejson1 = json_decode($response, true);

        // if(isset($decodejson1["status"]) === 404)
        // {
        //     $pesan = [
        //         "message" => $decodejson1["message"],
        //         "code" => $decodejson1["status"] 
        //     ];
        // }
        // else{
        //     try {
        //         if($decodejson1["metaData"]["code"] === 412)
        //         {
        //             $pesan = [
        //                 "message" => "Gagal Response, Params its not valid",
        //                 "code" => 412,
        //                 "data" => $decodejson1
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
        // }

        // echo json_encode($pesan);


        // echo $jsonString;
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
                "tglDaftar" => isset($post['tgldaftar']) ? $post['tgldaftar'] : null,
                "noKartu" => isset($post['nokartu']) ? $post['nokartu'] : null, //0002457745323(example) (noKartu peserta tidak ditemukan)
                "kdPoli" => isset($post['kdpoli']) ? $post['kdpoli'] : null, //kode poli harus diisi
                "keluhan" => isset($post['keluhan']) ? $post['keluhan'] : null, // db
                "kunjSakit" => isset($post['kunjsakit']) ? $post['kunjsakit'] : "false", //db
                "sistole" =>  isset($post['sistole']) ? $post['sistole'] : 0, //db
                "diastole" =>  isset($post['diastole']) ? $post['diastole'] : 0, //db
                "beratBadan" => isset($post['beratbadan']) ? $post['beratbadan'] : 0, //db
                "tinggiBadan" => isset($post['tinggibadan']) ? $post['tinggibadan'] : 0, //db
                "respRate" => isset($post['resprate']) ? $post['resprate'] : 0, //db
                "lingkarPerut" => isset($post['lingkarperut']) ? $post['lingkarperut'] : 0, //db
                "heartRate" => isset($post['heartrate']) ? $post['heartrate'] : 0,//db
                "rujukBalik" => isset($post['rujukbalik']) ? $post['rujukbalik'] : 0,//db
                "kdTkp"=> isset($post['kdtkp']) ? $post['kdtkp'] : null
            );

        // echo json_encode($request);
        
        $response = $this->rest->callAPI('POST', $url, json_encode($request));
        echo $response;
        $decodejson1 = json_decode($response, true);

        if($response)
        {
            try {

                if($decodejson1["status"] == 404)
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
                        "message" => "Failed Post, Value its not valid",
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
                        "message" => "Berhasil Response, Add Antrian Success",
                        "code" => 201,
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
            catch (\Exception $e) {
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

    function getbyantrianid(string $nourut, $date): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $this->dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/pendaftaran/noUrut/" . $nourut . "/tglDaftar/" . $date;

        // echo $url;

        $response = $this->rest->callAPI('GET', $url, false);

        // echo $response;

        $decodejson1 = json_decode($response, true);
        
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
                $pesan = "Fatal Server response error";
                
            } else {
                $pesan = "Fatal Problem Other" . $e->getMessage();
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
        // echo $response;

        $response = $this->rest->callAPI('GET', $url, false);
        // echo $response;
        $decodejson1 = json_decode($response, true);
        
    //    if(isset($decodejson1["status"]) === 404)
    //    {

    //    }
    //    else{
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
                    $pesan = "Fatal Server response error";
                    
                } else {
                    $pesan = "Fatal Problem Other" . $e->getMessage();
                }
            }catch (\Exception $response)
            {
                $pesan = [
                    "message" => $decodejson1["message"],
                    "code" => 404
                ];
            }
            
    //    }
        
        echo json_encode($pesan);
    }

    function deleteantrian(string $nokartu, $date, string $nourut, string $kode): void
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
                    "message" => "Success Response, Delete Pendaftaran Success",
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


    function webpostantrian(): void
    {
        date_default_timezone_set('UTC');
        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $this->dotenv->load( __DIR__ . '/.env');

        $url = $_ENV['URL_API'] . "/pendaftaran";

        $tgldaftar = isset($_POST['tgldaftar']) ? $_POST['tgldaftar'] : null;
        $formatdate = date('d-m-Y', strtotime($tgldaftar));

        $request = array(
                // "kdProviderPeserta" => is_null($this->kodeprovider) ? null : $this->kodeprovider, //noted error : kdProviderPeserta tidak sesuai dengan referensi sistem (error: belum tau kode provider peserta nya) (kdprovider set data)
                "kdProviderPeserta" => isset($_POST['kdproviderpst']) ? $_POST['kdproviderpst'] : null, //noted error : kdProviderPeserta tidak sesuai dengan referensi sistem (error: belum tau kode provider peserta nya) (kdprovider set data)
                "tglDaftar" => $formatdate,
                "noKartu" => isset($_POST['nokartu']) ? $_POST['nokartu'] : null, //0002457745323(example) (noKartu peserta tidak ditemukan)
                "kdPoli" => isset($_POST['kdpoli']) ? $_POST['kdpoli'] : null, //kode poli harus diisi
                "keluhan" => isset($_POST['keluhan']) ? $_POST['keluhan'] : null, // db
                "kunjSakit" => isset($_POST['kunjsakit']) ? $_POST['kunjsakit'] : "false", //db
                "sistole" =>  isset($_POST['sistole']) ? $_POST['sistole'] : 0, //db
                "diastole" =>  isset($_POST['diastole']) ? $_POST['diastole'] : 0, //db
                "beratBadan" => isset($_POST['beratbadan']) ? $_POST['beratbadan'] : 0, //db
                "tinggiBadan" => isset($_POST['tinggibadan']) ? $_POST['tinggibadan'] : 0, //db
                "respRate" => isset($_POST['resprate']) ? $_POST['resprate'] : 0, //db
                "lingkarPerut" => isset($_POST['lingkarperut']) ? $_POST['lingkarperut'] : 0, //db
                "heartRate" => isset($_POST['heartrate']) ? $_POST['heartrate'] : 0,//db
                "rujukBalik" => isset($_POST['rujukbalik']) ? $_POST['rujukbalik'] : 0,//db
                "kdTkp"=> isset($_POST['kdtkp']) ? $_POST['kdtkp'] : null
            );

        // echo json_encode($request);
        
        $response = $this->rest->callAPI('POST', $url, json_encode($request));
        $decodejson1 = json_decode($response, true);

        if($response)
        {
            try {

                $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
                $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
                $decodejson = json_decode($decompressed,true);

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
                        "message" => "Failed Post, Value its not valid or null",
                        "code" => 412,
                        "data" => $decodejson
                    ];

                    // echo json_encode($pesan);
                }
                else{
                    
                    $pesan = [
                        "message" => "Berhasil Response, Add Antrian Success",
                        "code" => 201,
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
            catch (\Exception $e) {
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