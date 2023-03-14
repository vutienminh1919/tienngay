<?php 
$status_pay="";
if($contractDB->status==17)
{
if( $contractDB->ky_cham_tra ==0)
{
  $status_pay="Chưa đến kỳ thanh toán";
}
if($contractDB->ky_cham_tra >0)
{
  $status_pay="Chậm trả";
}
}else if($contractDB->status==19) {
  $status_pay="Đã tất toán";
}else{
  $status_pay="Không xác định";
}
 $penalty=0;
 $tong_thanh_toan=0;
$tien_con_no=0;
$da_thanh_toan=0;
$penalty_dathanhtoan=0;


$tong_thanh_toan=(float)$contractDB->total_money_paid_now;
$da_thanh_toan=(float)$contractDB->da_thanh_toan;
$tien_con_no=(float)$contractDB->tien_con_no;

$phat_cham_tra_top=(float)$contractDB->penalty_now;
$tien_thua_thanh_toan = !empty($contractDB->tien_thua_thanh_toan) ? $contractDB->tien_thua_thanh_toan : 0;
$tien_thua_tat_toan = !empty($contractDB->tien_thua_tat_toan) ? $contractDB->tien_thua_tat_toan : 0;
$phiChamTraConLaiTruocTatToan = !empty($contractDB->phi_cham_tra_con_lai_truoc_tat_toan) ? $contractDB->phi_cham_tra_con_lai_truoc_tat_toan : 0;
$tien_chua_tra_top=$contractDB->total_money_paid_now;
$tien_qua_han_top=$contractDB->phi_phat_sinh;
$tong_so_tien_thieu = !empty($contractDB->tong_so_tien_thieu) ? $contractDB->tong_so_tien_thieu : 0;
$du_no_goc_con_lai = !empty($dataTatToanPart1->goc_chua_tra_den_thoi_diem_dao_han) ? $dataTatToanPart1->goc_chua_tra_den_thoi_diem_dao_han : 0;

	//start tong tien thanh toan tt
	$du_no_con_lai_tt =0;
	$phi_phat_cham_tra_tt =0;

	$du_no_con_lai_tt = !empty($dataTatToanPart1->du_no_con_lai) ? $dataTatToanPart1->du_no_con_lai : 0;
	$phi_phat_cham_tra_tt = !empty($contractDB->penalty_pay) ? $contractDB->penalty_pay : 0;
	$phi_phat_tat_toan_truoc_han = !empty($debtData->phi_thanh_toan_truoc_han) ? $debtData->phi_thanh_toan_truoc_han : 0;
	$phi_phat_sinh_tt = !empty($contractDB->phi_phat_sinh) ? $contractDB->phi_phat_sinh : 0;
	$tien_chua_tra_ky_thanh_toan = !empty($contractDB->tien_chua_tra_ky_thanh_toan) ? $contractDB->tien_chua_tra_ky_thanh_toan : 0;
	$tien_du_ky_truoc = !empty($contractDB->tien_du_ky_truoc) ? $contractDB->tien_du_ky_truoc : 0;
	$tien_thua_thanh_toan = !empty($contractDB->tien_thua_thanh_toan) ? $contractDB->tien_thua_thanh_toan : 0;

	$tong_tien_thanh_toan_tt = $du_no_con_lai_tt + $phi_phat_cham_tra_tt + $phi_phat_tat_toan_truoc_han+$phi_phat_sinh_tt+$tien_chua_tra_ky_thanh_toan -$tien_du_ky_truoc-$tien_thua_thanh_toan + $tong_so_tien_thieu;

	$tien_thanh_ly_tai_san_dam_bao = 0;
	$chi_phi_thanh_ly_tai_san = 0;
	$tien_chenh_lech_thanh_ly = 0;
	$tien_thanh_ly_tai_san_dam_bao = !empty($contractDB->liquidation_info->price_real_sold) ? $contractDB->liquidation_info->price_real_sold : 0;
	$chi_phi_thanh_ly_tai_san = !empty($contractDB->liquidation_info->fee_sold) ? $contractDB->liquidation_info->fee_sold : 0;
	if ($contractDB->status == 19 && $tien_thanh_ly_tai_san_dam_bao > 0 ) {
		$tien_chenh_lech_thanh_ly = $contractDB->liquidation_info->different_amount_after_payment_finish;
	}
	//end tong tien thanh toan tt

