<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use App\Models\LapMaestros\MaestrosAptoModel as Maestros;

class MaestrosAptosSeeder extends Seeder
{
    protected $minRow = 1;
    protected string $maxColumn = 'G'; 

    protected $connection = 'utilities';
    /**
     * Run the database seeds.
     */
    public function run(): void 
    {  
        $provincia = ''; //COL1
        $dni = ''; //COL2
        $fullName = ''; //col3
        $ie = ''; //col4
        $condicion = ''; //col5
        $nivel = '';//col6
        $distrito = ''; //col7

        $archivo = storage_path('app/docs/2023/consolidado.xlsx');

        $reader = IOFactory::createReader('Xlsx');
        $spreedsheet = $reader->load($archivo);
        $worksheet = $spreedsheet->getActiveSheet();
        $higestRow = $worksheet->getHighestRow();
        $higestIndexColumn = Coordinate::columnIndexFromString($this->maxColumn);

        for($row = 2; $row <= $higestRow; $row++){
            for($col = 1; $col <= $higestIndexColumn; $col++ ){
                $value = $worksheet->getCell([$col, $row])->getValue();
                switch ($col){
                    case 1:
                        $provincia = $value;
                    break;
                    case 2:
                        if(strlen($value) < 8){
                            $dni =  str_pad($value, 8, '0', STR_PAD_LEFT);
                        }else  {
                            $dni = $value;
                        }
                    break;
                    case 3: 
                        $fullName = $value;
                    break;
                    case 4:
                        $ie = $value;
                    case 5:
                        $condicion = $value;
                    case 6:
                        $nivel = $value;
                    break;
                    case 7:
                        $distrito = $value;
                    break;
                }
            }
            Maestros::create([
                'full_name' => $fullName,
                'provincia' => $provincia,
                'dni' => $dni,
                'ie' => $ie,
                'condicion' => $condicion,
                'nivel' => $nivel,
                'distrito' => $distrito
            ]);
        }
    }
}
