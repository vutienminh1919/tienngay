<!-- page content -->
<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<div class="right_col" role="main">
   
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title">
                <div class="title_left">
                    <h3>Quản lý phí mới
                        <br>
                       <small>
                       <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#">Quản lý phí</a> 
                       </small>
                   </h3>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <table  id="datatable-button"  class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên gói</th>
                                         <th>Từ ngày</th>
                                       <th>Đến ngày</th>
                                         <th>Ngày cập nhật</th>
                                         <th>Người cập nhật</th>
                                         <th class="text-right">Trạng thái</th>
                                        <th class="text-right">Chi tiết</th>
                                    </tr>
                                </thead>
                <tbody>
                        <?php
                            $dataUpdate = array();
                            $dataUpdate['stringColumn'] = $columnFeeLoans;
                            //var_dump($dataFee);die;
                            if(!empty($dataFee)){
                                $key = 0;
                                foreach($dataFee as $item){
                            ?>
                        <tr>
                            <td><?php echo $key+1?></td>
                            <td><?= $item->title?></td>
             <td><?=(!empty($item->from)) ? date('d/m/Y', $item->from) : '' ;?></td>
              <td><?=(!empty($item->to)) ? date('d/m/Y', $item->to) : '' ;?></td>
               <td><?=(!empty($item->updated_at)) ? date('d/m/Y', $item->updated_at) : '' ;?></td>
              <td><?=(!empty($item->updated_by)) ? $item->updated_by : '' ;?></td>
                          <td>
                  <center><input disabled class='aiz_switchery' type="checkbox" data-set='status'
                        data-id="<?php echo $item->_id->{'$oid'} ?>" data-main="<?=(!empty($item->main)) ? $item->main : '' ;?>"
                    <?php    $status =  !empty($item->status) ?  $item->status : "";
                     echo ($status=='active') ? 'checked' : '';  ?>
                                     /></center>
                       </td>
                    <td class="sorting_1">

						<?php

						$dataUpdate['columnFeeLoans'] = $item;
						$dataUpdate['groupRoles'] = $groupRoles;
						?>
						<?php if( $item->type != 'bieu-phi-nha-dat' ) { ?>
                        <button class="btn btn-primary text-right" style="float: right;" data-toggle="modal" data-target="#modal_update_<?= getId($item->_id)?>">
                           Sửa biểu phí
                        </button>
							<?php
							$this->load->view("web/feeloan_new/popup_update.php", $dataUpdate);
							?>
						<?php } else { ?>
							<button class="btn btn-primary text-right" style="float: right;" data-toggle="modal" data-target="#modal_update_estate_<?= getId($item->_id)?>">
								Sửa biểu phí
							</button>
							<?php
							$this->load->view("web/feeloan_new/popup_update_estate.php", $dataUpdate);
							?>
						<?php } ?>
                    </td>

                        </tr>
                      
                        <?php $key++;}} ?>
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
<?php 
    $dataCreate['columnFeeLoansCreate'] = $columnFeeLoans;
//    $this->load->view("web/feeloan_new/popup_create.php", $dataCreate);
    //$this->load->view("web/feeloan_new/popup_update.php", $data);
?>
<script src="<?= base_url("assets")?>/js/feeloan_new/index.js"></script>
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
            var main = $(this).data('main');
           
            changeCheckbox.onchange = function () {
                $.ajax({url: _url.base_url +'feeLoanNew/doUpdateStatus?id='+id+'&status='+ changeCheckbox.checked+'&main='+ main,
                    success: function (result) {
                        console.log(result.res);
                     if(result.res)
                     {
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
                    }else{
                        alert(result.message);
                        window.location.reload();
                    }
                    }
                });
            };
        });
    }
    });
</script>
