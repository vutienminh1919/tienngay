
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
            <div class="doughnut_middledata" style="color: #2FB39C;">

              45
            </div>

              <canvas id="DanhSachLeadv2" height="255" width="255" style="margin: auto; display: block;">


              </canvas>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-5">

          <p><strong>Tổng cộng: 65</strong> </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#2FB39C"></i>
              &nbsp;
              Lead đã Duyệt: 15
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#3398DA"></i>
              &nbsp;
              Lead đã Hủy: 20
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#9B59B2"></i>
              &nbsp;
              Trả lại CSKH: 30
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#BDC4D5"></i>
              &nbsp;
              Lead Đang vay: 15
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#0000FF"></i>
              &nbsp;
              Nguồn Inhouse: 20
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#A30014"></i>
              &nbsp;
              Nguồn Tự kiếm: 30
            </a>
          </p>
          <p>
            <a href="#" class="text-dark">
              <i class="fa fa-square" style="color:#445C74"></i>
              &nbsp;
              Nguồn Vãng lai: 30
            </a>
          </p>
        </div>
      </div>

    </div>
  </div>
</div>
<script>
if ($('#DanhSachLeadv2').length){
  var ctx = document.getElementById("DanhSachLeadv2");
  var data = {
                // labels: ["a","b","c","d","e","f"],
                datasets: [
                    {
                        data: [10, 20, 20, 30],
                        label: 'Data 1',
                        labels: ["Lead đã Duyệt", "Lead đã Hủy", "Trả lại CSKH", "Lead Đang vay"],
                        percent: ["10", "20", "30", "40"],
                        backgroundColor : ['#2FB39C','#3398DA','#9B59B2','#BDC4D5']
                    },
                    {
                        data: [30, 50],
                        label: 'Data 2',
                        labels: ["Nguồn Inhouse", "Nguồn Tự kiếm:", "Nguồn Vãng lai:"],
                        percent: ["10", "20", "30"],
                        backgroundColor : ['#0000FF','#A30014','#445C74']
                    }
                ],
            };

            var options = {
                tooltips: {
                    callbacks: {
                        label: function (item, data) {
                            var label = data.datasets[item.datasetIndex].labels[item.index];
                            var percent = data.datasets[item.datasetIndex].percent[item.index];
                            var value = data.datasets[item.datasetIndex].data[item.index];
                            return label + ': ' + value + ' (' + percent + ')%';
                        }
                    }
                },
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
            };

            var pieChart = new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: options
            });


}
</script>
