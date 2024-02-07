<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MaestrosAptosSeeder extends Seeder
{
    protected $minRow = 1;
    protected string $maxColumm = 'G'; 
    /**
     * Run the database seeds.
     */
    public function run(): void 
    {  
        $archivo = Storage::get('app/docs/2023/consolidado.xlsx');

        $reader = IOFactory::createReader('xlsx');
        $spreedsheet = $reader->load($archivo);
        $worksheet = $spreedsheet->getActiveSheet();
        
        

    }
}
