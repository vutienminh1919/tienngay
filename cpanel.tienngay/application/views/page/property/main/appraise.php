<div class="right_col" role="main">
<div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>Định giá tài sản
          <br>
					<small>
					<a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Định giá tài sản</a>
					</small>
          </h3>
      </div>
      <div class="title_right text-right">


        <a href="<?php echo base_url('property_main/listMainProperty')?>" class="btn btn-info ">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
            <?= $this->lang->line('Come_back')?>

        </a>
      </div>
    </div>
  </div>

  <br>&nbsp;
  <div class="row flex justify-content-center">
      <div class="col-xs-12  col-lg-8">
          <div class="card card-appraise" >
          <div class="card-body">
              <h5 class="card-title"><?= $this->lang->line('CHOOSE_THE_TYPE_LOAN')?></h5>
              <div class="form-group m-0 ">
                 <select class="form-control formality appraise" id="type_finance">
                  <?php 
                      if($configuration_formality){
                          foreach($configuration_formality as $key => $cf){
                  ?>
                     <option data-id="<?= getId($cf->_id)?>" data-code="<?= $cf->code ?>"  value='<?= !empty($cf->percent) ? $cf->percent : ""?>'><?= !empty($cf->name) ? $cf->name : ""?></option>
                  <?php }}?>
                </select>
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title"> <?= $this->lang->line('SELECT_ASSETS_WANT_VALUATE')?></h5>
              <ul class="selecttype step1">
              <?php 
                    if(!empty($mainPropertyData)){
                        foreach($mainPropertyData as $key => $property){
              ?>
                <li>
                  <input code="<?= !empty($property->code) ? $property->code : "" ?>" id="selecttype_<?php echo $key?>" onchange="get_property_by_main(this)"  type="radio" name="selecttype" value="<?= !empty($property->_id->{'$oid'}) ? $property->_id->{'$oid'} : "" ?>">
                  <label for="selecttype_<?php echo $key?>" class="unchecked">
                  <?php 
                    if($property->name == "Xe Máy"){
                  ?>
                    <img src="<?php echo base_url();?>assets/imgs/icon/appraise_bike.png" alt="">
                  <?php }else{?>
                    <img src="<?php echo base_url();?>assets/imgs/icon/appraise_car.png" alt="">
                  <?php }?>
                  </label>
                  <label for="selecttype_<?php echo $key?>" class="checked">
                   
                    <?php 
                      if($property->name == "Xe Máy"){
                    ?>
                     <img src="<?php echo base_url();?>assets/imgs/icon/appraise_bike_checked.png" alt="">
                    <?php }else{?>
                      <img src="<?php echo base_url();?>assets/imgs/icon/appraise_car_checked.png" alt="">
                    <?php }?>
                  </label>
                  <?= !empty($property->name) ? $property->name : "" ?>
                </li>
                    <?php }}?>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title"><?= $this->lang->line('CHOOSE_PROPERTY_INFORMATION')?> </h5>
              <div class="form-group m-0 step2 select_property_by_main">
                <!-- <input type="text" class="form-control" placeholder="Hãng dòng, năm sản xuất. VD HonDa, 2018"> -->
                 <select class="form-control" id="selectize_property_by_main">
                    <option value=""><?= $this->lang->line('Select_property_information')?></option>
                </select>
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title"><?= $this->lang->line('CHOOSE_WHOLESALE_PRODUCT')?></h5>
              <div class="step3 depreciation_by_property" >  </div>
            </div>
            <div class="card-body">
              <button class="btn btn-lg btn-success w-100 thesubmit appraise" ><?= $this->lang->line('appraise')?></button>
            </div>
            <div class="card-body result_appraise" style="display:none">
              <h5 class="card-title text-pawn1"><?= $this->lang->line('VALUATION_RESULTS')?>:</h5>
              <div class="card-text">
                <?= $this->lang->line('Your_car_worth')?>: <span class='depreciation_price'  style="font-weight: bold;color: red;"></span> <span  style="font-weight: bold;color: red;">vnđ</span>
              </div>

              <div class="card-text">
              <?= $this->lang->line('amount_you_borrow')?>: <span class='amount_money'  style="font-weight: bold;color: red;"></span> <span  style="font-weight: bold;color: red;">vnđ</span>
              </div>
            </div>
            <div class="card-body create_contract" style="display:none">
             
               <input type="hidden" name='percent_type_loan' id="percent_type_loan" value="50"  class="form-control "  placeholder="" >
            </div>
          </div>

      </div>

    </div>

</div>
<style>
  .selectize-dropdown-content {
    max-height: initial !important;
    background-color:#fff;
  }
	.selecttype.step1 li:nth-child(3), .selecttype.step1 li:nth-child(4)
	{
		display: none !important;
	}
</style>
<script src="<?php echo base_url();?>assets/js/property/index.js"></script>

