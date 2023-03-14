<link href="<?php echo base_url(); ?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
<div class="right_col d-none" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span>Đang xử lý...</span>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<div class="title_left">
					<h3>Thêm mới bảo hiểm PTI Vững Tâm An
						<br>
						<small><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a> / <a href="<?php echo base_url('pti_vta') ?>">Danh sách bảo hiểm PTI Vững Tâm An</a>
							/ <a href="#">Bán mới</a></small>
					</h3>
				</div>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12">
			 <div class="sell_bh">
        <div class="title text-upercase">
            <label>Tạo đơn bán</label>
        </div>
        <div class="row paddding">
            <div class="col-md-2">
                <label class="title" style="margin-bottom: 0;">Đối tượng hưởng bh<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-2">
                <input type="radio" checked="checked" name="obj" id="buy_me" class="input_radio"   value="banthan"  /> Mua cho bản thân 
            </div>
            <div class="col-md-2">
                <input type="radio" name="obj" id="buy_another" class="input_radio" value="nguoithan" /> Mua cho người thân
            </div>
        </div>
         <div class="row paddding">
            <div class="col-md-2">
                <label class="title" style="margin-bottom: 0;">Giấy tờ xác minh<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-2">
                <input type="radio" checked="checked" group="img" name="checked_img" id="cmt_img" class="input_radio" value="tren18" /> Khách hàng trên 18 tuổi 
            </div>
            <div class="col-md-2">
                <input type="radio" name="checked_img" group="img" id="gks_img" class="input_radio" value="duoi18" /> Khách hàng dưới 18 tuổi
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
				<input type="hidden" name="code_fee" id="code_fee">
            </div>

            <div class="col-md-10">
                <div id="cmt">
                    <label for="input_cmt_search_cmt">
                        <img id="img_xac_minh_cmt" class="w-100" style="max-width: 350px; max-height: 250px;" src="https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" alt="">
                        <input type="file" id="input_cmt_search_cmt" data-preview="imgInp001" style="visibility: hidden;"></label>
                    
                    <a href="#" class="tooltip">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                        <span><b>Giấy tờ xác minh</b><br>
                            upload CMT/CCCD nếu khách hàng trên 18 tuổi
                        </span>
                    </a>

                    </div>
                     <div id="gks">
                    <label for="input_cmt_search_gks">
                        <img id="img_xac_minh_gks" class="w-100" style="max-width: 350px; max-height: 250px;" src="https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png" alt="">
                        <input type="file" id="input_cmt_search_gks" data-preview="imgInp001" style="visibility: hidden;"></label>
                    <a href="#" class="tooltip">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                        <span><b>Giấy tờ xác minh</b><br>
                            upload giấy khai sinh nếu khách hàng dưới 18 tuổi
                        </span>
                    </a>
                </div>

            </div>  
        </div>

        <div class="row paddding">
            <div class="col-md-12">
                <label class="title">Thông tin người mua bảo hiểm</label>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <span>Họ và tên:<span class="text-danger">*</span></span>
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="fullname" id="fullname" class="form-control">
                    </div>
                    <div id="ng_mua">
                        <div class="col-md-3">
                            <span>Ngày sinh:<span class="text-danger">*</span></span>
                        </div>
                        <div class="col-md-7">
                            <input type="date" name="birthday" id="date" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <span>Địa chỉ thường trú:<span class="text-danger">*</span></span>
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="address" id="add" class="form-control">
                    </div>
					<div class="col-md-3">
						<span>Email:<span class="text-danger">*</span></span>
					</div>
					<div class="col-md-7">
						<input type="text" name="email" id="qh" class="form-control">
					</div>
                    <div class="col-md-12" id="relationship-area" hidden="hidden" style="margin: 0; padding: 0">
                        <div class="col-md-3">
                            <span>Mối quan hệ với NĐBH:<span class="text-danger">*</span></span>
                        </div>
                        <div class="col-md-7">
                            <select id="relationship" class="form-control" name="relationship">
                              <option>Lựa chọn</option>
                              <option value="BM">Bố/mẹ</option>
                              <option value="VC">Vợ/chồng</option>
                              <option value="CON">Con</option>
                              <option value="ACE">Anh, chị, em ruột</option>
                              <option value="DN">Doanh nghiệp</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div> 
            <div class="col-md-6">
                <div class="row">
					<div class="col-md-3">
						<span>Giới tính:<span class="text-danger">*</span></span>
					</div>

					<div class="col-md-7">
						<div class="radio-inline text-primary">
							<label><input name='gender' id="male_gender" value="1" checked type="radio">&nbsp;<?= $this->lang->line('male')?></label>
						</div>
						<div class="radio-inline text-danger">
							<label><input name='gender' id="female_gender" value="2" type="radio">&nbsp;<?= $this->lang->line('Female')?></label>
						</div>
					</div>
                    <div class="col-md-3">
                        <span class="text_cmt_gks_nm">CMT/CCCD:<span class="text-danger">*</span></span>
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="cmt" id="cmt_ttnm" class="form-control" >
                    </div>
                    <div class="col-md-3">
                        <span>Điện thoại:<span class="text-danger">*</span></span>
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="phone" id="phone_ttnm" class="form-control">
                    </div>
                   <div class="col-md-3">
									Phòng giao dịch <span class="text-danger">*</span>
								</div>
					 <div class="col-md-7">
								<select name="store" class="form-control">
									<?php foreach ($stores as $store) {
										if (in_array($store->_id->{'$oid'}, $storeDataCentral)) continue;?>
										<option value="<?php echo $store->_id->{'$oid'}; ?>"><?php echo $store->name; ?></option>
									<?php } ?>
								</select>
							</div>
				

                </div>
            </div> 
        </div>
        <div class="row paddding" id="sell_another">
            <div class="col-md-12">
                <label class="title">Thông tin người hưởng</label>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <span>Họ và tên:<span class="text-danger">*</span></span>
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="fullname_another" id="name_another" class="form-control">
                    </div>
                    <div id="ng_huong">
                        <div class="col-md-3">
                            <span>Ngày sinh:<span class="text-danger">*</span></span>
                        </div>
                        <div class="col-md-7">
                            <input type="date" name="birthday_another" id="date_anothe" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <span>Email:<span class="text-danger">*</span></span>
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="email_another" id="name_email" class="form-control">
                    </div>

                </div>
            </div> 
            <div class="col-md-6">
                <div class="row">
					<div class="col-md-3">
						<span>Giới tính:<span class="text-danger">*</span></span>
					</div>
					<div class="col-md-7">
						<div class="radio-inline text-primary">
							<label><input name='gender_another' id="male_gender_another" value="1" checked type="radio">&nbsp;<?= $this->lang->line('male')?></label>
						</div>
						<div class="radio-inline text-danger">
							<label><input name='gender_another' id="female_gender_another" value="2" type="radio">&nbsp;<?= $this->lang->line('Female')?></label>
						</div>
					</div>
                    <div class="col-md-3">
                        <span class="text_cmt_gks_nt">CMT/CCCD:<span class="text-danger">*</span></span>
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="cmt_another" id="cmt_another" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <span>Điện thoại:<span class="text-danger">*</span></span>
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="phone_another" id="phone_another" class="form-control">
                    </div>
					<div class="col-md-3">
						<span>Địa chỉ thường trú:<span class="text-danger">*</span></span>
					</div>
					<div class="col-md-7">
						<input type="text" name="address_another" id="add" class="form-control">
					</div>

                </div>
            </div> 
        </div>
        <div class="row paddding">
            <div class="col-md-12">
                <label class="title">Thông tin trách nhiệm<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <span>Quyền lợi bảo hiểm:</span>
                    </div>
                    <div class="col-md-7">
                        <select id="sel_ql" class="form-control">
                            <option value="0">-- Chọn quyền lợi bảo hiểm --</option>
							<?php if (!empty($list_fee)) :
									foreach ($list_fee as $key => $fee) :
							?>
										<option value="<?= !empty($fee->packet) ? $fee->packet : '';?>">Gói <?= !empty($fee->number_packet) ? $fee->number_packet : '';?> - <?= !empty($fee->died_fee) ? $fee->died_fee : '';?></option>
							<?php endforeach;
								endif; ?>
                        </select>
                        <div class="description" style="margin-top: 15px;">
                            <p><span>Tử vong do tai nạn:</span><span class="pull-right tvdtn">0 VND</span></p>
                            <p><span>Chi phí Y tế điều trị tai nạn:</span><span class="pull-right cpdt">0 VND</span></p>
                        </div>
                    </div>

                </div>
            </div> 
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <span>Thời hạn bảo hiểm:</span>
                    </div>
                    <div class="col-md-7">
                        <select id="sel_year" class="form-control">
                            <option value="">-- Chọn thời hạn bảo hiểm --</option>
							<option value="3M">3 tháng</option>
							<option value="6M">6 tháng</option>
                            <option value="1Y">1 năm</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <span>Phí bảo hiểm:</span>
                    </div>
                    <div class="col-md-6" style="padding-left: 15px;">
                        <p><span id="price_pti_vta">0 VND</span></p>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row paddding ">
            <div class="col-md-12">
                <label class="title">XÁC NHẬN THÔNG TIN<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-12 row_bottom">
                <div class="row">
                    <div class="col-md-8">
                        <span>1. Bạn/Người được bảo hiểm có mắc phải hoặc đang điều trị bệnh/ tình trạng: động kinh, tâm thần, phong hay không?</span>
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="ck1" id="gp1_no" value="co"> Có
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="ck1" id="gp1_yes" value="khong" checked> Không
                    </div>
                </div>
            </div>
            <div class="col-md-12 row_bottom">
                <div class="row">
                    <div class="col-md-8">
                        <span>2. Bạn/Người được bảo hiểm có bị tàn phế hoặc thương tật vĩnh viễn từ 50% trở lên hay không?</span>
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="ck2" id="gp2_no" value="co"> Có
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="ck2" id="gp2_yes" value="khong" checked> Không
                    </div>

                </div>
            </div>
            <div class="col-md-12 row_bottom">
                <div class="row">
                    <div class="col-md-8">
                        <span>3. Bạn/Người được bảo hiểm có đang điều trị bệnh Covid 19 hoặc đang bị cách ly tại nhà hoặc tập trung theo quy định của Nhà nước tại thời điểm tham gia bảo hiểm (F0, F1) hay không?</span>
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="ck3" id="gp3_no" value="co"> Có
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="ck3" id="gp3_yes" value="khong" checked> Không
                    </div>

                </div>
            </div>
        </div>
        
					<div class="col-md-12 col-xs-12">
						<div class="" style="text-align: center">
							<button class="btn btn-success add_pti_vta_btnSave">
								Bán mới
							</button>
							<a href="<?php echo base_url('pti_vta') ?>" class="btn btn-info ">
								<?php echo $this->lang->line('back') ?>
							</a>
						</div>
					</div>
   </div>

	</div>