if($contractDB->status==19 || $contractDB->status==40)
{
  $tien_con_no=0;
  $phat_cham_tra_top=0;
  $tien_chua_tra_top=0;
   $tien_qua_han_top=0;
   $du_no_goc_con_lai=0;
}
if($contractDB->status==33 || $contractDB->status==34)
{
  $tong_thanh_toan=$tong_thanh_toan-$du_no_goc_con_lai;
  $tien_con_no=$tien_con_no-$du_no_goc_con_lai;
  $tien_chua_tra_top=$tien_chua_tra_top-$du_no_goc_con_lai;
  $du_no_goc_con_lai=0;

}
if($tong_thanh_toan<0) $tong_thanh_toan=0;
if($tien_con_no<0) $tien_con_no=0;
if($tien_chua_tra_top<0) $tien_chua_tra_top=0;

?>
<div class="row flex" style="justify-content: center;">
          <div class="col-xs-12  col-md-6">
			  <div class="table-responsive">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <th>Khách hàng</th>
                  <td class="text-right text-danger"><strong><?php echo $contractDB->customer_infor->customer_name?></strong> </td>
                </tr>
                <tr>
                  <th>Mã HĐ</th>
                  <td class="text-right"><?php echo $contractDB->code_contract_disbursement ?></td>
                </tr>
                 <tr>
                  <th>Mã phiếu ghi</th>
                  <td class="text-right"><?php echo $contractDB->code_contract ?></td>
                </tr>
                <tr>
                  <th>Sản phẩm vay</th>
                  <td class="text-right"><?php echo $contractDB->loan_infor->name_property->text ?></td>
                </tr>
                <tr>
                  <th>Hình thức vay</th>
                  <td class="text-right"><?php echo change_type_loan($contractDB->loan_infor->type_loan->text)?></td>
                </tr>
                <tr>
                  <th>Thời gian vay</th>
                  <td class="text-right"><?= !empty($contractDB->disbursement_date) ? date('d/m/Y', intval($contractDB->disbursement_date)) : ""?> - <?= !empty($contractDB->ngay_ket_thuc) ? date('d/m/Y', intval($contractDB->ngay_ket_thuc)) : ""?> (<?= !empty($contractDB->tong_so_ngay_trong_ky) ? intval($contractDB->tong_so_ngay_trong_ky) : ""?> ngày)</td>
                </tr>
                <tr>
                  <th>Hình thức trả</th>
                  <td class="text-right"><?php echo type_repay($contractDB->loan_infor->type_interest) ?></td>
                </tr>
                <tr>
                  <th>Phí thực tính</th>
                  <td class="text-right">
                   <a href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?php echo $contractDB->_id->{'$oid'} ?>" class="dropdown-item yeu_cau_giai_ngan"> Xem Phí
                                    Thực Tính</a>
                      
                    </td>
                </tr>
                  <tr>
                  <th>Mã giảm bảo hiểm</th>
                  <td class="text-right">
                   <a href="javascript:void(0)" onclick="edit_coupon_bhkv(this)" data-id="<?php echo $contractDB->_id->{'$oid'} ?>" class="dropdown-item yeu_cau_giai_ngan"> Xem Mã BH KV</a>
                      
                    </td>
                </tr>
           <tr>
                  <th>Trạng thái</th>
                  <td class="text-right">
                  <?php echo contract_status($contractDB->status); ?>
                      
                    </td>
                </tr>
				<?php if (isset($exemption_contract->status)) { ?>
				<tr>
					<th>Trạng thái miễn giảm</th>
					<td class="text-right">
						<?= isset($exemption_contract->status) ? exemptions_status($exemption_contract->status) : ""; ?>
					</td>
				</tr>
				<?php } ?>
				<?php if ($userSession['is_superadmin'] == 1) { ?>
					<tr>
						<th>Đổi trạng thái hợp đồng</th>
						<td class="text-right">
							<div class="col-xs-12 col-lg-6">
								<select class="form-control" name="status_contract_convert" id="status_contract_convert">
									<option value="" <?php echo $status == '-' ? 'selected' : '' ?>><?= $this->lang->line('All_status') ?></option>
									<?php foreach (contract_status() as $key => $value) { ?>
										<option <?php echo $contractDB->status == $key ? 'selected' : '' ?>
												value="<?= $key ?>"> <?= $value ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</td>
					</tr>
				<?php } ?>
              </tbody>
            </table>
            <input type="hidden" class="form-control " name="id_contract" value="<?php echo $contractDB->_id->{'$oid'} ?>" readonly>
          	</div>
          </div>

          <div class="col-xs-12  col-md-6">
			  <div class="table-responsive">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <th>Tiền vay</th>
                  <td class="text-right"><?php echo number_format($contractDB->loan_infor->amount_money)?></td>
                </tr>
                <tr>
                  <th>Gốc còn lại</th>
                  <td class="text-right"><?php echo number_format($du_no_goc_con_lai)?></td>
                </tr>
                  <tr>
                  <th>Số tiền cần trả</th>
                  <td class="text-right tong_thanh_toan_top"><?php echo number_format($tong_thanh_toan) ?></td>
                </tr>
                <tr>
                  <th>Tiền đã trả</th>
                  <td class="text-right tong_da_thanh_toan_top"><?php echo number_format($da_thanh_toan)?></td>
                </tr>
               <!--   <tr>
                  <th>Tiền thừa</th>
                  <td class="text-right tong_da_thanh_toan_top"><?php echo number_format($tien_thua_thanh_toan)?></td>
                </tr> -->
                <tr>
                  <th>Tiền còn phải trả</th>
                  <td class="text-right text-danger tong_con_no_top"><?php echo  number_format( $tien_con_no) ?></td>
                </tr>
               
                <tr>
                  <th>Số kỳ chậm trả</th>
                  <td class="text-right text-danger ky_cham_tra_top"><?php echo $contractDB->ky_cham_tra?></td>
                </tr>

                <tr>
                  <th>Tiền chưa trả</th>
                  <td class="text-right total_money_paid_pay_top"><?= number_format($tien_chua_tra_top) ?></td>
                </tr>
                 <tr>
                  <th>Tiền quá hạn</th>
                  <td class="text-right text-danger so_tien_phat_sinh_top"><?php echo number_format($tien_qua_han_top) ?></td>
                </tr>
                <tr>
                  <th>Tiền phạt chậm trả</th>
                  <td class="text-right penalty_top"><?php echo number_format($phat_cham_tra_top); ?></td>
                </tr>
               <?php if($contractDB->status==19)
               { ?>
                <tr>
                  <th>Tiền phạt chậm trả còn lại trước khi tất toán</th>
                  <td class="text-right penalty_top"><?php echo number_format($phiChamTraConLaiTruocTatToan); ?></td>
                </tr>
                <tr>
                  <th>Tiền thừa sau khi tất toán</th>
                  <td class="text-right penalty_top"><?php echo number_format($tien_thua_tat_toan); ?></td>
                </tr>
              <?php } ?>
				<?php if(($contractDB->status == 19 && $tien_thanh_ly_tai_san_dam_bao > 0))
				{ ?>
					<tr>
						<th>Tiền thanh lý tài sản: </th>
						<td class="text-right "><?= !empty($tien_thanh_ly_tai_san_dam_bao) ? number_format($tien_thanh_ly_tai_san_dam_bao) : 0;?></td>
					</tr>
					<tr>
						<th>Chi phí thanh lý tài sản: </th>
						<td class="text-right "><?= !empty($chi_phi_thanh_ly_tai_san) ? number_format($chi_phi_thanh_ly_tai_san) : 0;?></td>
					</tr>
					<tr>
						<th>Tiền chênh lệch: </th>
						<td class="text-right "><?php echo number_format($tien_chenh_lech_thanh_ly); ?></td>
					</tr>
				<?php } ?>
       
          <?php if($contractDB->status==33)
               { ?>
                <tr>
                  <th>Tiền thiếu gia hạn</th>
                  <td class="text-right penalty_top"><?php echo number_format($contractDB->tien_thieu_gia_han); ?></td>
                </tr>
              <?php } ?>

              </tbody>
            </table>
         	 </div>
          </div>
        </div>
