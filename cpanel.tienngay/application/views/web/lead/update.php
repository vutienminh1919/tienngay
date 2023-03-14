<div class="right_col" role="main" style="min-height: 3815px;">
    <input type="hidden" id="id" value="<?= !empty($this->uri->segment(3)) ? $this->uri->segment(3) : ""?>">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Cập nhật khách hàng
                <br>
                <small>
                    <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="<?php echo base_url('lead')?>">Danh sách khách hàng</a>/ <a href="#">Cập nhật khách hàng</a>
                </small>
                </h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Số điện thoại <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="phone_number" value="<?= !empty($lead->phone_number) ? $lead->phone_number : ""?>" class="form-control col-md-7 col-xs-12" data-parsley-id="5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Loại tài chính<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="type_finance" class="form-control">
                                        <option value="1" <?= $lead->type_finance == 1 ? "selected" : ""?> >Cầm đồ</option>
                                        <option value="2" <?= $lead->type_finance == 2 ? "selected" : ""?>>Vay tiền</option>
                                      </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Trạng thái gọi điện <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="call" class="form-control">
                                        <option value="1" <?= $lead->call == 1 ? "selected" : ""?>>Chưa gọi</option>
                                        <option value="2" <?= $lead->call == 2 ? "selected" : ""?>>Đã gọi</option>
                                      </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tình trạng<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" <?= $lead->status == 1 ? "selected" : ""?> >Số máy không tồn tại, số máy không có thực,sai số</option>
                                        <option value="2" <?= $lead->status == 2 ? "selected" : ""?>>Thuê bao hiện đang tạm khóa</option>
                                        <option value="3" <?= $lead->status == 3 ? "selected" : ""?>>Gọi điện có tín hiệu nhưng Khách hàng không nghe máy</option>
                                        <option value="4" <?= $lead->status == 4 ? "selected" : ""?>>Thuê bao hiện không liên lạc được</option>
                                        <option value="5" <?= $lead->status == 5 ? "selected" : ""?>>Máy điện thoại báo bận</option>
                                        <option value="6" <?= $lead->status == 6 ? "selected" : ""?>>Khách hàng nghe máy nhưng hẹn gọi lại sau (chưa tư vấn được gì)</option>
                                        <!--Có thêm 2 option con-->
                                        <option value="7" data-temp="temp_7" <?= $lead->status == 7 ? "selected" : ""?>>Không đạt yêu cầu</option>
                                        <!--Có thêm 4 option con-->
                                        <option value="8" data-temp="temp_8" <?= $lead->status == 8 ? "selected" : ""?>>Khách hàng không quan tâm/không có nhu cầu, không đồng ý nghe tư vấn</option>
                                        <!--Có thêm nhiều option con-->
                                        <option value="9" data-temp="temp_9" <?= $lead->status == 9 ? "selected" : ""?>>Khách hàng đồng ý nghe tư vấn</option>
                                    </select>
                                </div>
                            </div>
                            
                            <?php if(!empty($lead->reason_1) && $lead->status == 7) { ?>
                                <div class="form-group div-temp">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 1 <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="reason_1" id="reason_1" class="form-control">
                                            <option value="1" <?= $lead->reason_1 == 1 ? "selected" : ""?> >Nơi cư trú không đạt điều kiện (tỉnh/tp khác)</option>
                                            <option value="2" <?= $lead->reason_1 == 2 ? "selected" : ""?> >Tuổi thấp hơn/Cao hơn so với điều kiện</option>
                                        </select>
                                    </div>
                                </div>
                            <?php }?>
                            
                            <?php if(!empty($lead->reason_1) && $lead->status == 8) { ?>
                                <div class="form-group div-temp">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 1 <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="reason_1" id="reason_1" class="form-control">
                                            <option value="1" <?= $lead->reason_1 == 1 ? "selected" : ""?> >Lý do khác</option>
                                            <option value="2" <?= $lead->reason_1 == 2 ? "selected" : ""?> >Khách hàng từ chối nghe</option>
                                            <option value="3" <?= $lead->reason_1 == 3 ? "selected" : ""?> >Khách hàng không thích/không hài lòng về VFC</option>
                                            <option value="4" <?= $lead->reason_1 == 4 ? "selected" : ""?> >Khách hàng không có nhu cầu</option>
                                        </select>
                                    </div>
                                </div>
                            <?php }?>
                            
                            <?php if(!empty($lead->reason_1) && $lead->status == 9) { ?>
                                <div class="form-group div-temp">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 1 <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="reason_1" id="reason_1" class="form-control" onchange="changeLevel9(this)">
                                            <option value="1" <?= $lead->reason_1 == 1 ? "selected" : ""?>>KH quan tâm nhưng không đạt điều kiện</option>
                                            <option value="2" <?= $lead->reason_1 == 2 ? "selected" : ""?>>KH có nhu cầu và đạt điều kiện</option>
                                            <option value="3" <?= $lead->reason_1 == 3 ? "selected" : ""?>>Khách hàng đang nghe tư vấn thì bận việc và hẹn gọi lại sau</option>
                                            <option value="4" <?= $lead->reason_1 == 4 ? "selected" : ""?>>Khách hàng không có nhu cầu</option>
                                            <option value="5" <?= $lead->reason_1 == 5 ? "selected" : ""?>>Khách hàng đã có khoản vay của VFC (chưa tất toán)</option>
                                        </select>
                                    </div>
                                </div>
                            <?php }?>
                            
                            <?php if(!empty($lead->reason_2) && $lead->reason_1 == 1 && $lead->status == 9) { ?>
                                <div class="form-group div-temp div-temp-9">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 2 <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="reason_2" id="reason_2" class="form-control">
                                            <option value="1" <?= $lead->reason_2 == 1 ? "selected" : ""?>>Khác</option>
                                            <option value="2" <?= $lead->reason_2 == 2 ? "selected" : ""?>>Công việc/nghề nghiệp không đạt điều kiện</option>
                                            <option value="3" <?= $lead->reason_2 == 3 ? "selected" : ""?>>Tài sản không đạt điều kiện</option>
                                            <option value="4" <?= $lead->reason_2 == 4 ? "selected" : ""?>>Địa chỉ cư trú không đạt điều kiện (Đã đạt đk 7.1)</option>
                                            <option value="5" <?= $lead->reason_2 == 5 ? "selected" : ""?>>Thời gian cư trú không đạt kiền kiện</option>
                                        </select>
                                    </div>
                                </div>
                            <?php }?>
                            
                            <?php if(!empty($lead->reason_2) && $lead->reason_1 == 2 && $lead->status == 9) { ?>
                                <div class="form-group div-temp div-temp-9">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 2 <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="reason_2" id="reason_2" class="form-control" onchange="changeLevel9_2(this)">
                                            <option value="1" <?= $lead->reason_2 == 1 ? "selected" : ""?>>Khách hàng đạt điều kiện nhưng chưa đồng ý nộp hồ sơ</option>
                                            <option value="2" <?= $lead->reason_2 == 2 ? "selected" : ""?>>KH quan tâm, đạt điều kiện và hứa nộp hồ sơ trong vòng từ 1-3 ngày</option>
                                            <option value="3" <?= $lead->reason_2 == 3 ? "selected" : ""?>>KH nộp hồ sơ và làm thủ tục vay ngay tại PGD/CH</option>
                                        </select>
                                    </div>
                                </div>
                            <?php }?>
                            
                            <?php if(!empty($lead->reason_3) && $lead->reason_1 == 2 && $lead->reason_2 == 1 && $lead->status == 9) { ?>
                                <div class="form-group div-temp-9-2">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 3<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="reason_3" id="reason_3" class="form-control">
                                            <option value="1" <?= $lead->reason_3 == 1 ? "selected" : ""?>>Khác</option>
                                            <option value="2" <?= $lead->reason_3 == 2 ? "selected" : ""?>>Đã có Khoản vay của Ngân hàng/TCTC khác</option>
                                            <option value="3" <?= $lead->reason_3 == 3 ? "selected" : ""?>>Lãi suất cao</option>
                                            <option value="4" <?= $lead->reason_3 == 4 ? "selected" : ""?>>Khách hàng muốn Khoản vay cao hơn/ Thời hạn vay dài hơn</option>
                                            <option value="5" <?= $lead->reason_3 == 5 ? "selected" : ""?>>Không đồng ý các loại phí</option>
                                        </select>
                                    </div>
                                </div>
                            <?php }?>
                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary" type="button" onclick="window.location.href='<?= base_url("lead")?>'"><i class="fa fa-times" aria-hidden="true"></i> Hủy</button>
                                    <button type="button" class="btn btn-success btn-save"><i class="fa fa-save"></i> Lưu lại</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/js/lead/index.js")?>"></script>
