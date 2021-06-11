<?php

namespace App\Repository;

class EstudianteRepository extends GuzzleHttpRequest {
    
    public function find($matricula){
        return $this->get('api/estudiante/'.$matricula)
        ->getValues(); 
    }
}