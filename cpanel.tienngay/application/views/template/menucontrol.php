<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title">
                <h3>Menu Control</h3>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="x_panel">
                        <div class="x_content">
                            <?php for ($i=0; $i < 5; $i++) { ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary" style="margin-right: 45px;">
                                            <i class="fa fa-plus"></i>
                                            </button>
                                            <!-- <button type="button" class="btn btn-primary">
                                                <i class="fa fa-minus"></i>
                                                
                                                </button> -->
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3">
                                </div>
                                <div class="col-xs-12 col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control">
                                        <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary" style="margin-right: 45px;">
                                        <i class="fa fa-plus"></i>
                                        </button>
                                        </span>
                                    </div>
                                </div>
                                <?php for ($z=0; $z < 5; $z++) { ?>
                                <div class="col-xs-12 col-md-3">
                                </div>
                                <div class="col-xs-12 col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control">
                                        <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary">
                                        <i class="fa fa-minus"></i>
                                        </button>
                                        </span>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /page content -->