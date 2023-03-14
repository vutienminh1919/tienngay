<!-- page content -->
<div class="right_col" role="main">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";

	
	?>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">

				<div class="row">
					<div class="col-xs-12 col-lg-1">
						<h2>Bảo hiểm</h2>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<span class='div_error'></span>
				</div>

				
				<div class="clearfix"></div>
			</div>
			<div class="x_content">

				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<form class="form-inline" action="<?php echo base_url('kpi/listKPI') ?>"
								  method="get" style="width: 100%">
								<div class="col-xs-12">
									<div class="row">
										
										<div class="col-lg-2">
											<div class="input-group">
												<span class="input-group-addon"><?php echo $this->lang->line('from') ?></span>
												<input type="date" name="fdate" class="form-control"
													   value="<?= !empty($fdate) ? $fdate : "" ?>">
											</div>
										</div>
										<div class="col-lg-2">
											<div class="input-group">
												<span class="input-group-addon"><?php echo $this->lang->line('to') ?></span>
												<input type="date" name="tdate" class="form-control"
													   value="<?= !empty($tdate) ? $tdate : "" ?>">

											</div>
										</div>
										

										<div class="col-lg-2 text-right">
											<button class="btn btn-primary w-100"><i class="fa fa-search"
																					 aria-hidden="true"></i> <?php echo $this->lang->line('search') ?>
											</button>
										</div>
									
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="col-xs-12">
						 <div class="title_right text-right row">
						 
                           <div class="form-group">
						<input type="file" name="upload_file" class="form-control"
										   placeholder="sothing">

								</div>
         				<a class="btn btn-primary" id="import_bao_hiem" >Import excel </a>
                        
                       </div>
                       <a href="<?php echo base_url('assets/mau_import/mau_import_bao_hiem_pgd.xlsx') ?>"> Tải mẫu import</a>
                   </div>
               </div>

                                        
                                    
						<br>
						
								
										<div class="table-responsive">
											<div><?php //echo $result_count; ?></div>
											<table id="datatable-button" class="table table-striped datatablebutton">
												<thead>
												<tr>
													
													<th>Nhân viên</th>
													
													<th class="center">Ngày bán</th>
													<th class="center">Loại bảo hiểm</th>
													<th class="center">Tên khách hàng</th>
													<th class="center">Số tiền</th>
													<th class="center">Ghi chú</th>
													
												</tr>
											
												</thead>

												<tbody>

												<?php
												if (!empty($baohiemData)) {
									foreach ($baohiemData as $key => $baohiem) {
														?>
					<tr>	
					<td >
						<?= !empty($baohiem->name_nv) ? $baohiem->name_nv : '' ?>
						
					</td>
					<td >
						<?= !empty($baohiem->store->name) ? $baohiem->store->name : '' ?>
						
					</td>
					<td >
						<?= !empty($baohiem->loai_bao_hiem) ? $baohiem->loai_bao_hiem : '' ?>
						
					</td>
					<td >
						<?= !empty($baohiem->ten_khach_hang) ? $baohiem->ten_khach_hang : '' ?>
						
					</td>
					<td >
						<?= !empty($baohiem->so_tien) ? $baohiem->so_tien : '' ?>
						
					</td>
					<td >
						<?= !empty($baohiem->ghi_chu) ? $baohiem->ghi_chu : '' ?>
						
					</td>
				    </tr>
														<?php }} ?>
												</tbody>
											</table>
											<div class="pagination pagination-sm">
												<?php echo $pagination ?>
											</div>
										</div>
									
								</div>
								
								


							</div>
						</div>
					</div>
			


	
	
<script src="<?php echo base_url(); ?>assets/js/baohiem_pgd/index.js"></script>
<script type="text/javascript">
	$(document).ready(function () {

		// Show Input element
		$('.edit').click(function () {
			var status = $(this).data('status');
			console.log(status);

			$('.txtedit').hide();
			$(this).next('.txtedit').show().focus();
			$(this).hide();

		});

		// Save data
		$(".txtedit").on('focusout', function () {

			// Get edit id, field name and value
			var id = this.id;
			var split_id = id.split("-");
			var field_name = split_id[0];
			var edit_id = split_id[1];
			var value = $(this).val();

			// Hide Input element
			$(this).hide();

			// Hide and Change Text of the container with input elmeent
			$(this).prev('.edit').show();
			$(this).prev('.edit').text(value);

			// Sending AJAX request
			$.ajax({
				url: _url.base_url + 'kpi/update',
				type: 'post',
				data: {field: field_name, value: value, id: edit_id},
				success: function (response) {
					console.log('Save successfully');
				}
			});

		});

	});
	detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');
</script>
<script>

	$("#import_bao_hiem").click(function (event) {
		event.preventDefault();
		var inputimg = $('input[name=upload_file]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);

		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'bao_hiem_pgd/importBaohiem',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				//console.log(data);
				if (data.res) {

					$('#successModal').modal('show');
					$('.msg_success').text(data.message);
					$(".theloading").hide();
					setTimeout(function () {
						window.location.href = _url.base_url + 'bao_hiem_pgd/listBaohiem';
					}, 3000);
					console.log(data);
				} else {
					console.log(data);
					$("#div_error").css("display", "block");
					$(".div_error").text(data.message);
					window.scrollTo(0, 0);
					setTimeout(function () {
						$("#div_error").css("display", "none");
					}, 3000);
					setTimeout(function () {
						window.location.href = _url.base_url + 'bao_hiem_pgd/listBaohiem';
					}, 1000);
				}
			},
			error: function (data) {
				//console.log(data);
				$(".theloading").hide();


			}
		});

	});
	</script>
<style type="text/css">
	.container {
		margin: 0 auto;
	}


	.edit {
		width: 100%;
		height: 25px;
	}

	.editMode {
		/*border: 1px solid black;*/

	}

	.txtedit {
		display: none;
		width: 99%;
		height: 30px;
	}


	table tr:nth-child(1) th {
		color: white;

	}


</style>
