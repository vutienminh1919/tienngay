
        <div class="x_panel setup-content" id="step-6">
          <div class="x_content">
         
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Thẩm định hồ sơ<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
             <textarea type="text" id="expertise_file" required="" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Thẩm định thực địa<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea type="text" id="expertise_field" required="" class="form-control"></textarea>
              </div>
            </div>
            
       

            <button class="btn btn-primary nextBtn pull-right" type="button" data-toggle="modal" data-target="#createContract">Tạo</button>
            <button class="btn btn-secondary  pull-right save_contract"  type="button" data-step="6"  data-toggle="modal" data-target="#saveContract">Lưu</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Quay lại</button>
          </div>
        </div>


<!-- Modal HTML -->
<div id="createContract" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
                <div class="icon-box success">
					<i class="fa fa-check"></i>
				</div>
				<h4 class="modal-title">Xác nhận tạo hợp đồng mới</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-info"   data-dismiss="modal"><?= $this->lang->line('Cancel')?></button>
        <button type="button" class="btn btn-success btn-create-contract"><?= $this->lang->line('ok')?></button>
			</div>
		</div>
	</div>
</div>
