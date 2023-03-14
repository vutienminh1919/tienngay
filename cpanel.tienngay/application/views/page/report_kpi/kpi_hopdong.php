<?php
$contract_total=(!empty($data->contract_total)) ? $data->contract_total : 0;
$contract_moi=(!empty($data->contract_moi)) ? $data->contract_moi : 0;
$contract_dang_xl=(!empty($data->contract_dang_xl)) ? $data->contract_dang_xl : 0;
$contract_cho_pd=(!empty($data->contract_cho_pd)) ? $data->contract_cho_pd : 0;
$contract_da_duyet=(!empty($data->contract_da_duyet)) ? $data->contract_da_duyet : 0;
$contract_cho_gn=(!empty($data->contract_cho_gn)) ? $data->contract_cho_gn : 0;
$contract_da_gn=(!empty($data->contract_da_gn)) ? $data->contract_da_gn : 0;
$contract_khac=(!empty($data->contract_khac)) ? $data->contract_khac : 0;
 $fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : date('Y-m-01');
  $tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : date('Y-m-d');
 ?>
    <div class="col-md-6 col-xs-12">
      <div class="x_panel tile">
        <div class="x_title">
          <h2>Danh sách Hợp Đồng</h2>
    <!--      <ul class="nav navbar-right panel_toolbox">
        <li>
          <a target="_blank" href="<?php echo base_url('kpi/listDetail_daily_pgd')?>">
            <i class="fa fa-pie-chart"></i>
            Chi tiết PGD
          </a>
        </li>
        <li>
          <a target="_blank" href="<?php echo base_url('kpi/listDetail_daily_user')?>">
            <i class="fa fa-pie-chart"></i>
            Chi tiết GDV
          </a>
        </li>

      </ul> -->
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            <div class="col-12 col-md-6 ">
               <div class="chartwrapper">
            <div class="doughnut_middledata" style="color: red;">
                <?=$contract_total ?>
            </div>
              <canvas id="DanhSachHopDong" height="170" width="170" style="margin: auto;  display: block;">
              </canvas>
            </div>
            </div>
            <div class="col-12 col-md-6 ">
            <table class="table table-borderless">
  <thead>
    <tr>
      <th scope="col">Trạng thái</th>
      <th scope="col">Số lượng (%)</th>
     
    </tr>
  </thead>
  <tbody>
    <tr style="color:#2fb39c">
      <td>
          <a style="color:#2fb39c" target="_blank" href="<?php echo base_url('pawn/search').'?status=1&fdate='.$fdate.'&tdate='.$tdate ?>" class="text-dark">
                <i class="fa fa-square" ></i> &nbsp;
               Mới: 
                </a>
            </td>
      <td> 
        <?=$contract_moi ?> 
      (<i><?=($contract_total>0) ? round(($contract_moi/$contract_total)*100) : 0 ?></i>%)
    </td>
   
    </tr>
      <tr style="color:#bcc4d5">
      <td>
         <a style="color:#bcc4d5" target="_blank" href="<?php echo base_url('pawn/search').'?status=2&fdate='.$fdate.'&tdate='.$tdate ?>" class="text-dark">
                <i class="fa fa-square" ></i> &nbsp;
                Chờ CHT duyệt: 
                </a>
            </td>
      <td> 
        <?=$contract_dang_xl ?> 
      (<i><?=($contract_total>0) ? round(($contract_dang_xl/$contract_total)*100) : 0 ?></i>%)
    </td>
     <td></td>
    </tr>
      <tr style="color:#445d75">
      <td>
      <a style="color:#445d75" target="_blank" href="<?php echo base_url('pawn/search').'?status=5&fdate='.$fdate.'&tdate='.$tdate ?>" class="text-dark">
                <i class="fa fa-square" ></i> &nbsp;
                Chờ HS duyệt: 
                </a>
            </td>
      <td> 
        <?=$contract_cho_pd ?> 
      (<i><?=($contract_total>0) ? round(($contract_cho_pd/$contract_total)*100) : 0 ?></i>%)
    </td>
     <td></td>
    </tr>
     <tr style="color:#9a5ab2">
      <td>
        <a style="color:#9a5ab2" target="_blank" href="<?php echo base_url('pawn/search').'?status=6&fdate='.$fdate.'&tdate='.$tdate ?>" class="text-dark">
                <i class="fa fa-square" ></i> &nbsp;
                Hội sở đã duyệt: 
                </a>
            </td>
      <td> 
        <?=$contract_da_duyet ?> 
      (<i><?=($contract_total>0) ? round(($contract_da_duyet/$contract_total)*100) : 0 ?></i>%)
    </td>
     <td></td>
    </tr>
 <tr style="color:#3398da">
      <td>
         <a style="color:#3398da" target="_blank" href="<?php echo base_url('pawn/search').'?status=15&fdate='.$fdate.'&tdate='.$tdate ?>" class="text-dark">
                <i class="fa fa-square" ></i> &nbsp;
                Chờ giải ngân: </a>
            </td>
      <td> 
        <?=$contract_cho_gn ?> 
      (<i><?=($contract_total>0) ? round(($contract_cho_gn/$contract_total)*100) : 0 ?></i>%)
    </td>
     <td></td>
    </tr>
     <tr style="color:#a30041">
      <td>
          <a style="color:#a30041" target="_blank" href="<?php echo base_url('pawn/search').'?ngay_giai_ngan=2&status=17&fdate='.$fdate.'&tdate='.$tdate ?>" class="text-dark">
                <i class="fa fa-square" ></i> &nbsp;
                Đang vay: 
                </a>
            </td>
      <td> 
        <?=$contract_da_gn ?> 
      (<i><?=($contract_total>0) ? round(($contract_da_gn/$contract_total)*100) : 0 ?></i>%)
    </td>
     <td></td>
    </tr>
      <tr style="color:#2778a5">
      <td>
          <a style="color:#2778a5" target="_blank" href="#" class="text-dark">
                <i class="fa fa-square" ></i> &nbsp;
                 Khác: <?=$contract_khac ?>
                </a>
            </td>
      <td> 
        <?=$contract_khac ?> 
      (<i><?=($contract_total>0) ? round(($contract_khac/$contract_total)*100) : 0 ?></i>%)
    </td>
     <td></td>
    </tr>
  </tbody>
