<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3><?php  
           echo $this->lang->line('coupon_list')?>
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#"><?php echo $this->lang->line('coupon_list')?></a>
            </small>
          </h3>
        </div>
        <div class="title_right text-right">
          <a href="<?php echo base_url("coupon/createcoupon")?>" class="btn btn-info " ><i class="fa fa-plus" aria-hidden="true"></i> <?php echo $this->lang->line('create_coupon')?></a>
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
                    
                      <th>Ngày bắt đầu</th>
                      <th>Ngày kết thúc</th>
                      <th>Ngày tạo</th>
                      <th>Trạng thái </th>
                      <th><?php echo $this->lang->line('Function')?></th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($couponData)) {
                        $stt = 0;
                        foreach($couponData as $key => $coupon){
                            if($coupon->status != 'block'){
                            $stt++;

                    ?>
                    <tr class='coupon_<?= !empty($coupon->_id->{'$oid'}) ? $coupon->_id->{'$oid'} : "" ?>'>
                      <td><?php echo $stt ?></td>
  
                      <td><?= !empty($coupon->code) ?  $coupon->code : ""?></td>
                   
                        <td><?= !empty($coupon->start_date) ? date('m/d/Y H:i:s', $coupon->start_date ) : ""?></td>
                          <td><?= !empty($coupon->end_date) ? date('m/d/Y H:i:s', $coupon->end_date) : ""?></td>
                      <td><?= !empty($coupon->updated_at) ?   date('m/d/Y H:i:s', $coupon->updated_at): ""?></td>
                      <td>
                        <center><input class='aiz_switchery' type="checkbox"
                                    data-set='status'
                                        data-id=<?php echo $coupon->_id->{'$oid'} ?>
                                    <?php    $status =  !empty($coupon->status) ?  $coupon->status : "";
                            echo ($status=='active') ? 'checked' : '';  ?>
                                                     /></center>
                      

                      
                      </td>
                      <td>
						  <a class="btn btn-primary"  href="<?php echo base_url("coupon/update?id=").$coupon->_id->{'$oid'}?>">
							  <i class="fa fa-edit"></i> Sửa
						  </a>
					<!-- 	  <a class="btn btn-danger mr-0 btn-delete" href="javascript:void(0);"  data-toggle="modal" data-target="#detele_<?php echo $coupon->_id->{'$oid'}?>">
							  <i class="fa fa-close"></i> Xóa
						  </a> -->
                      </td>
                      <!-- Modal HTML -->
                        <div id="detele_<?php echo $coupon->_id->{'$oid'}?>" class="modal fade">
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
                                <!--     <button type="button" data-id="<?= !empty($coupon->_id->{'$oid'}) ? $coupon->_id->{'$oid'} : ""?>" class="btn btn-success delete_coupon" data-dismiss="modal"><?php echo $this->lang->line('ok')?></button> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </tr>
                  <?php } }}?>

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
<script src="<?php echo base_url();?>assets/js/coupon/index.js"></script>
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
                $.ajax({url: _url.base_url +'coupon/doUpdateStatusCoupon?id='+id+'&status='+ changeCheckbox.checked,
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