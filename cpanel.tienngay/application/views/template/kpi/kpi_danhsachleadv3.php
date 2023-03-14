
<div class="col-md-6 col-xs-12">
  <div class="x_panel tile fixed_height_320 overflow_hidden">
    <div class="x_title">
      <h2>Device Usage</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <table class="" style="width:100%;table-layout:fixed">
        <tr>
          <th style="width:37%;">
            <p>Top 5</p>
          </th>
          <th>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
              <p class="">Device</p>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
              <p class="">Progress</p>
            </div>
          </th>
        </tr>
        <tr>
          <td>
            <canvas id="DanhSachLeadv3" class="" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
          </td>
          <td>
            <table class="tile_info">
              <tr>
                <td>
                  <p><i class="fa fa-square blue"></i>IOS </p>
                </td>
                <td>30%</td>
              </tr>
              <tr>
                <td>
                  <p><i class="fa fa-square green"></i>Android </p>
                </td>
                <td>10%</td>
              </tr>
              <tr>
                <td>
                  <p><i class="fa fa-square purple"></i>Blackberry </p>
                </td>
                <td>20%</td>
              </tr>
              <tr>
                <td>
                  <p><i class="fa fa-square aero"></i>Symbian </p>
                </td>
                <td>15%</td>
              </tr>
              <tr>
                <td>
                  <p><i class="fa fa-square red"></i>Others </p>
                </td>
                <td>30%</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<script>
if ($('#DanhSachLeadv3').length){

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

  $('#DanhSachLeadv3').each(function(){

    var chart_element = $(this);
    var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);

  });

}
</script>
