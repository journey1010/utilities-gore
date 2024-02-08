<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LapMaestros\LapSerieModel as Lap;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class LaptopsSerieSeeder extends Seeder
{
    protected $minRow = 2;
    protected string $maxColumn = 'G'; 

    /**
     * Run the database seeds.
     */
    public function run(): void
    {    
        $caja = '';
        $serie = '';

        $archivo = storage_path('app/docs/2023/Cambiar nombre laptop.xlsx');
        $reader = IOFactory::createReader('Xlsx');
        $spreedsheet = $reader->load($archivo);
        $worksheet = $spreedsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = Coordinate::columnIndexFromString(self::$maxColumn);

        for($row = 2; $row <= $highestRow; $row++){
            for($col = 1; $row <= $highestColumn; $col++){
                $value  = $worksheet->getCell([$col, $row])->getValue();
                
            }
        }
    }
}
