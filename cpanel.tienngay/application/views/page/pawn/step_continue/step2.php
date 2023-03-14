
        <div class="x_panel setup-content" id="step-2">
          <div class="x_content">
            <!-- <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('job')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="name_job" value="<?= $contractInfor->job_infor->name_job ? $contractInfor->job_infor->name_job : "" ?>" required class="form-control">
              </div>
            </div> -->
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Company_name')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="name_company" value="<?= $contractInfor->job_infor->name_company ? $contractInfor->job_infor->name_company : "" ?>" required class="form-control">
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Company_address')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="address_company" value="<?= $contractInfor->job_infor->address_company ? $contractInfor->job_infor->address_company : "" ?>" required class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Company_phone_number')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="phone_number_company" required class="form-control" value="<?= !empty($contractInfor->job_infor->phone_number_company) ? $contractInfor->job_infor->phone_number_company : "" ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Job_position')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <!-- <input type="text" id="job_position" required class="form-control" value="<?= !empty($contractInfor->job_infor->job_position) ? $contractInfor->job_infor->job_position : "" ?>"> -->
              <select class="form-control" id="job_position">
                  <option value="Mới tốt nghiệp" <?= $contractInfor->job_infor->job_position == "Mới tốt nghiệp" ? "selected" : "" ?>>Mới tốt nghiệp</option>
                  <option value="Nhân viên /Chuyên viên" <?= $contractInfor->job_infor->job_position == "Nhân viên /Chuyên viên" ? "selected" : "" ?>>Nhân viên /Chuyên viên</option>
                  <option value="Chuyên viên chính" <?= $contractInfor->job_infor->job_position == "Chuyên viên chính" ? "selected" : "" ?>>Chuyên viên chính</option>
                  <option value="Chuyên viên cao cấp" <?= $contractInfor->job_infor->job_position == "Chuyên viên cao cấp" ? "selected" : "" ?>>Chuyên viên cao cấp</option>
                  <option value="Trưởng nhóm/Giám sát" <?= $contractInfor->job_infor->job_position == "Trưởng nhóm/Giám sát" ? "selected" : "" ?>>Trưởng nhóm/Giám sát</option>
                  <option value="Trưởng phòng" <?= $contractInfor->job_infor->job_position == "Trưởng phòng" ? "selected" : "" ?>>Trưởng phòng</option>
                  <option value="Giám đốc và cấp cao hơn" <?= $contractInfor->job_infor->job_position == "Giám đốc và cấp cao hơn" ? "selected" : "" ?>>Giám đốc và cấp cao hơn</option>
                  <option value="Không" <?= $contractInfor->job_infor->job_position == "Không" ? "selected" : "" ?>>Không</option>
              </select>
              </div>
            </div>

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
              <input type="text" id="salary" value="<?= $contractInfor->job_infor->salary ? $contractInfor->job_infor->salary : "" ?>" required class="form-control">
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">
              <?= $this->lang->line('Form_payment_wages')?><span class="text-danger">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" id="receive_salary_via">
                    <option value="1"  <?= $contractInfor->job_infor->receive_salary_via == "1" ? "selected" : "" ?>>Tiền mặt</option>
                    <option value="2"  <?= $contractInfor->job_infor->receive_salary_via == "2" ? "selected" : "" ?>>Chuyển khoản</option>
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
                  <option value="<?php echo $value?>" <?= $contractInfor->job_infor->job == $value ? "selected" : "" ?>><?php echo $value?></option>
                      <?php }?>
              </select>
              </div>
            </div>

            <button class="btn btn-primary nextBtnCreate pull-right" data-step="2"  type="button">Tiếp tục</button>
            <?php 
                $step = !empty($contractInfor->step) ? $contractInfor->step : "1";
                if($step < 2){
                  $step = "2";
                };
            ?>
            <button class="btn btn-primary  pull-right save_contract"  data-step="<?php echo $step?>"   type="button" data-toggle="modal" data-target="#saveContract">Lưu lại</button>
            <button class="btn btn-danger backBtn pull-right" type="button">Quay lại</button>
          </div>
        </div>



                              
                                   
                  
