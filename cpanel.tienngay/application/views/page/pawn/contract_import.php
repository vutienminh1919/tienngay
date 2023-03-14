<!-- page content -->
<div class="right_col" role="main">
<div class="theloading" style="display:none" >
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
    <span ><?= $this->lang->line('Loading')?>...</span>
  </div>
    <?php
    $fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
    $tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
    $property = !empty($_GET['property']) ? $_GET['property'] : "";
    $status = !empty($_GET['status']) ? $_GET['status'] : "-";
    $code_contract = !empty($_GET['code_contract']) ? $_GET['code_contract'] : "";
    $code_contract_disbursement = !empty($_GET['code_contract_disbursement']) ? $_GET['code_contract_disbursement'] : "";
    $customer_name = !empty($_GET['customer_name']) ? $_GET['customer_name'] : "";
    $customer_phone_number= !empty($_GET['customer_phone_number']) ? $_GET['customer_phone_number'] : "";
    $customer_identify= !empty($_GET['customer_identify']) ? $_GET['customer_identify'] : "";
    
    ?>
    <div class="row top_tiles">
        <div class="col-xs-12">
            <div class="page-title">
                <div class="title_left">
                    <h3>Danh sách hợp đồng cũ
                        <br>
                        <small>
                            <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Danh sách hợp đồng cũ</a>
                        </small>
                    </h3>
                </div>
                
           
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
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
                           
    <form action="<?php echo base_url('pawn/search_import')?>" method="get" style="width: 100%;">
        <div class="row">
            <div class="col-lg-2">
                 <input type="text" name="code_contract" class="form-control" placeholder="Mã phiếu ghi" value="<?= !empty($code_contract) ?  $code_contract : ""?>" >
            </div>
            <div class="col-lg-2">
                <input type="text" name="code_contract_disbursement" class="form-control" placeholder="Mã hợp đồng" value="<?= !empty($code_contract_disbursement) ?  $code_contract_disbursement : ""?>" >
            </div>
            <div class="col-lg-2">
                <input type="text" name="customer_name" class="form-control" placeholder="Họ và tên" value="<?= !empty($customer_name) ?  $customer_name : ""?>" >
            </div>
            <div class="col-lg-2">
                <input type="text" name="customer_phone_number" class="form-control" placeholder="Số điện thoại" value="<?= !empty($customer_phone_number) ?  $customer_phone_number : ""?>" >
            </div>
            <div class="col-lg-2">
                <input type="text" name="customer_identify" class="form-control" placeholder="CMND" value="<?= !empty($customer_identify) ?  $customer_identify : ""?>" >
            </div>
           <div class="col-lg-2 ">
                <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> <?= $this->lang->line('search')?></button>
            </div>
        </div>
        <br/>
        <div class="row">
        <div class="col-lg-2">
        <select class="form-control" name="property">
            <option value=""><?= $this->lang->line('All_property')?></option>
            <?php foreach ($mainPropertyData as $p) {?>
                <option <?php echo $property == $p->code ? 'selected' : ''?> value="<?php echo $p->code; ?>"><?php echo $p->name; ?></option>
            <?php }?>
        </select>
    </div>
    <div class="col-lg-2">
        <select class="form-control" name="status">
            <option value="" <?php echo $status == '-' ? 'selected' : ''?>><?= $this->lang->line('All_status')?></option>

            <option <?php echo $status == 1 ? 'selected' : ''?> value="1" >Mới</option>
            <option <?php echo $status == 2 ? 'selected' : ''?> value="2" >Chờ CHT duyệt</option>
            <option <?php echo $status == 3 ? 'selected' : ''?> value="3" >Đã hủy</option>
            <option <?php echo $status == 4 ? 'selected' : ''?> value="4" >CHT không duyệt</option>
            <option <?php echo $status == 5 ? 'selected' : ''?> value="5" >Chờ hội sở duyệt</option>
            <option <?php echo $status == 6 ? 'selected' : ''?> value="6" >Đã duyệt</option>
            <option <?php echo $status == 7 ? 'selected' : ''?> value="7" >Kế toán không duyệt</option>
            <option <?php echo $status == 8 ? 'selected' : ''?> value="8" >Hội sở không duyệt</option>
            <option <?php echo $status == 9 ? 'selected' : ''?> value="9" >Chờ ngân lượng sử lý</option>
            <option <?php echo $status == 10 ? 'selected' : ''?> value="10" >Giải ngân ngân lượng thất bại</option>
            <option <?php echo $status == 15 ? 'selected' : ''?> value="15" >Chờ giải ngân</option>
            <option <?php echo $status == 16 ? 'selected' : ''?> value="16" >Đã tạo lệnh giải ngân thành công</option>
            <option <?php echo $status == 17 ? 'selected' : ''?> value="17" >Đang vay</option>
            <option <?php echo $status == 18 ? 'selected' : ''?> value="18" >Giải ngân thất bại</option>
            <option <?php echo $status == 19 ? 'selected' : ''?> value="19" >Đã tất toán</option>
            <option <?php echo $status == 20 ? 'selected' : ''?> value="20" >Đã quá hạn</option>
            <option <?php echo $status == 21 ? 'selected' : ''?> value="21" >Chờ hội sở duyệt gia hạn</option>
            <option <?php echo $status == 22 ? 'selected' : ''?> value="22" >Chờ kế toán duyệt gia hạn</option>
            <option <?php echo $status == 23 ? 'selected' : ''?> value="23" >Đã gia hạn</option>
           <!--  <option <?php echo $status == 24 ? 'selected' : ''?> value="24" >Chờ kế toán xác nhận</option>
             <option <?php echo $status == 25 ? 'selected' : ''?> value="25" >Đã duyệt gia hạn</option> -->
        </select>
    </div>
                <div class="col-lg-3">
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
                        <input type="date" name="fdate" class="form-control" value="<?= !empty($fdate) ?  $fdate : ""?>" >
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-group">
                        <span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
                        <input type="date" name="tdate" class="form-control" value="<?= !empty($tdate) ?  $tdate : ""?>" >
                    </div>
                </div>
             <div class="col-lg-2">
            
          <a style="background-color: #18d102;" href="<?php echo base_url('')?>/ASPawnDetail/do_export_contract_import?fdate=<?=$fdate;?>&tdate=<?=$tdate;?>" class="btn btn-primary w-100" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất excel</a>
      </div>
            </div>
        </form>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row"></div>
                        </div>
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <!-- <table id="datatable-buttons" class="table table-striped"> -->
        <table  class="table table-striped" >
        <thead>
            <tr>
                <th>#</th>
              <th><?= $this->lang->line('Function')?></th>
                <th><?= $this->lang->line('Contract_Code')?></th>
                <th>Mã phiếu ghi</th>
                <th><?= $this->lang->line('Customer')?></th>
                <th><?= $this->lang->line('phone_number')?></th>
                <th><?= $this->lang->line('CMT1')?></th>
                <th><?= $this->lang->line('Asset')?></th>
                <th><?= $this->lang->line('amount_loan')?></th>
                <th><?= $this->lang->line('status')?></th>
                <th> <?= $this->lang->line('interest_payment')?></th>
                <th><?= $this->lang->line('Number_loan_days')?></th>
                <th>Blacklist</th>
                <th>Phòng giao dịch</th>
                <th>Người tạo</th>
                <th>Ngày tạo</th>
                <th>Ngày giải ngân</th>
                <!--     <th>Tình trạng</th> -->
            </tr>
        </thead>
        <tbody>
            <!-- <tr>
                <td colspan="13" class="text-center">Không có dữ liệu</td>
                </tr> -->
            <?php
                if(!empty($contractData)){
                   foreach($contractData as $key => $contract){
                    //  var_dump($contract->id->{'$oid'});die;
                ?>
            <tr>
                <td><?php echo $key+1?></td>
                  <td>
                <div class="dropdown">
                   <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Chức năng 
                    <span class="caret"></span></button>
                  <ul class="dropdown-menu" style="z-index: 99999">
    <?php
        if($contract->status != 0)  {?>
     <li><a href="<?php echo base_url("pawn/detail?id=").$contract->_id->{'$oid'}?>" class="dropdown-item"> Chi tiết </li>
        <li><a href="<?php echo base_url("pawn/viewImageAccuracy?id=").$contract->_id->{'$oid'}?>" class="dropdown-item">
            Xem chứng từ
        </li>
        <!-- <li><a href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ''?>"  class="btn btn-info yeu_cau_giai_ngan" > Xem Phí Thực Tính</li> -->

        <?php }?>


        
<!--check accessright  vận hành theo trạng thái  -->   
        <?php 
        // check accessright của vận hành theo trạng thái 
            if(in_array('giao-dich-vien', $groupRoles)){
            ?>

            <?php
             // buttom edit khi bị kế toán từ chối  status = 7 chỉ cho sửa phần thông tin chuyển khoản
                if(in_array($contract->status, array(25)))  {?>
                <li><a href="<?php echo base_url("accountant/view?id=").$contract->_id->{'$oid'}.'&&type=1'?>" class="dropdown-item ">
                    Tạo phiếu thu gia hạn
                </li>
            <?php }?>
<!-- 
            <?php
             // buttom gửi hội sở duyệt gia hạn
                if(in_array($contract->status, array(17,20)) 
                        && in_array("5ed85a49fbbf0531e1bdab0f",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)" onclick="gui_hs_duyet_gia_han(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ''?>"  class="dropdown-item ">
                    Gửi gia hạn
                </li>
            <?php }?> -->

            <?php
             // buttom edit fee
                if(in_array($contract->status, array(1,4,7,8)) && in_array("5def17f668a3ff1204003ad7",  $userRoles->role_access_rights))  {?>
               <!-- <li><a  href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ''?>"  class="dropdown-item yeu_cau_giai_ngan" > Xem Phí Thực Tính</li> -->
            <?php }?>

            <?php
             // buttom edit khi bị kế toán từ chối  status = 7 chỉ cho sửa phần thông tin chuyển khoản
                if(in_array($contract->status, array(7)) && in_array("5def17f668a3ff1204003ad7",  $userRoles->role_access_rights))  {?>
                <li><a href="<?php echo base_url("pawn/updateDisbursement?id=").$contract->_id->{'$oid'}?>" class="dropdown-item">
                    <?= $this->lang->line('Edit')?>
                </li>
            <?php }?>

            <?php
             // buttom edit tiếp tục tạo hợp đồng = 0
                if($contract->status == 0)  {?>
                <li><a href="<?php echo base_url("pawn/continueCreate?id=").$contract->_id->{'$oid'}?>" class="dropdown-item">
                    Tạo lại
                </li>
            <?php }?>
             <?php
             // buttom edit status = 1,4,8
                if(in_array($contract->status, array(1,4,8)) && in_array("5def17f668a3ff1204003ad7",  $userRoles->role_access_rights))  {?>
                <li><a href="<?php echo base_url("pawn/update?id=").$contract->_id->{'$oid'}?>" class="btdropdown-item">
                    <?= $this->lang->line('Edit')?>
                </li>
            <?php }?>

            <?php 
                // buttom upload
                if(in_array($contract->status, array(1,4,6,7,8)) 
                        && in_array("5def400868a3ff1204003ad9",  $userRoles->role_access_rights))  {?>
                <li><a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=").$contract->_id->{'$oid'}?>" class="dropdown-item">
                    <?= $this->lang->line('Upload_documents')?>
                </li>
            <?php }?>
            <?php
             // buttom gửi cht duyệt 
                if(in_array($contract->status, array(1,4)) 
                        && in_array("5dedd24f68a3ff3100003649",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)" onclick="gui_cht_duyet(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ''?>"  class="dropdown-item gui_cht_duyet">
                    Gửi duyệt
                </li>
            <?php }?>

            <!-- <?php 
            // buttom tạo lại hợp đồng
                if(in_array($contract->status, array(3)) 
                       && in_array("5da98b8568a3ff2f10001b06",  $userRoles->role_access_rights))  {?>
                <li><a href="#" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>  class="btn btn-info "> Tạo lại </li>
            <?php }?> -->

            <?php 
            // buttom tạo yêu cầu giải ngân 
                if(in_array($contract->status, array(6,7)) 
                        && in_array("5dedd32468a3ff310000364d",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)" onclick="yeu_cau_giai_ngan(this)" data-codecontract="<?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : ''?>" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ''?>"  class="dropdown-item yeu_cau_giai_ngan" > Yêu cầu giải ngân </li>
            <?php }?>
            <?php 
            // buttom in hợp đồng
                if(!in_array($contract->status, array(0))  
                        && in_array("5def401068a3ff1204003ada",  $userRoles->role_access_rights))  {?>          
                <li><a href="<?php echo base_url("pawn/printed?id=").$contract->_id->{'$oid'}?>" target="_blank" class="dropdown-item"> In hợp đồng </li>
            <?php }?>
            <?php 
            // buttom hủy hợp đồng
                if(in_array($contract->status, array(1,4,6,7,8)) && in_array("5db6b8c9d6612bceeb712375",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)" onclick="huy_hop_dong(this)"  data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : "";?>"  class="dropdown-item huy_hop_dong">Hủy hợp đồng </li>
            <?php }?>
        <?php }?>
<!--check accessright hàng trưởng theo trạng thái  -->
        <?php 
        // check accessright của của hàng trưởng theo trạng thái 
            if(in_array('cua-hang-truong', $groupRoles)){
            ?>
         <!--    <?php
             // buttom gửi hội sở duyệt gia hạn
                if(in_array($contract->status, array(17,20)) 
                        && in_array("5ed85a49fbbf0531e1bdab0f",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)" onclick="gui_hs_duyet_gia_han(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ''?>"  class="dropdown-item ">
                    Gửi gia hạn
                </li>
            <?php }?> -->

           
               <li><a href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ''?>"  class="dropdown-item yeu_cau_giai_ngan" > Xem Phí Thực Tính</li>
           


               <?php
             // buttom edit status = 8
                if(in_array($contract->status, array(8)) && in_array("5def17f668a3ff1204003ad7",  $userRoles->role_access_rights))  {?>
                <li><a href="<?php echo base_url("pawn/update?id=").$contract->_id->{'$oid'}?>" class="dropdown-item">
                    <?= $this->lang->line('Edit')?>
                </li>
            <?php }?>

            <?php 
                // buttom upload
                if(in_array($contract->status, array(8)) 
                        && in_array("5def400868a3ff1204003ad9",  $userRoles->role_access_rights))  {?>
                <li><a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=").$contract->_id->{'$oid'}?>" class="dropdown-item">
                    <?= $this->lang->line('Upload_documents')?>
                </li>
            <?php }?>
            <?php 
              // buttom Của hàng trưởng từ chối hợp đồng
                if(in_array($contract->status, array(2)) 
                        && in_array("5dedd2c868a3ff310000364a",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)" onclick="cht_tu_choi(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item cht_tu_choi"  > Không duyệt </li>
            <?php }?>
            <?php 
             // buttom chuyển lên hội sở
                if(in_array($contract->status, array(2,8)) 
                        && in_array("5dedd2d868a3ff310000364b",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)" onclick="chuyen_hoi_so(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item chuyen_hoi_so" > Duyệt </li>
            <?php }?>

            <!-- <?php 
            // buttom tạo lại hợp đồng
                if(in_array($contract->status, array(3)) 
                       && in_array("5da98b8568a3ff2f10001b06",  $userRoles->role_access_rights))  {?>
                <li><a href="#" class="btn btn-info "> Tạo lại </li>
            <?php }?> -->
            <?php 
            // buttom in hợp đồng
                if(!in_array($contract->status, array(0))  
                        && in_array("5def401068a3ff1204003ada",  $userRoles->role_access_rights))  {?>
                <li><a href="<?php echo base_url("pawn/printed?id=").$contract->_id->{'$oid'}?>" target="_blank" class="dropdown-item"> In hợp đồng </li>
            <?php }?>
            <?php 
           // buttom hủy hợp đồng
                if(in_array($contract->status, array(1,2,4,6,7,8)) 
                        && in_array("5db6b8c9d6612bceeb712375",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)"  onclick="huy_hop_dong(this)"  data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item huy_hop_dong" >Hủy hợp đồng </li>
            <?php }?>
        <?php }?>

<!--check accessright của hội sở theo trạng thái -->
        <?php 
        // check accessright của hội sở theo trạng thái 
            if(in_array('hoi-so', $groupRoles)){
            ?>
           
               <li><a href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ''?>"  class="dropdown-item yeu_cau_giai_ngan" > Xem Phí Thực Tính</li>
          
            <?php 
            // buttom duyet hợp đồng
                if(in_array($contract->status, array(5)) 
                        && in_array("5dedd2e668a3ff310000364c",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)" onclick="hsduyet(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item duyet"> Duyệt </li>
            <?php }?>
            <?php 
           // buttom hủy hợp đồng
                if(in_array($contract->status, array(5)) 
                        && in_array("5db6b8c9d6612bceeb712375",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)" onclick="huy_hop_dong(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item huy_hop_dong" >Hủy hợp đồng </li>
            <?php }?>
            <?php 
           // buttom hủy hợp đồng
                if(in_array($contract->status, array(5)) 
                        && in_array("5e65a5c33894ad25f051b756",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)" onclick="hoi_so_khong_duyet(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item huy_hop_dong" >HS không duyệt </li>
            <?php }?>
            <?php 
            // buttom duyet gia hạn hợp đồng
                if(in_array($contract->status, array(21)))  {?>
                <li><a href="javascript:void(0)" onclick="hsduyetgiahan(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item duyet"> Duyệt gia hạn </li>
            <?php }?>
            <?php 
            // buttom hủy gia hạn hợp đồng
                if(in_array($contract->status, array(21)))  {?>
                <li><a href="javascript:void(0)" onclick="hshuygiahan(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item duyet"> Hủy gia hạn </li>
            <?php }?>
        <?php }?>

<!--check accessright của kế toán theo trạng thái -->

        <?php 
     
            if(in_array('ke-toan', $groupRoles)){
            ?>
             <?php 
            // buttom duyet gia hạn hợp đồng
                if(in_array($contract->status, array(22)))  {?>
                <li><a href="javascript:void(0)" onclick="ktduyetgiahan(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item duyet"> Duyệt gia hạn </li>
            <?php }?>
            <?php 
            // buttom huy gia hạn hợp đồng
                if(in_array($contract->status, array(22)))  {?>
                <li><a href="javascript:void(0)" onclick="kthuygiahan(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item duyet"> Hủy gia hạn </li>
            <?php }?>
            <?php 
                // buttom upload
                if(in_array($contract->status, array(17)) 
                        && in_array("5def400868a3ff1204003ad9",  $userRoles->role_access_rights))  {?>
                <li><a href="<?php echo base_url("pawn/accountantUpload?id=").$contract->_id->{'$oid'}?>" class="dropdown-item">
                    <?= $this->lang->line('Upload_documents')?>
                </li>
            <?php }?>

           <?php 
           // buttom giải ngân gọi lệnh giải ngân sang vimo
                if(in_array($contract->status, array(15,10)) 
                        && in_array("5def15a268a3ff1204003ad6",  $userRoles->role_access_rights))  {?>
                <li><a href="<?php echo base_url("pawn/disbursement/")?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>" class="btn btn-info " > Giải ngân </li>
                <li><a href="<?php echo base_url("pawn/disbursement_nl/")?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>" class="btn btn-info " > Giải ngân ngân lượng </li>
            <?php }?>

            <?php 
            // buttom kế toán ko duyệt hợp đồng
                if(in_array($contract->status, array(15,10)) 
                        && in_array("5def401b68a3ff1204003adb",  $userRoles->role_access_rights))  {?>
                <li><a href="javascript:void(0)" onclick="ketoan_tu_choi(this)"  data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item ketoan_tu_choi" > Không duyệt </li>
            <?php }?>
            <?php 
            // buttom in hợp đồng
                 if(!in_array($contract->status, array(0))  
                        && in_array("5def401068a3ff1204003ada",  $userRoles->role_access_rights))  {?>
                <li><a href="<?php echo base_url("pawn/printed?id=").$contract->_id->{'$oid'}?>" target="_blank" class="dropdown-item "> In hợp đồng </li>
            <?php }?>
            <?php 
           // buttom hủy hợp đồng
                if(in_array($contract->status, array(15,10)) 
                        && in_array("5db6b8c9d6612bceeb712375",  $userRoles->role_access_rights)) {?>
                <li><a href="javascript:void(0)" onclick="huy_hop_dong(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item huy_hop_dong">Hủy hợp đồng </li>
            <?php }?>

        <?php }?>
<!--check accessright  supper admin  và vận hành theo trạng thái  -->       
<!-- gdv -->
    <?php
             // buttom edit khi bị kế toán từ chối  status = 7 chỉ cho sửa phần thông tin chuyển khoản
                if(in_array($contract->status, array(25)))  {?>
                <li><a href="<?php echo base_url("accountant/view?id=").$contract->_id->{'$oid'}.'&&type=1'?>" class="dropdown-item ">
                Tạo phiếu thu gia hạn
                </li>
            <?php }?>
    <!--   <?php
         // buttom gửi hội sở duyệt gia hạn
            if(in_array($contract->status, array(17,20)))  {?>
            <li><a href="javascript:void(0)" onclick="gui_hs_duyet_gia_han(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ''?>"  class="dropdown-item ">
                Gửi gia hạn
            </li>
        <?php }?> -->
        <?php 
         //check accessright của  supper admin theo trạng thái 
            if($userSession['is_superadmin'] == 1  || in_array('van-hanh', $groupRoles))  {?>
             
               
               <li><a href="javascript:void(0)" onclick="edit_fee(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ''?>"  class="dropdown-item yeu_cau_giai_ngan" > Xem Phí Thực Tính</li>
          

            <?php
             // buttom edit khi bị kế toán từ chối  status = 7 chỉ cho sửa phần thông tin chuyển khoản
                if(in_array($contract->status, array(7)))  {?>
                <li><a href="<?php echo base_url("pawn/updateDisbursement?id=").$contract->_id->{'$oid'}?>" class="dropdown-item ">
                    <?= $this->lang->line('Edit')?>
                </li>
            <?php }?>
            <?php 
           // buttom không duyệt trả về của hàng trưởng hợp đồng
                if(in_array($contract->status, array(5))  )  {?>
                <li><a href="javascript:void(0)" onclick="hoi_so_khong_duyet(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item huy_hop_dong" >HS không duyệt </li>
            <?php }?>
            <?php 
            // buttom hủy gia hạn hợp đồng
                if(in_array($contract->status, array(21,22)) )  {?>
                <li><a href="javascript:void(0)" onclick="hshuygiahan(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item duyet"> Hủy gia hạn </li>
            <?php }?>   
                <?php 
                // buttom duyet gia hạn hợp đồng
                    if(in_array($contract->status, array(22)))  {?>
                    <li><a href="javascript:void(0)" onclick="ktduyetgiahan(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item duyet"> Gia hạn </li>
                <?php }?>
              <?php 
            // buttom duyet gia hạn hợp đồng
                if(in_array($contract->status, array(21)) )  {?>
                <li><a href="javascript:void(0)" onclick="hsduyetgiahan(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item duyet"> Duyệt gia hạn </li>
            <?php }?>
            <?php 
                // buttom upload
                if(in_array($contract->status, array(17)))  {?>
                <li><a href="<?php echo base_url("pawn/accountantUpload?id=").$contract->_id->{'$oid'}?>" class="dropdown-item ">
                    <?= $this->lang->line('Upload_documents')?>
                </li>
            <?php }?>
            <?php
             // buttom edit tiếp tục tạo hợp đồng = 0
                if($contract->status == 0)  {?>
                <li><a href="<?php echo base_url("pawn/continueCreate?id=").$contract->_id->{'$oid'}?>" class="dropdown-item">
                    Tạo lại
                </li>
            <?php }?>
                <?php
                // buttom edit status = 1,4,7
                    if(in_array($contract->status, array(1,4,8)))  {?>
                    <li><a href="<?php echo base_url("pawn/update?id=").$contract->_id->{'$oid'}?>" class="dropdown-item">
                        <?= $this->lang->line('Edit')?>
                    </li>
                <?php }?>

                <?php 
                // buttom upload
                if(in_array($contract->status, array(1,4,6,7,8)))  {?>
                <li><a href="<?php echo base_url("pawn/uploadsImageAccuracy?id=").$contract->_id->{'$oid'}?>" class="dropdown-item">
                    <?= $this->lang->line('Upload_documents')?>
                </li>
            <?php }?>
            <?php
             // buttom gửi cht duyệt 
                if(in_array($contract->status, array(1,4)))  {?>
                <li><a href="javascript:void(0)" onclick="gui_cht_duyet(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item gui_cht_duyet">
                    Gửi duyệt
                </li>
            <?php }?>

            <!-- <?php 
            // buttom tạo lại hợp đồng
                if(in_array($contract->status, array(3)))  {?>
                <li><a href="#" data-id=<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>  class="btn btn-info "> Tạo lại </li>
            <?php }?> -->

            <?php 
            // buttom tạo yêu cầu giải ngân 
                if(in_array($contract->status, array(6,7)))  {?>
                <li><a href="javascript:void(0)" onclick="yeu_cau_giai_ngan(this)"  data-codecontract="<?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : ''?>" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item yeu_cau_giai_ngan" > Yêu cầu giải ngân </li>
            <?php }?>
            <?php 
            // buttom in hợp đồng
                if(!in_array($contract->status, array(0)))  {?>
                <li><a href="<?php echo base_url("pawn/printed?id=").$contract->_id->{'$oid'}?>" target="_blank" class="dropdown-item "> In hợp đồng </li>
            <?php }?>
    <!-- Cht -->
            <?php 
              // buttom Của hàng trưởng từ chối hợp đồng
                if(in_array($contract->status, array(2,8)))  {?>
                <li><a href="javascript:void(0)" onclick="cht_tu_choi(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item cht_tu_choi"  > CHT Không duyệt </li>
            <?php }?>
            <?php 
             // buttom chuyển lên hội sở
                if(in_array($contract->status, array(2,8)))  {?>
                <li><a href="javascript:void(0)" onclick="chuyen_hoi_so(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item chuyen_hoi_so" > CHT Duyệt </li>
            <?php }?>
    <!-- hội sở -->
            <?php 
            // buttom duyet hợp đồng
                if(in_array($contract->status, array(5)))  {?>
                <li><a href="javascript:void(0)" onclick="hsduyet(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item duyet">Hội sở Duyệt </li>
            <?php }?>
    <!-- kế toán -->
            <?php 
           // buttom giải ngân gọi lệnh giải ngân sang vimo
                if(in_array($contract->status, array(15,10)))  {?>
                <li><a href="<?php echo base_url("pawn/disbursement/")?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>" class="dropdown-item" > Giải ngân </li>
                <li><a href="<?php echo base_url("pawn/disbursement_nl/")?><?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>" class="dropdown-item" > Giải ngân ngân lượng </li>
            <?php }?>

            <?php 
            // buttom kế toán ko duyệt hợp đồng
                if(in_array($contract->status, array(15,10)))  {?>
                <li><a href="javascript:void(0)" onclick="ketoan_tu_choi(this)"  data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item ketoan_tu_choi" >KT Không duyệt </li>
            <?php }?>

            <?php 
            // buttom kế toán ko duyệt hợp đồng
                if(in_array($contract->status, array(1,2,4,5,6,7,8,10,15)))  {?>
                 <li><a href="javascript:void(0)" onclick="huy_hop_dong(this)" data-id="<?= !empty($contract->_id->{'$oid'}) ? $contract->_id->{'$oid'} : ""?>"  class="dropdown-item huy_hop_dong" >Hủy hợp đồng </li>
            <?php }?>
        <?php }?>
        </ul>
        </div>
        </td> 
        <td><?= !empty($contract->code_contract_disbursement) ? $contract->code_contract_disbursement : "" ?></td>
        <td><?= !empty($contract->code_contract) ? $contract->code_contract : "" ?></td>
        <td><?= !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : ""?></td>
        <td><?= !empty($contract->customer_infor->customer_phone_number) ? hide_phone($contract->customer_infor->customer_phone_number) : ""?></td>
        <td><?= !empty($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : ""?></td>
        <td><?= !empty($contract->loan_infor->name_property->text) ? $contract->loan_infor->name_property->text : ""?></td>
        <?php 
         $amount_money = !empty($contract->loan_infor->amount_money) ? number_format((float)$contract->loan_infor->amount_money) : 0;
        ?>
        <td><?= !empty($amount_money) ? $amount_money : ""?></td>

        <td>
            <?php
                $status = !empty($contract->status) ? $contract->status: "";
                if($status == 0){
                    echo "Nháp";
                }else if($status == 1){
                  echo "Mới";
                }else if($status == 2) {
                  echo "Chờ trưởng PGD duyệt";
                }else if($status == 3) {
                    echo "Đã hủy";
                }else if($status == 4) {
                    echo "Trưởng PGD không duyệt";
                }else if($status == 5) {
                    echo "Chờ hội sở duyệt";
                }else if($status == 6) {
                    echo "Đã duyệt";
                }else if($status == 7) {
                    echo "Kế toán không duyệt";
                }else if($status == 8) {
                    echo "Hội sở không duyệt";
                }else if($status == 9) {
                    echo "Chờ ngân lượng xử lý";
                }else if($status == 10) {
                    echo "Ngân lượng giải ngân thất bại";
                }else if($status == 15) {
                    echo "Chờ giải ngân";
                }else if($status == 16) {
                    echo "Tạo lệnh giải ngân thành công";
                }else if($status == 17) {
                    echo "Đang vay";
                }else if($status == 18) {
                    echo "Giải ngân thất bại";
                }else if($status == 19) {
                    echo "Đã tất toán";
                }else if($status == 20) {
                    echo "Đã quá hạn ";
                }else if($status == 21) {
                    echo "Chờ hội sở duyệt gia hạn";
                }else if($status == 22) {
                    echo "Chờ kế toán duyệt gia hạn ";
                }else if($status == 23) {
                    echo "Đã gia hạn ";
                }else if($status == 24) {
                    echo "chờ kế toán xác nhận phiếu thu gia hạn";
                }else if($status == 25) {
                    echo "đã duyệt gia hạn";
                }
                ?>
        </td>

        <td>
            <?php
                $type_interest = !empty($contract->loan_infor->type_interest) ? $contract->loan_infor->type_interest: "";
                if($type_interest == 1){
                  echo "Lãi hàng tháng, gốc hàng tháng";
                }else{
                  echo "Lãi hàng tháng, gốc cuối kỳ";
                }
                ?>
        </td>
        <td><?= !empty($contract->loan_infor->number_day_loan) ? $contract->loan_infor->number_day_loan : ""?></td>
        <td><?= !empty($contract->customer_infor->is_blacklist) && $contract->customer_infor->is_blacklist == 1 ? "Có" : ""?></td>
        <td><?= !empty($contract->store->name) ? $contract->store->name : "" ?></td>

        <td><?= !empty($contract->created_by) ? $contract->created_by : ""?></td>
        <td><?= !empty($contract->created_at) ?  date('d/m/Y', $contract->created_at) : ""?></td>

        <td><?= !empty($contract->disbursement_date) ?  date('d/m/Y', $contract->disbursement_date) : ""?></td>


        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                                <div class="">
                                    <?php echo $pagination?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="extension" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title title_modal_approve">Duyệt gia hạn hợp đồng</h5>
        <hr>
        <div class="form-group">
            <label>Nhà đầu tư:</label>
            <select class="form-control" id='investor'>
                    <option value=''>Choose option</option>
                    <?php 
                      if(!empty($listInvestor)){
                        foreach($listInvestor as $key => $investor){
                            // if(!in_array($investor->code,array('vimo','vfc'))){
                    ?>
                      <option  value='<?= !empty($investor->_id->{'$oid'}) ? $investor->_id->{'$oid'} :  "" ;?>' ><?= !empty($investor->name) ? $investor->name :  "" ;?></option>
                      <?php  } }?>
                  </select>
        </div>

        <div class="form-group">
            <label>Ghi chú:</label>
            <textarea class="form-control approve_note_extension" rows="5" ></textarea>
            <input type="hidden"   class="form-control status_approve_extension" value="23">
            <input type="hidden"   class="form-control contract_id_extension">
        </div>
        </table>
        <p class="text-right">
          <button  class="btn btn-danger approve_submit_extension">Xác nhận</button>
        </p>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title title_modal_approve"></h5>
        <hr>

        <div class="form-group code_contract_approve" style="display:none">
            <label>Mã hợp đồng:</label>
            <input type="text"   class="form-control " name="code_contract_disbursement_approve" value="">
        </div>
        <div class="form-group error_code_contract" style="display:none">
            <label>Trường hợp vi phạm:</label>
            <select class="form-control " name="error_code"  style="width: 75%" >
                 <option value=''>Choose option</option>
                <?php foreach (contract_error_code() as $key => $value) { ?>
                    <option value="<?= $key ?>"><?= $key.' - '.$value ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Ghi chú:</label>
            <textarea class="form-control approve_note" rows="5" ></textarea>
            <input type="hidden"   class="form-control status_approve">
            <input type="hidden"   class="form-control code_contract_disbursement_type" value="0">
            
            <input type="hidden"   class="form-control contract_id">
        </div>
        </table>
        <p class="text-right">
          <button  class="btn btn-danger approve_submit">Xác nhận</button>
        </p>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="hsduyet" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title title_modal_approve"></h5>
        <hr>
        <div class="form-group">
            <label>Số tiền được vay:</label>
            <input type="text"   class="form-control amount_money_max" disabled>
            <label>Số tiền vay:</label>
            <input type="text"   class="form-control amount_money" disabled>
             <label>Phí bảo hiểm khoản vay:</label>
            <input type="text"   class="form-control fee_gic" disabled>
              <label>Phí bảo hiểm xe:</label>
            <input type="text"   class="form-control fee_gic_easy" disabled>
             <label>Phí bảo hiểm phúc lộc thọ:</label>
            <input type="text"   class="form-control fee_gic_plt" disabled>
             <label>Số tiền giải ngân:</label>
            <input type="text"   class="form-control amount_loan" disabled>
            <label>Ghi chú:</label>
            <textarea class="form-control approve_note_hs" rows="5" ></textarea>
            <input type="hidden"   class="form-control status_approve">
            <input type="hidden"   class="form-control contract_id">
          <input type="hidden" class="tilekhoanvay"  value="<?=$tilekhoanvay?>">

        <input type="hidden" id="insurrance_contract" name="insurrance_contract" >
        <input type="hidden" id="loan_insurance" name="loan_insurance" >
        <input type="hidden"  name="number_month_loan" >
         </div>
        </table>
        <p class="text-right">
          <button  class="btn btn-primary edit_amount_money">Sửa</button>
          <button  class="btn btn-danger approve_submit">Xác nhận</button>
        </p>
      </div>

    </div>
  </div>
</div>


<div class="modal fade" id="editFee" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title title_modal_approve">Xem phí thực tính</h5>
        <hr>
         <div class="form-group row" >
              <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
            Coupon <span class="text-danger">*</span>
              </label>
              <div class="col-lg-6 col-sm-12 col-12">
                    <input type="text" class="form-control code_coupon"  value="" disabled>
                  </div>
            </div>
        <div class="form-group">
            <input type="hidden"   class="form-control contract_id_fee">
             <input type="hidden"   class="form-control" id="number_day_loan">
             <div class="row">
                <div class="col-lg-6">
            <label>Lãi suất phải thu của người vay:</label>
            <input type="text" class="form-control percent_interest_customer"  value="" disabled>

            <label>Phí tư vấn quản lý:</label>
            <input type="text" class="form-control percent_advisory"  value="" disabled>

            <label>Phí thẩm định và lưu trữ tài sản đảm bảo:</label>
            <input type="text"   class="form-control percent_expertise"  value="" disabled>

            <label>Phần trăm phí quản lý số tiền vay chậm trả:</label>
            <input type="text"   class="form-control penalty_percent"  value="" disabled>
            <label>Số tiền quản lý số tiền vay chậm trả:</label>
            <input type="text"   class="form-control penalty_amount"  value="" disabled>
            </div>
            <div class="col-lg-6"> 
            <label>Phí tư vấn gia hạn:</label>
            <input type="text"   class="form-control extend"  value="" disabled>

            <label>Phí tất toán(trước 1/3):</label>
            <input type="text"   class="form-control percent_prepay_phase_1"  value="" disabled>

            <label>Phí tất toán(trước 2/3):</label>
            <input type="text"   class="form-control percent_prepay_phase_2"  value="" disabled>

            <label>Phí tất toán(sau 2/3):</label>
            <input type="text"   class="form-control percent_prepay_phase_3"  value="" disabled>
            </div>
        </div>
            <!-- <label>Ghi chú:</label>
            <textarea class="form-control fee_note" rows="5" ></textarea>
         -->
        </div>
        </table>
        <p class="text-right">
      <!--   <button class="btn btn-danger submit_edit_fee">Xác nhận</button> -->
        </p>
    </div>

    </div>
</div>
</div>


<!-- /page content -->
<?php $this->load->view('page/modal/create_pawn');?>
<script src="<?php echo base_url();?>assets/js/pawn/contract.js?rev=<?php echo time();?>"></script>
<script src="<?php echo base_url();?>assets/js/numeral.min.js"></script>
<script>
// $(document).ready(function(){
    $('#reservation').change(function(event) {
      var date_range = $('#reservation').val();
        var dates = date_range.split(" - ");
        var start = dates[0];
        var end = dates[1];
        var start = moment(dates[0],'D MMMM YY');
        var end = moment(dates[1],'D MMMM YY');
    });

  
// });
</script>
