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
    protected string $maxColumn = 'C'; 

    /**
     * Run the database seeds.
     */
    public function run(): void
    {    
        $caja = '';
        $serie = '';
        $condicion = '';

        $archivo = storage_path('app/docs/2023/laptops.xlsx');
        $reader = IOFactory::createReader('Xlsx');
        $spreedsheet = $reader->load($archivo);
        $worksheet = $spreedsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = Coordinate::columnIndexFromString($this->maxColumn);

        for($row = 2; $row <= $highestRow; $row++){
            for($col = 1; $col <= $highestColumn; $col++){
                $value  = $worksheet->getCell([$col, $row])->getValue();
                switch($col){
                    case 1:
                        $caja = $value;
                        break;
                    case 2:
                        $serie = $value;
                        break;
                    case 3:
                        $condicion = $value;
                        break;
                }
            }
            Lap::create([
                'caja' => $caja,
                'serie' => $serie,
                'condicion' => $condicion
            ]);
        }
    }
}
