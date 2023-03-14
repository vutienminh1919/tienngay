<!-- page content -->
<?php
  $type = !empty($_GET['type']) ? $_GET['type'] : "";
  $id = !empty($_GET['id']) ? $_GET['id'] : "";
  $tab = !empty($_GET['tab']) ? $_GET['tab'] : "1";
$display_image = $this->config->item("display_img");

?>
<div class="right_col" role="main">
  <div class="theloading" id="loading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span ><?= $this->lang->line('Loading')?>...</span>
  </div>
  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>
          Chi tiết kỳ trả lãi <br>
          <small>
        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('accountant')?>">Quản lý hợp đồng đang vay</a> / <a href="#">Chi tiết kỳ trả lãi</a>
      </small>
        </h3>
      </div>

    </div>
  </div>
  <div class="col-xs-12">
    <div class="x_panel">
      <div class="x_content">
        <?php $this->load->view('page/accountant/top_view_detail');?>

        <br>

        <div class="" role="tabpanel" data-example-id="togglable-tabs">
          <ul id="myTab" class="nav nav-pills" role="tablist">
            <li role="presentation" class="<?php if($type !=1) echo "active"?>"><a href="#tab_content1" id="tab001" role="tab" data-toggle="tab" aria-expanded="true">Chi tiết kỳ thanh toán</a>
            </li>
           <!--  <li role="presentation" class=""><a href="#tab_content2" role="tab" id="tab002" data-toggle="tab" aria-expanded="false">Thông tin khách hàng</a>
            </li> -->
       <!--  <li role="presentation" class=""><a href="#tab_content4" role="tab" id="tab004" data-toggle="tab" aria-expanded="false">Lịch sử trả </a>
        </li> -->
        <?php  if($contractDB->status != 33 && $contractDB->status != 34 && $contractDB->status != 19 && $contractDB->status != 40){
                ?>
            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="tab003" data-toggle="tab" aria-expanded="false">Thanh toán</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content5" role="tab" id="tab005" data-toggle="tab" aria-expanded="false">Tất toán</a>
            </li>
          <?php }  ?>
               <li role="presentation" class=""><a href="#tab_content8" role="tab" id="tab008" data-toggle="tab" aria-expanded="false">Chi tiết hợp đồng</a>

            </li>
            <!--<li role="presentation" class=""><a href="#tab_content6" role="tab" id="tab006" data-toggle="tab" aria-expanded="false">Gia hạn</a>
            </li>-->
            <!--  <li ><a target="_blank" href="<?php echo base_url()?>pawn/viewImageAccuracy?id=<?=$id?>"  id="tab007" >Chứng từ</a>
           </li> -->
            <!--  <li role="presentation" class=""><a href="#tab_content9" role="tab" id="tab009" data-toggle="tab" aria-expanded="false">Lịch sử xét duyệt</a>
            </li> -->
			  <?php if ($display_image) : ?>
				  <li role="presentation" class=""><a href="#tab_content10" role="tab" id="tab010" data-toggle="tab" aria-expanded="false">Lịch sử tác động</a>

				  </li>
			  <?php endif;?>
            <?php
            if(!empty($contractData)){
              $last_key = count($contractData);
              foreach($contractData as $key => $contract){
                $current_day = strtotime(date('m/d/Y'));
                $datetime = strtotime(date('m/d/Y'));
                if ($key == $last_key-1) {
                  $datetime = !empty($contract->ngay_ky_tra) ? intval($contract->ngay_ky_tra): $current_day;
                }
                if($current_day > $datetime && ($contractDB->status == 25)){
                ?>
                  <li role="presentation" class="<?php if($type == "1") echo "active"?>"><a href="#tab_content6" role="tab" id="tab006" data-toggle="tab" aria-expanded="false">Gia hạn</a>
                  </li>
            <?php }}} ?>
