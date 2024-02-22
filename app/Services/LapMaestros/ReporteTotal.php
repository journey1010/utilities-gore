<?php

namespace App\Services\LapMaestros;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Support\Facades\Storage;

class ReporteTotal
{

    protected $fila = 2;

    protected $headersTotal = [
        'A1' => 'Provincia',
        'B1' => 'Total',
        'C1' => 'Entregadas',
        'D1' => 'Restante',
    ];
    
    
    public function generateReporte($consulta)
    {
        $spreadsheet = new Spreadsheet();
        $workSheet = $this->setStyleHeaders($spreadsheet->getActiveSheet());

        $this->fila = 2;

        foreach ($consulta as $dato) {
            $workSheet->setCellValue('A' . $this->fila, $dato->Provincia);
            $workSheet->setCellValue('B' . $this->fila, $dato->TotalPorProvincia);
            $workSheet->setCellValue('C' . $this->fila, $dato->Entregado);
            $workSheet->setCellValue('D' . $this->fila, $dato->RestanteProvincia);
            $this->fila++;
        }

        $this->setColumnWidths($workSheet);
        $this->setRowHeights($workSheet);
        $this->setStyleBorders($workSheet);

        $fileName = 'Reporte-Lista-Total' . date('Y-m-d-H-i-s')  . '.xlsx';

        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/public/exports/') . $fileName);
        $url = asset(Storage::url('app/public/exports/' . $fileName));
        $url = str_replace('storage/app/public/exports', 'storage/exports', $url);
        return $url;
    }

    private function setStyleHeaders(Worksheet $hojaActiva)
    {
        foreach ($this->headersTotal as $indice => $valor) {
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

    protected function styleTotal(Worksheet $hojaActiva)
    {   
        $fila = 10;
        $hojaActiva->setCellValue('E' . $fila , $estado_entrada);
        $hojaActiva->getStyle('E' . $fila)->getFont()->setBold(true)->setUnderline(false)->setStrikethrough(false);
        $hojaActiva->getStyle('E' . $fila)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
        $hojaActiva->getStyle('E' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color_estado);

    }
    

    private function setColumnWidths(Worksheet $workSheet)
    {
        $workSheet->getColumnDimension('A')->setWidth(20);
        $workSheet->getColumnDimension('B')->setWidth(40);
        $workSheet->getColumnDimension('C')->setWidth(40);
        $workSheet->getColumnDimension('D')->setWidth(50);
    }

    private function setRowHeights(Worksheet $workSheet)
    {
        $workSheet->getRowDimension('2')->setRowHeight(25);
        $workSheet->getDefaultRowDimension()->setRowHeight(20);
    }

    private function setStyleBorders(Worksheet $workSheet)
    {
        $workSheet->getStyle('A2:D' . ($this->fila - 1))
            ->getBorders()
            ->getOutline()
            ->setBorderStyle(Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');
    }
}