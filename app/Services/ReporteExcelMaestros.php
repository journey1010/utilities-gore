<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpParser\Node\Expr\FuncCall;

class ReporteExcelMaestros 
{

    protected $headersReportMaestros =  [
        'A1' => 'PROVINCIA',
        'B1' => 'NOMBRE COMPLETO',
        'C1' => 'SERIE LAPTOP',
        'D1' => '¿RECIBIÓ LAPTOP?'
    ];

    public static function listMaestroLaptops($consulta) 
    {
        $spreadsheet = new Spreadsheet();
        $workSheet = self::setStyleHeaders($spreadsheet->getActiveSheet());
        
        $fila = 2;

        foreach ($consulta as $dato) {
          
            $workSheet->setCellValue('A' . $fila, $dato['id_empleado']);
            $workSheet->setCellValue('B' . $fila, $dato['nombres']);
            $workSheet->setCellValue('C' . $fila, $dato['apellidos']);
            $workSheet->setCellValue('D' . $fila, $dato['departamento']);
            $fila++;
        }

        $workSheet->getColumnDimension('A')->setWidth(20);
        $workSheet->getColumnDimension('B')->setWidth(40);
        $workSheet->getColumnDimension('C')->setWidth(40);
        $workSheet->getColumnDimension('D')->setWidth(50);
    }

    public function setStyleHeaders(Worksheet $hojaActiva)
    {
        foreach ($this->headersReportMaestros as $indice => $valor){
            $hojaActiva->setCellValue($indice, $valor);
            $hojaActiva->getStyle($indice)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
            $hojaActiva->getStyle($indice)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
        }

        $blackFont = new Font();
        $blackFont->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));

        return $hojaActiva;
    }

}
