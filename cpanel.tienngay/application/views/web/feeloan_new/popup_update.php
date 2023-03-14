<div id="modal_update_<?= getId($columnFeeLoans->_id)?>" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sửa biểu phí</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Title : </div>
                                <input type="text" id="title" class="form-control" value="<?= $columnFeeLoans->title?>" >
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">From : </div>
                                <input type="date" id="from" class="form-control" value="<?= $this->time_model->convertTimestampToDatetime_($columnFeeLoans->from)?>" >
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">To : </div>
                                <input type="date" id="to" class="form-control" value="<?= $this->time_model->convertTimestampToDatetime_($columnFeeLoans->to)?>" >
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <?php foreach($columnFeeLoans->infor as $key=>$value) { ?>
                                        <li name="li_day" data-day="<?= $key?>" role="presentation" class="<?= $key == '30' ? "active" : ""?>">
                                            <a href="#day_<?= $key?>_<?= getId($columnFeeLoans->_id)?>" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">
                                                <?= $key?> ngày
                                            </a>
                                        </li>
                                <?php }?>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <?php foreach($columnFeeLoans->infor as $key=>$value) { ?>
                                        <div role="tabpanel" name="div_type_<?= $key?>" class="tab-pane fade <?= $key == '30' ? "active in" : ""?>" id="day_<?= $key?>_<?= getId($columnFeeLoans->_id)?>" aria-labelledby="home-tab">

    <div class="row">
        <?php foreach($value as $keyType=>$valType) {?>
                <div name="div_detail" data-type="<?= $keyType?>" class="col-xs-12 col-md-6" style="border-right: 1px solid #ccc;">
                    <h4><?= type_fee($keyType); ?> : </h4>
                    <?php foreach($valType as $keyFee=>$valFee) { ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <?php
                                            echo $stringColumn->infor->{$key}->{$keyType}->{$keyFee}->name;
                                        ?> :
                                    </div>
                                    <input type="text" <?= $keyFee == 'percent_interest_customer' ? "disabled" : "" ?> value="<?= $valFee?>" name="<?= $keyFee?>" data-name="<?= $keyFee?>" class="form-control number">
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
                <?php if(in_array('phat-trien-san-pham', $groupRoles)) { ?>
                <button type="button" class="btn btn-primary" name="btn-update" data-modal-id="modal_update_<?= getId($columnFeeLoans->_id)?>" data-id="<?= getId($columnFeeLoans->_id)?>" data-url="<?= base_url("feeLoanNew/update")?>">Cập nhật</button>
                <?php }?>
            </div>
        </div>
    </div>
</div>
