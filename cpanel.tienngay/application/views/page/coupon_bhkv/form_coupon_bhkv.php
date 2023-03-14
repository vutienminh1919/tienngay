<?php
$id=(isset($_GET['id']) && !empty($_GET['id'])) ?  $_GET['id'] : '';
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span >Đang Xử Lý...</span>
  </div>
  <div class="row">


    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Cài đặt giảm bảo hiểm khoản vay
                  <br/><br/>
                  <small><a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('coupon_bhkv/listCoupon_bhkv')?>">Danh sách mã giảm </a> / <a href="#"><?= (empty($id)) ?  'Tạo mã giảm bảo hiểm ' :  '' ?></a></small>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_content">
                <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class='div_error'></span>
        </div>
        <form class="form-horizontal form-label-left" id="form_coupon_bhkv" enctype="multipart/form-data" action="<?php echo base_url("coupon_bhkv/doAddCoupon_bhkv")?>" method="post">
          <input type="hidden" name="id_coupon_bhkv" class="form-control " value="<?= !empty($coupon_bhkv->_id->{'$oid'}) ? $coupon_bhkv->_id->{'$oid'} : ""?>">
        
    <div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"> Tên chương trình <span class="text-danger">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" class="form-control code" name="code" value="<?php !empty($coupon_bhkv->code) ? print $coupon_bhkv->code : print "" ?>">
        </div>
    </div>
<div class="form-group row">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Hình thức vay
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
             <select class="form-control formality" name="type_loan[]"  multiple="multiple" id="type_loan"   >
            <option value=''> Chọn hình thức vay </option>
            <?php 
                if($configuration_formality){
                    foreach($configuration_formality as $key => $cf){
            ?>
             <option value="<?= !empty(getId($cf->_id)) ? getId($cf->_id) : ""?>" <?php if(!empty($coupon_bhkv->type_loan) && in_array(getId($cf->_id),$coupon_bhkv->type_loan)) { echo 'selected';}else{ echo '';}  ?> ><?= !empty($cf->name) ? $cf->name : ""?></option>
             <?php }}?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Sản phẩm vay
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
             <select class="form-control "name="loan_product[]"  multiple="multiple" id="loan_product"   >
            <option value=''> Chọn sản phẩm vay </option>
            <?php 
              
                    foreach(loan_products() as $key => $value){
            ?>
            <option value="<?php echo $key;   ?>" <?php if(!empty($coupon_bhkv->loan_product) && in_array((string)$key,$coupon_bhkv->loan_product)) { echo 'selected';}else{ echo '';}  ?> ><?= $value ?></option>
             <?php }?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Property_type')?> 
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <select class="form-control" id="type_property" name="type_property[]"  multiple="multiple"  >
            <option value=''> Chọn Loại tài sản </option>
            <?php 
                if(!empty($mainPropertyData)){
                    foreach($mainPropertyData as $key => $property_main){
                ?>
            
            <option value="<?php echo getId($property_main->_id);   ?>" <?php if(!empty($coupon_bhkv->type_property) && in_array(getId($property_main->_id),$coupon_bhkv->type_property)) { echo 'selected';}else{ echo '';}  ?> ><?= !empty($property_main->name) ? $property_main->name : "" ?></option>
            <?php } }?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Thời gian vay
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <select class="form-control" id="number_day_loan"  name="number_day_loan[]"  multiple="multiple">
          <?php 
           $number_day_loan = (isset($coupon_bhkv->number_day_loan) && is_array($coupon_bhkv->number_day_loan) ) ? $coupon_bhkv->number_day_loan : array(); 
          // var_dump($number_day_loan); die;
          ?>
            <option value=''> Chọn thời gian vay </option>
             <option value="30" <?=  ( is_array($number_day_loan) && in_array("30", $number_day_loan)) ? 'selected' : '' ?> >1 tháng</option>
          <option value="90" <?= (is_array($number_day_loan) && in_array("90", $number_day_loan)) ? 'selected' : '' ?>>3 tháng</option>
          <option value="180" <?= (is_array($number_day_loan) && in_array("180", $number_day_loan)) ? 'selected' : '' ?>>6 tháng</option>
          <option value="270" <?= (is_array($number_day_loan) && in_array("270", $number_day_loan)) ? 'selected' : '' ?>>9 tháng</option>
          <option value="360" <?= (is_array($number_day_loan) && in_array("360", $number_day_loan)) ? 'selected' : '' ?>>12 tháng</option>
          <option value="540" <?= (is_array($number_day_loan) && in_array("540", $number_day_loan)) ? 'selected' : '' ?>>18 tháng</option>
          <option value="720" <?= (is_array($number_day_loan) && in_array("720", $number_day_loan)) ? 'selected' : '' ?>>24 tháng</option>
        
        </select>
    </div>
