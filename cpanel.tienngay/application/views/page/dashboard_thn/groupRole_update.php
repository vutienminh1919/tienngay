<!-- page content -->
<div class="right_col" role="main">
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<h3>Cập nhật nhóm quyền
				</h3>
			</div>
		</div>
		<br>&nbsp;
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="row">
						<div class="col-xs-12 col-lg-11">
							<div class="row">
								<div class="col-lg-3">
									<input id="role_id" class="form-control" type="hidden" value="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>">
									<input id="role_name" class="form-control" type="text" value="<?= !empty($role->name) ? $role->name : ""?>">
								</div>
								<div class="col-lg-2">
										<select class="form-control" id="role_code">
											<option value="Role Trưởng Phòng" <?= !empty($role->role_code) && $role->role_code == "Role Trưởng Phòng"  ? 'selected' : ""?> >Role Trưởng Phòng</option>
											<option value="Role Lead" <?= !empty($role->role_code) && $role->role_code == "Role Lead"  ? 'selected' : ""?> >Role Lead</option>
											<option value="Role Nhân Viên" <?= !empty($role->role_code) && $role->role_code == "Role Nhân Viên"  ? 'selected' : ""?> >Role Nhân Viên</option>
										</select>
								</div>
								<div class="col-lg-2">
										<select class="form-control" id="role_area">
											<option value="" >Tất cả</option>
											<option value="Miền Bắc" <?= !empty($role->role_area) && $role->role_area == "Miền Bắc"  ? 'selected' : ""?>>Miền Bắc</option>
											<option value="Miền Nam" <?= !empty($role->role_area) && $role->role_area == "Miền Nam"  ? 'selected' : ""?> >Miền Nam</option>
										</select>
								</div>
								<div class="col-lg-2">
										<select class="form-control" id="role_function">
											<option value="" >Tất cả</option>
											<option value="Call" <?= !empty($role->role_function) && $role->role_function == "Call"  ? 'selected' : ""?> >Call</option>
											<option value="Field" <?= !empty($role->role_function) && $role->role_function == "Field"  ? 'selected' : ""?> >Field</option>
										</select>
								</div>

								<div class="col-lg-2 text-right">
									<button class="btn btn-primary w-100 btn-update-group-role"><i class="fa fa-plus" aria-hidden="true"></i> Cập nhật</button>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="row">
						<div class="col-xs-12">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul class="nav nav-tabs bar_tabs" role="tablist">
									<li role="presentation" class="active">
										<a href="#tab_user" id="tab_user_nav" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
											User</a>
									</li>
								</ul>
								<div class="tab-content">
									<?php $this->load->view("web/role/tab_user", $role)?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

	function showModalUser(thiz) {
		//Get user selected
		var userids = [];
		if($("#tbl_user tbody").find("tr").length > 0) {
			$("#tbl_user tbody").find("tr").each(function() {
				var userId = $(this).find("#user_id").val();
				userids.push(userId);
			});
		}

		$.ajax({
			method: "POST",
			url: _url.get_user_in_role,
			data: {
				user_ids: JSON.stringify(userids)
			},
			success: function(data) {
				$("#tbl_modal_user").DataTable().destroy();
				$('#tbl_modal_user').DataTable({
					"info": false,
					data: data.data,
					columns: [
						{ data: 'id', visible: false },
						{ data: 'email' },
						/* CHECKBOX */
						{
							mRender: function (data, type, row) {
								return '<input type="checkbox" class="check_id_user" name="check_id_user" value="' + row.id + '" >'
							}
						}
					]
				});
			},
			error: function(error) {
				console.log(error);
			}
		});
		$("#modal_select_user").modal("show");
	}

	function saveModalUser(thiz) {
		var arrUsers = [];
		$('#tbl_modal_user').DataTable().rows().iterator('row', function(context, index){
			var section = {};
			// haveDivSection = true;
			var id = $(this.row(index).data())[0].id;
			var node = $(this.row(index).node());
			var isChecked = $(node).closest("tr").find("input[type='checkbox']"). prop("checked");
			if(isChecked) {
				var des = $(node).closest("tr").find("td").html();
				section['id'] = id;
				section['email'] = des;
				arrUsers.push(section);
			}
		});
		//Init data for tables
		var temp = "";
		if(arrUsers.length > 0) {
			for(var i=0; i < arrUsers.length; i++) {
				temp += "<tr>";
				temp += "<input type='hidden' id='email' value='"+arrUsers[i].email+"'>";
				temp += "<input type='hidden' id='user_id' value='"+arrUsers[i].id+"'>";
				temp += "<td>"+arrUsers[i].email+"</td>";
				temp += "<td><a onclick='remove(this)' class='close-link' data-user-id='"+arrUsers[i].id+"'><i class='fa fa-close'></i></a></td>";
				temp += "</tr>";
			}
			//Append HTML
			$("#tbl_user tbody").append(temp);
		}
		$("#modal_select_user").modal("hide");
	}

	function remove(thiz) {
		$(thiz).closest("tr").remove();
	}


	$(".btn-update-group-role").on("click", function() {
		//Get user
		var users = getDataUser();
		$.ajax({
			method: "POST",
			url: _url.base_url + 'dashboard_thn/update',
			data: {
				role_id: $("#role_id").val(),
				role_name: $("#role_name").val(),
				role_code: $("#role_code").val(),
				role_area: $("#role_area").val(),
				role_function: $("#role_function").val(),
				users: JSON.stringify(users),
			},
			success: function(data) {
				if(data.code != '200') {
					alert(data.message);
				} else {
					window.location.href = _url.base_url + 'dashboard_thn/index_groupRole_thn'
				}

			},
			error: function(error) {

			}
		});
	});

	function getDataUser() {
		var arr = [];
		$("#tbl_user tbody").find("tr").each(function() {
			var data = {};
			var id = $(this).find("#user_id").val();
			var email = $(this).find("#email").val();
			var infor = {};
			infor.email = email;
			data[id] = infor;
			arr.push(data);
		});
		return arr;
	}



</script>
