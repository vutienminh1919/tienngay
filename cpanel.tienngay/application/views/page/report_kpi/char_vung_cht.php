<?php $count=count(explode(",",$data_labels));?>
<div class="col-12 col-md-6 col-lg-8 kpiitemwrapper">

          <canvas id="kpi_vung"   class="w-100"></canvas>
</div>

        <div class="col-12 col-md-3 col-lg-4">
<!-- 
          <p class="kpidata">
            <strong>
              Tổng chi tiêu:
              <span class="pull-right text-danger tong_chi_tieu">
                <?=$tong_chi_tieu ?> đ
              </span>
            </strong>
          </p> -->
          <p class="kpidata">
            <strong>
              KPI giải ngân
              <span class="pull-right text-danger kpi_giai_ngan">
                <?=$kpi_giai_ngan ?> đ
              </span>
            </strong>
          </p>
          <p class="kpidata">
            <strong>
              KPI KH mới
              <span class="pull-right text-danger kpi_kh_moi">
                <?=$kpi_kh_moi ?> 
              </span>
            </strong>
          </p>
          <p class="kpidata">
            <strong>
              KPI bảo hiểm
              <span class="pull-right text-danger kpi_bao_hiem">
                <?=$kpi_bao_hiem ?> đ
              </span>
            </strong>
          </p>
        </div>
<script>
  if ($('#kpi_vung').length){

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
  var data_kpiPercent_tlNoQuaHan = [];

  var data_kpiPercent_ToTal_label = [];
  var data_kpiPercent_ToTal = [];

  data_kpichitieu_dsGiaiNgan.forEach(KPI_Percent_convert);

  function KPI_Percent_convert(item, index) {
    var kpiPercent_dsGiaiNgan = Math.round((data_kpidatduoc_dsGiaiNgan[index] / data_kpichitieu_dsGiaiNgan[index]) * datakpi_titrong_dsGiaiNgan[index]);
    data_kpiPercent_dsGiaiNgan.push(kpiPercent_dsGiaiNgan);

    var kpiPercent_dsBaoHiem = Math.round((data_kpidatduoc_dsBaoHiem[index] / data_kpichitieu_dsBaoHiem[index]) *datakpi_titrong_dsBaoHiem[index]);
    data_kpiPercent_dsBaoHiem.push(kpiPercent_dsBaoHiem);

    var kpiPercent_slKhachHangMoi = Math.round((data_kpidatduoc_slKhachHangMoi[index] / data_kpichitieu_slKhachHangMoi[index]) * datakpi_titrong_slKhachHangMoi[index]);
    data_kpiPercent_slKhachHangMoi.push(kpiPercent_slKhachHangMoi);

    // var kpiPercent_tlNoQuaHan = Math.round((data_kpidatduoc_tlNoQuaHan[index] / data_kpichitieu_tlNoQuaHan[index]) * 100);
    // data_kpiPercent_tlNoQuaHan.push(kpiPercent_tlNoQuaHan);

    var kpiPercent_ToTal = kpiPercent_dsGiaiNgan + kpiPercent_dsBaoHiem + kpiPercent_slKhachHangMoi; //+ kpiPercent_tlNoQuaHan;

    data_kpiPercent_ToTal_label.push(kpiPercent_ToTal);
    data_kpiPercent_ToTal.push(0);
  }

  var chart_doughnut_settings = {
    type: 'horizontalBar',
    data: {

      labels: [<?=$data_labels ?>],
      datasets: [
        {
          type: 'horizontalBar',
          label: 'DS giải ngân',
          data: data_kpiPercent_dsGiaiNgan,
          backgroundColor: '#26B99A',
          datalabels: {
            display: false,
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              if (value == 0) {
                return '';
              } else {
                return value + '%';
              }
            }
          }
        },{
          type: 'horizontalBar',
          label: 'DS bảo hiểm',
          data: data_kpiPercent_dsBaoHiem,
          backgroundColor: '#E74C3C',
          datalabels: {
            display: false,
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              if (value == 0) {
                return '';
              } else {
                return value + '%';
              }
            }
          }

        },{
          type: 'horizontalBar',
          label: 'SL khách hàng mới',
          data: data_kpiPercent_slKhachHangMoi,
          backgroundColor: '#2778a5',
          datalabels: {
            display: false,
            align: 'center',
            anchor: 'center',
            color: '#fff',
            formatter: function(value, context) {
              if (value == 0) {
                return '';
              } else {
                return value + '%';
              }
              
            }
          }
        }
        // ,{
        //   type: 'horizontalBar',
        //   label: 'Tỉ lệ  quá hạn',
        //   data: data_kpiPercent_tlNoQuaHan,
        //   backgroundColor: '#3498DB',
        //   datalabels: {
        //     align: 'center',
        //     anchor: 'center',
        //     color: '#fff',
        //     formatter: function(value, context) {
        //       if (value == 0) {
              //   return '';
              // } else {
              //   return value + '%';
              // }
        //     }
        //   }
        // }
        ,{
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
        tooltips: true,
        layout: {
          padding: {
            right: 45,
          }
        },
        scales: {
          xAxes: [{
            stacked: true,
          }],
          yAxes: [{
            stacked: true,
          }]
        },
        plugins: {
          datalabels: {
            
            font: {
              weight: 'normal',
              size: 14
            },
          }
        },
      }
    }

    $('#kpi_vung').each(function(){

      var chart_element = $(this);
      $(chart_element).attr("height", (<?=$count?>*32) + 100);
      var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);
    
    });


  }

</script>
