<?php

namespace Rscharitas\MVCPCARE\Controller;
use Rscharitas\MVCPCARE\App\View;

class HomeController
{

    function index(): void
    {
        // echo "Selamat Datang di Bridging Pcare";
        $viewpath = 'resources/views';
        $template = 'template';
        $view = new View($viewpath, $template);
        $view->render('home');
    }

}