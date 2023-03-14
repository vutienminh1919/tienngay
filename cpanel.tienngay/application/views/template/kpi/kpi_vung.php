

<div class="col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>KPI các vùng</h2>
      <ul class="nav navbar-right panel_toolbox">

        <li>
          <a class="close-link" href="#" title="Close">
            <i class="fa fa-close"></i>
          </a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <div class="row">
        <div class="col-12 col-md-6">
          <h4>Danh sách các vùng của VFC</h4>
          <br>
        </div>
        <div class="col-12 col-md-6">
          <div class="form-group">
            <select class="form-control" style="max-width: 255px;margin-left:auto">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-8 kpiitemwrapper">
          <canvas id="kpi_vung" height="255" class="w-100"></canvas>
        </div>

        <div class="col-12 col-md-3 col-lg-4">

          <p class="kpidata">
            <strong style="color:#2778a5">
              Tổng chi tiêu:
              <span class="pull-right text-danger">
                1.5 tỷ
              </span>
            </strong>
          </p>
          <p class="kpidata">
            <strong style="color:#2778a5">
              KPI giải ngân:
              <span class="pull-right text-danger">
                1.5 tỷ
              </span>
            </strong>
          </p>
          <p class="kpidata">
            <strong style="color:#2778a5">
              KPI KH mới:
              <span class="pull-right text-danger">
                1.5 tỷ
              </span>
            </strong>
          </p>
          <p class="kpidata">
            <strong style="color:#2778a5">
              KPI bảo hiểm:
              <span class="pull-right text-danger">
                1.5 tỷ
              </span>
            </strong>
          </p>
          <p class="kpidata">
            <strong style="color:#2778a5">
              KPI hđ quá hạn:
              <span class="pull-right text-danger">
                1.5 tỷ
              </span>
            </strong>
          </p>

        </div>
      </div>

    </div>
  </div>
</div>


<script>
if ($('#kpi_vung').length){

  var data_kpichitieu_dsGiaiNgan = [41,52,72,45,67];
  var data_kpichitieu_dsBaoHiem = [41,56,45,23,45];
  var data_kpichitieu_slKhachHangMoi = [41,78,34,56,67];
  var data_kpichitieu_tlNoQuaHan = [41,59,56,34,23];

  var data_kpidatduoc_dsGiaiNgan = [12,32,45,33,21];
  var data_kpidatduoc_dsBaoHiem = [20,45,21,45,22];
  var data_kpidatduoc_slKhachHangMoi = [30,22,23,67,53];
  var data_kpidatduoc_tlNoQuaHan = [12,76,43,56,32];

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
    type: 'horizontalBar',
    data: {

      labels: ["Khu vực 1","Khu vực 2","Khu vực 3","Khu vực 4","Khu vực 5"],
      datasets: [
        {
          type: 'horizontalBar',
          label: 'Doanh số giải ngân',
          data: data_kpiPercent_dsGiaiNgan,
          backgroundColor: '#E74C3C',
          datalabels: {
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              return value + '%';
            }
          }
        },{
          type: 'horizontalBar',
          label: 'Doanh số bảo hiểm',
          data: data_kpiPercent_dsBaoHiem,
          backgroundColor: '#26B99A',
          datalabels: {
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              return value + '%';
            }
          }
        },{
          type: 'horizontalBar',
          label: 'Số lượng khách hàng mới',
          data: data_kpiPercent_slKhachHangMoi,
          backgroundColor: '#9B59B6',
          datalabels: {
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              return value + '%';
            }
          }
        },{
          type: 'horizontalBar',
          label: 'Tỉ lệ hđ quá hạn',
          data: data_kpiPercent_tlNoQuaHan,
          backgroundColor: '#3498DB',
          datalabels: {
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              return value + '%';
            }
          }
        },{
          type: 'horizontalBar',
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
            right: 45,
          }
        },
        scales: {
          xAxes: [{
            stacked: true,
            gridLines: {
                display:false
            }
          }],
          yAxes: [{
            stacked: true,
            gridLines: {
                display:false
            }
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

    $('#kpi_vung').each(function(){

      var chart_element = $(this);
      var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);

    });

  }
</script>
