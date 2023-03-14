<?php


namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel
{
    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->sheet = $this->spreadsheet->getActiveSheet();
    }

    // lưu ý trong lib excel thêm  const FORMAT_CURRENCY_VND = '#,##0_-';
    public function setCellValue($col, $value, $convert_number = false)
    {
        if ($convert_number == false) {
            return $this->sheet->setCellValue($col, $value);
        } else {
            return $this->sheet->setCellValue($col, $value)->getStyle($col)->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_CURRENCY_VND);
        }

    }

    public function setStyle($col)
    {
        $styles = [
            'font' =>
                [
                    'name' => 'Arial',
                    'bold' => false,
                    'italic' => false,
                    'strikethrough' => false,
                ],
            'borders' =>
                [
                    'left' =>
                        [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '808080']
                        ],
                    'right' =>
                        [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '808080']
                        ],
                    'bottom' =>
                        [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '808080']
                        ],
                    'top' =>
                        [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '808080']
                        ]
                ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => dechex(rand(0x000000, 0xFFFFFF))]
            ],
            'quotePrefix' => true
        ];
        $this->sheet->getStyle($col)->applyFromArray($styles)->getAlignment()->setHorizontal('center');
    }

    public function callLibExcel($filename)
    {
        // Redirect output to a client's web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.
        ob_end_clean();
        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