<!--			  View Tất toán HĐ có tài sản thanh lý-->
			  <?php  if($contractDB->status == 40){ ?>
				  <li role="presentation" class=""><a href="#tab_content14" role="tab" id="tab014"
													  data-toggle="tab" aria-expanded="false">Tất toán (tài sản đảm bảo đã thanh lý)</a>
				  </li>
			  <?php }  ?>
			  <!-- View upload đơn miễn giảm 61371d2a5324a775ef2a8783 => Quyền tạo đơn miễn giảm khối KD -->
			  <?php if (in_array("61371d2a5324a775ef2a8783", $userRoles->role_access_rights)) { ?>
			  <?php if (isset($exemption_contract) && !in_array($exemption_contract->status,[2,3,8,9]) || $contractDB->status == 19) { ?>
				  <li role="presentation" class="d-none"><a href="#tab_content_create_exemption_contract"
															role="tab"
															id="tab_create_exemption_contract"
															data-toggle="tab" aria-expanded="false">Upload đơn miễn giảm</a>
				  </li>
			  <?php } else if (in_array($exemption_contract->status,[2,3,8,9])) { ?>
				  <li role="presentation" class=""><a href="#tab_content_update_exemption_contract"
													  role="tab"
													  id="tab_update_exemption_contract"
													  data-toggle="tab"
													  aria-expanded="false">Cập nhập đơn miễn giảm</a>
				  </li>
			  <?php } else { ?>
				  <li role="presentation" class=""><a href="#tab_content_create_exemption_contract"
													  role="tab"
													  id="tab_create_exemption_contract"
													  data-toggle="tab"
													  aria-expanded="false">Upload đơn miễn giảm</a>
				  </li>
			  <?php } } ?>
			 <?php if ($display_image) : ;?>
			  <?php if (!empty($exemption_contract_all)) { ?>
				  <li role="presentation" class=""><a href="#tab_content_history_exemption_contract"
													  role="tab"
													  id="tab_history_exemption_contract"
													  data-toggle="tab" aria-expanded="false">Thông tin miễn giảm</a>
				  </li>
			  <?php } ?>
			 <?php else: ;?>
			  	<?php if (!$isTransactionExemptionsApproved) : ;?>
					 <?php if (!empty($exemption_contract_all)) { ?>
						 <li role="presentation" class=""><a href="#tab_content_history_exemption_contract"
															 role="tab"
															 id="tab_history_exemption_contract"
															 data-toggle="tab" aria-expanded="false">Thông tin miễn giảm</a>
						 </li>
					 <?php } ?>
				<?php endif;?>
			  <?php endif;?>
          </ul>
          <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade <?php if($type !=1) echo "active in"?> " id="tab_content1" aria-labelledby="tab001">
              <?php $this->load->view('page/accountant/debt_detail_tab001');?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="tab002">
        <?php $this->load->view('page/accountant/debt_detail_tab002');?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="tab003">
        <?php $this->load->view('page/accountant/thn/debt_detail_tab003');?>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="tab005">
        <?php $this->load->view('page/accountant/thn/debt_detail_tab005');?>
            </div>
            <div role="tabpanel" class="tab-pane fade <?php if($type == "1") echo "active in"?>" id="tab_content6" aria-labelledby="tab006">
        <?php $this->load->view('page/accountant/debt_detail_tab006');?>
            </div>

               <div role="tabpanel" class="tab-pane fade" id="tab_content8" aria-labelledby="tab008">
        <?php $this->load->view('page/accountant/debt_detail_tab008');?>
            </div>
               <div role="tabpanel" class="tab-pane fade" id="tab_content9" aria-labelledby="tab009">
        <?php $this->load->view('page/accountant/debt_detail_tab009');?>
            </div>
			  <?php if ($display_image) : ?>
				  <div role="tabpanel" class="tab-pane fade" id="tab_content10" aria-labelledby="tab010">
					  <?php $this->load->view('page/accountant/debt_detail_tab010');?>
				  </div>
			  <?php endif ;?>

			  <!-- View upload đơn miễn giảm -->
			  
			 
			 
          <?php if (in_array("61371d2a5324a775ef2a8783", $userRoles->role_access_rights)) { ?>
        <?php if (isset($exemption_contract) && !in_array($exemption_contract->status,[2,3,8,9]) || $contractDB->status == 19) { ?>
         <div role="tabpanel" class="tab-pane fade d-none" id="tab_content_create_exemption_contract" aria-labelledby="tab_create_exemption_contract">
          <?php $this->load->view('page/accountant/thn/create_exemption_contract'); ?>
        </div>
        <?php } else if (in_array($exemption_contract->status,[2,3,8,9])) { ?>
          <div role="tabpanel" class="tab-pane fade" id="tab_content_update_exemption_contract" aria-labelledby="tab_update_exemption_contract">
          <?php $this->load->view('page/accountant/thn/update_exemption_contract'); ?>
        </div>
        <?php } else { ?>
          <div role="tabpanel" class="tab-pane fade" id="tab_content_create_exemption_contract" aria-labelledby="tab_create_exemption_contract">
          <?php $this->load->view('page/accountant/thn/create_exemption_contract'); ?>
        </div>
        <?php } } ?>
	<?php if ($display_image) : ;?>
        <?php if (!empty($exemption_contract_all)) { ?>
         <div role="tabpanel" class="tab-pane fade" id="tab_content_history_exemption_contract" aria-labelledby="tab_history_exemption_contract">
          <?php $this->load->view('page/accountant/thn/histories_exemption_contract.php'); ?>
        </div>
        <?php } ?>
	<?php else: ;?>
		<?php if (!$isTransactionExemptionsApproved) : ;?>
			<?php if (!empty($exemption_contract_all)) { ?>
				<div role="tabpanel" class="tab-pane fade" id="tab_content_history_exemption_contract" aria-labelledby="tab_history_exemption_contract">
					<?php $this->load->view('page/accountant/thn/histories_exemption_contract.php'); ?>
				</div>
			<?php } ?>
		<?php endif;?>
	<?php endif;?>
         
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<input type="hidden" id="id_contract" class="form-control" value="<?= isset($_GET['id']) ? $_GET['id'] : ''; ?>" >
<!-- /page content -->
<div class="modal fade" id="tab001_noteModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Ghi chú</h5>
        <hr>
        <div class="form-group">
          <textarea class="form-control" rows="5"></textarea>
        </div>
      <p class="text-right">
        <button class="btn btn-danger">Xác nhận</button>
      </p>

      <table class="table">
        <thead>
          <tr>
            <th>Lịch sử ghi chú</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              Chúng tôi cung cấp các khoản vay từ 5 triệu - 30 triệu và tư vấn các khoản vay lớn hơn theo nhu cầu khách hàng.
            </td>
          </tr>
          <tr>
            <td>
              Chúng tôi cung cấp các khoản vay từ 5 triệu - 30 triệu và tư vấn các khoản vay lớn hơn theo nhu cầu khách hàng.
            </td>
          </tr>
          <tr>
            <td>
              Chúng tôi cung cấp các khoản vay từ 5 triệu - 30 triệu và tư vấn các khoản vay lớn hơn theo nhu cầu khách hàng.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</div>
