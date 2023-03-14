<div id="modal_update_<?= getId($data->_id)?>" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sửa thông tin nhà đầu tư</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Tên nhà đầu tư: </div>
                                <input type="text" name="name" class="form-control" value="<?= $data->name?>" >
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Mã nhà đầu tư: </div>
                                <input type="text" name="code_investor" class="form-control" value="<?= $data->code?>" >
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Trạng thái : </div>
                                <select class="form-control" id='status' >
                                    <option  <?= $data->status == 'active' ? "selected" : "" ?> value="active">Hoạt động</option>
                                    <option <?= $data->status == 'deactive' ? "selected" : "" ?> value="deactive">Không hoạt động</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Lãi suất phải trả nhà đầu tư : </div>
                                <input type="text" name="percent_interest_investor" class="form-control percent_interest_investor_update" value="<?= $data->percent_interest_investor?>" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" name="btn-update" data-modal-id="modal_update_<?= getId($data->_id)?>" data-id="<?= getId($data->_id)?>" data-url="<?= base_url("investor/update")?>">Cập nhật</button>
            </div>
        </div>
    </div>
</div>