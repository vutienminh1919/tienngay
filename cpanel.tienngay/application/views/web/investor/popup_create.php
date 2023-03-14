<div id="modal_create" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Thêm mới nhà đầu tư</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Tên nhà đầu tư : </div>
                                <input type="text" id="name" class="form-control" value="" >
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Mã nhà đầu tư : </div>
                                <input type="text" id="code_investor" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Lãi suất phải trả cho nhà đầu tư : </div>
                                <input type="text" id="percent_interest_investor" class="form-control number" value="">
                            </div>
                        </div>
                    </div>
                   
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="btn-create" data-url="<?= base_url("investor/create")?>">Tạo mới</button>
            </div>
        </div>
    </div>
</div>