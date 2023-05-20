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
        $url = $_ENV['URL_API'] . "/kunjungan";

        $request = [
            "noKunjungan" =>  null,
            //nokartu harus disesuaikan dengan pendaftaran poli tersebut 
            "noKartu" => "0002077406561", 
            //(noted: kemungkinan syarat untuk melakukan kunjungan jika no kartu telah terdaftar dalam poli yang didaftarkan melalui service pendaftaran)
            "tglDaftar" => date('d-m-Y'),
            "kdPoli" => "001",
            "keluhan" => "sakit kepala",
            "kdSadar" => "01",
            "sistole" =>  120,
            "diastole" =>  123,
            "beratBadan" => 55,
            "tinggiBadan" => 178,
            "respRate" => 80,
            "heartRate" => 80,
            "lingkarPerut" => 45,
            'kdDokter' => "287981",
            "kdDiag1" => "A01.0",
            "kdStatusPulang" => "4",
        ];


        // $request = [
        //     "noKunjungan" =>  null,
        //     "noKartu" => $arr["GuarantorCardNo"],
        //     "tglDaftar" => date('d-m-Y'),
        //     "kdPoli" => null,
        //     // "keluhan" => "keluhan",
        //     "kdSadar" => "01",
        //     "sistole" =>  (int)$arr["siastole"],
        //     "diastole" =>  (int)$arr["diastole"],
        //     "beratBadan" => (int)$arr["berat_badan"],
        //     "tinggiBadan" => (int)$arr["tinggi_badan"],
        //     "respRate" => (int)$arr["frekuensi_pernapasan"],
        //     "heartRate" => (int)$arr["detak_jantung"],
        //     "lingkarPerut" => (int)$arr["lingkar_perut"],
        // ];

        $response = $this->rest->callAPI('POST', $url, json_encode($request, true));
        echo $response;
    }

    function getkunjungan(string $nokartu): void
    {
        
        date_default_timezone_set('UTC');

        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));

        $dotenv = new Dotenv();
        $rest = new RestClient();

        $dotenv->load( __DIR__ . '/.env');
        $url = $_ENV['URL_API'] . "/kunjungan/peserta/" . $nokartu;

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
    


}