<?php

namespace App\Service;

use App\Models\AlumnoModelo;
use App\Repository\EstudianteRepository;

class findAlumno  {
   
/*     1. Cuando se consulte ese alumno, antes debe de buscar si está
   en la bd, y sino, consultar a la api.
2. Busco al alumno por medio de una api
3. Guardar los datos de ese alumno en la bd. */
    protected $estudianteRepository;
    protected $alumno;
    
    public function __construct()
    {
        $this->estudianteRepository = new EstudianteRepository ();
    }

    public function find ($no_de_control) 
    {
        $alumno = AlumnoModelo::find($no_de_control);
        if ($alumno) return $alumno;
        $this->alumno = $this->estudianteRepository->find($no_de_control);
        if($this->alumno){
            $result = $this->save();
            if($result)
                return $this->alumno;
        }
        return false;
    }

    public function save ()
    {
        $alumno = new AlumnoModelo();
        $alumno->no_de_control = $this->alumno->no_de_control;
        $alumno->nombre = $this->alumno->nombre;
        $alumno->apellidos = $this->alumno->apellidos;
        $alumno->carrera = $this->alumno->carrera;
        $alumno->semestre = $this->alumno->semestre;
        $alumno->sexo = $this->alumno->sexo;
        $alumno->email = $this->alumno->email;
        return $alumno->save();
    }
}