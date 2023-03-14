<div class="right_col" role="main" style="min-height: 1160px;">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>Thiết lập nhóm quyền team QUẢN LÝ HỢP ĐỒNG VAY
					<br>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<a target="_blank" class="btn btn-success" href="<?= base_url("dashboard_thn/displayCreate")?>">Thêm mới nhóm quyền</a>
					<div class="x_title">

						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table id="datatable-buttons" class="table table-striped">
							<thead>
							<tr>
								<th>Name</th>
								<th style="width: 17%;">Action</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach($groupRoles->data as $role) { ?>
								<tr>
									<td><?= !empty($role->name) ? $role->name : ""?></td>
									<td class="text-right">
										<a target="_blank" class="btn btn-primary"  href='<?= base_url("dashboard_thn/displayUpdate?id=").getId($role->_id)?>' >
											<i class="fa fa-edit"></i> Edit
										</a>
										<button class="btn btn-danger mr-0 btn-delete" data-id="<?= getId($role->_id)?>">
											<i class="fa fa-close"></i> Delete
										</button>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(".btn-delete").on("click", function() {
		var r = confirm("Are you sure want to delete ?");
		if (r == true) {
			var id = $(this).data("id");
			$.ajax({
				method: "POST",
				url: _url.base_url + 'dashboard_thn/delete',
				data:{id:id},
				success: function(data) {
					if(data.code != 200) {
						alert(data.message);
					} else {
						window.location.reload();
					}
				},
				error: function(error) {
					console.log(error);
				}
			});
		}
	});
</script>