<script type="text/template" id="temp_7">
    <div class="form-group div-temp">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 1 <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="reason_1" id="reason_1" class="form-control">
                <option value="1">Nơi cư trú không đạt điều kiện (tỉnh/tp khác)</option>
                <option value="2">Tuổi thấp hơn/Cao hơn so với điều kiện</option>
            </select>
        </div>
    </div>
</script>
<script type="text/template" id="temp_8">
    <div class="form-group div-temp">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 1 <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="reason_1" id="reason_1" class="form-control">
                <option value="1">Lý do khác</option>
                <option value="2">Khách hàng từ chối nghe</option>
                <option value="3">Khách hàng không thích/không hài lòng về VFC</option>
                <option value="4">Khách hàng không có nhu cầu</option>
            </select>
        </div>
    </div>
</script>
<script type="text/template" id="temp_9">
    <div class="form-group div-temp">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 1 <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="reason_1" id="reason_1" class="form-control" onchange="changeLevel9(this)">
                <option value="1">KH quan tâm nhưng không đạt điều kiện</option>
                <option value="2">KH có nhu cầu và đạt điều kiện</option>
                <option value="3">Khách hàng đang nghe tư vấn thì bận việc và hẹn gọi lại sau</option>
                <option value="4" selected>Khách hàng không có nhu cầu</option>
                <option value="5">Khách hàng đã có khoản vay của VFC (chưa tất toán)</option>
            </select>
        </div>
    </div>
