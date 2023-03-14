<!-- page content -->
<div class="load"></div>
<div id="loading" class="theloading" style="display: none;">
	<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
<div class="right_col" role="main">
<?php $message = $this->session->flashdata('error'); ?>
	<?php
	if (isset($message)) {
		echo '<div class="alert alert-danger" id="hide_it">' . $message . '</div>';
		$this->session->unset_userdata($message);
	}
	?>
    <div class="realEstate">
        <h3>Thêm mới hợp đồng thuê mặt bằng</h3>
		<div class="btn-top">
			<small>
				<a href="<?php echo base_url("tenancy/listTenancy"); ?>"><i class="fa fa-home"></i>Danh sách hợp
					đồng</a>
			</small>
			<div style="display: flex">
				<?php if (in_array('ke-toan', $groupRoles)): ?>
					<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal1">Import hợp
						đồng <img src="<?php echo base_url(); ?>assets/imgs/icon/ic_import.svg" alt=""></button>
				<?php endif; ?>
				<div class="form-btn">
					<a type="button" class="btn btn-success"
					   href="<?= base_url("tenancy/exampleExcel") ?>"
					   target="_blank">Tải xuống file mẫu</a>
				</div>
			</div>
		</div>
            <h3>Thông tin hợp đồng</h3>
            <div>
                <div class="realEstate-label"><span><b>1</b> Thông tin hợp đồng thuê</span></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-input">
                            <p>Số hợp đồng thuê<span>*</span></p>
                            <input type='text' placeholder="Nhập" name="code_contract" value="<?= set_value('code_contract'); ?>" required />
                        </div>
                    </div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Ngày bắt đầu tính tiền <span>*</span></p>
							<input type='text' onfocus="(this.type='date')" placeholder="Ngày"
								   name="start_date_contract" value="<?= set_value('start_date_contract'); ?>"/>
						</div>
					</div>
                    <div class="col-md-4">
                        <div class="form-input">
                            <p>Ngày kết thúc hợp đồng<span>*</span></p>
                            <input type='text' onfocus="(this.type='date')" placeholder="Ngày" name="end_date_contract" value="<?= set_value('end_date_contract'); ?>"/>
                        </div>
                    </div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Ngày ký hợp đồng<span>*</span></p>
							<input type='text' onfocus="(this.type='date')" placeholder="Ngày" name="date_contract"
								   value="<?= set_value('date_contract'); ?>"/>
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-input">
							<p>Thời hạn thuê<span>*</span></p>
							<select name="contract_expiry_date" id="">
								<option value="">Chọn thời hạn thuê</option>
								<option value="1">1 năm</option>
								<option value="2">2 năm</option>
								<option value="3">3 năm</option>
								<option value="4">4 năm</option>
								<option value="5">5 năm</option>
							</select>
						</div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-input">
                           <p>Nhân viên phụ trách</p>
								<input type='text' placeholder="Nhập Nhân viên " name="staff_ptmb" value="<?= set_value('staff_ptmb'); ?>"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-input">
                            <p>Phòng giao dịch<span>*</span></p>
								<input type='text' placeholder="Nhập" name="store_name" value="<?= set_value('store_name'); ?>"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-input">
                            <p>Khu vực<span>*</span></p>
							<select name="address" id="address">
								<option value="">-- Chọn tỉnh/Tp --</option>
								<?php foreach ($result_district as $e): ?>
									<option value="<?= $e->code ?>"><?php echo $e->name ?></option>
								<?php endforeach; ?>
							</select>
                        </div>
                    </div>
					<div class="col-md-4">
						<div class="form-input">
							<p>Công ty<span>*</span></p>
							<input type='text' placeholder="Nhập" name="name_cty" value="<?= set_value('name_cty'); ?>"/>
						</div>
					</div>
                    <div class="col-md-4">
                        <div class="form-input">
                            <p>Diện tích mặt bằng(m2)<span>*</span></p>
                            <input type='number' placeholder="Nhập" name="dien_tich"  value="<?= set_value('dien_tich'); ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="realEstate-label"><span><b>2</b> Thông tin chủ nhà</span></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-input">
                            <p>Họ tên chủ nhà<span>*</span></p>
                            <input type='text' placeholder="Nhập" name="ten_chu_nha" value="<?= set_value('ten_chu_nha'); ?>"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-input">
                            <p>Số điện thoại<span>*</span></p>
                            <input type='text' placeholder="Nhập" name="sdt_chu_nha" value="<?= set_value('sdt_chu_nha'); ?>"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-input">

							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Chủ tài khoản <span>*</span></p>
								<input type='text' placeholder="Nhập" name="ten_tk_chu_nha" value="<?= set_value('ten_tk_chu_nha'); ?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Số tài khoản<span>*</span></p>
								<input type='text' placeholder="Nhập" name="so_tk_chu_nha" value="<?= set_value('so_tk_chu_nha'); ?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Ngân hàng <span>*</span></p>
								<select name="bank_name" id="bank_name">
									<option value="">-- Chọn Ngân Hàng --</option>
									<?php  foreach ($result_bank_name as $i): ?>
										<option value="<?= $i->bank_code ?>"><?php echo $i->name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div>
					<div class="realEstate-label"><span><b>3</b> Thông tin đặt cọc</span></div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-input">
								<p>Số tiền đặt cọc<span>*</span></p>
								<input type='text' placeholder="Nhập" name="tien_coc" id="tien_coc" value="<?= set_value('tien_coc'); ?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Ngày đặt cọc<span>*</span></p>
								<input type='text' onfocus="(this.type='date')" placeholder="Ngày" name="ngay_dat_coc" value="<?= set_value('ngay_dat_coc'); ?>"/>
							</div>
					</div>
				</div>
				<div>
					<div class="realEstate-label"><span><b>4</b> Thông tin tin thanh toán</span></div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-input">
								<p>Giá thuê/tháng<span>*</span></p>
								<input type='text' placeholder="Nhập" name="one_month_rent" id="one_month_rent" value="<?= set_value('one_month_rent'); ?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Kỳ hạn thanh toán<span>*</span></p>
								<select name="ky_tra" id="">
									<option value="">-- Chọn kỳ hạn thanh toán --</option>
									<option value="1">1 tháng</option>
									<option value="2">2 tháng</option>
									<option value="3">3 tháng</option>
									<option value="6">6 tháng</option>
									<option value="12">12 tháng</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div>
					<div class="realEstate-label"><span><b>5</b> Thông tin thuế</span></div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-input">
								<p>Mã số thuế</p>
								<input type='text' placeholder="Nhập" name="ma_so_thue" value="<?= set_value('ma_so_thue'); ?>"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-input">
								<p>Trách nhiệm kê khai</p>
								<select name="nguoi_nop_thue" id="">
									<option value="">Chọn bên thanh toán thuế</option>
									<option value="1">Công ty</option>
									<option value="2">Chủ nhà</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<?php if (in_array('ke-toan',$groupRoles)):?>
				<button type="submit" class="btn btn-success" id="insertTenancy">Hoàn thành <img
							src="<?php echo base_url(); ?>assets/imgs/icon/ic_check.svg" alt=""></button>
				<?php endif; ?>
				<button class="btn btn-danger">
					<a href="<?php echo base_url("tenancy/listTenancy"); ?>" style="color: white">
					Quay lại
					</a>
				</button>
			</div>
	</div>
	<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1-label">

		<div class="modal-dialog " role="document" id="iic">
			<div class="modal-content table-respon	sive">
			<div class="x_content">
				<div class="row_import">
						<div class="dashboarditem_line2 orange">
							<div class="thetitle">
								<i class="fa fa-upload"></i> Import Lead
							</div>
							<div class="panel panel-default">
								<form class="form-inline" id="form_transaction"
									  action="<?php echo base_url('tenancy/importTenancy') ?>"
									  enctype="multipart/form-data"
									  method="post">
									<strong><?= $this->lang->line('Upload') ?>&nbsp;</strong>
									<div class="form-group">
										<input type="file" name="upload_file" class="form-control"
											   placeholder="sothing">
									</div>
									<button type="submit" class="btn btn-primary" id="import_baddebt"
											style="margin:0"><?= $this->lang->line('Upload') ?></button>
								</form>
							</div>
						</div>
				</div>
			</div>
			</div>
		</div>
	</div>

