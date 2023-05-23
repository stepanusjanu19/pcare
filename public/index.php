<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rscharitas\MVCPCARE\App\Router;
use Rscharitas\MVCPCARE\Controller\HomeController;
use Rscharitas\MVCPCARE\Controller\DiagnosaController;
use Rscharitas\MVCPCARE\Controller\DokterController;
use Rscharitas\MVCPCARE\Controller\KesadaranController;
use Rscharitas\MVCPCARE\Controller\KunjunganController;
use Rscharitas\MVCPCARE\Controller\PesertaController;
use Rscharitas\MVCPCARE\Controller\PendaftaranController;
use Rscharitas\MVCPCARE\Controller\PoliController;
use Rscharitas\MVCPCARE\Controller\ProviderController;
use Rscharitas\MVCPCARE\Controller\Status_PulangController;
use Rscharitas\MVCPCARE\Controller\SpesialisController;


//display
Router::add('GET', '/', HomeController::class, 'index');
Router::add('GET', '/viewAntrian', PendaftaranController::class, 'viewantrian');


//get model
Router::add('GET', '/getmodel', PendaftaranController::class, 'getmodel');


//get data
Router::add('GET', '/getDiagnosa/([0-9a-zA-Z]*)/([0-9a-zA-Z]*)/([0-9a-zA-Z]*)', DiagnosaController::class, 'getdiagnosa');
Router::add('GET', '/getDokter/([0-9a-zA-Z]*)/([0-9a-zA-Z]*)', DokterController::class, 'getdokter');
Router::add('GET', '/getKesadaran', KesadaranController::class, 'getkesadaran');
Router::add('GET', '/getKunjungan/([0-9a-zA-Z]*)', KunjunganController::class, 'getkunjungan');
Router::add('GET', '/getPeserta/([0-9a-zA-Z]*)', PesertaController::class, 'getpeserta');
Router::add('GET', '/getAntrianNoUrut/([0-9a-zA-Z]*)/([0-9]{2}-[0-9]{2}-[0-9]{4})', PendaftaranController::class, 'getbyantrianid');
Router::add('GET', '/getAntrianProvider/([0-9]{2}-[0-9]{2}-[0-9]{4})/([0-9a-zA-Z]*)/([0-9a-zA-Z]*)', PendaftaranController::class, 'getantrianbyprovider');
Router::add('GET', '/getPoli/([0-9a-zA-Z]*)/([0-9a-zA-Z]*)', PoliController::class, 'getpoli');
Router::add('GET', '/getProvider/([0-9a-zA-Z]*)/([0-9a-zA-Z]*)', ProviderController::class, 'getprovider');
Router::add('GET', '/getStatusPulang/([0-9a-zA-Z]*)', Status_PulangController::class, 'getstatuspulang');
Router::add('GET', '/getSpesialis', SpesialisController::class, 'getspesialis');
Router::add('GET', '/getSpesialisKhusus', SpesialisController::class, 'getspesialiskhusus');
Router::add('GET', '/getSpesialisSarana', SpesialisController::class, 'getspesialissarana');
Router::add('GET', '/getSubSpesialis/([0-9a-zA-Z]*)', SpesialisController::class, 'getsubspesialis');


//post data
Router::add('POST', '/postAntrian', PendaftaranController::class, 'postantrian');
Router::add('POST', '/postKunjungan', KunjunganController::class, 'postkunjungan');

//delete data
Router::add('DELETE', '/deleteAntrian/([0-9a-zA-Z]*)/([0-9]{2}-[0-9]{2}-[0-9]{4})/([0-9a-zA-Z]*)/([0-9a-zA-Z]*)', PendaftaranController::class, 'deleteantrian');





// Router::add('GET', '/hello', HomeController::class, 'hello', [AuthMiddleware::class]);
// Router::add('GET', '/world', HomeController::class, 'world', [AuthMiddleware::class]);
// Router::add('GET', '/about', HomeController::class, 'about');
// Router::add('GET', '/products/([0-9a-zA-Z]*)/categories/([0-9a-zA-Z]*)', ProductController::class, 'categories');

Router::run();