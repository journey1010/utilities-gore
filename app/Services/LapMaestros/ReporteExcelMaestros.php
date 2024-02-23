<?php

namespace App\Services\LapMaestros;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Support\Facades\Storage;

class ReporteExcelMaestros
{

    protected $fila = 2;

    protected $headersReportMaestros = [
        'A1' => 'PROVINCIA',
        'B1' => 'NOMBRE COMPLETO',
        'C1' => 'DNI',
        'D1' => 'SERIE LAPTOP',
        'E1' => '¿RECIBIÓ LAPTOP?',
    ];

    public function generateReporte($consulta)
    {
        $spreadsheet = new Spreadsheet();
        $workSheet = $this->setStyleHeaders($spreadsheet->getActiveSheet());

        $this->fila = 2;

        foreach ($consulta as $dato) {
            $workSheet->setCellValue('A' . $this->fila, $dato->Provincia);
            $workSheet->setCellValue('B' . $this->fila, $dato->FullName);
            $workSheet->setCellValue('C' . $this->fila, $dato->DNI);
            $workSheet->setCellValue('D' . $this->fila, $dato->SerieLap);
            $workSheet->setCellValue('E' . $this->fila, $dato->LaptopRecibida);
            $this->fila++;
        }

        $this->setColumnWidths($workSheet);
        $this->setRowHeights($workSheet);
        $this->setStyleBorders($workSheet);

        $fileName = 'Reporte-Lista-Maestros' . date('Y-m-d-H-i-s')  . '.xlsx';

        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/public/exports/') . $fileName);
        $url = asset(Storage::url('app/public/exports/' . $fileName));
        $url = str_replace('storage/app/public/exports', 'storage/exports', $url);
        return $url;
    }

    private function setStyleHeaders(Worksheet $hojaActiva)
    {
        foreach ($this->headersReportMaestros as $indice => $valor) {
            $hojaActiva->setCellValue($indice, $valor);
            $hojaActiva->getStyle($indice)
                ->getFont()
                ->setBold(true)
                ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
            $hojaActiva->getStyle($indice)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('000000');
        }

        return $hojaActiva;
    }

    private function setColumnWidths(Worksheet $workSheet)
    {
        $workSheet->getColumnDimension('A')->setWidth(20);
        $workSheet->getColumnDimension('B')->setWidth(40);
        $workSheet->getColumnDimension('C')->setWidth(40);
        $workSheet->getColumnDimension('D')->setWidth(50);
        $workSheet->getColumnDimension('E')->setWidth(50);
    }

    private function setRowHeights(Worksheet $workSheet)
    {
        $workSheet->getRowDimension('2')->setRowHeight(25);
        $workSheet->getDefaultRowDimension()->setRowHeight(20);
    }

    private function setStyleBorders(Worksheet $workSheet)
    {
        $workSheet->getStyle('A2:E' . ($this->fila - 1))
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');
    }
}