</div>

     

            <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Vùng
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control district_shop" name="code_area[]" multiple="multiple"  id="code_area" >
                <option value="">Chọn khu vực</option>
            
                 <?php 
                          if(!empty($areaData)){

                            foreach($areaData as $key => $area){
                        
                        ?>
                            <option  value="<?= !empty($area->code) ? $area->code : "";?>" <?php if(!empty($coupon_bhkv->code_area) && in_array($area->code,$coupon_bhkv->code_area)) { echo 'selected';}else{ echo '';}  ?>><?= !empty($area->title) ? $area->title : "";?></option>
                            <?php }}?>
              </select>

                    </div>
                </div>
                 <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                     Phòng giao dịch <span class="text-danger"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="code_store" class="form-control" name="code_store">
                        <option value=""><?= $this->lang->line('All')?></option>
                          <?php foreach ($storeData as $p) {
                   if(!empty($stores))
                   {
                     if(!in_array($p->id, $stores))
                      continue;
                   }
                ?>
                              <option <?= (isset($coupon_bhkv->code_store) && $p->id==$coupon_bhkv->code_store) ? 'selected' : '' ?>   value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
                          <?php }?>
                      </select>
                </div>
            </div>

           <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                      Ngày bắt đầu <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="date" name="start_date"  class="form-control start_date"  value="<?php !empty($coupon_bhkv->start_date) ? print date('Y-m-d',$coupon_bhkv->start_date) : print "" ?>">
        </div>
    </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                      Ngày kết thúc <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="date"   class="form-control end_date" name="end_date"  value="<?php !empty($coupon_bhkv->end_date) ? print date('Y-m-d',$coupon_bhkv->end_date) : print "" ?>">
            </div>
        </div>
         
              <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                     Khoản vay áp dụng từ <span class="text-danger"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="start_money"  class="form-control start_money"  value="<?php !empty($coupon_bhkv->start_money) ? print number_format($coupon_bhkv->start_money) : print "" ?>">
        </div>
    </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                     Khoản vay áp dụng đến <span class="text-danger"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text"   class="form-control end_money" name="end_money"  value="<?php !empty($coupon_bhkv->end_money) ? print number_format($coupon_bhkv->end_money) : print "" ?>">
            </div>
        </div>
         <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                     % Phí giảm <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="number"  min="0" max="100"  class="form-control percent_reduction" name="percent_reduction"  value="<?php !empty($coupon_bhkv->percent_reduction) ? print $coupon_bhkv->percent_reduction : print "" ?>" >
            </div>
        </div>
         
          <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Mô tả chi tiết chương trình: <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea name="note" id="note" rows="4" cols="100" placeholder="" class="form-control"><?php !empty($coupon_bhkv->note) ? print $coupon_bhkv->note : print "" ?></textarea>
        </div>
    </div>
        </div>
           
      
     
          
           <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                   Loại coupon
                  </label>
                  <div class="col-lg-6 col-sm-12 col-xs-12 ">
                    <div class="radio-inline text-primary">
                      <label>
                        <input type="radio" name="type_coupon" value="1" <?php ($coupon_bhkv->type_coupon=="1") ? print "checked" : print "" ?>  <?php !isset($coupon_bhkv->type_coupon) ? print "checked" : print "" ?>> Áp dụng tất cả
                      </label>
                    </div>
                    <div class="radio-inline text-danger">
                      <label>
                        <input type="radio"   name="type_coupon" value="2" <?php ($coupon_bhkv->type_coupon=="2") ? print "checked" : print "" ?>> Chỉ CEO duyệt
                      </label>
                    </div>
                  </div>
                </div>
           <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    <?php print $this->lang->line('status')?>
                  </label>
                  <div class="col-lg-6 col-sm-12 col-xs-12 ">
                    <div class="radio-inline text-primary">
                      <label>
                        <input type="radio" name="status" value="active" <?php ($coupon_bhkv->status=="active") ? print "checked" : print "" ?>  <?php !isset($coupon_bhkv->status) ? print "checked" : print "" ?>> <?php print $this->lang->line('active')?>
                      </label>
                    </div>
                    <div class="radio-inline text-danger">
                      <label>
                        <input type="radio"   name="status" value="deactive" <?php ($coupon_bhkv->status=="deactive") ? print "checked" : print "" ?>> <?php print $this->lang->line('deactive')?>
                      </label>
                    </div>
                  </div>
                </div>
      <div class="form-group">
      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button class="btn btn-success  create_coupon_bhkv">
          <i class="fa fa-save"></i>
          <?php echo $this->lang->line('save')?>
        </button>
        <a href="<?php echo base_url('coupon_bhkv/listCoupon_bhkv')?>" class="btn btn-info ">
          <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back')?>

        </a>
      </div>
                </div>
              </form>

    <!-- /page content -->
    <script src="<?php echo base_url();?>assets/js/coupon_bhkv/index.js"></script>

    <style type="text/css">
      textarea {

  white-space: pre;

  overflow-wrap: normal;

  overflow-x: scroll;

}
    </style>
<script>
    function readURL_all(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var parent = $(input).closest('.form-group');
            //console.log(parent);
            reader.onload = function (e) {
                parent.find('.wrap').hide('fast');
                parent.find('.blah').attr('src', e.target.result);
                parent.find('.wrap').show('fast');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".x_content").on('change', '.imgInp', function () {

        readURL_all(this);
    });
</script>
