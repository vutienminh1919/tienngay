
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3><?php echo $this->lang->line('store_list')?>
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#"><?php echo $this->lang->line('store_list')?></a>
            </small>
          </h3>
        </div>
        <div class="title_right text-right">
          <a href="<?php echo base_url("store/createStore")?>" class="btn btn-info " ><i class="fa fa-plus" aria-hidden="true"></i> <?php echo $this->lang->line('add_new')?></a>
        </div>
      </div>
    </div>

    <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">
          <div class="row">
            <div class="col-xs-12">

              <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo $this->lang->line('store')?></th>
                      <th><?php echo $this->lang->line('Address')?></th>
                      <th><?php echo $this->lang->line('phone')?></th>
                      <th><?php echo $this->lang->line('investment_amount')?></th>
                      <th><?php echo $this->lang->line('created_date')?></th>
                      <th><?php echo $this->lang->line('type')?></th>
                      <th><?php echo $this->lang->line('status')?></th>
                      <th><?php echo $this->lang->line('Function')?></th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php 
                    if(!empty($storeData)) {
                        $stt = 0;
                        foreach($storeData as $key => $store){
                            if($store->status != 'block'){
                            $stt++;

                    ?>
                    <tr class='store_<?= !empty($store->_id->{'$oid'}) ? $store->_id->{'$oid'} : "" ?>'>
                      <td><?php echo $stt ?></td>
                      <td><?= !empty($store->name) ?  $store->name : ""?></td>
                      <td><?= !empty($store->address) ?  $store->address : ""?></td>
                      <td><?= !empty($store->phone) ?  $store->phone : ""?></td>
                      <td><?= !empty($store->investment) ? number_format($store->investment) : ""?></td>
                      <td><?= !empty($store->created_at) ?   date('m/d/Y', $store->created_at): ""?></td>
                      <td>
                      <?php
                            $type =  !empty($store->type_pgd) ?  $store->type_pgd : "";
                            if($type == '1'){
                                echo'Phòng giao dịch';
                            }else if($type == '2'){
                                echo 'Trung tâm bán';
                            } else {
                              echo 'Đã cơ cấu' ;
                            }
                        
                        ?>
                      </td>
                      <td>
                      <?php
                            $status =  !empty($store->status) ?  $store->status : "";
                            if($status == 'active'){
                                echo $this->lang->line('active');
                            }else{
                                echo $this->lang->line('deactive');
                            }
                        
                        ?>
                      </td>
                      <td>
						  <a class="btn btn-primary"  href="<?php echo base_url("store/update?id=").$store->_id->{'$oid'}?>">
							  <i class="fa fa-edit"></i> Sửa
						  </a>
						  <a class="btn btn-danger mr-0 btn-delete" href="javascript:void(0);"  data-toggle="modal" data-target="#detele_<?php echo $store->_id->{'$oid'}?>">
							  <i class="fa fa-close"></i> Xóa
						  </a>
                      </td>
                      <!-- Modal HTML -->
                        <div id="detele_<?php echo $store->_id->{'$oid'}?>" class="modal fade">
                            <div class="modal-dialog modal-confirm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="icon-box danger">
                                            <!-- <i class="fa fa-times"></i> -->
                                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                                        </div>
                                    
                                        <h4 class="modal-title"><?php echo $this->lang->line('title_delete')?>?</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo $this->lang->line('body_modal_delete')?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo $this->lang->line('cancel')?></button>
                                        <!-- <button type="button" class="btn btn-danger">Danger</button> -->
                                    <button type="button" data-id="<?= !empty($store->_id->{'$oid'}) ? $store->_id->{'$oid'} : ""?>" class="btn btn-success delete_store" data-dismiss="modal"><?php echo $this->lang->line('ok')?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                  <?php } }}?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<!-- /page content -->
<script src="<?php echo base_url();?>assets/js/store/index.js"></script>
