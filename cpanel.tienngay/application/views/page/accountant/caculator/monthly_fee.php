<!-- page content -->
<div class="right_col" role="main">
<div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span ><?= $this->lang->line('Loading')?>...</span>
  </div>
  <div class="row top_tiles">
    <div class="col-xs-9">
      <div class="page-title">
        <div class="title_left" style="width: 100%">
          <h3>Tính lãi phí tháng
                    <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#">Thu hồ nơ</a> / <a href="#">Tính lãi phí tháng</a>
                    </small>
                    </h3>
          <div class="alert alert-danger alert-result" id="div_error" style="display:none; color:white;"></div>
        </div>
      </div>
    </div>
    

<div class="col-xs-12">
        <div class="row">
                           
             <form class="form-horizontal form-label-left" action="<?php echo base_url("accountant/caculator_monthly_fee")?>" method="GET" style="width: 100%;">


                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>

               
                        <?php
                $type_finance =  '';

                if (empty($dataInit['type_finance']) && empty($dataInit['main'])) { ?>
                    <?php
                    $data['configuration_formality'] = $configuration_formality;
                    $data['mainPropertyData'] = $mainPropertyData;
                    $data['type_finance'] = $type_finance;
                    $this->load->view("page/property/template/loan_infor_no_init", $data)
                    ?>
                <?php } ?>
                 <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                     Số tiền vay
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="money" value="<?=isset($_GET['money_lead']) ? $_GET['money_lead'] : "" ?>" class="form-control " placeholder="Nhập số tiền vay" required>
                    </div>
                </div>
              <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                      Hình thức trả lãi
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control district_shop"  name="hinh_thuc_tra_lai">
            <?php $hinh_thuc_tra_lai=isset($_GET['hinh_thuc_tra_lai']) ? $_GET['hinh_thuc_tra_lai'] : ''; ?>
                       
                        <option value="">Chọn hình thức trả lãi</option>
                        <?php foreach(type_repay() as $key => $value){ ?>
                            <option <?php echo $hinh_thuc_tra_lai == $key ? 'selected' : ''?> value="<?=$key?>"><?= $value ?></option>
                            <?php } ?>
                      </select>

                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                          Kỳ hạn vay
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control" id="number_day_loan">
                        <option value="">-- Chọn kỳ hạn vay --</option>
                        <option  value="1">
                          1 tháng
                        </option>
                        <option value="3">
                          3 tháng
                        </option>
                        <option value="6">
                          6 tháng
                        </option>
                        <option value="9">
                          9 tháng
                        </option>
                        <option value="12">
                          12 tháng
                        </option>
                        <option value="18">
                          18 tháng
                        </option>
                        <option value="24">
                          24 tháng
                        </option>
                      </select>

                    </div>
                </div>
               
                 <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                      Hình thức phí
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select class="form-control district_shop"  name="hinh_thuc_phi">
           
                       
                        <option value="">Chọn hình thức phí</option>
                        <option class="u49_input_option" selected="" value="bpc">Biểu phí chuẩn</option>
          <option class="u49_input_option" value="coupon">Áp dụng Cupon</option>
          <option class="u49_input_option" value="other">Khác</option>
                      </select>

                    </div>
                </div>
               
                 <div style="display:none" id="form_coupon">
             <div class="form-group row">
      <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
        Chương trình ưu đãi <span class="text-danger">*</span>
      </label>
      <div class="col-lg-6 col-sm-12 col-12">
        <select class="form-control" id="code_coupon">
          <option value="">-- Chọn Chương trình ưu đãi --</option>
          <?php
          $coupon = isset($contractInfor->loan_infor->code_coupon) ? $contractInfor->loan_infor->code_coupon : '';
          foreach ($couponData as $key => $item) { ?>
            <option <?php echo $item->code == $coupon ? 'selected' : '' ?>
                value="<?= $item->code ?>"><?= $item->code ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Vùng
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control district_shop" name="code_area"  id="code_area" >
                <option value="">Chọn khu vực</option>
            
                 <?php 
                          if(!empty($areaData)){

                            foreach($areaData as $key => $area){
                        
                        ?>
                            <option  value="<?= !empty($area->code) ? $area->code : "";?>" <?php if(!empty($coupon->code_area) && in_array($area->code,$coupon->code_area)) { echo 'selected';}else{ echo '';}  ?>><?= !empty($area->title) ? $area->title : "";?></option>
                            <?php }}?>
              </select>

                    </div>
                </div> 
        <div class="form-group row">

                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Phòng giao dịch<span class="text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" id="stores" data-id="<?= $contractInfor->store->id;?>">
                    <?php 

                        foreach($stores as $key =>  $value){
                     
                    ?>
                <option  data-address="<?= !empty($value->address) ? $value->address : ""?>" data-code-address="<?= !empty($value->code_address_store) ? $value->code_address_store : ""?>" value="<?= !empty($value->_id->{'$oid'}) ? $value->_id->{'$oid'} : ""?>" ><?= !empty($value->name) ? $value->name : ""?></option>
                        <?php }?>
                    </select>
                </div>
            </div>  
    </div>
  </div>
                <div style="display:none" id="form_other">
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                       Lãi suất vay
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" name="loan_interest" value="<?=isset($_GET['loan_interest']) ? $_GET['loan_interest'] : "" ?>" class="form-control " placeholder="Nhập % lãi suất vay"  />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                       Phí tư vấn quản lý
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" value="<?=isset($_GET['management_consulting_fee']) ? $_GET['management_consulting_fee'] : "" ?>"  name="management_consulting_fee" class="form-control " placeholder="Nhập % phí tư vấn quản lý " >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                       Phí thẩm định và lưu trữ tài sản
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  type="number" name="renewal_fee" value="<?=isset($_GET['renewal_fee']) ? $_GET['renewal_fee'] : "" ?>" class="form-control" placeholder="Nhập % phí thẩm định" >
                    </div>
                </div>
                 
            </div>
              <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                 Ngày giải ngân
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <input type="date" name="date" class="form-control" value="<?= date("Y-m-d");?>" >
                    </div>
                </div>
      <!--     <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                 Ngày tất toán
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <input type="date" name="ngay_tat_toan" class="form-control" value="<?= date("Y-m-d");?>" >
                    </div>
                </div> -->
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                     <a class="btn btn-danger  clear">
                     Làm lại
                    </a>
                    <a class="btn btn-success  caculator_loan">
                      <i class="fa fa-save"></i>
                       Tính lãi phí
                    </a>
                  
                  </div>
                </div>
              </form>
       
                 <br/>
                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
           <div class="table-responsive ">
     <table id="tb_caculator" class="table table-striped datatable-buttons">
            <thead>
            <tr>
               <th>Kỳ trả</th>
                <th>Ngày kỳ trả</th>
                <th>Số ngày</th>
                 <th>Tiền lãi</th>
                <th>Tiền phí</th>
                <th>Gốc và lãi hàng kỳ</th>
                <th>Tiền gốc trả hàng kỳ</th>
                <th>Tiền trả hàng kỳ</th>
                 <!-- <th>Tiền tất toán</th> -->
            </tr>
            </thead>
            <tbody >
            <?php 
    
           if(!empty($calucatorData)){
               echo $calucatorData;
             ?>
            <?php } ?>
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



<script src="<?php echo base_url();?>assets/js/pawn/index.js"></script> 
<script src="<?php echo base_url();?>assets/js/accountant/caculator.js"></script> 
<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets")?>/js/numeral.min.js"></script>
<script type="text/javascript">
    //detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');
  

</script>
