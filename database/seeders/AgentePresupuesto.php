<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AgentePresupuesto extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'agente',
            'last_name' => 'agente participante presupuesto',
            'dni' => '12345678',
            'email' => 'agente_presupuesto@gmail.com',
            'rol' => 'agentePresupuesto',
            'password' => Hash::make('Hola5.3++')
        ]);
    }
}
