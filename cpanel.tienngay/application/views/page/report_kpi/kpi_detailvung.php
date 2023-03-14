<div class="col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>KPI giao dịch viên</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li>
          <a href="<?php echo base_url('kpi/listDetailKPI_user')?>">
            <i class="fa fa-pie-chart"></i>
            Chi tiết
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
        

            <script>
            $('.selectize-detail').selectize({
              // sortField: 'text'
            });
            </script>

            <table class="table table-borderless">
              <tbody>
                <tr>
                  <th style="color:#1ABB9C">
                    <i class="fa fa-square" style="color:#1ABB9C"></i> &nbsp;
                     Tổng giải ngân:
                  </th>
                  <td style="text-align:right;color:red">
                   <?=number_format($kpi_giai_ngan) ?> đ
                  </td>
                </tr>
                <tr>
                  <th style="color:#E74C3C">
                    <i class="fa fa-square" style="color:#E74C3C"></i> &nbsp;
                     Tổng bảo hiểm:
                  </th>
                  <td style="text-align:right;color:red">
                     <?=$kpi_bao_hiem ?> đ
                  </td>
                </tr>
                <tr>
                  <th style="color:#337ab7">
                    <i class="fa fa-square" style="color:#337ab7"></i> &nbsp;
                     Tổng khách hàng mới:
                  </th>
                  <td style="text-align:right;color:red">
                   <?=number_format($kpi_kh_moi) ?> 
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

   var data_kpichitieu_dsGiaiNgan = [<?=$data_kpichitieu_dsGiaiNgan ?>];
  var data_kpichitieu_dsBaoHiem = [<?=$data_kpichitieu_dsBaoHiem ?>];
  var data_kpichitieu_slKhachHangMoi = [<?=$data_kpichitieu_slKhachHangMoi ?>];


  var data_kpidatduoc_dsGiaiNgan = [<?=$data_kpidatduoc_dsGiaiNgan ?>];
  var data_kpidatduoc_dsBaoHiem = [<?=$data_kpidatduoc_dsBaoHiem ?>];
  var data_kpidatduoc_slKhachHangMoi = [<?=$data_kpidatduoc_slKhachHangMoi ?>];

   var datakpi_titrong_dsGiaiNgan = [<?=$datakpi_titrong_dsGiaiNgan ?>];
  var datakpi_titrong_dsBaoHiem = [<?=$datakpi_titrong_dsBaoHiem ?>];
  var datakpi_titrong_slKhachHangMoi = [<?=$datakpi_titrong_slKhachHangMoi ?>];

  var data_kpiPercent_dsGiaiNgan = [];
  var data_kpiPercent_dsBaoHiem = [];
  var data_kpiPercent_slKhachHangMoi = [];
//  var data_kpiPercent_tlNoQuaHan = [];

  var data_kpiPercent_ToTal_label = [];
  var data_kpiPercent_ToTal = [];

  data_kpichitieu_dsGiaiNgan.forEach(KPI_Percent_convert);

  function KPI_Percent_convert(item, index) {
    var kpiPercent_dsGiaiNgan = Math.round((data_kpidatduoc_dsGiaiNgan[index] / data_kpichitieu_dsGiaiNgan[index]) * datakpi_titrong_dsGiaiNgan[index]);
    data_kpiPercent_dsGiaiNgan.push(kpiPercent_dsGiaiNgan);

    var kpiPercent_dsBaoHiem = Math.round((data_kpidatduoc_dsBaoHiem[index] / data_kpichitieu_dsBaoHiem[index]) * datakpi_titrong_dsBaoHiem[index]);
    data_kpiPercent_dsBaoHiem.push(kpiPercent_dsBaoHiem);

    var kpiPercent_slKhachHangMoi = Math.round((data_kpidatduoc_slKhachHangMoi[index] / data_kpichitieu_slKhachHangMoi[index]) * datakpi_titrong_slKhachHangMoi[index]);
    data_kpiPercent_slKhachHangMoi.push(kpiPercent_slKhachHangMoi);

    // var kpiPercent_tlNoQuaHan = Math.round((data_kpidatduoc_tlNoQuaHan[index] / data_kpichitieu_tlNoQuaHan[index]) * 100);
    // data_kpiPercent_tlNoQuaHan.push(kpiPercent_tlNoQuaHan);

    var kpiPercent_ToTal = kpiPercent_dsGiaiNgan + kpiPercent_dsBaoHiem + kpiPercent_slKhachHangMoi ;

    data_kpiPercent_ToTal_label.push(kpiPercent_ToTal);
    data_kpiPercent_ToTal.push(0);
  }

  var chart_doughnut_settings = {
    type: 'bar',
    data: {

      labels: ["Tháng 1","Tháng 2","Tháng 3","Tháng 4","Tháng 5","Tháng 6","Tháng 7","Tháng 8","Tháng 9","Tháng 10","Tháng 11","Tháng 12"],
      datasets: [
        {
          type: 'bar',
          label: 'DS giải ngân',
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
          label: 'DS bảo hiểm',
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
          label: 'SL khách hàng mới',
          data: data_kpiPercent_slKhachHangMoi,
          backgroundColor: '#337ab7',
          datalabels: {
            display: false,
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              return value + '%';
            }
          }
        },
        // {
        //   type: 'bar',
        //   label: 'Tỉ lệ hợp đồng quá hạn',
        //   data: data_kpiPercent_tlNoQuaHan,
        //   backgroundColor: '#3498DB',
        //   datalabels: {
        //     display: false,
        //     align: 'center',
        //     anchor: 'center',
        //     color: '#fff',
        //     formatter: function(value, context) {
        //       return value + '%';
        //     }
        //   }
        // },
        {
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
