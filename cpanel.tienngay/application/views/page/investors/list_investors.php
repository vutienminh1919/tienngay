<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3><?php echo $this->lang->line('investors_list')?>
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#"><?php echo $this->lang->line('investors_list')?></a>
            </small>
          </h3>
        </div>
        <div class="title_right text-right">
          <a href="<?php echo base_url("investors/createinvestors")?>" class="btn btn-info " ><i class="fa fa-plus" aria-hidden="true"></i> <?php echo $this->lang->line('create_investors')?></a>
        </div>
      </div>
    </div>

    <?php 
    function get_type($id_type)
    {
      switch ($id_type) {
        case '1':
        return "Tiền mặt";
             break;
        case '2':
        return  "Chuyển khoản";
           break;
    }

    }
    ?>
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
                      <th><?php echo $this->lang->line('code')?></th>
                      <th><?php echo $this->lang->line('name')?></th>
                      <th><?php echo $this->lang->line('dentity_card')?></th>
                      <th><?php echo $this->lang->line('balance')?></th>
                      <th><?php echo $this->lang->line('info')?></th>
                      <th><?php echo $this->lang->line('bank')?></th>
                      <th><?php echo $this->lang->line('percent_interest_investor')?></th>
                      <th><?php echo $this->lang->line('updated_date')?></th>
                      <th><?php echo $this->lang->line('status')?></th>
                      <th><?php echo $this->lang->line('Function')?></th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($investorsData)) {
                        $stt = 0;
                        foreach($investorsData as $key => $investors){
                            if($investors->status != 'block'){
                            $stt++;

                    ?>
                    <tr class='investors_<?= !empty($investors->_id->{'$oid'}) ? $investors->_id->{'$oid'} : "" ?>'>
                      <td><?php echo $stt ?></td>
  
                    <td><?= !empty($investors->code) ?  $investors->code : ""?></td>
                    <td><?= !empty($investors->name) ?  $investors->name : ""?></td>
                      <td class="float-left">
                        CMND: <b><?= !empty($investors->dentity_card) ?  $investors->dentity_card : ""?></b></br>
                        MST: <b><?= !empty($investors->tax_code) ?  $investors->tax_code : ""?> </b></br>
                      </td>
                      <td><?= !empty($investors->balance) ?  number_format($investors->balance) : ""?></td>
                     <td>
                        Ngày sinh: <b><?= !empty($investors->date_of_birth) ? DateTime::createFromFormat('Y-m-d',  $investors->date_of_birth )->format('d-m-Y'): ""?></b></br>
                        Địa chỉ: <b><?= !empty($investors->address) ?  $investors->address : ""?></b></br>
                        Email: <b><?= !empty($investors->email) ?  $investors->email : ""?></b></br>
                      </td>
                       <td><?= !empty($investors->bank) ?  $investors->bank : ""?></td>
                      <td><?= !empty($investors->form_of_receipt) ?  $investors->form_of_receipt : ""?></td>
                      <td><?= !empty($investors->updated_at) ?   date('d/m/Y H:i:s', $investors->updated_at): ""?></td>
                      <td>
                        <center><input class='aiz_switchery'  type="checkbox"
                                    data-set='status'
                                        data-id=<?php echo $investors->_id->{'$oid'} ?>
                                    <?php    $status =  !empty($investors->status) ?  $investors->status : "";
                            echo ($status=='active') ? 'checked' : '';  ?> /></center>
                      </td>
                      <td>
						  <a class="btn btn-primary"  href="<?php echo base_url("investors/update?id=").$investors->_id->{'$oid'}?>">
							  <i class="fa fa-edit"></i> Chi tiết
						  </a>
						  <a class="btn btn-danger mr-0 btn-delete" href="<?php echo base_url("investors/view_detail?id=").$investors->_id->{'$oid'}?>"  >
							  <i class="fa fa-eye"></i> Xem hợp đồng
						  </a>
                      </td>
                      <!-- Modal HTML -->
                        <div id="detele_<?php echo $investors->_id->{'$oid'}?>" class="modal fade">
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
                                <!--     <button type="button" data-id="<?= !empty($investors->_id->{'$oid'}) ? $investors->_id->{'$oid'} : ""?>" class="btn btn-success delete_investors" data-dismiss="modal"><?php echo $this->lang->line('ok')?></button> -->
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
<script src="<?php echo base_url();?>assets/js/investors/index.js"></script>
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
                $.ajax({url: _url.base_url +'investors/doUpdateStatusInvestors?id='+id+'&status='+ changeCheckbox.checked,
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