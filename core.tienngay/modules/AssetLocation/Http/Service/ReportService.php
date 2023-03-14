<?php


namespace Modules\AssetLocation\Http\Service;

use Modules\AssetLocation\Http\Repository\ReportRepository;
use Modules\AssetLocation\Http\Repository\WarehouseRepository;

class ReportService extends BaseService
{
    protected $reportRepository;
    protected $warehouseRepository;

    public function __construct(ReportRepository $reportRepository,
                                WarehouseRepository $warehouseRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->warehouseRepository = $warehouseRepository;
    }

    public function report_all($request)
    {
        $data = [];

        $data['so_luong_ton_dau_thang'] = $this->reportRepository->report_all($request, 'so_luong_ton_dau_thang');
        $data['tong_tien_ton_dau_thang'] = $this->reportRepository->report_all($request, 'tong_tien_ton_dau_thang');
        $data['so_luong_nhap'] = $this->reportRepository->report_all($request, 'so_luong_nhap');
        $data['tong_tien_nhap'] = $this->reportRepository->report_all($request, 'tong_tien_nhap');
        $data['so_luong_xuat'] = $this->reportRepository->report_all($request, 'so_luong_xuat');
        $data['tong_tien_xuat'] = $this->reportRepository->report_all($request, 'tong_tien_xuat');
        $data['so_luong_ton_cuoi_thang'] = $this->reportRepository->report_all($request, 'so_luong_ton_cuoi_thang');
        $data['tong_tien_ton_cuoi_thang'] = $this->reportRepository->report_all($request, 'tong_tien_ton_cuoi_thang');

        return $data;
    }

    public function report_partial($request)
    {
        $warehouse = $this->warehouseRepository->findMany(['level' => (int)$request->level]);
        foreach ($warehouse as $value) {
            $value['report'] = $this->reportRepository->findOne(['month' => $request->month, 'warehouse_asset_location_id' => $value['_id']]);
        }
        return $warehouse;
    }
}
