<div class="x_title">
    <!--Xuất excel-->
    <div class="row">
        <div class="col-xs-12">
            <?php if ($this->session->flashdata('error_excel')) { ?>
            <div class="alert alert-danger alert-result">
                <?= $this->session->flashdata('error_excel') ?>
            </div>
            <?php } ?>
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
            <?php } ?>
            <div class="row">
                <form action="<?php echo base_url('accountingSystem/export')?>" method="get" style="width: 100%;">
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->lang->line('from')?> tháng</span>
                            <input type="month" name="fdate_export" class="form-control" value="<?= !empty($_GET['fdate_export']) ? $_GET['fdate_export'] : ""?>" >
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->lang->line('to')?> tháng</span>
                            <input type="month" name="tdate_export" class="form-control" value="<?= !empty($_GET['tdate_export']) ? $_GET['tdate_export'] : ""?>" >
                        </div>
                    </div>
                    <div class="col-lg-2 text-right">
                        <button style="background-color: #18d102;" type="submit" class="btn btn-primary w-100"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; Xuất excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Search-->
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
                <form action="<?php echo base_url('accountingSystem/searchSummaryTotal')?>" method="get" style="width: 100%;">
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->lang->line('from')?> ngày</span>
                            <input type="date" name="fdate" class="form-control" value="<?= !empty($_GET['fdate']) ? $_GET['fdate'] : ""?>" >
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->lang->line('to')?> ngày</span>
                            <input type="date" name="tdate" class="form-control" value="<?= !empty($_GET['tdate']) ? $_GET['tdate'] : ""?>" >
                        </div>
                    </div>
                    <div class="col-lg-2 text-right">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i>&nbsp; <?= $this->lang->line('search')?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>