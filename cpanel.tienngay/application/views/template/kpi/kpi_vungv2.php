<div class="col-xs-12">
  <div class="x_panel tile">
    <div class="x_title">
      <h2>KPI các vùng</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row large-gutter">
        <div class="col-xs-12 col-md-6 col-lg-8 form-horizontal kpiitemwrapper">


          <?php for ($i=0; $i < 5 ; $i++) { ?>
            <a href="#" class="widget_summary">
              <div class="w_left w_25">
                <span>PGD XYZ</span>
              </div>
              <div class="w_center w_55">
                <div class="progress">
                  <div class="progress-bar bg-green" role="progressbar" style="width: 10%;" title="SOmething: 10%">

                  </div>
                  <div class="progress-bar bg-red" role="progressbar" style="width: 20%;" title="20%">

                  </div>
                  <div class="progress-bar bg-info" role="progressbar" style="width: 30%;" title="30%">

                  </div>
                </div>
              </div>
              <div class="w_right w_20">
                <span>60%</span>
              </div>
              <div class="clearfix"></div>
            </a>
          <?php } ?>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-4 ">
          <div class="form-group">

            <select class="form-control selectize-phonggiaodich" multiple placeholder="Tất cả các phòng giao dịch">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>

          </div>

          <script>
          $('.selectize-phonggiaodich').selectize({
            // sortField: 'text'
          });
          </script>

          <table class="table table-borderless">
            <tbody>
              <tr>
                <th style="color:#2778a5">
                  <i class="fa fa-square" style="color:#A30014"></i> &nbsp;
                  Tổng chi tiêu:
                </th>
                <td style="text-align:right;color:red">
                  1.5 tỷ
                </td>
              </tr>
              <tr>
                <th style="color:#2778a5">
                  <i class="fa fa-square" style="color:#A30014"></i> &nbsp;
                  Tổng chi tiêu:
                </th>
                <td style="text-align:right;color:red">
                  1.5 tỷ
                </td>
              </tr>
              <tr>
                <th style="color:#2778a5">
                  <i class="fa fa-square" style="color:#A30014"></i> &nbsp;
                  Tổng chi tiêu:
                </th>
                <td style="text-align:right;color:red">
                  1.5 tỷ
                </td>
              </tr>
              <tr>
                <th style="color:#2778a5">
                  <i class="fa fa-square" style="color:#A30014"></i> &nbsp;
                  Tổng chi tiêu:
                </th>
                <td style="text-align:right;color:red">
                  1.5 tỷ
                </td>
              </tr>
            </tbody>
          </table>





        </div>
      </div>
    </div>
  </div>
</div>
