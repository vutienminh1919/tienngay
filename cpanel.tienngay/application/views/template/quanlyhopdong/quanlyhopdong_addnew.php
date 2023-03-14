<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/template/validate.js"></script>
<link href="<?php echo base_url();?>assets/build/css/add-newcontract.css" rel="stylesheet">
<!-- page content -->
<div class="right_col add-newcontract" role="main">
	<div class="theloading" style="display:none" >
		<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
		<span ><?= $this->lang->line('Loading')?>...</span>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="page-title">
				<h3>Hội sở/ Quản lý hợp đồng/ Tạo hợp đồng vay mới</h3>
			</div>
		</div>
		<div class="col-xs-12 nopadding">
			<div id="wizard" class="form_wizard wizard_horizontal">
				<ul class="wizard_steps">
					<li>
						<a id="user-step1" href="#step-1">
						<span class="step_no">
							<img src="<?php echo base_url();?>assets/imgs/icon/person-bounding-box.svg" style="max-width: 32px; max-height: 32px;" alt="check-user">
						</span>
							<span class="step_descr">
						    Nhận diện khách hàng
					    </span>
						</a>
					</li>
					<li>
						<a id="user-step2" href="#step-2" class="disabled">
						<span class="step_no">
							<img src="<?php echo base_url();?>assets/imgs/icon/user.svg" style="max-width: 32px; max-height: 32px;" alt="user">
						</span>
							<span class="step_descr">
							Thông tin khách hàng và thông tin liên quan
						</span>
						</a>
					</li>
					<li>
						<a id="user-step3" href="#step-3"  class="disabled">
						<span class="step_no">
							<img src="<?php echo base_url();?>assets/imgs/icon/file-alt-solid.svg" style="max-width: 32px; max-height: 32px;" alt="document">
						</span>
							<span class="step_descr">
						  	Thông tin hồ sơ liên quan
					  	</span>
						</a>
					</li>
				</ul>
			</div>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">123</div>
				<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">23123</div>
			</div>
			<form role="form" id="main_1" class="form-horizontal form-label-left" action="/example" method="post" novalidate>
				<!--      <form role="form" class="form-horizontal form-label-left">-->
				<div class="form-horizontal form-label-left">
					<div class="setup-content" id="step-1">
						<?php $this->load->view('template/quanlyhopdong/quanlyhopdong_addnew_1');?>
					</div>
					<div class="setup-content" id="step-2">
						<?php $this->load->view('template/quanlyhopdong/quanlyhopdong_addnew_2');?>
					</div>
					<div class="setup-content" id="step-3">
						<?php $this->load->view('template/quanlyhopdong/quanlyhopdong_addnew_3');?>
					</div>
				</div>
				<div style="height: 50px">
					<button id="nextBtnCreate_1" class="btn btn-primary nextBtn pull-right mt-2" type="button">Tiếp tục</button>
					<button id="backStep" class="btn btn-secondary pull-right mt-2" type="button" style="display: none;">Trở lại</button>
				</div>

			</form>

		</div>

	</div>
</div>
<!-- /page content -->
<div id='toTop'>
	<i class="fa fa-arrow-circle-up"></i>
</div>
<script src="<?php echo base_url();?>assets/js/lead/index.js"></script>

<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets")?>/js/numeral.min.js"></script>
<!--<script src="--><?php //echo base_url() ?><!--assets/js/template/create_contract.js"></script>-->
<script src="<?php echo base_url() ?>assets/js/add_newcontract/index.js"></script>



