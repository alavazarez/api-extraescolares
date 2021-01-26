<?php

namespace App\Repository;

class FormacionIntegralRepository extends GuzzleHttpRequest {
    
    public function find($matricula){
        return $this->get('api/formacion-integral/'.$matricula)->getValues(); 
    }
}