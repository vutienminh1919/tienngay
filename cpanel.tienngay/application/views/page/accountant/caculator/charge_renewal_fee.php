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
					<h3>Tính phí gia hạn
                    <br>
                    <small>
                        <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#">Thu hồ nơ</a> / <a href="#">Tính phí gia hạn</a>
                    </small>
                    </h3>
					<div class="alert alert-danger alert-result" id="div_error" style="display:none; color:white;"></div>
				</div>
			</div>
		</div>
		

<div class="col-xs-12">
        <div class="row">
                           
             <form class="form-horizontal form-label-left" action="<?php echo base_url("accountant/caculator_charge_renewal_fee")?>" method="post" style="width: 100%;">


                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                     Mã hợp đồng 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="code_contract" class="form-control " placeholder="Nhập mã hợp đồng" required>
                    </div>
                </div>
               
         
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-success  create_store">
                      <i class="fa fa-save"></i>
                       Tính toán
                    </button>
                
                  </div>
                </div>
              </form>
       
                 <br/>
           <div class="table-responsive">
     <table id="datatable-buttons" class="table table-striped datatable-buttons">
            <thead>
            <tr>
                <th>#</th>
                <th>Tổng lãi còn lại <br> + phí còn lại</th>
                <th>Kỳ này</th>
                <th>Lãi vay</th>
                <th>Phí tư vấn quản lý</th>
                <th>Phí thẩm định <br>và lưu trữ tài sản</th>
                <th>Phí trả gia hạn</th>
              
               
            </tr>
            </thead>
            <tbody name="list_lead">
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

<script src="<?php echo base_url("assets")?>/js/jquery-ui.js"></script>
<script src="<?php echo base_url("assets")?>/js/numeral.min.js"></script>
 <script src="<?php echo base_url();?>assets/js/lead/index.js"></script> 

<script type="text/javascript">
    detail('<?=(isset($_GET['id'])) ? $_GET['id'] : '' ?>');
  

</script>
