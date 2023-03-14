<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">

<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none" >
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span >Đang Xử lý...</span>
	</div>
	<div class="row top_tiles">
		<?php
		$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
		$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";

		?>
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Danh sách HĐ bảo hiểm VBI
						<br>
						<small>
							<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Danh sách HĐ bảo hiểm VBI</a>
						</small>
					</h3>

				</div>

			</div>
		</div>

		<?php
		function get_tt_gic($id)
		{
			switch ($id) {
				case '4e9eb09f-2834-409f-a987-9928d4d8eac9':
					return "Đã đính kèm chứng từ";
					break;
				case '566e72ce-fb1a-456e-b337-b968ae47f0cc':
					return  "Đã duyệt";
					break;
				case '30fe988b-0e95-4ae9-a5cb-2cf3214f97e0':
					return  "Hoàn tất";
					break;
				case 'acc31454-af61-4896-b9a6-7d79ac8f9e37':
					return  "Tạo mới";
					break;
				case '817eaae4-46e3-41f9-befb-ac52c3c01933':
					return  "Chấm dứt hợp đồng";
					break;
				case 'c2105d39-f3bd-4932-98d8-7c5766a96bb9':
					return  "Từ chối duyệt";
					break;
				case '7c666d28-765d-413a-ab8e-6c39e937ea72':
					return  "Thanh toán đủ";
					break;
				case '93fbe0b2-1bab-4915-84bf-4abdca935952':
					return  "Thanh toán 1 phần";
					break;
				case '2f77342d-ddc2-4194-8b2a-48068237a5c2':
					return  "Hết hiệu lực";
					break;
			}
		}
		function get_tt_contract($id)
		{
			switch ($id) {
				case '1':
					return "Mới";
					break;
				case '2':
					return  "Chờ phòng giao dịch mới";
					break;
				case '3':
					return  "Đã hủy";
					break;
				case '4':
					return  "Trưởng PGD không duyệt";
					break;
				case '5':
					return  "Chờ hội sở duyệt";
					break;
				case '6':
					return "Đã duyệt";
					break;
				case '7':
					return  "Kế toán không duyệt";
					break;
				case '15':
					return  "Chờ giải ngân";
					break;
				case '16':
					return  "Đã tạo lệnh giải ngân thành công";
					break;
				case '17':
					return  "Đang vay";
					break;
				case '18':
					return "Giải ngân thất bại";
					break;
				case '19':
					return  "Đã tất toán";
					break;
				case '20':
					return  "Đã quá hạn";
					break;
				case '21':
					return  "Chờ hội sở duyệt gia hạn";
					break;
				case '22':
					return  "Chờ kế toán duyệt gia hạn";
					break;
				case '23':
					return  "Đã gia hạn";
					break;
				case '24':
					return  "Chờ kế toán xác nhận";
					break;
			}
		}
		function get_product($id)
		{
			switch ($id) {
				case 'd518454e-9cd9-4409-b5ba-6b9d0810fb4d':
					return "Bảo hiểm khoản vay(VFC)";
					break;
				case '2':
					return  "Đã nhập kho";
					break;
				case '3':
					return "Cần xuất kho";
					break;
				case '4':
					return  "Đã xuất kho";
					break;
			}
		}
		?>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">

					<div class="row">
						<div class="col-xs-12 col-lg-12">
							<div class="row">
								<form action="<?php echo base_url('vbi/listVbi')?>" method="get" style="width: 100%;">
									<div class="col-lg-3">
										<label></label>
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
											<input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate : ""?>">
										</div>
									</div>
									<div class="col-lg-3">
										<label></label>
										<div class="input-group">
											<span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
											<input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : ""?>">
										</div>
									</div>

									<div class="col-lg-2 text-right">
										<label></label>
										<button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</button>
									</div>
									<div class="col-lg-2 text-right">
										<label></label>
										<a style="background-color: #18d102;" href="<?=base_url()?>excel/excel_vbi_ungthuvu?fdate=<?=$fdate.'&tdate='.$tdate?>" class="btn btn-primary w-100" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất excel UTV</a>
									</div>
									<div class="col-lg-2 text-right">
										<label></label>
										<a style="background-color: #18d102;" href="<?=base_url()?>excel/excel_vbi_sotxuathuyet?fdate=<?=$fdate.'&tdate='.$tdate?>" class="btn btn-primary w-100" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất excel SXH</a>
									</div>

								</form>
							</div>

						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<span class='div_error'></span>
							</div>
							<div class="table-responsive">
								<div ><?php echo $result_count;?></div>
								<table id="datatable-button" class="table table-striped">
									<thead>
									<tr>
										<th>#</th>
										<th>Mã hợp đồng</th>
										<th>Mã Phiếu ghi</th>
										<th>Người được BH</th>

										<th>Số tiền vay</th>
										<th>Tổng Phí bảo hiểm</th>
										<th>Gói bảo hiểm VBI 1</th>
										<th>Phí gói 1</th>
										<th>Gói bảo hiểm VBI 2</th>
										<th>Phí gói 2</th>
										<th>Ngày tạo</th>
										<th>Người tạo</th>
										<th>Trạng thái</th>
										<?php if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('ke-toan', $groupRoles)) : ?>
										<th>Chặn bảo hiểm</th>
										<?php endif; ?>
										<th><?php echo $this->lang->line('Function')?></th>
									</tr>
									</thead>

									<tbody>
									<?php
									if(!empty($vbiData)) {
										$stt = 0;
										foreach($vbiData as $key => $vbi){

											if($vbi->status != 'block'){
												$stt++;
//												$gic_info=$gic->gic_info;
												$contract_info=$vbi->contract_info;
												?>
												<tr class='gic_<?= !empty($vbi->_id->{'$oid'}) ? $vbi->_id->{'$oid'} : "" ?>'>
													<td><?php echo $stt ?></td>
													<td><?= !empty($vbi->contract_info->code_contract_disbursement) ?  $vbi->contract_info->code_contract_disbursement : ""?> </td>
													<td><?= !empty($vbi->code_contract) ?  $vbi->code_contract : ""?> </td>

													<td>
														<?= !empty($vbi->contract_info->customer_infor->customer_name) ?  $vbi->contract_info->customer_infor->customer_name : ""?><br>
														<?= !empty($vbi->contract_info->customer_infor->customer_BOD) ?  $vbi->contract_info->customer_infor->customer_BOD : ""?><br>
														<?= !empty($vbi->contract_info->customer_infor->customer_email) ?  $vbi->contract_info->customer_infor->customer_email : ""?><br>
														<?= !empty($vbi->contract_info->customer_infor->customer_phone_number) ?  $vbi->contract_info->customer_infor->customer_phone_number : ""?>
													</td>

													<td>

														<?= !empty($vbi->contract_info->loan_infor->amount_loan) ?  number_format($vbi->contract_info->loan_infor->amount_loan) : ""?>


													</td>

													<td>

														<?= !empty($vbi->contract_info->loan_infor->amount_VBI) ?  number_format($vbi->contract_info->loan_infor->amount_VBI) : ""?>


													</td>
													<td><?= !empty($vbi->contract_info->loan_infor->code_VBI_1) ?  $vbi->contract_info->loan_infor->code_VBI_1 : ""?></td>
													<td><?= !empty($vbi->contract_info->loan_infor->amount_code_VBI_1) ?  number_format($vbi->contract_info->loan_infor->amount_code_VBI_1) : ""?></td>
													<td><?= !empty($vbi->contract_info->loan_infor->code_VBI_2) ?  $vbi->contract_info->loan_infor->code_VBI_2 : ""?></td>
													<td><?= !empty($vbi->contract_info->loan_infor->amount_code_VBI_2) ?  number_format($vbi->contract_info->loan_infor->amount_code_VBI_2) : ""?></td>
													<td><?= !empty($vbi->created_at) ?   date('m/d/Y H:i:s', $vbi->created_at): ""?></td>
													<td><?= !empty($vbi->contract_info->created_by) ?   $vbi->contract_info->created_by: ""?></td>

                                                      <td> 
         <?php if($userSession['is_superadmin'] == 1 && $vbi->status_vbi == '1'){ ?>
            Thất bại
         <?php if($vbi->created_at >strtotime('2021-07-01') ) { ?>
            <a href="javascript:void(0)" onclick="restore_vbi('<?= $vbi->contract_id ?>')" class="btn btn-info btn-sm ">
              Gửi lại
            </a>
        <?php } ?>
          
        <?php }else if($vbi->status_vbi == 'active'){ 
          echo "Hoàn thành"; 
        }else if($vbi->status_vbi == 'delete'){
          echo "Đã xóa"; } ?>
          <br>  
        </td>
												<?php if ($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('ke-toan', $groupRoles)) : ?>
													<td><?= !empty($contract_info->chan_bao_hiem) ? prevent_insurance($contract_info->chan_bao_hiem) : ""?></td>
												<?php endif; ?>
													<td>
                        <span class="dtr-data">
               <a class="btn btn-primary" target="_blank"  href="<?php echo base_url("/pawn/detail?id=").$vbi->contract_id?>" >
                 Chi tiết
              </a>

                   </span>
													</td>
													<!-- Modal HTML -->
													<div id="detele_<?php echo $vbi->_id->{'$oid'}?>" class="modal fade">
														<div class="modal-dialog modal-confirm">
															<div class="modal-content">
																<div class="modal-header">
																	<div class="icon-box danger">
																		<!-- <i class="fa fa-times"></i> -->
																		<i class="fa fa-exclamation" aria-hidden="true"></i>
																	</div>

																	<h4 class="modal-title"><?php echo $this->lang->line('title_delete')?>?</h4>
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																</div>
																<div class="modal-body">
																	<p><?php echo $this->lang->line('body_modal_delete')?></p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-info" data-dismiss="modal"><?php echo $this->lang->line('cancel')?></button>
																
																</div>
															</div>
														</div>
													</div>

												</tr>
											<?php } }}?>

									</tbody>
								</table>
								<div class="">
									<?php echo $pagination ?>
								</div>

							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

</div>

<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/gic/index.js"></script>
<script src="<?php echo base_url();?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/activeit.min.js"></script>

<style type="text/css">
	.w-25 {
		width: 8%!important;
	}
</style>

<script>

function restore_vbi(id){
    event.preventDefault();
   
    let urlSubmit = _url.base_url + 'vbi/restore_vbi';
    var formData = {
        id_contract: id
    };
    $.ajax({
        url :  urlSubmit,
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
            $(".theloading").hide();
            if (data.code == 200) {
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                setTimeout(function(){ 
                    window.location.href =  _url.base_url + "vbi/listVbi";
                }, 2000);
            } else {
                $("#errorModal").modal("show");
                $(".msg_error").text(data.msg);
                $(".disbursement").hide();
                $(".disbursement_disabled").show();
                setTimeout(function(){ 
                    window.location.href =  _url.base_url + "vbi/listVbi";
                }, 2000);
            }
        },
        error: function(data) {
            $(".theloading").hide();
            console.log(data);
            $("#loading").hide();
        }
    });
 
}


</script>
