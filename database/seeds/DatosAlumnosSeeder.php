<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatosAlumnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //guardar un solo registro
        DB::table('alumnos')->insert([
            'name' => 'Jhonatan',
            'matricula' => 16270736,
            'Carrera' => 'Ingenieria Mecanica',
            'Semestre' => 9,
            'Actividad' => 'Futbol', 
          ]);
  
          //guardar 20 registros
          $arrays = range(0,20);
          foreach ($arrays as $valor) {
            DB::table('alumnos')->insert([	            
                'name' => Str::random(10),
                'matricula' => rand(1, 99999999),
                'Carrera' => Str::random(20),
                'Semestre' => rand(1, 12),
                'Actividad' => Str::random(10),
            ]);
          }
    }
}
