<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TipoIdentificacionSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,

        ]);
    }
}
