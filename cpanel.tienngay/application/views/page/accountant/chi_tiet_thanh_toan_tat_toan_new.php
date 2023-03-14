<tbody>
    <?php
    
//        var_dump($contractDataTatToan);
//        die;
    
    $total_tien_phai_tra_hang_ky = 0;
    $total_tien_goc = 0;
    $total_tien_lai = 0;
    $tong_so_ngay=0;
    $total_phi_tham_dinh_luu_tru_tai_san_1ky = 0;
    $total_phat_cham_tra = 0;
    $total_phat_tat_toan = 0;
    $total_tong_tien_phai_thanh_toan = 0;
    $total_da_thanh_toan = 0;
 
    if(!empty($contractDataTatToan)){
        //Get ngay_ky_tra của kì tất toán
        $ngay_ky_tra_cua_ki_tat_toan = 0;
        foreach($contractDataTatToan as $key => $contract){
            if(!empty($contract->ki_khach_hang_tat_toan) && $contract->ki_khach_hang_tat_toan == 1) {
                $ngay_ky_tra_cua_ki_tat_toan = $contract->ngay_ky_tra;
                break;
            }
        }
        foreach($contractDataTatToan as $key => $contract){
            $tien_tra_phai_tra_hang_thang = (float)$contract->tien_tra_1_ky;
            $tien_goc_1ky = (float)$contract->tien_goc_1ky;
            $tien_lai_1ky = 0;
            $tien_phi_tham_dinh_luu_tru_tai_san_1ky = 0;
            $phat_cham_tra_1ky = !empty($contract->tien_phi_cham_tra_1ky_da_tra) ? $contract->tien_phi_cham_tra_1ky_da_tra : 0;
            $phat_tat_toan = !empty($contract->fee_finish_contract) ? $contract->fee_finish_contract : 0;
            if(!empty($contract->ki_khach_hang_tat_toan) && $contract->ki_khach_hang_tat_toan == 1) {
                //Get số ngày  thực tế
                $this->createdAt = $this->time_model->convertDatetimeToTimestamp(new DateTime());
                $timestamp30days = 30 * 86400; // 1/5
                $rangeDate = $contract->ngay_ky_tra - $this->createdAt;  // = 1/6 - 15/5 = 23
                $so_ngay_no_thuc_te = round(($timestamp30days - $rangeDate) / 86400);
                $tien_lai_1ky = $contract->tien_lai_1ky_da_tra * $so_ngay_no_thuc_te / 30 ;
                $tien_phi_tham_dinh_luu_tru_tai_san_1ky = $contract->tien_phi_1ky_da_tra * $so_ngay_no_thuc_te / 30 ;
                $tien_tra_phai_tra_hang_thang = $tien_goc_1ky + $tien_lai_1ky + $tien_phi_tham_dinh_luu_tru_tai_san_1ky;
            } else {
                //So sánh ngày kỳ trả với ngày kỳ trả của kì tất toán
                //Nếu lớn hơn thì = 0
                //Nếu nhỏ hơn thì lấy DB
                if($contract->ngay_ky_tra > $ngay_ky_tra_cua_ki_tat_toan) {
                    $tien_lai_1ky = 0;
                    $tien_phi_tham_dinh_luu_tru_tai_san_1ky = 0;
                    $tien_tra_phai_tra_hang_thang = $tien_goc_1ky;
                } else {
                    $tien_lai_1ky = (float)$contract->lai_ky;
                    $tien_phi_tham_dinh_luu_tru_tai_san_1ky = (float)$contract->phi_tu_van + (float)$contract->phi_tham_dinh;
                }
            }
            $tong_tien_phai_thanh_toan = $tien_tra_phai_tra_hang_thang + $phat_cham_tra_1ky + $phat_tat_toan;
            //Total
            $total_tien_phai_tra_hang_ky += $tien_tra_phai_tra_hang_thang;
            $total_tien_goc += $tien_goc_1ky;
            $total_tien_lai += $tien_lai_1ky;
            $total_phat_tat_toan += $phat_tat_toan;
            $total_phi_tham_dinh_luu_tru_tai_san_1ky += $tien_phi_tham_dinh_luu_tru_tai_san_1ky;
            $total_phat_cham_tra += $phat_cham_tra_1ky;
            $total_tong_tien_phai_thanh_toan += $tong_tien_phai_thanh_toan;
            $tong_so_ngay+=!empty($contract->so_ngay_trong_ky) ? $contract->so_ngay_trong_ky : 0;
            ?>
                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?= !empty($contract->ngay_ky_tra) ? date('d/m/Y', intval($contract->ngay_ky_tra) ) : ""?></td>
                        <td><?= !empty($contract->so_ngay_trong_ky) ? $contract->so_ngay_trong_ky : ""?></td>
                        <td><?= number_format(((int)$tien_tra_phai_tra_hang_thang) )?></td>
                        <td><?= number_format($tien_goc_1ky )?></td>
                        <td><?= number_format($tien_lai_1ky )?></td>
                        <td><?= number_format($tien_phi_tham_dinh_luu_tru_tai_san_1ky )?></td>
                        
                        <td><?= number_format($tong_tien_phai_thanh_toan )?></td>
                        <td><?= number_format($tong_tien_phai_thanh_toan )?></td>
                        <td><?= number_format(0 )?></td>
                       <td>
                                    <?php
                                    if ($contract->status == 1) {
                                            $current_day = strtotime(date('m/d/Y').' 23:59:59');
                                            $datetime = !empty($contract->ngay_ky_tra) ? intval($contract->ngay_ky_tra): $current_day;
                                            $time = intval(($current_day - $datetime) / (24*60*60));
                                            if ($time <= 0) {
                                                    echo ' <i class="fa fa-circle text-primary" aria-hidden="true"></i> Chưa đến kỳ';
                                            }else if ($time >= 1 && $time <= 3) {
                                                    echo '<i class="fa fa-circle text-warning" aria-hidden="true"></i>  Quá hạn'.$time.' ngày -  tiêu chuẩn';
                                            } else if ($time > 3 && $time < $contract->so_ngay_trong_ky) {
                                                    echo '<i class="fa fa-circle text-orange" aria-hidden="true"></i> Quá hạn '.$time.' ngày -  xấu cấp 1';
                                            } else if ($time > $contract->so_ngay_trong_ky ) {
                                                    echo '<i class="fa fa-circle text-danger" aria-hidden="true"></i> Quá hạn '.$time.' ngày -  xấu cấp 2';
                                            }
                                    } else if ($contract->status == 2) {
                                            echo '<i class="fa fa-circle text-success" aria-hidden="true"></i> '.$this->lang->line('paid');
                                    } else {
                                            echo ' <i class="fa fa-circle text-danger" aria-hidden="true"></i> Đã quá hạn';
                                    }
                                    ?>
                            </td>
                            <td><?= number_format($phat_cham_tra_1ky )?></td>
                        <td><?= number_format($phat_tat_toan )?></td>
                       
                    </tr>
            <?php }} ?>
            <tr>
                <td><b>Tổng</b></td>
                <td></td>
                <td><b><?= $tong_so_ngay ?></b></td>
                <td><b><?= number_format(($total_tien_phai_tra_hang_ky) )?></b></td>
                <td><b><?= number_format((round($total_tien_goc)) )?></b></td>
                <td><b><?= number_format(($total_tien_lai) )?></b></td>
                <td><b><?= number_format(($total_phi_tham_dinh_luu_tru_tai_san_1ky) )?></b></td>
               
                <td><b><?= number_format(($total_tong_tien_phai_thanh_toan) )?></b></td>
                <td><b><?= number_format(($total_tong_tien_phai_thanh_toan) )?></b></td>
                <td><b><?= number_format(0 )?></b></td>
                <td></td>
                 <td><b><?= number_format(($total_phat_cham_tra) )?></b></td>
                <td><b><?= number_format(($total_phat_tat_toan) )?></b></td>
         </tr>
    </tbody>