</div>

<!-- /page content -->
<div class="modal fade" id="tab002_phoneresultModal" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">GỌI CHO SỐ: 0347110955</h5>
      <hr>
      <div class="row">
        <div class="col-xs-12 col-lg-6">
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Họ và tên</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="NGUYEN VAN AN" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Số điện thoại</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="0347110955" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Mối quan hệ</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="Khách hàng" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Số điện thoại mới</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="" >
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Kết quả</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="" >
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-lg-6">
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Số tiền hẹn thanh toán</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="" >
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Ngày hẹn thanh toán</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" value="" >
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-4 col-sm-4 col-xs-12">Ghi chú</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <textarea class="form-control" rows="3" cols="80"></textarea>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-xs-12">
              <h4>00:15:15</h4>
            </div>
          </div>
        </div>
      </div>
      <p class="text-center">
        <button class="btn btn-danger">Lưu và kết thúc</button>
      </p>

    </div>

  </div>
</div>
</div>
<script src="<?php echo base_url();?>assets/js/accountant/payment.js"></script>
<script src="<?php echo base_url();?>assets/js/numeral.min.js"></script>
<script src="<?php echo base_url();?>assets/js/transaction/tree_select/jquery.bootstrap.treeselect.js"></script>


<script type="text/javascript" src="<?php echo base_url();?>assets/js/accountant/renewal.js"></script>
<script src="<?php echo base_url(); ?>assets/js/examptions/index.js"></script>


<style>
  .form-group {
    margin-bottom: 0;
  }
  .form-control {
    border: 1px solid #F2F2F2;
  }

