<?php

namespace Modules\ApiCpanel\Excel;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\Importable;

class ImportKT implements ToArray
{
    use Importable;

    public function array(array $array)
    {
        return $array;
    }
}
