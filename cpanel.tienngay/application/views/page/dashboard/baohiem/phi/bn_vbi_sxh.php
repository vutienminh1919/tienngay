
<div class="col-md-4 col-xs-12">
  <div class="x_panel tile">
    <div class="x_title">
      <h2>Tổng số lượng</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row flex align-items-center">
        <div class="col-12 col-md-6 col-lg-7">
          <canvas id="baohiem_tongsoluong" height="200" ></canvas>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
          <p>
            <strong>Tổng cộng: 65</strong>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#E74C3C"></i>
              GIC: 15
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#26B99A"></i>
              MIC: 20
            </a>
          </p>
        </div>
      </div>

    </div>
  </div>
</div>
<script>
if ($('#baohiem_tongsoluong').length){

  var baohiem_tongsoluong_settings = {
    type: 'doughnut',
    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
    data: {
      labels: [
        "GIC",
        "MIC",
      ],
      datasets: [{
        data: [15, 20],
        backgroundColor: [
          "#E74C3C",
          "#26B99A",

        ],
        hoverBackgroundColor: [
          "#E95E4F",
          "#36CAAB",
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

  $('#baohiem_tongsoluong').each(function(){

    var chart_element = $(this);
    var baohiem_tongsoluong = new Chart( chart_element, baohiem_tongsoluong_settings);

  });

}
</script>
