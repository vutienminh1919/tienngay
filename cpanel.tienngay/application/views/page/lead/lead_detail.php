<!-- page content -->
<div class="right_col" role="main">
<div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span ><?= $this->lang->line('Loading')?>...</span>
  </div>
	<div class="row top_tiles">
		<div class="col-xs-11">
			<div class="page-title">
				<div class="title_left" style="width: 100%">
					<h3>Chi tiết lead
                    <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="<?php echo base_url('lead_custom')?>">Quản lý lead</a> / <a href="#">Chi tiết lead</a>
                    </small>
                    </h3>
					<div class="alert alert-danger alert-result" id="div_error" style="display:none; color:white;"></div>
				</div>
			</div>
		</div>
		<div class="col-xs-1">
			<div class="page-title">
				<div class="text-right">
					<a href="<?php echo base_url('lead_custom')?>" class="btn btn-info "> Quay lại </a>
			
                       

				</div>
			</div>
		</div>
		<div class="col-12 col-lg-12">
            
            <div class="row">
            
                    <div class="col-xs-12">
                    <input type="hidden" value="" name="_id"/>
                
                        <div class="form-group">
                            <label class="control-label col-md-3">Họ và Tên :</label>
                            <div class="col-md-9">
                                <input name="fullname" placeholder="Họ và tên khách hàng" class="form-control"
                                       type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email :</label>
                            <div class="col-md-9">
                                <input name="email" placeholder="Email khách hàng" class="form-control"
                                       type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Hình thức vay</label>
                            <div class="col-md-9">
                                <select name="type_finance" class="form-control" id="type_finance">
                                <?php foreach ($lead_type_finance as $key => $item) { ?>
                                <option value="<?= $key ?>"><?= $item ?></option>
                                <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Hộ khẩu</label>
                            <div class="col-md-3">
                                <select name="hk_province" class="form-control">
                                        <?php foreach ($provinces as $key => $item) { ?>
                                        <option value="<?= $item->code ?>"><?= $item->name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-3">
                                <select name="hk_district" class="form-control" id="hk_district">
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-3">
                                <select name="hk_ward" class="form-control" id="hk_ward">
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nơi sống</label>
                            <div class="col-md-3">
                                <select name="ns_province" class="form-control">
                                    <?php foreach ($provinces as $key => $item) { ?>
                                        <option value="<?= $item->code ?>"><?= $item->name ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-3">
                                <select name="ns_district" class="form-control" id="ns_district">
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-3">
                                <select name="ns_ward" class="form-control" id="ns_ward">
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Đối tượng</label>
                            <div class="col-md-9">
                                <select name="obj" class="form-control" id="obj">
                                <?php foreach ($history = lead_obj() as $key => $item) { ?>
                                        <option value="<?= $key ?>"><?= $item ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nơi làm việc</label>
                            <div class="col-md-3">
                                <input name="com" placeholder="Tên công ty" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-1">Địa chỉ</label>
                            <div class="col-md-5">
                                <input name="com_address" placeholder="Nhập địa chỉ công ty" class="form-control"
                                       type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Vị trí/Chức vụ</label>
                            <div class="col-md-9">
                                <input name="position" placeholder="Vị trí chức vụ" class="form-control"
                                       type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Thời gian làm việc</label>
                            <div class="col-md-9">
                                <input name="time_work" placeholder="Thời gian làm việc" class="form-control"
                                       type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Hợp đồng lao động</label>
                            <div class="col-md-3">
                                <label><input id="has_contract_work" name='contract_work' value="1"  type="radio">&nbsp;Có</label>
                                 <label><input id="no_contract_work" name='contract_work' value="2" type="radio">&nbsp;Không</label>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Giấy tờ xác nhận công việc (Khác)</label>
                            <div class="col-md-3">
                                <input name="other_contract" placeholder="Giấy tờ xác nhận công việc"
                                       class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Hình thức nhận lương</label>
                            <div class="col-md-3">
                                <label><input id="salary_pay_mon" name='salary_pay' value="1"  type="radio">&nbsp;Tiền mặt</label>
                                 <label><input id="salary_pay_card" name='salary_pay' value="2" type="radio">&nbsp;Chuyển khoản</label>
                                
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Thu nhập</label>
                            <div class="col-md-3">
                                <input name="income" placeholder="Thu nhập" class="form-control"
                                       type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Giấy tờ chứng minh thu nhập khác</label>
                            <div class="col-md-3">
                                <input name="other_income" placeholder="Giấy tờ chứng minh thu nhập khác"
                                       class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Thẩm định nơi làm việc</label>
                            <div class="col-md-3">
                                 <label><input id="has_workplace_evaluation"  name='workplace_evaluation' value="1"  type="radio">&nbsp;Có</label>
                                 <label><input id="no_workplace_evaluation" name='workplace_evaluation' value="2" type="radio">&nbsp;Không</label>

                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Đăng kí xe chính chủ</label>
                            <div class="col-md-3">
                                <label><input id="has_vehicle_registration" name='vehicle_registration' value="1"  type="radio">&nbsp;Có</label>
                                 <label><input id="no_vehicle_registration" name='vehicle_registration' value="2" type="radio">&nbsp;Không</label>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nhãn hiệu đời xe</label>
                            <div class="col-md-3">
                                <select class="form-control" id="property_by_main" name="property_id">
                                <?php if (!empty($mainPropertyData)) {
                                        foreach ($mainPropertyData as $key => $mainProperty) { ?>
                                            <option class="form-control"
                                                    value="<?= $mainProperty->_id ?>"><?= !empty($mainProperty->name) ? $mainProperty->name : "" ?></option>
                                        <?php }
                                    } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nhu cầu vay</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="loan_amount">
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-3">Thời hạn vay</label>
                            <div class="col-md-3">
                                <select class="form-control" id="loan_time" name="loan_time">
                                <?php foreach ($loan_time = loan_time() as $key => $item) { ?>
                                        <option value="<?= $key ?>"><?= $item ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Hình thức trả lãi</label>
                            <div class="col-md-3">
                                <select class="form-control" id="type_repay" name="type_repay">
                                <?php foreach ($type_repay = type_repay() as $key => $item) { ?>
                                        <option value="<?= $key ?>"><?= $item ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-3">Trả góp hàng tháng</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="amout_repay">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Trạng thái TLS</label>
                            <div class="col-md-3">
                                <select class="form-control" id="status_sale" name="status_sale">
                                    <?php foreach ($lead_status = lead_status() as $key => $item) { ?>
                                        <option value="<?= $key ?>"><?= $item ?></option>
                                    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-3">Lý do hủy</label>
                            <div class="col-md-3">
                                <select class="form-control" id="reason_cancel" name="reason_cancel">
                                <?php if (!empty($reason)) {
                                        foreach ($reason as $key => $obj) { ?>
                                            <option class="form-control"
                                                    value="<?= $key ?>"><?= $obj ?></option>
                                        <?php }
                                    } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Chuyển đến PGD</label>
                            <div class="col-md-3">
                                
                                <select class="form-control" id="id_PDG" name="id_PDG">
                                <?php if (!empty($storeData)) {
                                        foreach ($storeData as $key => $obj) { ?>
                                            <option class="form-control"
                                                    value="<?= $obj->_id->{'$oid'} ?>"><?= $obj->name ?></option>
                                        <?php }
                                    } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-3">Thời gian</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control datepicker" name="time_support">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
              <label class="control-label col-md-3">Nguồn</label>
              <div class="col-md-3">
                <select name="source" class="form-control" id="source">
                  <?php 
                    foreach (lead_source() as $key => $obj) { ?>
                      <option class="form-control"
                          value="<?= $key ?>"><?= $obj ?></option>
               
                 <?php  } ?>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Địa điểm cụ thể hỗ trợ:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="address_support">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">UTM Source:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="utm_source">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">UTM Campaign:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="utm_campaign">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Qualified</label>
                            <div class="col-md-3">
                                 <label><input id="has_qualified"  name='qualified' value="1"  type="radio">&nbsp;Có</label>
                                 <label><input id="no_qualified" name='qualified' value="2" type="radio">&nbsp;Không</label>

                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">TLS ghi chú</label>
                            <div class="col-md-3">
                                <textarea name="tls_note" placeholder="" class="form-control"></textarea>
                                
                            </div>
                        </div>
                    <br>
              
                    </div>

                
            </div>
        </div>


<div class="col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Lịch sử cuộc gọi</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
 <div class="table-responsive">
     <table id="datatable-buttons" class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Loại cuộc gọi</th>
                <th>Nhân viên</th>
                <th>Số gọi</th>
                <th>Số nghe</th>
            
                <th>Trạng thái  cuộc gọi</th>
                <th>Chi tiết</th>
                <th>Thời lượng</th>
                <th>File ghi âm</th>
                
            </tr>
            </thead>
            <tbody name="list_lead">
            <?php 
    
            if(!empty($recordingData)){
                $n=0;
                foreach ($recordingData as $key => $history) {
               if($history->direction =='outbound')
              {
               if($this->session->upnetInfor->extension_number!=$history->fromUser->ext || $lead->phone_number != $history->toNumber)
               {
                continue;
               }
              }else{
                if($this->session->upnetInfor->extension_number!=$history->toUser->ext || $lead->phone_number != $history->fromNumber)
               {
                continue;
               }

              } 
             ?>
                <tr>
                              <td><?php echo ++$n ?></td>
                    <td><?php if($history->direction =='outbound') 
                    echo '<i class="fa fa-sign-out" aria-hidden="true"></i><br>Outbound call' ;?>
                    <?php if($history->direction =='inbound') 
                     echo  '<i class="fa fa-sign-in" aria-hidden="true"></i><br>Inbound call'; ?>
                      <?php if($history->direction =='local') 
                     echo  '<i class="fa fa-refresh" aria-hidden="true"></i><br>Internal'; ?>
                     </td>
                     <td><?= ($history->fromUser) ? $history->fromUser->email : '' ?><br>
                       <?= ($history->toUser) ? $history->toUser->email : '' ?>
                     </td>
                 
                     <td><?= ($history->fromNumber) ? $history->fromNumber : ''; ?><br>
                       <?= ($history->fromUser) ? 'Nhánh: '.$history->fromUser->ext : ''; ?>
                     </td>
                     <td><?= ($history->toNumber) ? hide_phone($history->toNumber) : ''; ?><br>
                       <?= ($history->toUser) ? 'Nhánh: '.$history->toUser->ext : ''; ?>
                     </td>
                    <td><?= !empty($history->hangupCause) ? recoding_status($history->hangupCause) : "" ?></td>
                    <td>Bắt đầu: <?= !empty($history->startTime) ? date('d/m/Y H:i:s', $history->startTime/1000) : "" ?><br>
                    Trả lời: <?= (!empty($history->answerTime) && (int)($history->answerTime) > 0) ? date("d/m/Y H:i:s", $history->answerTime / 1000) : "Không có"; ?><br>
                    Kết thúc: <?= !empty($history->endTime) ? date('d/m/Y H:i:s', $history->endTime/1000) : "" ?><br> 
                     </td>
                      <td>Tổng time: <?= ($history->duration) ? $history->duration : '' ?><br>
                        Tổng time tư vấn: <?= ($history->billDuration) ? $history->billDuration : '' ?><br>
                      </td>
                    <td class="text-right">
                          <?php if($history->billDuration) { ?>



                         <?php  } ?>
                   
                    </td>
                </tr>
            <?php }} ?>
            </tbody>
        </table>

        </div>
      </div>
    </div>

    </div>
</div>

	</div>
</div>
<div id="listentoRecord" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nghe ghi âm</h4>
      </div>

      <div class="modal-body">
        <audio controls class="w-100" id="player">
      
          <source src="" type="audio/mp3" id="audio">
  
        </audio>
      </div>
      <div class="modal-footer">
    <!--     <button type="button" class="btn btn-default" >
          <i class="fa fa-download"></i> Download
        </button> -->
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>

      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets")?>/js/numeral.min.js"></script>
 <script src="<?php echo base_url();?>assets/js/lead/index.js"></script> 
<script type="text/javascript">
   
    detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');
  

</script>
<script type="text/javascript">
     $("input").prop('disabled', true);
     $("select").prop('disabled', true);
      $("textarea").prop('disabled', true);
       

   </script>
