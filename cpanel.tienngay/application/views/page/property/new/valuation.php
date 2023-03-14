<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
		 <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>
	</div>
	<div class="col-xs-12 fix_to_col" id="fix_to_col">
		<div class="table_app_all">
			<div class="top">
				<div class="row">
					<div class="col-xs-8">
						<div class="title">
							<span class="tilte_top_tabs">
								Định giá tài sản theo yêu cầu
							</span>

						</div>
					</div>
					<div class="col-xs-4 text-right">
					</div>
				</div>
			</div>
			<div class="middle table_tabs">
				<div class="clicked nav_tabs_vertical nav tabs">

				</div>

				<div class="tab-contents">
					<!-- tab valuation-->
					<div role="tabpanel" class="tab-pane fade in"
						 id="dinh-gia-tai-san"
						 aria-labelledby="khau-hao-tab">
							<div class="row">
								<div class="col-md-6 col-sx-12 text-left btn_list_filter">

								</div>
								<div class="col-md-6 col-sx-12 btn_list_filter text-right">
									<div class="button_functions btn-fitler">
										<a class="btn btn-success" href="<?= base_url('property/request_valuation_property')?>" <?= in_array('bo-phan-dinh-gia', $groupRoles) ? 'style="display:none"' : '' ?>>Thêm mới</a>
										<div class="button_functions btn-fitler">
											<button class="btn btn-secondary btn-success dropdown-toggle" type="button">
												Tìm kiếm  <i class="fa fa-filter"></i>
											</button>
											<div class="dropdown-menu drop_select">
												<select id="sellect-Range" class="limit_on_page" name="type">
													<option value="" selected="">Loại xe</option>
													<option value="XM">Xe Máy</option>
													<option value="OTO">Ô Tô</option>
												</select>
												<input id="nam_san_xuat_tai_san" class="limit_on_page"
													   name="nam_san_xuat_tai_san" type="number"
													   placeholder="năm sản xuất">
												<input id="hang_xe" class="limit_on_page"
													   name="hang_xe" type="text"
													   placeholder="Hãng xe tài sản">
												<input id="ten_tai_san" class="limit_on_page"
													   name="ten_tai_san" type="text"
													   placeholder="Tên tài sản">
												<button type="button" class="btn btn-outline-success"
														id="search">
													Tìm kiếm
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="table-responsive">
								<div>
									<h3>Danh sách tài sản yêu cầu </h3>
									<h4 class="text-success">Hiển thị (<span
												class="text-danger"><?php echo !empty($total_rows) ? $total_rows : 0 ?></span>)
										kết quả</h4>
								</div>
								<hr>
								<table id="" class="table table-striped">
									<thead>
									<tr style="text-align: center">
										<th style="text-align: center">STT</th>
										<th style="text-align: center">Hình thức</th>
										<th style="text-align: center">Tên tài sản </th>
										<th style="text-align: center">Người yêu cầu</th>
										<th style="text-align: center">Trạng thái</th>
										<th style="text-align: center">Chức năng</th>
									</tr>
									</thead>
									<tbody align="center">
									<?php if(!empty($property_valuation)) : ?>
									<?php foreach ($property_valuation as $key => $value) : ?>
										<tr>
											<td><?php echo ++$key ?></td>
											<td><?php echo $value->type == 'XM' ? '<i class="fa fa-motorcycle "></i>' : '<i class="fa fa-car"></i>' ?></td>
											<td><?php echo $value->str_name ?></td>
											<td><?php echo $value->created_by ?></td>
											<?php if ($value->status_valuation == 3) : ?>
												<td><span class="label "
														  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #009cfb">Đã duyệt</span>
												</td>
											<?php elseif ($value->status_valuation == 1) : ?>
												<td><span class="label "
														  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #0ed311">Đang chờ định giá</span>
												</td>
											<?php elseif ($value->status_valuation == 2) : ?>
												<td><span class="label "
														  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #ff5900">Đang chờ duyệt</span>
												</td>
											<?php elseif ($value->status_valuation == 4) : ?>
												<td><span class="label "
														  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #c227ec">Trả về</span>
												</td>
											<?php elseif ($value->status_valuation == 6) : ?>
												<td><span class="label "
														  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #e80404">Hủy duyệt</span>
												</td>
											<?php elseif ($value->status_valuation == 5 ) : ?>
												<td><span class="label "
														  style="font-size: 15px; background-color: #c6e1ee; padding: 7px; color: #3309cc">Hủy định giá</span>
												</td>
											<?php endif; ?>
											<td>
												<a target="_blank"
												   href="<?php echo base_url('property/detail_valuation_property?id=' . $value->_id->{'$oid'}) ?>"
												   type="button" class="btn btn-primary"
												   data-id="<?= $value->_id->{'$oid'} ?>">
													Chi tiết
												</a>
											</td>
										</tr>
									<?php endforeach; ?>
									<?php endif; ?>
									</tbody>
								</table>
							</div>
							<div>
								<nav class="text-right">
									<?php echo $pagination; ?>
								</nav>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	.btn-fitler .dropdown-menu {
		left:-230px;
		width:auto;
		padding:10px;
</style>

<script src="<?php echo base_url("assets/") ?>js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets/") ?>js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/property/new/index.js"></script>
<script>
	 $(document).ready(function () {
		 $('.btn-fitler button.btn-success').on('click', function () {
			 $('.drop_select').toggle();
		 });
		 $('#search').click(function (){
			 let type = $("select[name='type']").val()
			 let year = $("input[name='nam_san_xuat_tai_san']").val()
			 let hang_xe = $("input[name='hang_xe']").val()
			 let ten_tai_san = $("input[name='ten_tai_san']").val()
			 let hang_xe_upper = hang_xe.charAt(0).toUpperCase() + hang_xe.slice(1);
			 console.log(type,year,hang_xe,ten_tai_san)
			 window.location.href = _url.base_url + "property/valuation_property?type=" + type + "&nam_san_xuat=" + year + "&hang_xe=" + hang_xe_upper + "&ten_tai_san=" + ten_tai_san
		 })
	 });
</script>
