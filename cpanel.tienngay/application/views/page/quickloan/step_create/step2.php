
        <div class="x_panel setup-content" id="step-2">
          <div class="x_content">
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Company_name')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="name_company" required class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Company_address')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="address_company" required class="form-control">
              </div>
            </div>


            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Company_phone_number')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="phone_number_company" required class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Job_position')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="job_position" required class="form-control">
              </div>
            </div>

            <!-- <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('job')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="name_job" required class="form-control">
              </div>
            </div>
          -->
           
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Income')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="salary" required class="form-control number" value="0">
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Form_payment_wages')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <!-- <input type="text" id="receive_salary_via" required class="form-control"> -->
              <select class="form-control" id="receive_salary_via">
                    <option value=""></option>
                    <option value="1">Tiền mặt</option>
                    <option value="2">Chuyển khoản</option>
                </select>
              </div>
            </div>
            <button class="btn btn-primary nextBtnCreate pull-right" data-step="2"  type="button">Tiếp tục</button>
            <button class="btn btn-primary  pull-right save_contract"  data-step="2"   type="button" data-toggle="modal" data-target="#saveContract">Lưu lại</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Quay lại</button>
          </div>
        </div>



                              
                                   
                  