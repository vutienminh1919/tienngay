<?php
$tong_cong=!empty($data_plt->insurrance_plt->total_money) ? $data_plt->insurrance_plt->total_money : 0;
$tong_cong_mic=!empty($data_plt->insurrance_plt->total_money_mic) ? $data_plt->insurrance_plt->total_money_mic : 0;
$tong_cong_gic=!empty($data_plt->insurrance_plt->total_money_gic) ? $data_plt->insurrance_plt->total_money_gic : 0;
$tong_cong_vbi=!empty($data_plt->insurrance_plt->total_money_vbi) ? $data_plt->insurrance_plt->total_money_vbi : 0;
$mic_percent=($tong_cong>0) ? $tong_cong_mic/$tong_cong*100 : 0;
$gic_percent=($tong_cong>0) ? $tong_cong_gic/$tong_cong*100 : 0;
$vbi_percent=($tong_cong>0) ? $tong_cong_vbi/$tong_cong*100 : 0;
?>
<div class="col-md-4 col-xs-12">
  <div class="x_panel tile">
    <div class="x_title">
      <h2>Tổng giải ngân</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row flex align-items-center">
        <div class="col-12 col-md-6 col-lg-7">
          <canvas id="baohiem_tonggiaingan_data_plt" height="200" ></canvas>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
          <p>
            <strong>Tổng cộng: <?=number_format($tong_cong)?></strong>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#E74C3C"></i>
              GIC: <?=number_format($tong_cong_gic)?>
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#26B99A"></i>
              MIC: <?=number_format($tong_cong_mic)?>
            </a>
          </p>
            <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#3398da"></i>
              VBI: <?=number_format($tong_cong_vbi)?>
            </a>
          </p>
        </div>
      </div>

    </div>
  </div>
</div>
<script>
if ($('#baohiem_tonggiaingan_data_plt').length){

  var baohiem_tonggiaingan_settings_data_plt = {
    type: 'doughnut',
    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
    data: {
      labels: [
        "GIC",
        "MIC",
        "VBI",
      ],
      datasets: [{
        data: [<?=(int)$gic_percent?>, <?=(int)$mic_percent?>, <?=(int)$vbi_percent?>],
        backgroundColor: [
          "#E74C3C",
          "#26B99A",
          "#3398da",

        ],
        hoverBackgroundColor: [
           "#E74C3C",
          "#26B99A",
          "#3398da"
        ]
      }]
    },
    options: {
      legend: false,
      responsive: false,
      plugins: {
        datalabels: {
          display: false,
        }
      },
    }
  }

  $('#baohiem_tonggiaingan_data_plt').each(function(){

    var chart_element = $(this);
    var baohiem_tonggiaingan_data_plt = new Chart( chart_element, baohiem_tonggiaingan_settings_data_plt);

  });

}
</script>
