<link href="<?php echo base_url();?>assets/js/switchery/switchery.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3>Danh sách lịch sử gửi email
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Danh sách lịch sử gửi email</a>
            </small>
          </h3>
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
                       <th>Status</th>
                      <th>Code</th>
                      <th>Tên</th>
                      <th>From</th>
                      <th>From name</th>
                      <th>Subject</th>
                      <th>Message</th>
                      <th>Ngày tạo</th>
                     
                      
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($email_historyData)) {
                        $stt = 0;
                        foreach($email_historyData as $key => $email_history){
                       
                            $stt++;

                    ?>
                    <tr class='email_history_<?= !empty($email_history->_id->{'$oid'}) ? $email_history->_id->{'$oid'} : "" ?>'>
                      <td><?php echo $stt ?></td>
                     <td>
                        <center><input class='aiz_switchery' type="checkbox"
                                    data-set='status'
                                        data-id=<?php echo $email_history->_id->{'$oid'} ?>
                                    <?php    $status =  !empty($email_history->status) ?  $email_history->status : "";
                            echo ($status=='active') ? 'checked' : '';  ?>
                                                     /></center>
                      </td>
                      <td><?= !empty($email_history->code) ?  $email_history->code : ""?></td>
                      <td><?= !empty($email_history->code_name) ?  $email_history->code_name : ""?></td>
                      <td><?= !empty($email_history->from) ?  $email_history->from : ""?></td>
                      <td><?= !empty($email_history->from_name) ? $email_history->from_name : ""?></td>
                      <td><?= !empty($email_history->subject) ? $email_history->subject : ""?></td>
                      <td><?= !empty($email_history->message) ? $email_history->message : ""?></td>
                     
                      <td><?= !empty($email_history->created_at) ?   date('m/d/Y H:i:s', $email_history->created_at): ""?></td>

                    </tr>
                  <?php } }?>

                </tbody>
              </table>
            </div>
				<div class="">
					<?php echo $pagination ?>
				</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/email_history/index.js"></script>
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
                $.ajax({url: _url.base_url +'email_history/doUpdateStatusEmail_template?id='+id+'&status='+ changeCheckbox.checked,
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
