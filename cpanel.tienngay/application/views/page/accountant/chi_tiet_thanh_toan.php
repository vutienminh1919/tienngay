<tbody>
    <?php
    $tien_tra_1_ky=0;
    $tien_goc_1ky=0;
    $lai_ky=0;
    $tong_so_ngay=0;
    $tong_so_ngay_cham_tra=0;
    $phi_tu_van=0;
    $phi_tham_dinh=0;
    $phi_tu_van_tham_dinh = 0;
    $penalty=0;
    $tong_thanh_toan=(float)$contractDB->tong_thanh_toan;
    $da_thanh_toan=(float)$contractDB->da_thanh_toan;
    $con_lai_chua_tra=$tong_thanh_toan-$da_thanh_toan;
    if($da_thanh_toan> $tong_thanh_toan)
    {
        $da_thanh_toan=$tong_thanh_toan;
         $con_lai_chua_tra=0;
    }
   $phat_cham_tra_cttt=0;
    if(!empty($contractData)){
            foreach($contractData as $key => $contract){
                $phi_tu_van_ = !empty($contract->phi_tu_van) ? (float)$contract->phi_tu_van : 0;
                $phi_tham_dinh_ = !empty($contract->phi_tham_dinh) ? (float)$contract->phi_tham_dinh : 0;
                $tien_tra_1_ky+=round($contract->tien_tra_1_ky);
                $tien_goc_1ky+=(float)$contract->tien_goc_1ky;
                $lai_ky+=(float)$contract->lai_ky;
                $tong_so_ngay+=!empty($contract->so_ngay_trong_ky) ? $contract->so_ngay_trong_ky : 0;
                $phi_tu_van+=(float)$contract->phi_tu_van;
                $phi_tham_dinh+=(float)$contract->phi_tham_dinh;
                $phi_tu_van_tham_dinh += (float)$contract->phi_tu_van + (float)$contract->phi_tham_dinh;
                $so_ngay_cham_tra=!empty($contract->so_ngay_cham_tra) ? $contract->so_ngay_cham_tra : 0;
                
                $penalty_dathanhtoan=(!empty($contract->tien_phi_cham_tra_1ky_da_tra)) ? (float)$contract->tien_phi_cham_tra_1ky_da_tra :  0;
                $fee_delay_pay=(!empty($contract->fee_delay_pay)) ? $contract->fee_delay_pay : (float)$contract->penalty_now;
                $penalty_now=(!empty($contract->fee_delay_pay->so_tien)) ? $contract->fee_delay_pay->so_tien : $fee_delay_pay;
                $tien_thanh_toan_=(float)$contract->tien_tra_1_ky + $penalty_now;
                $tien_da_tra=  (float)$contract->da_thanh_toan+$penalty_dathanhtoan;
                $con_lai_chua_tra_=ceil($tien_thanh_toan_-$tien_da_tra);
                 $phat_cham_tra_cttt+=(float)$penalty_now;
                $tien_da_tra= ($tien_da_tra<= 1) ? 0 : $tien_da_tra;
                $tien_thanh_toan_= ($tien_thanh_toan_<= 1) ? 0 : $tien_thanh_toan_;
                 $con_lai_chua_tra_= ($con_lai_chua_tra_<= 1) ? 0 : $con_lai_chua_tra_;
                 $current_day =strtotime(date('Y-m-d',$contractDB->date_pay). ' 23:59:59');
                $ngay_ky_tra_ky_ht=!empty($contract->ngay_ky_tra) ? strtotime(date('Y-m-d',$contract->ngay_ky_tra.' 23:59:59')) : $current_day;
				
                $date_liquidation = !empty($contractDB->liquidation_info->created_at_liquidations) ? strtotime(date('Y-m-d',$contractDB->liquidation_info->created_at_liquidations)) : 0;
				if ($contractDB->status == 40) {
					$current_day = $date_liquidation;
				}
                $time = intval(($current_day - $ngay_ky_tra_ky_ht) / (24*60*60));
//           
                 if ($contract->status == 1) {
                    $so_ngay_cham_tra=$time;
                 }  
                 
                if($time<0)
                $so_ngay_cham_tra=0;
                 
                 $tong_so_ngay_cham_tra+=$so_ngay_cham_tra;

                
                    ?>

                    <tr>
                            <td><?php echo $key+1?></td>
                            <td><?= !empty($contract->ngay_ky_tra) ? date('d/m/Y', intval($contract->ngay_ky_tra) ) : ""?></td>
                            <td><?= !empty($contract->so_ngay_trong_ky) ? $contract->so_ngay_trong_ky :0 ?></td>
                             <td><span class="text-danger" ><?= !empty($contract->so_ngay_cham_tra) ? $contract->so_ngay_cham_tra : $so_ngay_cham_tra ?></span></td>
                            <td><?= number_format((round($contract->tien_tra_1_ky) ))?></td>
                            <td><?= !empty($contract->tien_goc_1ky) ? number_format($contract->tien_goc_1ky ) : "0"?></td>
                            <td><?= !empty($contract->lai_ky) ? number_format($contract->lai_ky ) : "0"?></td>
                            <td><?= number_format($phi_tu_van_ + $phi_tham_dinh_  )?></td>
                            
                            <td><?= number_format( $tien_thanh_toan_)?></td>
                            <td><?= number_format( $tien_da_tra )?></td>
                            <td><?= number_format($con_lai_chua_tra_ )?></td>
                            <td>
                                    <?php
                                    if($contractDB->status==33 || $contractDB->status==34)
                                    {
                                       echo '<i class="fa fa-circle text-success" aria-hidden="true"></i> '.$this->lang->line('paid');
                                    }else{
                                    if ($contract->status == 1) {
                                        
                                               echo  get_bucket_text($time);
                                            
                                    } else if ($contract->status == 2) {
                                            echo '<i class="fa fa-circle text-success" aria-hidden="true"></i> '.$this->lang->line('paid');
                                    } else {
                                            echo ' <i class="fa fa-circle text-danger" aria-hidden="true"></i> Đã quá hạn';
                                    }
                                   }
                                    ?>
                            </td>
                            <td><?= !empty($penalty_now) ? number_format($penalty_now ) : "0"?></td>
                            
                         
                    </tr>
            <?php }} ?>
             <tr>
                    <td><b>Tổng</b></td>
                    <td></td>
                    <td><b><?= $tong_so_ngay ?></b></td>
                    <td><span class="text-danger" ><b><?= $tong_so_ngay_cham_tra ?></b></span></td>
                    <td><b><?= number_format(($tien_tra_1_ky) )?></b></td>
                    <td><b><?= number_format((round($tien_goc_1ky)) )?></b></td>
                    <td><b><?= number_format(($lai_ky) )?></b></td>
                    <td><b><?= number_format(($phi_tu_van_tham_dinh) )?></b></td>
                    
                    <td><b><?= number_format(($tong_thanh_toan) )?></b></td>
                    <td><b><?= number_format(($da_thanh_toan) )?></b></td>
                    <td><b><?= number_format(($con_lai_chua_tra) )?></b></td>
                    <td></td>
                    <td><b><?= number_format(($phat_cham_tra_cttt) )?></b></td>
                    
                
             </tr>

    </tbody>
