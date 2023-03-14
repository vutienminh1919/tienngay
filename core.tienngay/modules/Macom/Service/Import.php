<?php

namespace Modules\Macom\Service;

use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Import
{
    public function __construct()
    {
        $this->xlxs = new Xlsx();
        $this->csv = new Csv();
    }

    public function get_data_import($file)
    {
        $path_name = $file->getPathName();
        $extension = $file->extension();
        if ($extension == 'csv') {
            $spreadsheet = $this->csv->load($path_name);
        } else {
            $spreadsheet = $this->xlxs->load($path_name);
        }
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        return $sheetData;
    }
}