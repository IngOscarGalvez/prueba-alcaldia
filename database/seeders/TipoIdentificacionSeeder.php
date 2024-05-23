<?php

namespace Database\Seeders;

use App\Models\Config\TipoIdentificacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoIdentificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Cédula'],
            ['name' => 'Tarjeta de Identidad'],
            ['name' => 'Registro Civil'],
            ['name' => 'Extranjería'],
            ['name' => 'Libreta Militar'],
            ['name' => 'Denuncio o permiso '],
            ['name' => 'Pasaporte '],
            ['name' => 'Tarjeta profesional'],
            ['name' => 'Sin Documentación'],
        ];

        foreach($data as $d) {
            $created = TipoIdentificacion::create([
                'name' => $d['name'],
            ]);
        }
    }
}