</script>
<script type="text/template" id="temp_9_1">
    <div class="form-group div-temp div-temp-9">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 2 <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="reason_2" id="reason_2" class="form-control">
                <option value="1">Khác</option>
                <option value="2">Công việc/nghề nghiệp không đạt điều kiện</option>
                <option value="3">Tài sản không đạt điều kiện</option>
                <option value="4">Địa chỉ cư trú không đạt điều kiện (Đã đạt đk 7.1)</option>
                <option value="5">Thời gian cư trú không đạt kiền kiện</option>
            </select>
        </div>
    </div>
</script>
<script type="text/template" id="temp_9_2">
    <div class="form-group div-temp div-temp-9">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 2 <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="reason_2" id="reason_2" class="form-control" onchange="changeLevel9_2(this)">
                <option value="1">Khách hàng đạt điều kiện nhưng chưa đồng ý nộp hồ sơ</option>
                <option value="2" selected>KH quan tâm, đạt điều kiện và hứa nộp hồ sơ trong vòng từ 1-3 ngày</option>
                <option value="3">KH nộp hồ sơ và làm thủ tục vay ngay tại PGD/CH</option>
            </select>
        </div>
    </div>
</script>
<script type="text/template" id="temp_9_2_1">
    <div class="form-group div-temp-9-2">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Diễn giải 3<span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="reason_3" id="reason_3" class="form-control">
                <option value="1">Khác</option>
                <option value="2">Đã có Khoản vay của Ngân hàng/TCTC khác</option>
                <option value="3">Lãi suất cao</option>
                <option value="4">Khách hàng muốn Khoản vay cao hơn/ Thời hạn vay dài hơn</option>
                <option value="5">Không đồng ý các loại phí</option>
            </select>
        </div>
    </div>
</script>
