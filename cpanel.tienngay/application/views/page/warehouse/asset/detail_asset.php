<!-- page content -->
<link href="<?php echo base_url();?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<div class="right_col" role="main">
	<div class="row top_tiles">
		<div class="col-xs-9">
			<div class="page-title">
				<div class="title_left" style="width: 100%">
					<h3><?= $this->lang->line('detail_asset')?> / <?= $asset->code_contract?>
                    <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="<?php echo base_url('warehouse/listAsset')?>"><?php echo $this->lang->line('asset_management')?></a> / <a href="#"><?php echo $this->lang->line('detail_asset')?></a>
                    </small>
                    </h3>
					<div class="alert alert-danger alert-result" id="div_error" style="display:none; color:white;"></div>
				</div>
			</div>
		</div>
		<div class="col-xs-3">
			<div class="page-title">
				<div class="text-right">
					
					
                 <!--    <a href="<?php echo base_url('warehouse/listAsset')?>" class="btn btn-info ">  <i class="fa fa-hand-o-left" aria-hidden="true"></i> Quay lại </a> -->
				</div>
			</div>
		</div>
           <input type="hidden" id="contract_id" value="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>">
		<div class="col-12 col-lg-12">
            <div class="x_panel ">
                <div class="x_content ">
                    <div class="form-horizontal form-label-left">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <!--thông tin cá nhân-->
                                <div class="x_title">
                                    <strong><i class="fa fa-user" aria-hidden="true"></i> <?= $this->lang->line('asset_information')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        Tên tài sản<span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input  type="text" required id="customer_email" value="<?= $asset->loan_infor->name_property->text ? $asset->loan_infor->name_property->text : "" ?>" class="form-control email-autocomplete">
                                        <div id="results" class="smartsearchresult "></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     Mã hợp đồng<span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input  type="text" id="customer_name" required value="<?= $asset->code_contract ? $asset->code_contract : "" ?>" class="form-control">
                                    </div>
                                </div>
                              
                              
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Loại tài sản<span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input  type="text" required id="type_property" name="type_property" value="<?= $asset->loan_infor->type_property->text ? $asset->loan_infor->type_property->text : "" ?>" class="form-control identify-autocomplete">
                                        <div id="resultsIdentify" class="smartsearchresult "></div>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                       Phòng giao dịch <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input  type="text" name="" type='text' value="<?= $asset->store->name ? $asset->store->name.' - '.$asset->store->address : "" ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                   Khấu hao<span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input  type="text" required id="customer_phone_number" value="<?= $asset->loan_infor->decreaseProperty[0]->name ? $asset->loan_infor->decreaseProperty[0]->name : "" ?>" class="form-control phone-autocomplete">
                                        <div id="resultsPhone" class="smartsearchresult "></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                       Nhãn hiệu <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input  type="text" name="" type='text' value="<?= $asset->property_infor[0]->value ? $asset->property_infor[0]->value : "" ?>" class="form-control" />
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                       Model <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input  type="text" name="" type='text' value="<?= $asset->property_infor[1]->value ? $asset->property_infor[1]->value : "" ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                       Biển số xe <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input  type="text" name="" type='text' value="<?= $asset->property_infor[2]->value ? $asset->property_infor[2]->value : "" ?>" class="form-control" />
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                       Số khung <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input  type="text" name="" type='text' value="<?= $asset->property_infor[3]->value ? $asset->property_infor[3]->value : "" ?>" class="form-control" />
                                    </div>
                                </div>
                                   <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                       Số máy <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input  type="text" name="" type='text' value="<?= $asset->property_infor[4]->value ? $asset->property_infor[4]->value : "" ?>" class="form-control" />
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                       Giá trị xe <span class="text-danger"> *</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input  type="text" name="" type='text' value="<?= $asset->loan_infor->price_property ? number_format($asset->loan_infor->price_property) : "" ?>đ" class="form-control" />
                                    </div>
                                </div>

                         <div class="form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ảnh tài sản <span class="red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="SomeThing" class="simpleUploader line">
                                <div class="uploads" id="uploads_tai_san">
                                    <?php 
                                        if(!empty($status_asset->image->anh_tai_san) && $status_asset->image->anh_tai_san != " ") {
                                            foreach((array)$status_asset->image->anh_tai_san as $key=>$value) {
                                                if(empty($value) || $value==" " ) continue;
                                            ?>
                                            <div class="block">
                                                <?php if($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') {?>
                                                    <a href="<?= $value->path ?>" class="magnifyitem" data-magnify="gallery" data-src="" data-caption="Hình ảnh tài sản" data-group="thegallery" >
                                                        <img src="<?= $value->path?>" alt="">
                                                    </a>
                                                <?php }?>
                                                                                 
                                                <button type="button" onclick="deleteImage(this)" data-id="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>" data-type="anh_tai_san" data-key='<?= $key?>' class="cancelButton "><i class="fa fa-times-circle"></i></button>
                                         
                                            </div>
                                    <?php }}?>
                                </div>
                                <label for="upload_tai_san">
                                    <div class="block uploader">
                                        <span>+</span>
                                    </div>
                                </label>
                                <input id="upload_tai_san" type="file" name="file" data-contain="uploads_tai_san" multiple data-type="anh_tai_san" class="focus">
                            </div>
                        </div> 
                    </div>
                      

                            </div>
                            <div class="col-xs-12 col-md-6">
                                <!-- Thông tin khoản vay-->
                                <div class="x_title">
                                    <strong><i class="fa fa-money" aria-hidden="true"></i> <?= $this->lang->line('warehouse_information')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                                
                               
                                <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     Mã kho <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input  type="text" id="code" required class="form-control number"  value="<?= $status_asset->code_warehouse ? $status_asset->code_warehouse : "" ?>">
                                        </div>
                                    </div>
                                  <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     Thời hạn<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input  type="text" id="expire_date" required class="form-control number"  value="<?= $asset->expire_date ? date('d/m/Y H:i:s',$asset->expire_date) : "" ?>">
                                        </div>
                                    </div>
                               
                                   <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Trạng thái tài sản<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input  type="text" id="money" required class="form-control number"  value="<?= $status_asset->trang_thai_tai_san ? get_tt_tai_san($status_asset->trang_thai_tai_san) : "" ?>">
                                        </div>
                                    </div>
                                      <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Trạng thái lưu kho<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input  type="text" id="money" required class="form-control number"  value="<?= $status_asset->trang_thai_trong_kho ? get_tt_trong_kho($status_asset->trang_thai_trong_kho) : "" ?>">
                                        </div>
                                    </div>
                                    
                                  <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Ngày nhập<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input  type="text" id="money" required class="form-control number"  value="<?= $status_asset->yeucaunhapkho ? date('d/m/Y H:i:s',$status_asset->yeucaunhapkho->ngay_yeu_cau) : "" ?>">
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Người nhập<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input  type="text" id="money" required class="form-control number"  value="<?= $status_asset->yeucaunhapkho ? $status_asset->yeucaunhapkho->nguoi_yeu_cau : "" ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Ngày xuất<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input  type="text" id="money" required class="form-control number"  value="<?= $status_asset->yeucauxuatkho ? date('d/m/Y H:i:s',$status_asset->yeucauxuatkho->ngay_yeu_cau) : "" ?>">
                                        </div>
                                    </div>
                                 <div class="form-group">
                                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    Người xuất<span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                            <input  type="text" id="money" required class="form-control number"  value="<?= $status_asset->yeucauxuatkho ? $status_asset->yeucauxuatkho->nguoi_yeu_cau : "" ?>">
                                        </div>
                                    </div>
                                 <div class="form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Chứng từ nhập xuất kho <span class="red">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="SomeThing" class="simpleUploader line">
                                <div class="uploads" id="uploads_chung_tu">
                                    <?php 
                                        if(!empty($status_asset->image->chung_tu_nhapxuat_kho)  && $status_asset->image->chung_tu_nhapxuat_kho != " ") {
                                            foreach((array)$status_asset->image->chung_tu_nhapxuat_kho as $key=>$value) {
                                                if(empty($value) || $value==" ") continue;
                                            ?>
                                            <div class="block">
                                                <?php if($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') {?>
                                                    <a href="<?= $value->path ?>" class="magnifyitem" data-magnify="gallery" data-src="" data-caption="Chứng từ nhập xuất kho" data-group="thegallery" >
                                                        <img src="<?= $value->path?>" alt="">
                                                    </a>
                                                <?php }?>
                                                                                 
                                                <button type="button" onclick="deleteImage(this)" data-id="<?= !empty($_GET['id']) ? $_GET['id'] : ""?>" data-type="chung_tu_nhapxuat_kho" data-key='<?= $key?>' class="cancelButton "><i class="fa fa-times-circle"></i></button>
                                         
                                            </div>
                                    <?php }}?>
                                </div>
                                <label for="upload_chung_tu">
                                    <div class="block uploader">
                                        <span>+</span>
                                    </div>
                                </label>
                                <input id="upload_chung_tu" type="file" name="file" data-contain="uploads_chung_tu" multiple data-type="chung_tu_nhapxuat_kho" class="focus">
                            </div>
                        </div> 
                    </div>
                                <!--end thông tin phong giao dich-->
                            </div>
                           <!--End Thông tin tài sản-->

                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


 <?php 
    function get_tt_tai_san($id)
    {
      switch ($id) {
        case '1':
        return "Đang cầm cố";
             break;
        case '2':
        return  "Cần trả khách";
           break;
        case '3':
        return  "Đã trả khách";
           break;
        case '4':
        return  "Cần thanh lý";
           break;
        case '5':
        return  "Đã thanh lý";
           break;
    }
  }
     function get_tt_contract($id)
    {
      switch ($id) {
        case '1':
        return "Mới";
             break;
        case '2':
        return  "Chờ phòng giao dịch mới";
           break;
        case '3':
        return  "Đã hủy";
           break;
        case '4':
        return  "Trưởng PGD không duyệt";
           break;
        case '5':
        return  "Chờ hội sở duyệt";
           break;
        case '6':
        return "Đã duyệt";
             break;
        case '7':
        return  "Kế toán không duyệt";
           break;
        case '15':
        return  "Chờ giải ngân";
           break;
        case '16':
        return  "Đã tạo lệnh giải ngân thành công";
           break;
        case '17':
        return  "Đang vay";
           break;
          case '18':
        return "Giải ngân thất bại";
             break;
        case '19':
        return  "Đã tất toán";
           break;
        case '20':
        return  "Đã quá hạn";
           break;
        case '21':
        return  "Chờ hội sở duyệt gia hạn";
           break;
        case '22':
        return  "Chờ kế toán duyệt gia hạn";
           break;
        case '23':
        return  "Đã gia hạn";
           break;
        case '24':
        return  "Chờ kế toán xác nhận";
           break;
    }
  }
    function get_tt_trong_kho($id)
    {
      switch ($id) {
        case '1':
        return "Cần nhập kho";
             break;
        case '2':
        return  "Đã nhập kho";
           break;
        case '3':
        return "Cần xuất kho";
             break;
        case '4':
        return  "Đã xuất kho";
           break;
    }
    }
    ?>

<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets")?>/js/numeral.min.js"></script>
<script src="<?php echo base_url();?>assets/js/warehouse/index.js"></script>
<script src="<?php echo base_url();?>assets/js/simpleUpload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />


<script>
  $(".magnifyitem").magnify({
   initMaximized: true
  });
</script>
<script type="text/javascript">
   function showModal() {
       $('#ContractHistoryModal').modal('show');
   }

</script>
 <script type="text/javascript">
     $("input[type='text']").prop('disabled', true);
    $("select").prop('disabled', true);
   </script>