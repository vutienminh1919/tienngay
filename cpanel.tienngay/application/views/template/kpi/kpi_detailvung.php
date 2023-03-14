

<div class="col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>KPI Vùng: Hà Nội 1</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li>
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            Chi tiết
          </a>
        </li>
        <li>
          <a class="close-link" href="#" title="Close">
            <i class="fa fa-close"></i>
          </a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row large-gutter">
        <div class="col-xs-12 col-md-6 col-lg-8 kpiitemwrapper">
          <canvas id="kpi_detailvung" height="450" class="w-100"></canvas>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="form-group">

              <select class="form-control selectize-detail" multiple placeholder="Tất cả các phòng giao dịch">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>

            </div>

            <script>
            $('.selectize-detail').selectize({
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


<script>
if ($('#kpi_detailvung').length){

  var data_kpichitieu_dsGiaiNgan = [41,52,41,52,41,52,41,52,41,52,41,52,];
  var data_kpichitieu_dsBaoHiem = [41,56,41,52,41,52,41,52,41,52,41,52,];
  var data_kpichitieu_slKhachHangMoi = [41,78,41,52,41,52,41,52,41,52,41,52,];
  var data_kpichitieu_tlNoQuaHan = [41,59,41,52,41,52,41,52,41,52,41,52,];

  var data_kpidatduoc_dsGiaiNgan = [12,32,41,52,41,52,41,52,41,52,41,52,];
  var data_kpidatduoc_dsBaoHiem = [20,45,41,52,41,52,41,52,41,52,41,52,];
  var data_kpidatduoc_slKhachHangMoi = [30,22,41,52,41,52,41,52,41,52,41,52,];
  var data_kpidatduoc_tlNoQuaHan = [12,76,41,52,41,52,41,52,41,52,41,52,];

  var data_kpiPercent_dsGiaiNgan = [];
  var data_kpiPercent_dsBaoHiem = [];
  var data_kpiPercent_slKhachHangMoi = [];
  var data_kpiPercent_tlNoQuaHan = [];

  var data_kpiPercent_ToTal_label = [];
  var data_kpiPercent_ToTal = [];

  data_kpichitieu_dsGiaiNgan.forEach(KPI_Percent_convert);

  function KPI_Percent_convert(item, index) {
    var kpiPercent_dsGiaiNgan = Math.round((data_kpidatduoc_dsGiaiNgan[index] / data_kpichitieu_dsGiaiNgan[index]) * 100);
    data_kpiPercent_dsGiaiNgan.push(kpiPercent_dsGiaiNgan);

    var kpiPercent_dsBaoHiem = Math.round((data_kpidatduoc_dsBaoHiem[index] / data_kpichitieu_dsBaoHiem[index]) * 100);
    data_kpiPercent_dsBaoHiem.push(kpiPercent_dsBaoHiem);

    var kpiPercent_slKhachHangMoi = Math.round((data_kpidatduoc_slKhachHangMoi[index] / data_kpichitieu_slKhachHangMoi[index]) * 100);
    data_kpiPercent_slKhachHangMoi.push(kpiPercent_slKhachHangMoi);

    var kpiPercent_tlNoQuaHan = Math.round((data_kpidatduoc_tlNoQuaHan[index] / data_kpichitieu_tlNoQuaHan[index]) * 100);
    data_kpiPercent_tlNoQuaHan.push(kpiPercent_tlNoQuaHan);

    var kpiPercent_ToTal = kpiPercent_dsGiaiNgan + kpiPercent_dsBaoHiem + kpiPercent_slKhachHangMoi + kpiPercent_tlNoQuaHan;

    data_kpiPercent_ToTal_label.push(kpiPercent_ToTal);
    data_kpiPercent_ToTal.push(0);
  }

  var chart_doughnut_settings = {
    type: 'bar',
    data: {

      labels: ["Thg 1","Thg 2","Thg 1","Thg 2","Thg 1","Thg 2","Thg 1","Thg 2","Thg 1","Thg 2","Thg 1","Thg 2",],
      datasets: [
        {
          type: 'bar',
          label: 'Doanh số giải ngân',
          data: data_kpiPercent_dsGiaiNgan,
          backgroundColor: '#E74C3C',
          datalabels: {
            display: false,
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              return value + '%';
            }
          }
        },{
          type: 'bar',
          label: 'Doanh số bảo hiểm',
          data: data_kpiPercent_dsBaoHiem,
          backgroundColor: '#26B99A',
          datalabels: {
            display: false,
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              return value + '%';
            }
          }
        },{
          type: 'bar',
          label: 'Số lượng khách hàng mới',
          data: data_kpiPercent_slKhachHangMoi,
          backgroundColor: '#9B59B6',
          datalabels: {
            display: false,
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              return value + '%';
            }
          }
        },{
          type: 'bar',
          label: 'Tỉ lệ HĐ vay quá hạn',
          data: data_kpiPercent_tlNoQuaHan,
          backgroundColor: '#3498DB',
          datalabels: {
            display: false,
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              return value + '%';
            }
          }
        },{
          type: 'bar',
          label: 'Tổng KPI',
          data: data_kpiPercent_ToTal,
          backgroundColor: '#2A3F54',
          datalabels: {
            align: 'end',
            anchor: 'end',
            color: '#2A3F54',
            formatter: function(value, context) {

              return data_kpiPercent_ToTal_label[context.dataIndex] + '%';
            }
          }
        }

      ]},
      options: {
        legend: {
          position: 'bottom'
        },
        responsive: true,
        tooltips: false,
        layout: {
          padding: {
            top: 25,
          }
        },
        scales: {
          xAxes: [{
            stacked: true,
            maxBarThickness: 32,
          }],
          yAxes: [{
            stacked: true,
            maxBarThickness: 32,
          }]
        },
        plugins: {
          datalabels: {
            display: true,
            font: {
              weight: 'bold',
              size: 14
            },
          }
        },
      }
    }

    $('#kpi_detailvung').each(function(){

      var chart_element = $(this);
      var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);

    });

  }
</script>