</div>
</div>
<div class="right_col">
	<p style="font-size: 24px; color: red; font-weight: bold">Sản phẩm bảo hiểm PTI Vững tâm an đã chính thức ngừng bán từ ngày 19/03/2022!!!</p>
</div>
	
<!-- /page content -->
<script src="<?php echo base_url(); ?>assets/js/pti_vta/form_add.js"></script>
 <script src="<?php echo base_url();?>assets/js/numeral.min.js"></script>

<style type="text/css">
.sell_bh
{ class="pull-right"
    background: #fff;
    padding: 0 15px;
    color: #333;
    line-height: 22px;
    margin: 0 -9px;
}
.sell_bh .title label
{
    display: block;
    padding: 15px;
    color: #333;
    border-bottom: 1px solid #ddd;
    text-align: center;
    text-transform: uppercase;
    font-size: 16px;
}
.paddding
{
    padding: 20px 0;
}
label.title
{
    text-transform: uppercase;
    margin-bottom: 30px;
}
.sell_bh row
{
    align-items: center;
}
[class^='col-md']
{
    margin-bottom: 15px;
}
.sell_bh .row .col-md-6:nth-child(even)
{
    padding-left: 35px;
}
.row_bottom
{
    padding-left: 35px;
}
#sell_another
{
    display: none;
}
#ng_mua, #ng_huong
{
    width: 100%;
}
.tooltip
{
    opacity: 1;
}
#gks
{
    display: none;
}
#gks, #cmt
{
    margin-bottom: 30px;
}
</style>
