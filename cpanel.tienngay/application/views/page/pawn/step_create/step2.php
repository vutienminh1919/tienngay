
        <div class="x_panel setup-content" id="step-2">
          <div class="x_content">
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Company_name')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="name_company" value="<?= $lead_info->com ? $lead_info->com : "" ?>" required class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Company_address')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="address_company" value="<?= $lead_info->com_address ? $lead_info->com_address : "" ?>" required class="form-control">
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
              <!-- <input type="text" id="job_position" required class="form-control" value="<?= $lead_info->position ? $lead_info->position : "" ?>" > -->

              <select class="form-control" id="job_position">
                  <option value="Mới tốt nghiệp">Mới tốt nghiệp</option>
                  <option value="Nhân viên /Chuyên viên">Nhân viên /Chuyên viên</option>
                  <option value="Chuyên viên chính">Chuyên viên chính</option>
                  <option value="Chuyên viên cao cấp">Chuyên viên cao cấp</option>
                  <option value="Trưởng nhóm/Giám sát">Trưởng nhóm/Giám sát</option>
                  <option value="Trưởng phòng">Trưởng phòng</option>
                  <option value="Giám đốc và cấp cao hơn">Giám đốc và cấp cao hơn</option>
                  <option value="Không">Không</option>
              </select>
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
					  Thời gian làm việc tại Công ty<span class="text-danger">*</span>
				  </label>
				  <div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="work_year" value="<?= $contractInfor->job_infor->work_year ? $contractInfor->job_infor->work_year : "" ?>" required class="form-control">
				  </div>
			  </div>
           
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Income')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="salary" required class="form-control number"  value="<?= $lead_info->income ? $lead_info->income : "0" ?>" >
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Form_payment_wages')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <!-- <input type="text" id="receive_salary_via" required class="form-control"> -->
               <?php $salary_pay=  ($lead_info->salary_pay) ? $lead_info->salary_pay : ''; ?>
              <select class="form-control" id="receive_salary_via">
                    <option value="1" <?= ($salary_pay=='1') ? "selected" : "" ?> >Tiền mặt</option>
                    <option value="2" <?= ($salary_pay=='2') ? "selected" : "" ?> >Chuyển khoản</option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              Nghề nghiệp<span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" id="job"  onfocus='this.size=9;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
              <?php
                 $job = status_job();
                      foreach($job as $key => $value){
                 ?>
                  <option value="<?php echo $value?>" ><?php echo $value?></option>
                  <?php }?>
                
              </select>
              </div>
            </div>

            <button class="btn btn-primary nextBtnCreate pull-right" data-step="2"  type="button">Tiếp tục</button>
            <button class="btn btn-primary  pull-right save_contract"  data-step="2"   type="button" data-toggle="modal" data-target="#saveContract">Lưu lại</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Quay lại</button>
          </div>
        </div>



                              
                                   
