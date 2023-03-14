<!-- page content -->
<div class="right_col" role="main">

	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<h3>Loại hình sản phẩm
					<br>
					<small>
						<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Loại hình sản phẩm</a>
					</small>
				</h3>
			</div>
		</div>
		<div class="col-xs-12">
			<?php if ($this->session->flashdata('error')) { ?>
				<div class="alert alert-danger alert-result">
					<?= $this->session->flashdata('error') ?>
				</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')) { ?>
				<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
			<?php } ?>
		</div>
		<br>
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-md-6 col-lg-4">
					<div class="x_panel">
						<form class="form-horizontal form-label-left" action="<?php echo base_url("WebsiteCTVTienNgay/createProductType")?>" method="post">
							<div class="x_title">
								<h2>Thêm mới loại hình sản phẩm</h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<div class="form-group">
									<label for="first-name">Loaị hình<span class="red">*</span>
									</label>
									<div >
										<input type="text" name = 'name_product_type' required class="form-control col-md-7 col-xs-12" placeholder="VD: Khoản vay, Bảo hiểm">
									</div>
									<label for="first-name"><?= $this->lang->line('Code')?>
									</label>
									<div >
										<input type="text" name = 'code_product_type' class="form-control col-md-7 col-xs-12" placeholder="VD: KV, BH">
									</div>
								</div>
								<div class="form-group">
									<label>Loại hình sản phẩm cha</label>
									<div >
										<select id="parent_package_create" name="parent_property" class="form-control">
											<option value=""><?= $this->lang->line('none')?></option>
											<?php
											function showCategories1($mainPropertyData, $parent_id = "", $char = "") {
												foreach($mainPropertyData  as $item){
													if($item->status != 'block'){
														if ($item->parent_id == $parent_id) {
															echo '<option value="'.getId($item->_id).'">';
															echo $char . $item->name;
															echo '</option>';
															// Tiếp tục đệ quy để tìm con của item đang lặp
															showCategories1($mainPropertyData, getId($item->_id), $char.' - ');
														}
													}
												}
											}
											showCategories1($mainPropertyData);
											?>
										</select>
									</div>
								</div>

<!--								<div id="addForm" class="form-group">-->
<!--									<div>-->
<!--										<button type="button" class="btn btn-info properties"><i class="fa fa-plus"></i>Thêm mới loại hình</button>-->
<!--									</div>-->
<!--								</div>-->
								<div id="add_properties">

								</div>

								<div id="productPricing" class="form-group" style="display:none">
									<div>
										<button type="button" class="btn btn-info product_pricing"><i class="fa fa-plus"></i><?= $this->lang->line('Add_depreciation')?></button>
									</div>
								</div>
								<div id="add_product_pricing">
								</div>

								<button type="submit" class="btn btn-primary btn-add-new-menu">Thêm mới loại hình</button>
							</div>
						</form>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-8">
					<div class="x_panel">
						<div class="x_content">
							<!-- <table class="table table-striped"> -->
							<table id="datatable-buttons" class="table table-striped">
								<thead>
								<tr>
									<th><?= $this->lang->line('asset_name')?></th>
									<th><?= $this->lang->line('appraise1')?></th>
									<!-- <th>Descriptions</th> -->
									<th class="text-right"><?= $this->lang->line('Manipulation')?></th>
								</tr>
								</thead>
								<tbody>
								<?php
								function showCategoriesTable($mainPropertyData, $parent_id = "", $char = "") {
									foreach ($mainPropertyData as $item) {
										if($item->status != 'block'){
											if ($item->parent_id == $parent_id) {

												?>
												<tr class='property_main_<?= getId($item->_id)?>'>
													<td><?= $char.$item->name?></td>
													<td><?= !empty($item->price) ? number_format(trim((int)$item->price))." vnđ" : ""?></td>
													<!--  <td><?= !empty($item->description) ? $item->description : ""?></td> -->
													<td class="text-right">

														<a  class="btn btn-primary"  href="<?php echo base_url("WebsiteCTVTienNgay/update?id=").getId($item->_id)?>">
															<i class="fa fa-edit"></i> <span>Sửa</span>
															<!-- <i class="fa fa-edit"></i> Sửa -->
														</a>
														<!-- <button class="btn btn-danger mr-0 btn-delete" data-id="<?= getId($item->_id)?>">
                                                                <i class="fa fa-close"></i> Delete
                                                            </button> -->
														<a href="javascript:void(0);"  class="btn btn-danger mr-0 " data-toggle="modal" data-target="#detele_<?= getId($item->_id)?>">
															<i class="fa fa-close"></i> <span>Xóa</span>
														</a>
													</td>
												</tr>
												<!--Modal-->
												<!-- Modal HTML -->
												<div id="detele_<?= getId($item->_id)?>" class="modal fade">
													<div class="modal-dialog modal-confirm">
														<div class="modal-content">
															<div class="modal-header">
																<div class="icon-box danger">
																	<!-- <i class="fa fa-times"></i> -->
																	<i class="fa fa-exclamation" aria-hidden="true"></i>
																</div>

																<h4 class="modal-title">Xác nhận xóa</h4>
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															</div>
															<div class="modal-body">
																<!-- <p>Do you really want to delete these records? This process cannot be undone.</p> -->
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-info" data-dismiss="modal">Hủy</button>
																<!-- <button type="button" class="btn btn-danger">Danger</button> -->
																<button type="button" data-id="<?= getId($item->_id)?>" class="btn btn-success delete_main_property" data-dismiss="modal">Đồng ý</button>
															</div>
														</div>
													</div>
												</div>
												<?php showCategoriesTable($mainPropertyData, getId($item->_id), $char.' - ');}}}}?>
								<?php showCategoriesTable($mainPropertyData);?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

<script src="<?php echo base_url();?>assets/js/website_ctv/index.js"></script>
<script type="text/javascript">
	var select =  $('#parent_package_create').selectize({
		create: false,
		valueField: '_id',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		},
		onChange: function(value) {
			if(value.length == 0) {
				$('#addForm').show();
				$('#add_properties').show();
			} else {
				$('#addForm').hide();
				$('#add_properties').hide();
				$('#productPricing').show();
			}
		}
	});
</script>