</div>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .realEstate h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .realEstate-form {
        padding: 16px;
        gap: 10px;
        width: 100%;
        background: #FFFFFF;
        border-radius: 8px;
        display: flex;
        flex-direction: column;

    }

    .realEstate-form h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .realEstate-form button {
        padding: 8px 16px;
        gap: 8px;
        width: 141px;
        height: 40px;
        color: white;
    }

    .realEstate-label {
        display: flex;
        flex-direction: row;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #676767;
    }

    .realEstate-label b {
        color: #1D9752;

    }

    .realEstate-label::after {
        content: "";
        flex: 1 1;
        border-bottom: 1px solid #D9D9D9;
        margin: auto;
        margin-left: 10px;
    }

    .form-input p {
        padding-top: 14px;
    }

    .form-input p {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #676767;
    }

    .form-input span {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
        color: #C70404;
    }

    .form-input input {
        padding: 16px;
        width: 100%;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
    }

    .form-input select {
        width: 100%;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        padding-left: 10px;
    }

    .form-input select option {
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        height: 35px;
        width: 100%;
    }
.form-input{
    margin-bottom: 8px;
}
    .btn-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 20px;
    }

	.theloading {
		position: fixed;
		z-index: 999;
		display: block;
		width: 100vw;
		height: 100vh;
		background-color: rgba(0, 0, 0, .7);
		top: 0;
		right: 0;
		color: #fff;
		display: flex;
		justify-content: center;
		align-items: center
	}

	.invalid{
		border: 1px solid red !important;
	}
