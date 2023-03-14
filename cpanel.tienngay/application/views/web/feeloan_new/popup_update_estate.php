<?php
	$able_edit = false;
	if(in_array('phat-trien-san-pham', $groupRoles)) {
		$able_edit = true;
	}
?>

<div id="modal_update_estate_<?= getId($columnFeeLoans->_id)?>" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sửa biểu phí nhà đất</h4>
            </div>
            <div class="modal-body">
                <div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">Title : </div>
								<input type="text" id="title" class="form-control" value="<?= $columnFeeLoans->title?>" <?= !$able_edit ? "disabled" : "" ?>>
							</div>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">From : </div>
								<input type="date" id="from" class="form-control" value="<?= $this->time_model->convertTimestampToDatetime_($columnFeeLoans->from)?>" <?= !$able_edit ? "disabled" : "" ?>>
							</div>
						</div>
					</div>
					  <div class="col-xs-3">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">To : </div>
                                <input type="date" id="to" class="form-control" value="<?= $this->time_model->convertTimestampToDatetime_($columnFeeLoans->to)?>" >
                            </div>
                        </div>
                    </div>

					<?php
						foreach($columnFeeLoans->infor as $key=>$value) {
							if ( is_string($value) ) {
								$title = '';
								switch ($key) {
									case "percent_prepay_phase_1":
										$title = "KH trả trước 1/3 thời hạn vay";
										break;
									case "percent_prepay_phase_2":
										$title = "KH trả trước 2/3 thời hạn vay";
										break;
									case "percent_prepay_phase_3":
										$title = "Khách hàng trả trước trong các trường hợp còn lại";
										break;
									case "extend":
										$title = "Phí tư vấn gia hạn số tiền vay";
										break;
									case "penalty_percent":
										$title = "% Phí quản lý số tiền vay chậm trả";
										break;
									case "penalty_amount":
										$title = "Số tiền quản lý số tiền vay chậm trả";
										break;
									case "extend_new_five":
										$title = "% phí tư vấn gia hạn từ 6 tháng trở lên";
										break;
									case "extend_new_three":
										$title = "% phí tư vấn gia hạn 6 tháng trở xuống";
										break;
									default:
										$title = '';
										break;
								}
					?>
							<div class="col-xs-12">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon"><?= $title ?></div>
										<input type="text" value="<?= $value?>" name="<?= $key?>" data-name="<?= $key?>" class="form-control number" <?= !$able_edit ? "disabled" : "" ?>>
									</div>
								</div>
							</div>
							<?php } ?>

					<?php }?>
                    <div class="col-xs-12">
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <?php foreach($columnFeeLoans->infor as $key=>$value) {
									if ( !is_string($value) ) {
										switch ($key) {
											case "100":
												$text = "=<100";
												break;
											case "100-200":
												$text = "100-200";
												break;
											case "200":
												$text = ">200";
												break;
											default:
												$text = '';
												break;
 										}
								?>

									<li name="li_day" data-day="<?= $key?>" role="presentation" class="<?= $key == '100' ? "active" : ""?>">
										<a href="#day_<?= $key ?>" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">
											Số tiền giải ngân <?= $text ?> triệu đồng
										</a>
									</li>
                                <?php }}?>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <?php foreach($columnFeeLoans->infor as $key=>$value) {
									if ( !is_string($value) ) {
								?>
									<div role="tabpanel" name="div_type_<?= $key?>" class="tab-pane fade <?= $key == '100' ? "active in" : ""?>" id="day_<?= $key ?>" aria-labelledby="home-tab">

										<div class="row">
											<?php foreach($value as $keyType=>$valType) {
												switch ($keyType) {
													case "percent_interest_customer":
														$title = "Lãi suất phải thu của người vay";
														break;
													case "percent_advisory":
														$title = "Phí tư vấn quản lý";
														break;
													case "percent_expertise":
														$title = "Phí thẩm định và lưu trữ tài sản đảm bảo";
														break;
													default:
														$title = '';
														break;
												}
												?>
												<div class="col-xs-12">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon"><?= $title ?></div>
															<input type="text" value="<?= $valType?>" name="<?= $keyType?>" data-name="<?= $keyType?>" class="form-control number" <?= !$able_edit ? "disabled" : "" ?>>
														</div>
													</div>
												</div>
											<?php }?>
										</div>
									</div>
								<?php }} ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <?php if(in_array('phat-trien-san-pham', $groupRoles)) { ?>
                <button type="button" class="btn btn-primary btn-estate" data-modal-id="modal_update_estate_<?= getId($columnFeeLoans->_id)?>" data-id="<?= getId($columnFeeLoans->_id)?>" data-url="<?= base_url("feeLoanNew/update")?>">Cập nhật</button>
                <?php }?>
            </div>
        </div>
    </div>
</div>