</style>
<div class="modal fade" id="editFee" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
   aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title title_modal_approve">Xem phí thực tính</h5>
        <hr>
        <div class="form-group row">
          <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
            Coupon <span class="text-danger">*</span>
          </label>
          <div class="col-lg-6 col-sm-12 col-12">
            <input type="text" class="form-control code_coupon" value="" disabled>
          </div>
        </div>
        <div class="form-group">
          <input type="hidden" class="form-control contract_id_fee">
          <input type="hidden" class="form-control" id="number_day_loan">
          <div class="row">
            <div class="col-lg-6">
              <label>Lãi suất phải thu của người vay:</label>
              <input type="text" class="form-control percent_interest_customer" value="" disabled>

              <label>Phí tư vấn quản lý:</label>
              <input type="text" class="form-control percent_advisory" value="" disabled>

              <label>Phí thẩm định và lưu trữ tài sản đảm bảo:</label>
              <input type="text" class="form-control percent_expertise" value="" disabled>

              <label>Phần trăm phí quản lý số tiền vay chậm trả:</label>
              <input type="text" class="form-control penalty_percent" value="" disabled>
              <label>Số tiền quản lý số tiền vay chậm trả:</label>
              <input type="text" class="form-control penalty_amount" value="" disabled>
            </div>
            <div class="col-lg-6">
              <label>Phí tư vấn gia hạn:</label>
              <input type="text" class="form-control extend" value="" disabled>

              <label>Phí tất toán(trước 1/3):</label>
              <input type="text" class="form-control percent_prepay_phase_1" value="" disabled>

              <label>Phí tất toán(trước 2/3):</label>
              <input type="text" class="form-control percent_prepay_phase_2" value="" disabled>

							<label>Phí tất toán(sau 2/3):</label>
							<input type="text" class="form-control percent_prepay_phase_3" value="" disabled>
				<label>% phí tư vấn gia hạn từ 6 tháng trở lên:</label>
				<input type="text" class="form-control extend_new_five" value="" disabled>
				<label>% phí tư vấn gia hạn 6 tháng trở xuống:</label>
				<input type="text" class="form-control extend_new_three" value="" disabled>
						</div>
					</div>
					<!-- <label>Ghi chú:</label>
					<textarea class="form-control fee_note" rows="5" ></textarea>
				   -->
				</div>
				</table>
				<p class="text-right">
					<?php
					 if($userSession['email'] == "hongtx@tienngay.vn" ){   ?>
					  <button class="btn btn-danger update_fee">Cập nhật</button>
					  <button class="btn btn-danger submit_edit_fee" disabled>Lưu</button>
					 <?php } ?>
				</p>
			</div>


    </div>
  </div>
</div>
<div class="modal fade" id="editCouponbhkv" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
   aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title title_modal_approve">Mã giảm bảo hiểm khoản vay </h5>
        <hr>
        <div class="form-group row">
          <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
            Coupon <span class="text-danger">*</span>
          </label>
          <div class="col-lg-6 col-sm-12 col-12">
            <select class="form-control" name="code_coupon_bhkv" disabled>
                          <option value="">Chọn coupon BHKV</option>
                          <?php 
                          foreach($coupon_bhkv as $value) { ?>
                            <option  <?php echo $value->code == $contractDB->code_coupon_bhkv ? 'selected' : '' ?>
                                value="<?php echo $value->code; ?>" ><?php echo $value->code; ?></option>
                          <?php } ?>
                        </select>
          </div>
        </div>
        <br/>
            <div class="col-md-12 col-xs-12">
            <div id="SomeThing" class="simpleUploader">
              <div class="uploads" id="uploads_img_file_cc">

              </div>
              <label for="uploadinput_cc" id="addup_cc">
                <div class="block uploader">
                  <span>+</span>
                </div>
              </label>
              <input id="uploadinput_cc" type="file" name="file" data-contain="uploads_img_file_cc"
                   data-title="Hồ sơ trả về" multiple data-type="img_file" class="focus">
            </div>
          </div>
           <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
            Ghi chú <span class="text-danger">*</span>
          </label>
          <textarea class="form-control approve_note" rows="5"></textarea>
         <input type="hidden" class="form-control contract_id_cp_bhkv">
        </table>
       <p class="text-right">
          <?php
           if($userSession['email'] == "hongtx@tienngay.vn" ){   ?>
            <button class="btn btn-danger update_coupon_bhkv">Cập nhật</button>
            <button class="btn btn-danger submit_edit_coupon_bhkv" disabled>Lưu</button>
           <?php  } ?>
        </p>
      </div>

    </div>
  </div>
