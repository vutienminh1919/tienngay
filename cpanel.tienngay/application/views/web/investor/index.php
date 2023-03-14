<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title">
                <div class="title_left">
                    <h3>Quản lý nhà đầu tư
                        <br>
                        <small>
                            <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a>/ <a href="#">Quản lý nhà đầu tư</a> 
                        </small>
                   </h3>
                </div>
                <div class="title_right text-right">
                    <a href="#" 
                       data-toggle="modal" data-target="#modal_create"
                       class="btn btn-info " ><i class="fa fa-plus" aria-hidden="true"></i> <?= $this->lang->line('create')?></a>
                </div>
            </div>
        </div>
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
                                        <th>Lãi suất phải trả nhà đầu tư</th>
                                        <th>Trạng thái</th>
                                        <th class="text-right">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
                                            if(!empty($investors)){
                                                $key = 0;
                                                foreach($investors as $item){
                                        ?>
                                        <tr>
                                            <td><?php echo $key+1?></td>
                                            <td><?= $item->name?></td>
                                            <td><?= !empty($item->percent_interest_investor) ? $item->percent_interest_investor : "0"?></td>
                                            <td><?= $item->status?></td>
                                            <td>
                                                <button class="btn btn-primary text-right" style="float: right;" data-toggle="modal" data-target="#modal_update_<?= getId($item->_id)?>">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </button>
                                                <?php 
                                                    $data['data'] = $item;
                                                    $this->load->view("web/investor/popup_update.php", $data);
                                                ?>
                                            </td>
                                        </tr>
                                        <?php $key++;}} ?>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("web/investor/popup_create.php");?>
<script src="<?= base_url("assets")?>/js/investor/index.js"></script>
