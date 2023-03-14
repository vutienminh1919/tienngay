<div class="right_col" role="main" style="min-height: 1160px;">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Báo cáo tiền phải trả khách hàng
                <br>
                <small>
                    <a href="<?php echo base_url()?>"><i class="fa fa-home" ></i> Home</a> / <a href="#">Báo cáo tiền phải trả khách hàng</a>
                </small>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <!--Xuất excel-->
                        <div class="row">
                            <div class="col-xs-12">
                                <?php if ($this->session->flashdata('error_excel_interest_month')) { ?>
                                <div class="alert alert-danger alert-result">
                                    <?= $this->session->flashdata('error_excel_interest_month') ?>
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success')) { ?>
                                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                                <?php } ?>
                                <div class="row">
                                    <form action="<?php echo base_url('accountingSystem/exportPublicDebtCustomer')?>" method="get" style="width: 100%;">
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon"><?php echo $this->lang->line('from')?></span>
                                                <input type="date" name="fdate_export" class="form-control" value="<?= !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : ""?>" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon"><?php echo $this->lang->line('to')?></span>
                                                <input type="date" name="tdate_export" class="form-control" value="<?= !empty($_GET['tdate_export']) ? $_GET['tdate_export'] : ""?>" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2 text-right">
                                            <button style="background-color: #18d102;" type="submit" class="btn btn-primary w-100"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất excel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
