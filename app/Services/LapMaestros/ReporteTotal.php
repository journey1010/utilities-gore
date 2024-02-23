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
    protected $fila = 3;

    protected $headersTotal = [
        'A2' => 'Provincia',
        'B2' => 'Total',
        'C2' => 'Entregadas',
        'D2' => 'Restante',
    ];
    
    public function generateReporte($consulta)
    {
        $spreadsheet = new Spreadsheet();
        $workSheet = $this->setStyleHeaders($spreadsheet->getActiveSheet());

        $workSheet->setCellValue('A1', 'REPORTE DEL TOTAL  DE LAPTOPS ENTREGADAS A MAESTROS');
        $workSheet->getStyle('A1')->getFont()->setBold(true)->setSize(20);

        $totalProvincia = 0;
        $totalEntregado =  0;
        $totalRestante  = 0;
        foreach ($consulta as $dato) {
            $workSheet->setCellValue('A' . $this->fila, $dato->Provincia);
            $workSheet->setCellValue('B' . $this->fila, $dato->TotalPorProvincia);
            $workSheet->setCellValue('C' . $this->fila, $dato->Entregado);
            $workSheet->setCellValue('D' . $this->fila, $dato->RestanteProvincia);

            $totalProvincia += $dato->TotalPorProvincia;
            $totalEntregado += $dato->Entregado;
            $totalRestante += $dato->RestanteProvincia; 

            $this->fila++;
        }

        $this->styleTotal($workSheet, $totalProvincia, $totalEntregado, $totalRestante);
        
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

    protected function styleTotal(Worksheet $hojaActiva, int $totalMaestros, int $entregadas, int $faltantes )
    {   
        $fila = 11;

        $hojaActiva->setCellValue('B' . $fila ,$totalMaestros);
        $hojaActiva->getStyle('B' . $fila)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
        $hojaActiva->getStyle('B' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('00FF00');

        $hojaActiva->setCellValue('C' . $fila ,$entregadas);
        $hojaActiva->getStyle('C' . $fila)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
        $hojaActiva->getStyle('C' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('00FF00');

        $hojaActiva->setCellValue('D' . $fila ,$faltantes);
        $hojaActiva->getStyle('D' . $fila)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
        $hojaActiva->getStyle('D' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('00FF00');

        $hojaActiva->setCellValue('E' . $fila , 'TOTAL');
        $hojaActiva->getStyle('E' . $fila)->getFont()->setBold(true)->setUnderline(false)->setStrikethrough(false);
        $hojaActiva->getStyle('E' . $fila)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
        $hojaActiva->getStyle('E' . $fila)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('00FF00');
    }
    

    private function setColumnWidths(Worksheet $workSheet)
    {
        $workSheet->getColumnDimension('A')->setWidth(20);
        $workSheet->getColumnDimension('B')->setWidth(20);
        $workSheet->getColumnDimension('C')->setWidth(20);
        $workSheet->getColumnDimension('D')->setWidth(20);
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