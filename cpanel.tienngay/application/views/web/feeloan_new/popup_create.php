<div id="modal_create" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Thêm mới biểu phí</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Title : </div>
                                <input type="text" id="title" class="form-control" value="" >
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                     <div class="form-group " >
             
              <label class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12">
              Biểu phí chuẩn:
              </label>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="radio-inline text-primary">
                <label><input name='main' value="1"  id="main"  type="checkbox"></label>
                </div>
             
              </div>
            </div>
        </div>
                    <div class="col-xs-12">
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <?php foreach($columnFeeLoansCreate->infor as $key=>$value) { ?>
                                        <li name="li_day" data-day="<?= $key?>" role="presentation" class="<?= $key == '30' ? "active" : ""?>">
                                            <a href="#day_<?= $key?>" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">
                                                <?= $key?> ngày
                                            </a>
                                        </li>
                                <?php }?>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <?php foreach($columnFeeLoansCreate->infor as $key=>$value) { ?>
                                        <div role="tabpanel" name="div_type_<?= $key?>" class="tab-pane fade <?= $key == '30' ? "active in" : ""?>" id="day_<?= $key?>" aria-labelledby="home-tab">
                                            <div class="row">
                                                <?php foreach($value as $keyType=>$valType) {?>
                                                        <div name="div_detail" data-type="<?= $keyType?>" class="col-xs-12 col-md-6" style="border-right: 1px solid #ccc;">
                                                             <h4><?= type_fee($keyType); ?> : </h4>
                                                            <?php foreach($valType as $keyFee=>$valFee) {?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="input-group-addon"><?= $valFee->name?> : </div>
                                                                            <input type="text" <?= $keyFee == 'percent_interest_customer' ? "disabled" : "" ?> value="<?= $valFee->value?>" name="<?= $keyFee?>" data-name="<?= $keyFee?>" class="form-control number">
                                                                        </div>
                                                                    </div>
                                                            <?php }?>
                                                        </div>
                                                <?php }?>
                                            </div>
                                        </div>    
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="btn-create" data-url="<?= base_url("feeLoanNew/create")?>">Tạo mới</button>
            </div>
        </div>
    </div>
</div>