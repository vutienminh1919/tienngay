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
                <h3>Cài đặt giảm phiếu thu tiền mặt
                  <br/><br/>
                  <small><a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('coupon_cash/listCoupon_cash')?>">Danh sách mã giảm </a> / <a href="#"><?= (empty($id)) ?  'Tạo mã giảm bảo hiểm ' :  '' ?></a></small>
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
        <form class="form-horizontal form-label-left" id="form_coupon_cash" enctype="multipart/form-data" action="<?php echo base_url("coupon_cash/doAddCoupon_cash")?>" method="post">
          <input type="hidden" name="id_coupon_cash" class="form-control " value="<?= !empty($coupon_cash->_id->{'$oid'}) ? $coupon_cash->_id->{'$oid'} : ""?>">
        
    <div class="form-group">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"> Tên chương trình <span class="text-danger">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" class="form-control code" name="code" value="<?php !empty($coupon_cash->code) ? print $coupon_cash->code : print "" ?>">
        </div>
    </div>
<div class="form-group row">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Loại khách
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
             <select class="form-control "name="loai_khach[]"  multiple="multiple" id="loai_khach"   >
            <option value=''> Chọn loại khách</option>
            <?php 
              $arr_loai=isset($coupon_cash->loai_khach) ? $coupon_cash->loai_khach : '';
                    foreach(loai_khach() as $key => $value){
            ?>
            <option value="<?php echo $key;   ?>" <?php if(!empty($coupon_cash->loai_khach) && in_array((string)$key,$coupon_cash->loai_khach)) { echo 'selected';}else{ echo '';}  ?> ><?= $value ?></option>
             <?php }?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Sản phẩm bảo hiểm
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
             <select class="form-control "name="bh_product[]"  multiple="multiple" id="bh_product"   >
            <option value=''> Chọn sản phẩm bảo hiểm</option>
            <?php 
              
                    foreach(bh_products() as $key => $value){
            ?>
            <option value="<?php echo $key;   ?>" <?php if(!empty($coupon_cash->bh_product) && in_array((string)$key,$coupon_cash->bh_product)) { echo 'selected';}else{ echo '';}  ?> ><?= $value ?></option>
             <?php }?>
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
                            <option  value="<?= !empty($area->code) ? $area->code : "";?>" <?php if(!empty($coupon_cash->code_area) && in_array($area->code,$coupon_cash->code_area)) { echo 'selected';}else{ echo '';}  ?>><?= !empty($area->title) ? $area->title : "";?></option>
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
                              <option <?= (isset($coupon_cash->code_store) && $p->id==$coupon_cash->code_store) ? 'selected' : '' ?>   value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
                          <?php }?>
                      </select>
                </div>
            </div>

           <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                      Ngày bắt đầu <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="date" name="start_date"  class="form-control start_date"  value="<?php !empty($coupon_cash->start_date) ? print date('Y-m-d',$coupon_cash->start_date) : print "" ?>">
        </div>
    </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                      Ngày kết thúc <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="date"   class="form-control end_date" name="end_date"  value="<?php !empty($coupon_cash->end_date) ? print date('Y-m-d',$coupon_cash->end_date) : print "" ?>">
            </div>
        </div>
         
            
         <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                     % Phí giảm <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="number"  min="0" max="100"  class="form-control percent_reduction" name="percent_reduction"  value="<?php !empty($coupon_cash->percent_reduction) ? print $coupon_cash->percent_reduction : print "" ?>" >
            </div>
        </div>
         
          <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Mô tả chi tiết chương trình: <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea name="note" id="note" rows="4" cols="100" placeholder="" class="form-control"><?php !empty($coupon_cash->note) ? print $coupon_cash->note : print "" ?></textarea>
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
                        <input type="radio" name="status" value="active" <?php ($coupon_cash->status=="active") ? print "checked" : print "" ?>  <?php !isset($coupon_cash->status) ? print "checked" : print "" ?>> <?php print $this->lang->line('active')?>
                      </label>
                    </div>
                    <div class="radio-inline text-danger">
                      <label>
                        <input type="radio"   name="status" value="deactive" <?php ($coupon_cash->status=="deactive") ? print "checked" : print "" ?>> <?php print $this->lang->line('deactive')?>
                      </label>
                    </div>
                  </div>
                </div>
      <div class="form-group">
      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button class="btn btn-success  create_coupon_cash">
          <i class="fa fa-save"></i>
          <?php echo $this->lang->line('save')?>
        </button>
        <a href="<?php echo base_url('coupon_cash/listCoupon_cash')?>" class="btn btn-info ">
          <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $this->lang->line('back')?>

        </a>
      </div>
                </div>
              </form>

    <!-- /page content -->
    <script src="<?php echo base_url();?>assets/js/coupon_cash/index.js"></script>

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
