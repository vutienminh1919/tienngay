<!-- page content -->
<div class="right_col" role="main">
   
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title">
                <h3>Quản lý phí
                     <br>
                    <small>
                    <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#">Quản lý phí</a> 
                    </small>
                </h3>
            </div>
        </div>
        <br>&nbsp;
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <table  id="datatable-buttons"  class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Hình thức vay</th>
                                        <th>Số kỳ vay</th>
                                        <th>Phần trăm</th>
                                        <th>Số tiền</th>
                                        <th class="text-right">Thao tác</th>
                                    </tr>
                                </thead>
    <tbody>
            <?php
                if(!empty($dataFee)){
                   foreach($dataFee as $key => $fee){
                ?>
            <tr>
                <td><?php echo $key+1?></td>
                <td><?= !empty($fee->name) ? $fee->name : "" ?></td>
                <td>
                <?php
                     $type_loan =  !empty($fee->type_loan) ? $fee->type_loan : "";
                     if($type_loan == "CC"){
                         echo "cầm cố";
                     }
                     if($type_loan == "DKX"){
                        echo "đăng ký xe";
                    }
                ?>
                </td>
                <td><?= !empty($fee->number_day_loan) ? $fee->number_day_loan/30 : ""?></td>
                <td><?= !empty($fee->percent) ? $fee->percent : ""?></td>
                <?php 
                    $amount = !empty($fee->amount) ? $fee->amount : 0;
                ?>
                <td><?= !empty($amount) ? number_format($amount) : "0"?></td>
                <td>
                <button class="btn btn-primary text-right" style="float: right;" data-toggle="modal" data-target="#editModal_<?= getId($fee->_id)?>">
                    <i class="fa fa-edit"></i> Sửa
                </button> 
                <div id="editModal_<?= getId($fee->_id)?>" class="modal fade" role="dialog" name="div-modal">
                            <input type="hidden" name="id_fee" value="<?= getId($fee->_id)?>"/>
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Sửa</h4>
                                    </div>
                                    <div class="modal-body">
                                         <?php if(empty($amount)){?>
                                            <input type="hidden" name="type_fee" value="1"/>
                                            <div class="form-group row">
                                                <div class="col-xs-3"><label style="margin-top:5px">Phần trăm</label></div>
                                                <div class="col-xs-9"> 
                                                <input name="percent_fee" value="<?= !empty($fee->percent) ? $fee->percent : ""?>" class="form-control w-100" >
                                                </div>
                                            </div>
                                         <?php }else{?>
                                            <input type="hidden" name="type_fee" value="2"/>
                                            <div class="form-group row">
                                                <div class="col-xs-3"><label style="margin-top:5px">Tiền phạt</label></div>
                                                <div class="col-xs-9"> 
                                                <input name="amount_fee" value="<?= !empty($amount) ? number_format($amount) : 0?>" class="form-control w-100" >
                                                </div>
                                            </div>
                                         <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-close"></i> Hủy</button>
                                        <button type="button" class="btn btn-primary save_fee_loan"><i class="fa fa-save"></i> Lưu lại</button>
                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </td>
                                        </tr>
                                      
                                        <?php }} ?>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<script src="<?= base_url("assets")?>/js/fee/index.js"></script>
