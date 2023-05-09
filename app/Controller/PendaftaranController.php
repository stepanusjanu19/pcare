<?php
namespace Rscharitas\MVCPCARE\Controller;
use Rscharitas\MVCPCARE\Model\PendaftaranModel;
use LZCompressor\LZString as LZ;
use Symfony\Component\Dotenv\Dotenv;
use Rscharitas\MVCPCARE\App\RestClient;

class PendaftaranController
{
    public $model;
    public $dotenv;
    public $rest;
    public $tstamp;

    public function __construct() { 

        $this->dotenv = new Dotenv();
        $this->rest = new RestClient();
        $this->model = new PendaftaranModel();
    }

    function postantrian(): void
    {
        date_default_timezone_set('UTC');
        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $this->dotenv->load( __DIR__ . '/.env');

        $url = $_ENV['URL_API'] . "/pendaftaran";

        // $request = array(
        //     "kdProviderPeserta" => "0114A026", //noted error : kdProviderPeserta tidak sesuai dengan referensi sistem (error: belum tau kode provider peserta nya)
        //     "tglDaftar" => "12-08-2015", //date berpengaruh dalam post data
        //     "noKartu" => "0001113569638", //0002457745323(example) (noKartu peserta tidak ditemukan)
        //     "kdPoli" => "001", //kode poli harus diisi
        //     "keluhan" => null,
        //     "kunjSakit" => true,
        //     "sistole" =>  0,
        //     "diastole" =>  0,
        //     "beratBadan" => 0,
        //     "tinggiBadan" => 0,
        //     "respRate" => 0,
        //     "lingkarPerut" => 0,
        //     "heartRate" => 0,
        //     "rujukBalik" => 0,
        //     "kdTkp"=>"10"
        // );

        $request = array(
            "kdProviderPeserta" => "0132B094", //noted error : kdProviderPeserta tidak sesuai dengan referensi sistem (error: belum tau kode provider peserta nya)
            "tglDaftar" => date('d-m-Y'),
            "noKartu" => "0002077407336", //0002457745323(example) (noKartu peserta tidak ditemukan)
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


        try {
            $response = $this->rest->callAPI('POST', $url, json_encode($request));
            $decodejson1 = json_decode($response, true);
            
            if($decodejson1["response"] != "")
            {
                $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
                $decompressed = @ LZ::decompressFromEncodedURIComponent($stringdecrypt);
                $decodejson = json_decode($decompressed,true);
                

                $pesan = [
                    "message" => "Success Response, Post Success",
                    "status" => 200,
                    "data" => $decodejson
                ];
            }
            else{
                $pesan = [
                    "message" => "Failed Response, Post Failed",
                    "status" => 400,
                ];
            }
            echo json_encode($pesan);
            
        }
        catch (Exception $e) {
            echo json_encode([
                "message" => "Fatal Problem Other" . $e->getMessage()
            ]);
        }

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
                    $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
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

    function getantrianbyprovider($date, int $start, int $limit): void
    {
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $this->dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/pendaftaran/tglDaftar/" . $date . "/" . $start . "/" . $limit;

        // echo $url;

        $response = $this->rest->callAPI('GET', $url, false);

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
                    $stringdecrypt = $this->rest->stringDecrypt($_ENV['CONST_ID'].$_ENV['SECRET_KEY'].$tStamp, $decodejson1["response"]);
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