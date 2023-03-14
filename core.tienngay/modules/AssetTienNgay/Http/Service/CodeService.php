<?php


namespace Modules\AssetTienNgay\Http\Service;

use Modules\AssetTienNgay\Http\Repository\CodeRepository;

class CodeService extends BaseService
{
    protected $codeRepository;

    public function __construct(CodeRepository $codeRepository)
    {
        $this->codeRepository = $codeRepository;
    }

    public function create()
    {

    }
}
