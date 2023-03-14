<!-- page content -->
<div class="right_col" role="main">

    <div class="row top_tiles">
        <div class="col-xs-12">
            <div class="page-title">
                <h3>Report: Daily Revenue</h3>

            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">

                    <div class="row">
                        <div class="col-xs-12 col-lg-1">
                            <h2> </h2>
                        </div>
                        <div class="col-xs-12 col-lg-11">
                            <div class="row">
                                <div class="col-lg-6">

                                </div>
                                <div class="col-lg-4">
                                    <div class="form-horizontal">
                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <div class="input-prepend input-group ">
                                                        <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                                        <input type="text" name="reservation" id="reservation" class="form-control" value="01/01/2019 - 01/25/2019" />
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="col-lg-2 text-right">
                                    <button class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</button>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">

                            </div>
                        </div>
                        <div class="col-xs-12">

                            <div class="table-responsive">
                                <table class="table table-bordered m-table table-hover table-calendar table-report" id="tblMoneyByDay">
                                    <thead style="background:#3f86c3; color: #ffffff;">
                                        <tr>
                                            <th width="50px" style="text-align:center;vertical-align:middle" rowspan="2">STT
                                                <br>[1]</th>
                                            <th style="text-align:center;vertical-align:middle" rowspan="2">Ngày
                                                <br>[2]</th>
                                            <th style="text-align:center;vertical-align:middle" rowspan="2">Tiền
                                                <br> đầu ngày
                                                <br>[3]</th>
                                            <th style="text-align:center;vertical-align:middle" rowspan="2">Cầm đồ
                                                <br>[4]</th>
                                            <th style="text-align:center;vertical-align:middle" rowspan="2">Vay lãi
                                                <br>[5]</th>
                                            <th style="text-align:center;vertical-align:middle" rowspan="2">Bát họ
                                                <br>[6]</th>
                                            <th style="text-align:center;vertical-align:middle" rowspan="2">Thu chi
                                                <br>[7]</th>
                                            <th style="text-align:center;vertical-align:middle" rowspan="2">Vốn
                                                <br>[8]</th>
                                            <th style="text-align:center;vertical-align:middle" rowspan="2">Tiền
                                                <br>cuối ngày
                                                <br>[9]=[3+4+5+6+7+8]</th>
                                            <th style="text-align:center;vertical-align:middle;border-bottom:1px solid !important" colspan="3">Đang cho vay+Khách vay</th>
                                            <th style="text-align:center;vertical-align:middle" rowspan="2">Vốn đi vay
                                                <br>[13]</th>
                                            <th style="text-align:center;vertical-align:middle" rowspan="2">Tổng tài sản
                                                <br>[14]=[9+10+11+12-13]</th>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align:middle">Cầm đồ
                                                <br>[10]</th>
                                            <th style="vertical-align:middle">Vay lãi
                                                <br>[11]</th>
                                            <th style="vertical-align:middle">Bát họ
                                                <br>[12]</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php for ($i=1; $i < 10 ; $i++) { ?>
                                        <tr>
                                            <td align="center" class="align-middle"> <?php echo $i ?></td>
                                            <td align="center" class="align-middle">01/09/2019</td>
                                            <td align="center" class="align-middle">1,000,000,000</td>
                                            <td align="center" class="align-middle text-danger">0</td>
                                            <td align="center" class="align-middle text-danger">0</td>
                                            <td align="center" class="align-middle text-danger">0</td>
                                            <td align="center" class="align-middle text-danger">0</td>
                                            <td align="center" class="align-middle text-danger">0</td>
                                            <td align="center" class="align-middle" style="background:#fcf8e3">1,000,000,000</td>
                                            <td align="center" class="align-middle">0</td>
                                            <td align="center" class="align-middle">0</td>
                                            <td align="center" class="align-middle">0</td>
                                            <td align="center" class="align-middle">1,000,000,000</td>
                                            <td align="center" class="align-middle" style="background:#fcf8e3">0</td>
                                        </tr>
                                      <?php } ?>
                                        <tr style="background:#ede8ab">
                                            <td align="right" colspan="2" class="align-middle label-footer">Quỹ tiền đầu kỳ</td>
                                            <td align="center" class="align-middle font-weight-bold text-blue">1,000,000,000</td>
                                            <td align="right" colspan="2" class="align-middle label-footer">Quỹ tiền cuối kỳ</td>
                                            <td align="center" class="align-middle font-weight-bold text-blue">1,000,000,000</td>
                                            <td align="center" class="align-middle"></td>
                                            <td align="center" class="align-middle"></td>
                                            <td align="center" class="align-middle"></td>
                                            <td align="center" class="align-middle label-footer">Tài sản đầu kỳ</td>
                                            <td align="center" class="align-middle font-weight-bold text-blue">0</td>
                                            <td align="center" class="align-middle"></td>
                                            <td align="center" class="align-middle label-footer">Tài sản cuối kỳ</td>
                                            <td align="center" class="align-middle font-weight-bold text-blue">0</td>
                                        </tr>
                                        <tr style="background:#ede8ab">
                                            <td align="right" colspan="2" class="align-middle label-footer">Chênh lệch</td>
                                            <td align="center" colspan="6" class="align-middle font-weight-bold text-blue">0</td>
                                            <td align="right" colspan="3" class="align-middle label-footer">Lợi nhuận</td>
                                            <td align="center" colspan="4" class="align-middle font-weight-bold text-blue">0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
