<!-- page content -->
<div class="right_col" role="main">

  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3><?= $this->lang->line('More_properties')?></h3>
      </div>
      <div class="title_right text-right">


        <a href="#" class="btn btn-info ">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
            <?= $this->lang->line('Come_back')?>

        </a>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
                      <h2><?= $this->lang->line('Some_Text')?></h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-horizontal form-label-left" action="<?php echo base_url("property_main/createMainProperty")?>" method="post">
          <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> <?= $this->lang->line('Property_type')?><span class="red">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name = 'name_property_main' required class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> <?= $this->lang->line('appraise1')?>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name = 'price' required class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('Select_parent')?></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="parent_package_create" name="parent_property" class="form-control">
                    <option value=""><?= $this->lang->line('none')?></option>
                    <?php 
                      if(!empty($mainPropertyData)){
                        foreach($mainPropertyData as $key => $mainProperty){
                    ?>
                      <option value="<?= !empty($mainProperty->_id->{'$oid'}) ? $mainProperty->_id->{'$oid'} : "" ?>"><?= !empty($mainProperty->name) ? $mainProperty->name : "" ?></option>
                      <?php }}?>
                </select>
                </div>
            </div>
            <!-- <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Switch</label>
              <div class="col-md-9 col-sm-9 col-xs-12">

                <div class="radio-inline text-primary">
                  <label>
                    <input type="radio" name="thefilter" value=""> Đang hoạt động
                  </label>
                </div>
                <div class="radio-inline text-danger">
                  <label>
                    <input type="radio" name="thefilter" value=""> Tạm dừng
                  </label>
                </div>


              </div>
            </div> -->
                 <div id="addForm" class="form-group">
                  <div class="col-md-3 col-sm-3 col-xs-12">

                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-info properties"><i class="fa fa-plus"></i>  <?= $this->lang->line('Add_properties')?></button>
                  </div>
                </div>
                <div id="add_properties">
                <div id="form_0" class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?= $this->lang->line('properties')?>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class='input-group '>
                      <input type='text' class="form-control"  name='properties[0]'/>
                      <span class="input-group-btn">
                        <a href="javascript:void(0);" class="btn btn-danger" data-id="form_0" onclick="remove_properties(this)">
                          <i class="fa fa-times"></i> <?= $this->lang->line('DETELE')?>
                        </a>
                      </span>
                    </div>

                  </div>
                </div>
                <!-- <div id="form2" class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Thêm Form
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class='input-group '>
                      <input type='text' class="form-control" />
                      <span class="input-group-btn">
                        <button class="btn btn-danger" onclick="$('#form2').remove()">
                          <i class="fa fa-times"></i> XÓA
                        </button>
                      </span>
                    </div>

                  </div>
                </div> -->
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success"><?= $this->lang->line('Submit')?></button>
                    </div>
                </div>
              </form>
            </ul>

          </div>
        </div>
    </div>
  </div>
  <!-- /page content -->
  <script src="<?php echo base_url();?>assets/js/property/index.js"></script>
<script type="text/javascript">
    $('#parent_package_create').selectize({
        create: false,
        valueField: '_id',
        labelField: 'name',
        searchField: 'name',
        maxItems: 1,
        sortField: {
            field: 'name',
            direction: 'asc'
        }
    });
</script>

