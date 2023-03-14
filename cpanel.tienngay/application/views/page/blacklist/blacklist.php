<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<div class="right_col" role="main">
	<div class="theloading" style="display:none" >
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span ><?= $this->lang->line('Loading')?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Blacklist
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Blacklist</a></small>
					</h3>
				</div>
                <div class="title_right text-right">

                    <?php
                    if($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('hoi-so', $groupRoles))  {?>
                        <a href="<?php echo base_url("BlackList/upload_blacklist")?>" class="btn btn-info " ><i class="fa fa-plus" aria-hidden="true"></i> <?= $this->lang->line('create')?></a>
                    <?php }?>

                </div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="x_panel">
			<div class="x_content">
				<?php if ($this->session->flashdata('success')) { ?>
					<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
				<?php } ?>
				<div class="table-responsive">
					<table id="datatable-buttons" class="table table-striped dataTable no-footer dtr-inline" style="white-space: normal">
						<thead>
						<tr>
							<th>#</th>
							<th>Chức năng</th>
							<th>Hình ảnh</th>
							<th>Tên</th>
							<th>Số ĐT</th>
							<th>Số CMTND</th>
							<th>Ghi chú</th>
							<th>Trạng thái</th>
						</tr>
						</thead>

						<tbody>
						<?php
						if(!empty($blacklist)) {
						$stt = 0;
						foreach($blacklist as $key => $value){
						if($value->status != 'block'){
						$stt++;

						?>
						<tr>
							<td><?php echo $stt ?></td>
                            <td>
                                <?php
                                if(($userSession['is_superadmin'] == 1 || in_array('van-hanh', $groupRoles) || in_array('hoi-so', $groupRoles)))  {?>
                                     <button id="btnEditBlacklist" class="btn btn-info btnEditBlacklist" data-id="<?php echo $value->_id->{'$oid'} ?>"><i class="fa fa-edit" aria-hidden="true"></i> Sửa</button> 
                                     <button class="btn btn-danger" 
                                             data-toggle="modal" 
                                             data-target="#deleteModal" 
                                             data-name="<?php echo $value->name ?>" 
                                             data-id_img_cvs="<?php echo $value->id_img_cvs ?>" 
                                             data-id="<?php echo $value->_id->{'$oid'} ?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Xóa
                                     </button> 
                                <?php }?>
                            </td>
							<td><img style="width: 150px" src="<?php echo !empty($value->image) ? $value->image : '' ?>"></td>
							<td><?php echo !empty($value->name) ? $value->name : '' ?></td>
							<td><?php echo !empty($value->phone) ? $value->phone : '' ?></td>
							<td><?php echo !empty($value->identify) ? $value->identify : '' ?></td>
							<td><?php echo !empty($value->note) ? $value->note : '' ?></td>
							<td>
								<center><input class='aiz_switchery' type="checkbox"
											   data-set='status'
											   data-id=<?php echo $value->id_img_cvs ?>
											   <?php    $status =  !empty($value->status) ?  $value->status : "";
											   echo ($status=='active') ? 'checked' : '';  ?>
									/></center>
							</td>
						</tr>
						<?php } ?>
						<?php } ?>
						<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
    <!-- Modal -->
    <div class="modal fade" id="blacklistModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cập nhật blacklist</h4>
                </div>
                <form id="formUpdate" action="<?php echo base_url('BlackList/updateBlacklist') ?>" enctype="multipart/form-data" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="dashboarditem_line2">
                                    <div class="panel panel-default">
                                        <input type='file' name="image" id="imageBlackList">
                                        <img id="imgBlackList" style="width: 200px" src="<?php echo base_url(); ?>assets/imgs/default_image.png" alt="your image" />
                                        <div class="form-group">
                                            <label for="nameBlacklist">Tên</label>
                                            <input type="text" class="form-control" name="name" id="nameBlacklist">
                                        </div>
                                        <div class="form-group">
                                            <label for="phoneBlackList">Số điện thoại</label>
                                            <input type="text" class="form-control" name="phone" id="phoneBlackList">
                                        </div>
                                        <div class="form-group">
                                            <label for="identifyBlackList">Số CMTND</label>
                                            <input type="text" class="form-control" name="identify" id="identifyBlackList">
                                        </div>
                                        <div class="form-group">
                                            <label for="noteBlackList">Ghi chú</label>
                                            <textarea class="form-control" id="noteBlackList" name="note" rows="3"></textarea>
                                        </div>
                                        <input type="text" name="url_image" id="urlImgBlackList" hidden>
                                        <input type="text" name="id_img_cvs" id="id_img_cvs" hidden>
                                        <input type="text" name="id" id="blacklistId" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" id="btnUpdateBlacklist" type="button" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Xóa blacklist</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 id="deleteTitle">Bạn có chắc muốn xóa blacklist?</h3>
                            <div class="align-content-center clearfix">
                                <button type="button" data-dismiss="modal" class="btn btn-info">Hủy</button>
                                <button id="btnDeleteBlacklist" type="button" class="btn btn-danger">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

<script src="<?php echo base_url();?>assets/js/pawn/index.js"></script>
<script src="<?php echo base_url();?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/activeit.min.js"></script>
<script>
	$(document).ready(function () {

      $('.btnEditBlacklist').on('click', function (event){
          var data = $(this).data();
          console.log(data);
        $.ajax({
          dataType:'json',
          url: _url.base_url + 'blackList/getBlacklistById',
          type: 'POST',
          data: data,
          success: function (res){
            // console.log(res);
            if (res.status == 200) {
              let data = res.data;
              // console.log(data);
              $("#blacklistModal").modal('show');
              $("#nameBlacklist").val(data.name);
              $("#phoneBlackList").val(data.phone);
              $("#identifyBlackList").val(data.identify);
              $("#noteBlackList").val(data.note);
              $("#urlImgBlackList").val(data.image);
              $("#imgBlackList").attr({src: data.image});
              $("#id_img_cvs").val(data.id_img_cvs);
              $("#blacklistId").val(data._id.$oid);
              
            } else {
              $(".alert-danger").text('Vui lòng thử lại!');
            }
          }
        });
      });

      //set data for delete modal
      $('#deleteModal').on('show.bs.modal', function (event) {
        var data = $(event.relatedTarget).data();
        // console.log(data);
        $('#btnDeleteBlacklist').data("id",data.id);
        $('#btnDeleteBlacklist').data("id_img_cvs",data.id_img_cvs);
        $('#deleteTitle').html("Bạn có muốn xóa "+data.name+" khỏi blacklist?");
      })

      $('#btnDeleteBlacklist').on('click', function (event){
        var data = $(this).data();
        // console.log(data);
        $.ajax({
          dataType:'json',
          url: _url.base_url + 'blackList/deleteBlacklist',
          type: 'POST',
          data: data,
          success: function (res){
            console.log(res);
            if (res.status == 200) {
              $(".alert-success").text('Xóa thành công!');
            } else {
              $(".alert-danger").text('Vui lòng thử lại!');
            }
            $("#deleteModal").modal('hide');
            window.location.reload();
          },
          error: function(error) {
            // console.log(error);
            $("#deleteModal").modal('hide');
            $(".alert-danger").text('Vui lòng thử lại!');
            window.location.reload();
          }
        });
      });

      $('#formUpdate').on('submit', function (event){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        console.log(form);
        $.ajax({
          dataType:'json',
          url: url,
          type: 'POST',
          data: form.serialize(),
          success: function (res){
            // console.log(res);
            if (res.status == 200) {
              let data = res.data;
              $("#blacklistModal").modal('show');
              $("#nameBlacklist").val(data.name);
              $("#phoneBlackList").val(data.phone);
              $("#identifyBlackList").val(data.identify);
              $("#noteBlackList").val(data.note);
            } else {
              $(".alert-danger").text('Vui lòng thử lại!');
            }
          }
        });
      });
	  
		set_switchery();
		function set_switchery() {
			$(".aiz_switchery").each(function () {
				new Switchery($(this).get(0), {
					color: 'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'});
				var changeCheckbox = $(this).get(0);
				var id = $(this).data('id');
				changeCheckbox.onchange = function () {
					$.ajax({url: _url.base_url +'blackList/doUpdateStatusBlacklist?id='+id+'&status='+ changeCheckbox.checked,
						success: function (result) {
							console.log(result);
							if (changeCheckbox.checked == true) {
								$.activeitNoty({
									type: 'success',
									icon: 'fa fa-check',
									message: result.message ,
									container: 'floating',
									timer: 3000
								});

							} else {
								$.activeitNoty({
									type: 'danger',
									icon: 'fa fa-check',
									message: result.message,
									container: 'floating',
									timer: 3000
								});

							}
						}
					});
				};
			});
		}
	});
</script>
