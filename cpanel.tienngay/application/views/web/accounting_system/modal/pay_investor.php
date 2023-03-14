<div class="modal fade" id="plan_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <input type="hidden" id="plan_id">
    <input type="hidden" id="code_contract">
    <input type="hidden" id="url_pay_investor" value="<?= base_url("accountingSystem/payInvestor")?>">
    
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Cập nhật thanh toán lãi và gốc cho NĐT cho kỳ <span id="time"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible text-center" style="display:none" id="div_error">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <span id="span_div_error"></span>
                </div>
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nguồn tiền trả gốc vay :</label>
                        <textarea class="form-control" id="resource_pay"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Ngày trả :</label>
                        <input type="date" name="fdate" class="form-control" id="date_pay">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Số tiền lãi đã trả :</label>
                        <input class="form-control" id="amount_interest_paid" />
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Số tiền gốc đã trả :</label>
                        <input class="form-control" id="amount_root_paid" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="btn-update-pay-investor">
                    <i class="fa fa-spinner fa-spin" style="display:none;"></i> Cập nhật
                </button>
            </div>
        </div>
    </div>
</div>