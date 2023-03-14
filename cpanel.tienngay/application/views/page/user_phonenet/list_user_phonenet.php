<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3><?php  echo $this->lang->line('user_phonenet_list')?>
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#"><?php echo $this->lang->line('user_phonenet_list')?></a>
            </small>
          </h3>
        </div>
        <div class="title_right text-right">
          <a href="<?php echo base_url("user_phonenet/createuser_phonenet")?>" class="btn btn-info " ><i class="fa fa-plus" aria-hidden="true"></i> <?php echo $this->lang->line('create_user_phonenet')?></a>
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
                      <th>Nhân viên</th>
                      <th>Số máy lẻ</th>
                   <th>Ngày tạo</th>
                   <th>Trạng thái</th>
                      <th><?php echo $this->lang->line('Function')?></th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($user_phonenetData)) {
                      $stt = 0;

                        foreach($user_phonenetData as $key => $user_phonenet){
                            $stt++;
                       

                    ?>
                    <tr class='user_phonenet_<?= !empty($user_phonenet->_id->{'$oid'}) ? $user_phonenet->_id->{'$oid'} : "" ?>'>
                      <td><?=$stt?></td>
                      <td><?= !empty($user_phonenet->email_user) ?  $user_phonenet->email_user : ""?></td>
                       <td><?= !empty($user_phonenet->extension_number) ?  $user_phonenet->extension_number : ""?></td>
                     
                      <td><?= !empty($user_phonenet->updated_at) ?   date('m/d/Y H:i:s', $user_phonenet->updated_at): ""?></td>
                       <td>
                        <center><input class='aiz_switchery' type="checkbox"
                                    data-set='status'
                                        data-id=<?php echo $user_phonenet->_id->{'$oid'} ?>
                                    <?php    $status =  !empty($user_phonenet->status) ?  $user_phonenet->status : "";
                            echo ($status=='active') ? 'checked' : '';  ?>
                                                     /></center>
                      

                      
                      </td>
                      <td>
		 <a class="btn btn-primary"  href="<?php echo base_url("user_phonenet/update?id=").$user_phonenet->_id->{'$oid'}?>">
							  <i class="fa fa-edit"></i> Sửa
						  </a> 
					
                      </td>
                  
                    </tr>
                  <?php }}?>

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
</div>
<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/user_phonenet/index.js"></script>
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
                $.ajax({url: _url.base_url +'user_phonenet/doUpdateStatusUser_phonenet?id='+id+'&status='+ changeCheckbox.checked,
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