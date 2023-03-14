
<div class="col-md-6 col-xs-12">
  <div class="x_panel tile">
    <div class="x_title">
      <h2>Danh sách Hợp Đồng</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li>
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            Chi tiết
          </a>
        </li>

      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row flex align-items-center">
        <div class="col-12 col-md-6 col-lg-7">
          <canvas id="DanhSachHopDong" height="255" ></canvas>
        </div>
        <div class="x_content">
          <div class="row flex align-items-center">
            <div class="col-12 col-md-6 col-lg-7">
              <canvas id="DanhSachHopDong" width="200" height="200" ></canvas>
            </div>
            <div class="col-12 col-md-6 col-lg-5">

              <p><strong>Tổng cộng: 65</strong> </p>
              <p>
                <a href="#" class="text-dark">
                <i class="fa fa-square" style="color:#E74C3C"></i>
                HĐ Mới: 15
                </a>
              </p>
              <p>
                <a href="#" class="text-dark">
                <i class="fa fa-square" style="color:#26B99A"></i>
                HĐ đang xử lý: 20
                </a>
              </p>
              <p>
                <a href="#" class="text-dark">
                <i class="fa fa-square" style="color:#9B59B6"></i>
                HĐ chờ phê duyệt: 30
                </a>
              </p>

          <p><strong>Tổng cộng: 65</strong> </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#E74C3C"></i>
              HĐ Mới: 15
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#26B99A"></i>
              HĐ đang xử lý: 0
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#9B59B6"></i>
              HĐ chờ phê duyệt: 30
            </a>
          </p>

          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#3498DB"></i>
              HĐ chờ giải ngân: 30
            </a>
          </p>

          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#BDC3C7"></i>
              HĐ chờ bổ xung: 30
            </a>
          </p>
        </div>
      </div>

    </div>
  </div>
</div>
</div>
</div>
<script>
if ($('#DanhSachHopDong').length){

  var chart_doughnut_settings = {
    type: 'doughnut',
    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
    data: {
      labels: [
        "HĐ Mới",
        "HĐ đang xử lý",
        "HĐ chờ phê duyệt",
        "HĐ chờ giải ngân",
        "HĐ chờ bổ xung"
      ],
      datasets: [{
        data: [15, null, 30, 30, 30],
        backgroundColor: [
          "#E74C3C",
          "#26B99A",
          "#9B59B6",
          "#3498DB",
          "#BDC3C7"
        ],
        hoverBackgroundColor: [
          "#E95E4F",
          "#36CAAB",
          "#B370CF",
          "#49A9EA",
          "#CFD4D8"
        ]
      }]
    },

    options: {
      legend: false,
      responsive: false,
      plugins: {
        datalabels: {
          color: '#ffffff',
          // formatter: function (value) {
          //   return Math.round(value) + '%';
          // },
          font: {
            weight: 'bold',
            size: 16,
          }
        }
      }
    }
  }

  $('#DanhSachHopDong').each(function(){

    var chart_element = $(this);
    var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);

  });

}
</script>
