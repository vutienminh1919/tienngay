<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3><?php  echo $this->lang->line('email_template_list')?>
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#"><?php echo $this->lang->line('email_template_list')?></a>
            </small>
          </h3>
        </div>
        <div class="title_right text-right">
          <a href="<?php echo base_url("email_template/createemail_template")?>" class="btn btn-info " ><i class="fa fa-plus" aria-hidden="true"></i> <?php echo $this->lang->line('create_email_template')?></a>
        </div>
      </div>
    </div>

    <?php function get_type($id_type)
    {
      switch ($id_type) {
        case '1':
        return "Sản phẩm/ Dịch vụ";
             break;
        case '2':
        return  "Về khoản vay";
           break;
        case '3':
          return "Thanh toán khoản vay";
           break;
    }

    }
    if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">
          <div class="row">
            <div class="col-xs-12">

              <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Code</th>
                      <th>Tên</th>
                      <th>From</th>
                      <th>From name</th>
                      <th>Subject</th>
                      <th>Message</th>
                      <th>Ngày cập nhật</th>
                      <th>Status</th>
                      <th><?php echo $this->lang->line('Function')?></th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($email_templateData)) {
                        $stt = 0;
                        foreach($email_templateData as $key => $email_template){
                       
                            $stt++;

                    ?>
                    <tr class='email_template_<?= !empty($email_template->_id->{'$oid'}) ? $email_template->_id->{'$oid'} : "" ?>'>
                      <td><?php echo $stt ?></td>
                     <td>
                        <center><input class='aiz_switchery' type="checkbox"
                                    data-set='status'
                                        data-id=<?php echo $email_template->_id->{'$oid'} ?>
                                    <?php    $status =  !empty($email_template->status) ?  $email_template->status : "";
                            echo ($status=='active') ? 'checked' : '';  ?>
                                                     /></center>
                      

                      
                      </td>
                      <td><?= !empty($email_template->code) ?  $email_template->code : ""?></td>
                      <td><?= !empty($email_template->code_name) ?  $email_template->code_name : ""?></td>
                      <td><?= !empty($email_template->from) ?  $email_template->from : ""?></td>
                      <td><?= !empty($email_template->from_name) ? $email_template->from_name : ""?></td>
                      <td><?= !empty($email_template->subject) ? $email_template->subject : ""?></td>
                      <td><?= !empty($email_template->message) ? $email_template->message : ""?></td>
                     
                      <td><?= !empty($email_template->updated_at) ?   date('m/d/Y H:i:s', $email_template->updated_at): ""?></td>
                      
                      <td>
						  <a class="btn btn-primary"  href="<?php echo base_url("email_template/update?id=").$email_template->_id->{'$oid'}?>">
							  <i class="fa fa-edit"></i> Sửa
						  </a>
					<!-- 	  <a class="btn btn-danger mr-0 btn-delete" href="javascript:void(0);"  data-toggle="modal" data-target="#detele_<?php echo $email_template->_id->{'$oid'}?>">
							  <i class="fa fa-close"></i> Xóa
						  </a> -->
                      </td>
                      <!-- Modal HTML -->
                        <div id="detele_<?php echo $email_template->_id->{'$oid'}?>" class="modal fade">
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
                                        <!-- <button type="button" class="btn btn-danger">Danger</button> -->
                                <!--     <button type="button" data-id="<?= !empty($email_template->_id->{'$oid'}) ? $email_template->_id->{'$oid'} : ""?>" class="btn btn-success delete_email_template" data-dismiss="modal"><?php echo $this->lang->line('ok')?></button> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </tr>
                  <?php } }?>

                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/email_template/index.js"></script>
<script src="<?php echo base_url();?>assets/js/switchery/switchery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/activeit.min.js"></script>

<style type="text/css">
  .w-25 {
    width: 8%!important;
}
</style>
<script>
	$(document).ready(function () {
   set_switchery();
    function set_switchery() {
        $(".aiz_switchery").each(function () {
            new Switchery($(this).get(0), {
                color: 'rgb(100, 189, 99)', secondaryColor: '#cc2424', jackSecondaryColor: '#c8ff77'});
            var changeCheckbox = $(this).get(0);
            var id = $(this).data('id');
           
            changeCheckbox.onchange = function () {
                $.ajax({url: _url.base_url +'email_template/doUpdateStatusEmail_template?id='+id+'&status='+ changeCheckbox.checked,
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
