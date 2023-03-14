<!-- page content -->
<div class="right_col" role="main">
	<div class="theloading" style="display:none">
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span><?= $this->lang->line('Loading') ?>...</span>
	</div>
	<div class="row top_tiles">
		<div class="col-xs-9">
			<div class="page-title">
				<div class="title_left" style="width: 100%">
					<h3>Tạo phiếu thu 
						<br>
						<small>
							<a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>/ <a href="#">Thu hồ
								nơ</a> / <a href="#">Tạo phiếu thu cho hợp đồng</a>
						</small>
					</h3>
					<div class="alert alert-danger alert-result" id="div_error"
						 style="display:none; color:white;"></div>
				</div>
			</div>
		</div>

    
		<div class="col-xs-12">
<?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger alert-result">
                  <?= $this->session->flashdata('error') ?>
                </div>
              <?php } ?>
              <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
              <?php } ?>

			<div class="row">
				<div class="x_panel">
					<div class="x_content">
						<form class="form-horizontal form-label-left" id="fetch_results"
							  action="<?php echo base_url("temporary_plan/do_transaction_created") ?>" method="POST"
							  style="width: 100%;" >



							<div class="form-group row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									Mã phiếu ghi
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="code_contract" class="form-control "
										   value="<?= isset($_POST['code_contract']) ? $_POST['code_contract'] : "" ?>"
										   placeholder="Nhập mã phiếu ghi" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									Ngày thanh toán
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="date" name="date" class="form-control"
										   value="<?= isset($_POST['date']) ? $_POST['date'] : "" ?>">
								</div>
							</div>
                            <div class="form-group row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									Số tiền thanh toán
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="amount" class="form-control"
										   value="<?= isset($_POST['amount']) ? $_POST['amount'] : "" ?>">
								</div>
							</div>
						 <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                   
                    <button class="btn btn-success" type="submit">
                      <i class="fa fa-save"></i>
                       Tạo phiếu thu
                    
                  </button>
                  </div>
                </div>
						</form>
          
          
<script type="text/javascript">
	// detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');
 window.setTimeout(function () { 
         $(".alert-danger").alert('close'); 
      }, 4000);    

</script>