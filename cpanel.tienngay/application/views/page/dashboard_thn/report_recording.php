<?php
$vehicles = !empty($_GET['vehicles']) ? $_GET['vehicles'] : "";
$name_property = !empty($_GET['name_property']) ? $_GET['name_property'] : "";
$get_call = !empty($_GET['get_call']) ? $_GET['get_call'] : "";
$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
$email_thn = !empty($_GET['email_thn']) ? $_GET['email_thn'] : "";
$hangupCause = !empty($_GET['hangupCause']) ? $_GET['hangupCause'] : "";
?>
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="col-xs-12 fix_to_col" id="fix_to_col">
		<div class="table_app_all">
			<div class="top">
				<div class="">
					<div class="col-xs-8">
						<div class="title">
							<span class="tilte_top_tabs" style="color: #035927 !important; font-weight: bold">
								Danh sách cuộc gọi
							</span>
						</div>
					</div>
					<div class="middle table_tabs row" style="width: 100%;display: block;">
						<div class="clicked nav_tabs_vertical">
							<div class="col-xs-10">
								<div class="thongke">
									<div class="col-xs-3 no-pad">
										<label>Không nghe máy</label>
										<div class="discount khongnghe styleType">
											<div class="discount_bg khongnghe" style="width: <?= (!empty($count) && $count != 0 ) ? round((($NO_USER_RESPONSE/$count)*100),2) : 0 ?>%"></div>
											<div class="text-absolute"><?= (!empty($count) && $count != 0 ) ? round((($NO_USER_RESPONSE/$count)*100),2) : 0 ?>%</div>
										</div>
									</div>
									<div class="col-xs-3 no-pad">
										<label>Máy bận</label>
										<div class="discount thuebao styleType">
											<div class="discount_bg thuebao" style="width: <?= (!empty($count) && $count != 0 ) ? round((($USER_BUSY/$count)*100),2) : 0 ?>%"></div>
											<div class="text-absolute"><?= (!empty($count) && $count != 0 ) ? round((($USER_BUSY/$count)*100),2) : 0 ?>%</div>
										</div>
									</div>
									<div class="col-xs-3 no-pad">
										<label>Người gọi dừng</label>
										<div class="discount mayban  styleType">
											<div class="discount_bg mayban" style="width: <?= (!empty($count) && $count != 0 ) ? round((($ORIGINATOR_CANCEL/$count)*100),2) : 0 ?>%"></div>
											<div class="text-absolute"><?= (!empty($count) && $count != 0 ) ? round((($ORIGINATOR_CANCEL/$count)*100),2) : 0 ?>%</div>
										</div>
									</div>
									<div class="col-xs-3 no-pad">
										<label>Nghe máy</label>
										<div class="discount nghemay styleType">
											<div class="discount_bg nghemay" style="width: <?= (!empty($count) && $count != 0 ) ? round((($NORMAL_CLEARING/$count)*100),2) : 0 ?>%"></div>
											<div class="text-absolute"><?= (!empty($count) && $count != 0 ) ? round((($NORMAL_CLEARING/$count)*100),2) : 0 ?>%</div>
										</div>
									</div>
								</div>

							</div>
							<div class="col-xs-2 total">
								Tổng <?= !empty($count) ? number_format($count) : 0 ?> cuộc gọi
							</div>
							<div class="col-xs-8">
								<ul class="nav tabs">

									<li  class="aos-init aos-animate <?= empty($get_call) ? 'in active' : '' ?>" data-aos-delay="1500" data-offset="1500" data-aos-duration="1500" data-aos="fade-right">
										<a href="<?php echo base_url()?>dashboard_thn/index_report_recording"><h3 class="qt_title">Tất cả</h3></a>
									</li>
									<li class="aos-init aos-animate <?= !empty($get_call) && $get_call == 3 ? 'in active' : '' ?>" data-aos-delay="1500" data-offset="1500" data-aos-duration="1700" data-aos="fade-right">
										<a href="<?php echo base_url()?>dashboard_thn/index_report_recording?get_call=3&fdate=<?= $fdate ?>&tdate=<?= $tdate ?>&email_thn=<?= $email_thn ?>&hangupCause=<?= $hangupCause ?>"><h3 class="qt_title">Cuộc gọi 03s - 10s</h3></a>
									</li>
									<li class="aos-init aos-animate <?= !empty($get_call) && $get_call == 10 ? 'in active' : '' ?>" data-aos-delay="1500" data-offset="1500" data-aos-duration="1800" data-aos="fade-right">
										<a href="<?php echo base_url()?>dashboard_thn/index_report_recording?get_call=10&fdate=<?= $fdate ?>&tdate=<?= $tdate ?>&email_thn=<?= $email_thn ?>&hangupCause=<?= $hangupCause ?>"><h3 class="qt_title">Cuộc gọi 10s trở lên</h3></a>
									</li>

								</ul>
							</div>
							<div class="col-xs-4 text-right">
								<button class="show-hide-total-all btn btn-success dropdown-toggle"
										onclick="$('#lockdulieu').toggleClass('show');">
									<span class="fa fa-filter"></span>
									Lọc dữ liệu
								</button>

								<a style="background-color: #035927;"
								   target="_blank"
								   href="<?= base_url() ?>excel/export_recording?fdate=<?= $fdate . '&tdate=' . $tdate. '&get_call=' . $get_call . '&email_thn=' . $email_thn . '&hangupCause=' . $hangupCause  ?>"
								   class="show-hide-total-all btn btn-success dropdown-toggle"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
									Xuất excel</a>


								<form action="<?php echo base_url('dashboard_thn/index_report_recording') ?>" method="get">
									<ul id="lockdulieu" class="dropdown-menu dropdown-menu-right"
										style="padding:15px;min-width:400px;">

										<li class="form-group">
											<div class="row">
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label>Từ:</label>
														<input type="date" name="fdate" class="form-control"
															   value="<?= !empty($fdate) ? $fdate : date('Y-m-01') ?>">
													</div>
												</div>
												<div class="col-xs-12 col-md-6">
													<div class="form-group">
														<label>Đến:</label>
														<input type="date" name="tdate" class="form-control"
															   value="<?= !empty($tdate) ? $tdate : date('Y-m-d') ?>">
													</div>
												</div>
											</div>
											<input type="hidden" value="<?= $get_call ?>" name="get_call">
										</li>

										<li class="form-group">
											<label>Email nhân viên: </label>
											<input type="text" name="email_thn" class="form-control"
												   value="<?= !empty($email_thn) ? $email_thn : "" ?>">
										</li>

										<li class="form-group">
											<label>Trạng thái: </label>
											<select class="form-control" name="hangupCause">
												<option value="">-- Tất cả --</option>
												<option value="NORMAL_CLEARING" <?= !empty($hangupCause) && $hangupCause == "NORMAL_CLEARING" ? "selected" : "" ?> >Nghe máy</option>
												<option value="NO_USER_RESPONSE" <?= !empty($hangupCause) && $hangupCause == "NO_USER_RESPONSE" ? "selected" : "" ?>>Không nghe máy</option>
												<option value="ORIGINATOR_CANCEL" <?= !empty($hangupCause) && $hangupCause == "ORIGINATOR_CANCEL" ? "selected" : "" ?>>Người gọi dừng</option>
												<option value="USER_BUSY" <?= !empty($hangupCause) && $hangupCause == "USER_BUSY" ? "selected" : "" ?> >Máy bận</option>
											</select>
										</li>

										<li class="text-right">
											<button class="btn btn-success" type="submit">
												<i class="fa fa-search" aria-hidden="true"></i>
												Tìm Kiếm
											</button>
										</li>

									</ul>
								</form>
							</div>



							<div class="clear" style="clear: both;">
							</div>
							<div class="tab-contents" style="margin-top: 15px">
								<div class="tab-panel  aos-init aos-animate active" data-aos-delay="1500" data-offset="1500" data-aos-duration="1600" data-aos="fade-up-down">
									<div class="table-responsive">
										<table id="" class="table table-striped">
											<thead>
											<tr style="text-align: center">
												<th style="text-align: center">STT</th>
												<th style="text-align: center">Nhân viên</th>
												<th style="text-align: center">Số điện thoại </th>
												<th style="text-align: center">Thời gian bắt đầu</th>
												<th style="text-align: center">Thời gian kết thúc</th>
												<th style="text-align: center">Thời gian call</th>
												<th style="text-align: center">Trạng thái </th>
											</tr>
											</thead>
											<tbody align="center">
											<?php if(!empty($data_report_thn)): ?>
												<?php foreach ($data_report_thn as $key => $value): ?>
											<tr>
												<td><?= ++$key ?></td>
												<td><?= !empty($value->fromUser->email) ? $value->fromUser->email : "" ?></td>
												<td><span class="text-success"><?= !empty($value->toNumber) ? hide_phone($value->toNumber) : "" ?></span></td>

												<td><?= !empty($value->startTime) ? date('d/m/Y H:i:s', $value->startTime / 1000) : "" ?></td>
												<td><?= !empty($value->endTime) ? date('d/m/Y H:i:s', $value->endTime / 1000) : "" ?></td>
												<td>
													<?= !empty($value->billDuration) ? $value->billDuration : 0 ?>s
												</td>
												<td>
													<?php if (!empty($value->hangupCause)): ?>
														<?php if ($value->hangupCause == "NORMAL_CLEARING"): ?>
															<span class="status nghemay">
															Nghe máy
															</span>
														<?php elseif ($value->hangupCause == "NO_USER_RESPONSE"): ?>
															<span class="status khongnghe">
															Không nghe máy
															</span>
														<?php elseif ($value->hangupCause == "ORIGINATOR_CANCEL"): ?>
															<span class="status nguoigoidung">
															Người gọi dừng
															</span>
														<?php else: ?>
															<span class="status thuebao">
															Máy bận
															</span>
														<?php endif; ?>
													<?php endif; ?>

												</td>
												<?php endforeach; ?>
												<?php endif; ?>
											</tr>



											</tbody>
										</table>
									</div>
									<div class="bottom d_page">
										<div class="row">
											<div class="col-xs-12 text-right">
												<div class="pagination">
													<?php echo $pagination; ?>
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
	</div>
	<style type="text/css">
		.khongnghe{
			background: linear-gradient(0deg, rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0.85)), #CD7B00;
			color: #CD7B00;
		}
		.nghemay{
			background: linear-gradient(0deg, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), #0E9549;
			color: #0E9549;
		}
		.mayban{
			background: #BCD4F0;
			color: #0054B6;
		}
		.thuebao{
			background: #EBD1D1;
			color: #9B1919;
		}
		.nguoigoidung{
			background: #BCD4F0;
			color: #0054B6;
		}
		.styleType{
			padding: 5px 0;
			text-align: center;
			font-weight: 600;
			font-size: 17px;
			position: relative;
			background: #ededed;
			height: 35px;
		}

		.tilte_top_tabs{
			margin-bottom: 20px;
			display: block;
		}
		.tabs{
			margin-top: 15px;
			border: none !important;
		}
		.total{
			font-weight: 600;
			font-size: 17px;
			height: 59px;
			display: flex;
			align-items: center;
			justify-content: flex-end;
		}
		.status{
			padding: 0 3px;
			border-radius: 5px;
			display: block;
		}
		.discount_bg {
			position: absolute;
			height: 100%;
			top: 0;
			left: 0;
		}
		.text-absolute {
			position: absolute;
			left: 0;
			right: 0;
		}
	</style>