</style>
<script>

	$(document).ready(function () {
		$("#insertTenancy").click(function (event) {
			event.preventDefault();
			$('.invalid-message').remove();
			$('.invalid').removeClass();
			var code_contract = $("input[name='code_contract']").val();
			var date_contract = $("input[name='date_contract']").val();
			var end_date_contract = $("input[name='end_date_contract']").val();
			var start_date_contract = $("input[name='start_date_contract']").val();
			var contract_expiry_date = $("select[name='contract_expiry_date']").val();
			var staff_ptmb = $("input[name='staff_ptmb']").val();
			var store_name = $("input[name='store_name']").val();
			var address = $("select[name='address']").val();
			var name_cty = $("input[name='name_cty']").val();
			var dien_tich = $("input[name='dien_tich']").val();
			var ten_chu_nha = $("input[name='ten_chu_nha']").val();
			var sdt_chu_nha = $("input[name='sdt_chu_nha']").val();
			var ten_tk_chu_nha = $("input[name='ten_tk_chu_nha']").val();
			var so_tk_chu_nha = $("input[name='so_tk_chu_nha']").val();
			var bank_name = $("select[name='bank_name']").val();
			var tien_coc = $("input[name='tien_coc']").val();
			var ngay_dat_coc = $("input[name='ngay_dat_coc']").val();
			var one_month_rent = $("input[name='one_month_rent']").val();
			var ky_tra = $("select[name='ky_tra']").val();
			var ma_so_thue = $("input[name='ma_so_thue']").val();
			var nguoi_nop_thue = $("select[name='nguoi_nop_thue']").val();
			var formData = new FormData();
			formData.append('code_contract', code_contract)
			formData.append('date_contract', date_contract)
			formData.append('end_date_contract', end_date_contract)
			formData.append('start_date_contract', start_date_contract)
			formData.append('contract_expiry_date', contract_expiry_date)
			formData.append('staff_ptmb', staff_ptmb)
			formData.append('store_name', store_name)
			formData.append('address', address)
			formData.append('name_cty', name_cty)
			formData.append('dien_tich', dien_tich)
			formData.append('ten_chu_nha', ten_chu_nha)
			formData.append('sdt_chu_nha', sdt_chu_nha)
			formData.append('ten_tk_chu_nha', ten_tk_chu_nha)
			formData.append('so_tk_chu_nha', so_tk_chu_nha)
			formData.append('bank_name', bank_name)
			formData.append('tien_coc', tien_coc)
			formData.append('ngay_dat_coc', ngay_dat_coc)
			formData.append('one_month_rent', one_month_rent)
			formData.append('ky_tra', ky_tra)
			formData.append('ma_so_thue', ma_so_thue)
			formData.append('nguoi_nop_thue', nguoi_nop_thue)
			console.log(bank_name);
			$.ajax({
				url: _url.base_url + 'tenancy/tenancyInsert',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					$(".modal_missed_call").hide();
					if (data.status == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.msg);
						window.scrollTo(0, 0);
						setTimeout(function () {
							window.location.reload();
						}, 500);
					} else {
						if (data.msg) {
							$(".msg_error").html("");
							 $.each(data.msg, function(i) {$('[name=' + i + ']').after("<span class='invalid-message' style='margin-top: 5px'>" + data.msg[i] + "</span>"); $('[name=' + i + ']').addClass("invalid")});
						}
						window.scrollTo(0, 0);
					}
				},
				error: function (data) {
					console.log(data);
					$(".theloading").hide();
				}
			})
		})

		function addCommas(str) {
			return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}

		$('#tien_coc').on('keyup', function (event) {
			var tien_coc = $("input[name='tien_coc']").val()
			$('#tien_coc').val(addCommas(tien_coc))
		})

		$('#one_month_rent').on('keyup', function (event) {
			var one_month_rent = $("input[name='one_month_rent']").val()
			$('#one_month_rent').val(addCommas(one_month_rent))
		})

	})

</script>

<script type="text/javascript">
  $(document).ajaxStart(function() {
    $("#loading").show();
    var loadingHeight = window.screen.height;
    $("#loading, .right-col iframe").css('height', loadingHeight);
    }).ajaxStop(function() {
      $("#loading").hide();
  });
</script>
