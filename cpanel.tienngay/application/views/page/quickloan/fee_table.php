<!-- page content -->
<div class="right_col" role="main">
    <div class="row top_tiles">
        <div class="col-xs-12">
            <div class="page-title">
                <div class="title_left">
                    <h3><?= $this->lang->line('Fee_table')?></h3>
                    <div class="alert alert-danger alert-result" id="div_error" style="display:none; color:white;"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12  col-lg-12">
            <div class="x_panel ">
                <div class="x_content ">
                    <div class="form-horizontal form-label-left">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <!-- Thông tin khoản vay-->
                                <div class="x_title">
                                    <strong><i class="fa fa-money" aria-hidden="true"></i> <?= $this->lang->line('Loan_information')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('amount_loan')?><span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <!-- <input type="text" id="number_day_loan" required class="form-control"> -->
                                        <input type="text" id='amount_money'  name="amount_money" class="form-control number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('Loan_form')?><span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control " id="type_loan" >
                                        <option value=''> </option>
                                        <option value='1'><?= $this->lang->line('pawn')?></option>
                                        <option value='2'> <?= $this->lang->line('vehicle_registration')?></option>
                                        <!-- <?php 
                                            if($configuration_formality){
                                                foreach($configuration_formality as $key => $cf){
                                        ?>
                                        <option value='<?= !empty($cf->percent) ? $cf->percent : ""?>'><?= !empty($cf->name) ? $cf->name : ""?></option>
                                        <?php }}?> -->
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('Number_loan_days')?><span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="number_day_loan" required class="form-control number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <?= $this->lang->line('Number_days_paid_period')?><span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="period_pay_interest" required class="form-control number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"> <?= $this->lang->line('formality2')?> <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="type_interest">
                                            <option value=""></option>
                                            <option value="1"><?= $this->lang->line('Outstanding_descending')?></option>
                                            <option value="2"><?= $this->lang->line('Monthly_interest_principal_maturity')?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('Insurance_premiums')?> <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="checkbox" id="insurrance"  class="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <?= $this->lang->line('Settlement_date')?> <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <input type="date" id="date_payment"  class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"></label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <button type="submit" class="btn btn-success submitFeeTable"><?= $this->lang->line('Provisional')?></button>
                                    </div>
                                </div>
                              

                                
                                <!-- <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Kỳ hạn vay <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                           
                                            <select class="form-control ky_han_vay" >
                                                <option value='1'>1 tháng</option>
                                                <option value='2'>2 tháng</option>
                                                <option value='3'>3 tháng</option>
                                                <option value='4'>4 tháng</option>
                                                <option value='5'>5 tháng</option>
                                                <option value='6'>6 tháng</option>
                                                <option value='7'>7 tháng</option>
                                                <option value='8'>8 tháng</option>
                                                <option value='9'>9 tháng</option>
                                                <option value='10'>10 tháng</option>
                                                <option value='11'>11 tháng</option>
                                                <option value='12'>12 tháng</option>
                                            </select>
                                
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Hình thức lãi  <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control hinh_thuc_lai" onchange='hinh_thuc_lai(this)' >
                                            <option value=""></option>

                                            <option value="2">Lãi hàng tháng, gốc cuối kỳ</option>
                                        </select>
                                    </div>
                                </div>

                               <div class="form-group">
                                    <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left">Bảng tính phí<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-bordered table-interest bang_phi1" style="vertical-align:middle;display:none">
                                            <thead>
                                                <tr>
                                                <th scope="col" rowspan="2">Kỳ trả</th>
                                                <th scope="col" colspan="7">Số tiền trả hàng kỳ</th>
                                                <th scope="col" rowspan="2">Gốc còn lại</th>
                                                <th scope="col" rowspan="2">Tiền phạt tất toán sớm</th>
                                                <th scope="col" rowspan="2">Tiền tất toán sớm</th>
                                                </tr>
                                                <tr>
                                                <th scope="col">Trả kỳ</th>
                                                <th scope="col">Làm tròn</th>
                                                <th scope="col">Gốc</th>
                                                <th scope="col">Tổng phí lãi</th>
                                                <th scope="col">Phí tư vấn</th>
                                                <th scope="col">Phí dịch vụ</th>
                                                <th scope="col">Lãi</th>
                                                </tr>
                                            </thead>
                                            <tbody class='tbody_bang_phi1'></tbody>
                                            <tfoot class="bg-warning">
                                                <tr>
                                                    <td class="text-danger" colspan="1">Tổng tiền</td>
                                                    <td class="text-danger tong_tien_tra_ky" ></td>
                                                    <td class="text-danger tong_round_tien_tra_ky"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-danger tong_phi_tu_van"></td>
                                                    <td class="text-danger tong_phi_tham_dinh"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <table class="table table-bordered table-interest bang_phi2" style="vertical-align:middle;display:none">
                                            <thead>
                                                <tr>
                                                <th scope="col" rowspan="2">Kỳ trả</th>
                                                <th scope="col" colspan="4">Số tiền trả hàng kỳ</th>
                                                <th scope="col" rowspan="2">Tiền phạt tất toán sớm</th>
                                                <th scope="col" rowspan="2">Tiền tất toán sớm</th>
                                                </tr>
                                                <tr>
                                                <th scope="col">Trả kỳ</th>
                                                <th scope="col">Phí tư vấn</th>
                                                <th scope="col">Phí dịch vụ</th>
                                                <th scope="col">Lãi</th>
                                                </tr>
                                            </thead>
                                            <tbody class='tbody_bang_phi2'></tbody>
                                            <tfoot class="bg-warning">
                                                <tr>
                                                    <td class="text-danger" colspan="1">Tổng tiền</td>
                                                    <td class="text-danger"> 2.234.234 </td>
                                                    <td class="text-danger"> 2.234.234 </td>
                                                    <td class="text-danger">2.234.234 </td>
                                                    <td class="text-danger">2.234.234 </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>`
                                            </tfoot>
                                        </table>
                                    </div>
                                   
                                </div> -->

                             
                                <!--End Thông tin khoản vay-->
                                 <!--Thông tin tài sản-->
                                <div class="x_title">
                                    <strong><i class="fa fa-motorcycle" aria-hidden="true"></i>  <?= $this->lang->line('Price_list')?></strong>
                                    <div class="clearfix"></div>
                                </div>
                                <div class='properties'>
                                </div>



                                <div class="form-group">
                                <table class="table table-bordered table-interest bang_phi1" style="vertical-align:middle;display:none">
                                            <thead>
                                                <tr>
                                                <th scope="col" rowspan="2"><?= $this->lang->line('Payment_period')?></th>
                                                <th scope="col" colspan="7"><?= $this->lang->line('amount_paid_installments')?></th>
                                                <th scope="col" rowspan="2"><?= $this->lang->line('Root_remaining')?></th>
                                                <th scope="col" rowspan="2"><?= $this->lang->line('Early_settlement_penalty')?></th>
                                                <th scope="col" rowspan="2"><?= $this->lang->line('Early_settlement')?></th>
                                                </tr>
                                                <tr>
                                                <th scope="col"><?= $this->lang->line('Pay_period')?></th>
                                                <th scope="col"><?= $this->lang->line('Rounding')?></th>
                                                <th scope="col"><?= $this->lang->line('Root')?></th>
                                                <th scope="col"><?= $this->lang->line('Total_interest_charges')?></th>
                                                <th scope="col"><?= $this->lang->line('Consultant_fee')?></th>
                                                <th scope="col"><?= $this->lang->line('Service_charge')?></th>
                                                <th scope="col"><?= $this->lang->line('Interest')?></th>
                                                </tr>
                                            </thead>
                                            <tbody class='tbody_bang_phi1'></tbody>
                                            <tfoot class="bg-warning">
                                                <tr>
                                                    <td class="text-danger" colspan="1"><?= $this->lang->line('Total_money')?></td>
                                                    <td class="text-danger tong_tien_tra_ky" ></td>
                                                    <td class="text-danger tong_round_tien_tra_ky"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-danger tong_phi_tu_van"></td>
                                                    <td class="text-danger tong_phi_tham_dinh"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <table class="table table-bordered table-interest bang_phi2" style="vertical-align:middle;display:none">
                                            <thead>
                                                <tr>
                                                <th scope="col" rowspan="2"><?= $this->lang->line('Payment_period')?></th>
                                                <th scope="col" colspan="4"><?= $this->lang->line('amount_paid_installments')?></th>
                                                <th scope="col" rowspan="2"><?= $this->lang->line('Early_settlement_penalty')?></th>
                                                <th scope="col" rowspan="2"><?= $this->lang->line('Early_settlement')?></th>
                                                </tr>
                                                <tr>
                                                <th scope="col"><?= $this->lang->line('Pay_period')?></th>
                                                <th scope="col"><?= $this->lang->line('Consultant_fee')?></th>
                                                <th scope="col"><?= $this->lang->line('Service_charge')?></th>
                                                <th scope="col"><?= $this->lang->line('Interest')?></th>
                                                </tr>
                                            </thead>
                                            <tbody id='tbody_bang_phi2'> <th scope="col"><?= $this->lang->line('Service_charge')?></th>
                                                <th scope="col"><?= $this->lang->line('Interest')?></th></tbody>
                                            <tfoot class="bg-warning">
                                                <tr>
                                                    <td class="text-danger" colspan="1"><?= $this->lang->line('Total_money')?></td>
                                                    <td class="text-danger tong_tien_tra_ky2"></td>
                                                    <td class="text-danger tong_phi_tu_van2"></td>
                                                    <td class="text-danger tong_phi_tham_dinh2"></td>
                                                    <td class="text-danger tong_lai_ky2"></td>
                                                    <td></td>
                                                    <td class="text-danger tong_tien_tat_toan2" style="text-align: right;"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                           
                            </div>
                           <!--End Thông tin tài sản-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url("assets")?>/js/numeral.min.js"></script>
<script src="<?php echo base_url();?>assets/js/pawn/index.js"></script>