</table>
             
            
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
						"Mới",
            "Đang xử lý",
						"Chờ CHT phê duyệt",
						"Hội sở đã duyệt",
            "Chờ giải ngân",
            "Đang vay",
						"Khác"
					],
					datasets: [{
						data: [<?=$contract_moi ?>, <?=$contract_dang_xl ?>, <?=$contract_cho_pd?>, <?=$contract_da_duyet ?>, <?=$contract_cho_gn ?>, <?=$contract_da_gn ?>, <?=$contract_khac ?>],
						backgroundColor: [
              "#2fb39c", "#bcc4d5", "#445d75", "#9a5ab2", "#3398da", "#a30041","#2778a5"
						],
						hoverBackgroundColor: [
             "#2fb39c", "#bcc4d5", "#445d75", "#9a5ab2", "#3398da", "#a30041","#2778a5"
						],
            datalabels : {
              display: false,
              color: '#fff',
              formatter: function(value, context) {
                if (value == 0) {
                  return '';
                } else {
                  return value;
                }
                
              }
            }
					}]
				},

      options: {
         display: false,
        legend: false,
        responsive: false,

      }
    }

    var chart_doughnut_settings_null = {
      type: 'doughnut',
      tooltip: false,
      data: {
          labels: [
            "0",
          ],
          datasets: [{
            data: [0.1],
            backgroundColor: [
              "#eee"
            ],
            hoverBackgroundColor: [
              "#ddd"
            ]
          }]
        },

      options: {
        legend: false,
        responsive: false,
         display: false,
        title: {
          display: false,
          text: 'Chưa có thông tin'
        },
        plugins: {
          datalabels: {
            display: true,
            font: {
              weight: 'normal',
              size: 14,
              color: '#fff'
            },
          }
        },
      }
    }

    $('#DanhSachHopDong').each(function(){

      var chart_element = $(this);
      <?php if($contract_total==0){ ?>
      var chart_doughnut = new Chart( chart_element, chart_doughnut_settings_null);
      <?php }else { ?>
      var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);
      <?php  } ?>

    });

  }
    </script>