</div>
<script type="text/javascript">
    $(".update_coupon_bhkv").click(function(event) {
    $('select[name="code_coupon_bhkv"]').attr('disabled', false);
  $('.update_coupon_bhkv').attr('disabled', true);
  $('.submit_edit_coupon_bhkv').attr('disabled', false);

});
	$(".update_fee").click(function(event) {
	  $('.percent_advisory').attr('disabled', false);
  $('.percent_expertise').attr('disabled', false);
  $('.percent_prepay_phase_1').attr('disabled', false);
  $('.percent_prepay_phase_2').attr('disabled', false);
  $('.percent_prepay_phase_3').attr('disabled', false);
  $('.update_fee').attr('disabled', true);
  $('.submit_edit_fee').attr('disabled', false);

});
$(".submit_edit_fee").click(function(event) {

  let contract_id = $(".contract_id_fee").val();
   var percent_interest_customer = $(".percent_interest_customer").val();
    var percent_advisory = $(".percent_advisory").val();
    var percent_expertise = $(".percent_expertise").val();
    var percent_prepay_phase_1 = $(".percent_prepay_phase_1").val();
    var percent_prepay_phase_2 = $(".percent_prepay_phase_2").val();
    var percent_prepay_phase_3 = $(".percent_prepay_phase_3").val();

      var formData = new FormData();
        formData.append('id', contract_id);
        formData.append('percent_interest_customer', percent_interest_customer);
        formData.append('percent_advisory', percent_advisory);
        formData.append('percent_expertise', percent_expertise);
        formData.append('percent_prepay_phase_1', percent_prepay_phase_1);
        formData.append('percent_prepay_phase_2', percent_prepay_phase_2);
        formData.append('percent_prepay_phase_3', percent_prepay_phase_3);


    //Call ajax
    $.ajax({
        url: _url.base_url + "pawn/updateFee",
        type: "POST",
        data : formData,
        dataType : 'json',
         processData: false,
        contentType: false,
        success: function(data) {
          $(".theloading").hide();
			if (data.code != 200) {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);

			} else {
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function(){
                    location.reload();
                }, 3000);
			}
        },
        error: function(error) {
            console.log(error);
        }
    });
});
$(".submit_edit_coupon_bhkv").click(function(event) {

  let contract_id = $(".contract_id_cp_bhkv").val();
   var code_coupon_bhkv = $("select[name='code_coupon_bhkv']").val();
  var approve_note = $(".approve_note").val();
  var count = $("img[name='img_transaction']").length;
  var image_file = {};
  if (count > 0) {
    $("img[name='img_transaction']").each(function () {
      var data = {};
      type = $(this).data('type');
      data['file_type'] = $(this).attr('data-fileType');
      data['file_name'] = $(this).attr('data-fileName');
      data['path'] = $(this).attr('src');
      var key = $(this).data('key');
      if (type == 'img_file') {
        image_file[key] = data;
      }
    });
  }

      var formData =  {
        id:contract_id,
        code_coupon_bhkv:code_coupon_bhkv,
        image_file:image_file,
        approve_note:approve_note,

      }
    //Call ajax
    $.ajax({
        url: _url.base_url + "contract/do_edit_coupon_bao_hiem",
        type: "POST",
        data : formData,
        dataType : 'json',
        success: function(data) {
          $(".theloading").hide();
      if (data.code != 200) {
        $("#errorModal").modal("show");
        $(".msg_error").text(data.msg);

      } else {
        $("#successModal").modal("show");
        $(".msg_success").text(data.msg);
        setTimeout(function(){
                    location.reload();
                }, 3000);
      }
        },
        error: function(error) {
            console.log(error);
        }
    });
});

$('input[type=file]').change(function () {
  var contain = $(this).data("contain");
  var title = $(this).data("title");
  var type = $(this).data("type");
  if (type == 'img_file') {
	  $(this).simpleUpload(_url.base_url + "pawn/upload_img", {
		  //$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
		  allowedExts: ["jpg", "jpeg", "jpe", "png", "gif","pdf"],
		  allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif","application/pdf"],
		  maxFileSize: 10000000, //10MB,
		  multiple: true,
		  limit: 10,
		  start: function (file) {
			  fileType = file.type;
			  fileName = file.name;
			  //upload started
			  this.block = $('<div class="block"></div>');
			  this.progressBar = $('<div class="progressBar"></div>');
			  this.block.append(this.progressBar);
			  $('#' + contain).append(this.block);
		  },
		  data: {
			  'type_img': type

		  },
		  progress: function (progress) {
			  //received progress
			  this.progressBar.width(progress + "%");
		  },
		  success: function (data) {
			  //upload successful
			  this.progressBar.remove();
			  if (data.code == 200) {
				  var content = "";
				  if( fileType != 'application/pdf')
				  {
					  content += '<img id="pdf" data-type="' + type + '"  data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_transaction"  data-key="' + data.key + '" src="' + data.path + '" /><button type="button" onclick="deleteImage(this)"  data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
				  }else{
					  content += '<img  data-type="' + type + '"  data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_transaction"  data-key="' + data.key + '" src="' + data.path + '" /><button type="button" onclick="deleteImage(this)"  data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button><div class="description"></div>';
				  }
				  var data = $('<div ></div>').html(content);
				  this.block.append(data);
			  } else {
				  //our application returned an error
				  var error = data.msg;
				  this.block.remove();
				  alert(error);
			  }
		  },
		  error: function (error) {
			  var msg = error.msg;
			  this.block.remove();
			  alert(msg);
		  }
	  });
  }
});
</script>
