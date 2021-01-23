<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\ConfigurationAcom;
use App\Models\TypeAcom;
use App\Models\TypeEvent;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Departamento de Formación Integral',
            'email' => 'admin@admin.com', 
            'password' => bcrypt('password'),
            'remember_token' => Str::random(60),
            'isAdmin' => true
        ]);

        ConfigurationAcom::create([
            'nameBossDAE' => 'Aqui va el nombre del jefe del Departamento de servicios Escolares',
            'nameCoordinator' => 'Aqui va el nombre del jefe del Departamento de servicios Escolares', 
            'nameBossDSE' => 'Aqui va el nombre del jefe del Departamento de servicios Escolares',
            'slogan' => 'Aqui va el slogan'
        ]);

        TypeAcom::create([
            'type' => 'Eventos',
        ]);
        TypeAcom::create([
            'type' => 'Donación',
        ]);

        TypeEvent::create([
            'type' => 'Deportivo',
        ]);
        TypeEvent::create([
            'type' => 'Cultural',
        ]);
        TypeEvent::create([
            'type' => 'Cívico',
        ]);
    }
}
