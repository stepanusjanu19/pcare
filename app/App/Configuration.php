<?php

namespace Rscharitas\MVCPCARE\App;

class Configuration {

    public function checkexistnokartu($nokartu, $arrayDat)
    {
        $isexist = false;
        $len = count($arrayDat);

        for ($i=0; $i<$len ; $i++) { 
            if($nokartu === $arrayDat[$i]['nokartu']){
                $isexist = true;
                break;
            }
        }
        return $isexist;
    }
}