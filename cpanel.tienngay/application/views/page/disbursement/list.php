
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3><?= $this->lang->line('Disbursement_management')?>
            <br>
            <small>
                <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#"><?php echo $this->lang->line('Disbursement_management')?></a>       </small>
          </h3>
        </div>

        <div class="title_right text-right">
          <form class="form-inline" action="<?php echo base_url('disbursementAccounting/importDisbursement')?>" enctype="multipart/form-data" method="post">
            <strong><?= $this->lang->line('Upload')?>&nbsp;</strong>
            <div class="form-group">
                <input type="file" name ="upload_file" class="form-control" placeholder="sothing">
            </div>


            <button type="submit" class="btn btn-primary" style="margin:0"><?= $this->lang->line('Upload')?></button>
        </form>
        </div>
      </div>
    </div>
    </div>
    <?php
      $fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
      $tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
      ?>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
      <div class="x_title">
      <form class="" action="<?php echo base_url('disbursementAccounting/search')?>" method="get">
        <div class="row">
          <div class="col-xs-12 col-lg-1">
            <h2> </h2>
          </div>
          <div class="col-xs-12 col-lg-11">
            <div class="row">

              <div class="col-lg-4">

              </div>
              <div class="col-lg-3">
                <div class="input-group">
                  <span class="input-group-addon"><?= $this->lang->line('From')?></span>
                  <input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate : ""?>" >

                </div>
              </div>
              <div class="col-lg-3">
              <div class="input-group">
                  <span class="input-group-addon"><?= $this->lang->line('To')?></span>
                  <input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : ""?>" >

                </div>
              </div>

              <div class="col-lg-2 text-right">
                <button class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>

              </div>
            </div>

          </div>
        </div>
        </form>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-result">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                <?php } ?>
          <!-- <div class="row">
            <div class="col-xs-12 col-lg-1">
              <h2>Dữ liệu</h2>
            </div>
            <div class="col-xs-12 col-lg-11">
              <div class="row">
                <div class="col-lg-4 text-right ">


                </div>
                <div class="col-lg-3">
                  <input type="text" class="form-control" placeholder="somthing">
                </div>
                <div class="col-lg-3">
                  <select class="form-control">
                    <option>Tất cả phòng giao dịch</option>
                    <option>Option one</option>
                    <option>Option two</option>
                    <option>Option three</option>
                    <option>Option four</option>
                  </select>
                </div>

                <div class="col-lg-2 text-right">
                  <button class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</button>

                </div>
              </div>

            </div>
          </div> -->
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            <div class="col-xs-12">
              <div class="row">

              </div>
            </div>
            <div class="col-xs-12">

              <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?= $this->lang->line('Trading_code')?></th>
                      <th><?= $this->lang->line('Contract_Code')?></th>
                      <th><?= $this->lang->line('Borrower')?></th>
                      <th><?= $this->lang->line('Borrower_code')?></th>
                      <th><?= $this->lang->line('Disbursement_date')?></th>
                      <th><?= $this->lang->line('Date_due')?></th>
                      <th><?= $this->lang->line('store')?></th>
                      <th><?= $this->lang->line('formality')?></th>
                      <th><?= $this->lang->line('atm_card_holder')?></th>
                      <th><?= $this->lang->line('ATM_card_number')?></th>
                      <th><?= $this->lang->line('Account_holder')?> </th>
                      <th><?= $this->lang->line('Account_number')?></th>
                      <th><?= $this->lang->line('Bank')?></th>
                      <th><?= $this->lang->line('Bank_code')?> </th>
                      <th><?= $this->lang->line('Branch')?></th>
                      <th><?= $this->lang->line('Amount_money')?></th>
                      <th><?= $this->lang->line('status')?></th>
                      <th><?= $this->lang->line('content')?></th>
                      <th><?= $this->lang->line('created_by')?></th>
                      <th><?= $this->lang->line('create_at')?></th>
                      <th><?= $this->lang->line('Disbursement_by')?></th>
                      <th></th>
                    </tr>
                  </thead>

                  <tbody>
                    <!-- <tr>
                    <td colspan="13" class="text-center">Không có dữ liệu</td>
                  </tr> -->
                  <?php
                    if(!empty($disbursement)){
                     foreach($disbursement as $key => $disbur){
                    ?>
                    <tr>
                      <td><?php echo $key+1 ?></td>
                      <td><?= !empty($disbur->_id->{'$oid'}) ?  (string)$disbur->_id->{'$oid'} : ""?></td>
                      <td><?= !empty($disbur->code_contract) ? (string) $disbur->code_contract : ""?></td>
                      <td><?= !empty($disbur->customer_name) ?  $disbur->customer_name : ""?></td>
                      <td><?= !empty($disbur->customer_id) ?  " ".(string)$disbur->customer_id : ""?></td>
                      <td><?= !empty($disbur->disbursement_at) ?  date('m/d/Y', $disbur->disbursement_at) : ""?></td>
                      <td><?= !empty($disbur->data_expire) ?  date('m/d/Y', $disbur->data_expire) : ""?></td>
                      <td><?= !empty($disbur->story_name) ?  (string)$disbur->story_name : ""?></td>
                      <td><?= !empty($disbur->type_payout) ?  (string)$disbur->type_payout : ""?></td>
                      <!-- <td>
                        <?php
                            $type_payout = !empty($disbur->type_payout) ? $disbur->type_payout : "";
                            if($type_payout == 2){
                                echo "Ngân hàng";
                            }elseif($type_payout == 3){
                                echo "ATM";
                            }
                        ?>
                      </td> -->
                      <td><?= !empty($disbur->atm_card_holder) ?  (string)$disbur->atm_card_holder : ""?></td>
                      <td><?= !empty($disbur->atm_card_number) ?  (string)$disbur->atm_card_number : ""?></td>
                      <td><?= !empty($disbur->bank_account_holder) ?  (string)$disbur->bank_account_holder : ""?></td>
                      <td><?= !empty($disbur->bank_account) ?  (string)$disbur->bank_account : ""?></td>
                      <td><?= !empty($disbur->bank) ?  (string)$disbur->bank : ""?></td>
                      <td><?= !empty($disbur->bank_id) ?  (string)$disbur->bank_id : ""?></td>
                      <td><?= !empty($disbur->bank_branch) ?  (string)$disbur->bank_branch : ""?></td>
                      <td><?= !empty($disbur->amount) ?  number_format($disbur->amount) : ""?></td>
                      <td>
                        <?php
                        $status = !empty($disbur->status) ?  $disbur->status : "";
                        if($status == "new"){
                          echo "Mới";
                        }elseif($status == "create_withdrawal_success"){
                          echo "Đã tạo lệnh giải ngân";
                        }elseif($status == "success"){
                          echo "Giải ngân thành công";
                        }elseif($status == "failed"){
                          echo "Giải ngân thất bại";
                        }elseif($status == "cancel"){
                          echo "Giao dịch bị hủy";
                        }
                        ?>
                      </td>
                      <td><?= !empty($disbur->description) ?  (string)$disbur->description : ""?></td>
                      <td><?= !empty($disbur->import_by) ?  (string)$disbur->import_by : ""?></td>
                      <td><?= !empty($disbur->import_at) ?  date('m/d/Y', $disbur->import_at) : ""?></td>

                      <td><?= !empty($disbur->disbursement_by) ?  $disbur->disbursement_by : ""?></td>

                      <td>
                        <a href="<?php echo base_url("DisbursementAccounting/view?id=").$disbur->_id->{'$oid'}?>">
                          <i class="fa fa-edit"></i>
                        </a>
                        <!-- <a href="#">
                          <i class="fa fa-trash"></i>
                        </a> -->
                      </td>
                    </tr>
                  <?php } }?>

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
