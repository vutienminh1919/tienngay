
<div class="col-md-6 col-xs-12">
  <div class="x_panel tile">
    <div class="x_title">
      <h2>Danh sách Lead</h2>
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
          <div class="chartwrapper">
            <div class="doughnut_middledata" style="color: red;">
             
              1000
            </div>

              <canvas id="DanhSachLead" height="255" width="255" style="margin: auto; display: block;">


              </canvas>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-5">

          <p><strong>Tổng cộng: 65</strong> </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#2fb39c"></i>
              &nbsp;
              Lead đã Duyệt: 15
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#bcc4d5"></i>
              &nbsp;
              Lead đã Hủy: 20
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#445d75"></i>
              &nbsp;
              Trả lại CSKH: 30
            </a>
          </p>
        </div>
      </div>

    </div>
  </div>
</div>
<script>
if ($('#DanhSachLead').length){

  var chart_doughnut_settings = {
    type: 'doughnut',
    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
    data: {
      labels: [
        "Đã Duyệt",
        "Đã Hủy",
        "Trả lại CSKH",
      ],
      datasets: [{
        data: [15, 20, 30],
        backgroundColor: [
         "#2fb39c", "#bcc4d5", "#445d75"

        ],
        hoverBackgroundColor: [
          "#2fb39c", "#bcc4d5", "#445d75"
        ]
      }]
    },
    options: {
      legend: false,
      responsive: false,
      aspectRatio: 1,
      plugins: {
      datalabels: {
          display: false,
        },
      }
    },

  }

  $('#DanhSachLead').each(function(){

    var chart_element = $(this);
    var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);

  });

}
</script>
