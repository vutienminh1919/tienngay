<?php
$lead_da_duyet=(!empty($data->lead_da_duyet)) ? $data->lead_da_duyet : 0;
$lead_da_huy=(!empty($data->lead_da_huy)) ? $data->lead_da_huy : 0;
$lead_tra_lai_cskh=(!empty($data->lead_tra_lai_cskh)) ? $data->lead_tra_lai_cskh : 0;

$lead_total_status=$lead_da_duyet+$lead_da_huy+$lead_tra_lai_cskh;

$lead_dangvay=(!empty($data->lead_dangvay)) ? $data->lead_dangvay : 0;
$lead_inhouse=(!empty($data->lead_inhouse)) ? $data->lead_inhouse : 0;
$lead_tu_kiem=(!empty($data->lead_tu_kiem)) ? $data->lead_tu_kiem : 0;
$lead_vang_lai=(!empty($data->lead_vang_lai)) ? $data->lead_vang_lai : 0;

$lead_total_pgd=$lead_dangvay+$lead_inhouse+$lead_tu_kiem+$lead_vang_lai;


 ?>
<div class="col-md-6 col-xs-12">
  <div class="x_panel tile" style="height: calc(100% - 10px)">
    <div class="x_title">
      <h2>Danh sách Lead</h2>
      
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row ">
        <div class="col-12 col-md-6 ">
           <div class="chartwrapper">
            <div class="doughnut_middledata" style="color: red;">
              
            </div>
              <canvas id="DanhSachLead" height="170" width="170" style="margin: auto; display: block;">
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
    <tr style="color:#2FB39C">
      <td>
        <i class="fa fa-square" ></i> &nbsp;
              Đã Duyệt:
            </td>
      <td> 
        <?=$lead_da_duyet ?> 
      (<i><?=($lead_total_status>0) ? round(($lead_da_duyet/$lead_total_status)*100) : 0 ?></i>%)
    </td>
    
    </tr>
      <tr style="color:#3398DA">
      <td>
        <i class="fa fa-square" ></i> &nbsp;
              Đã Hủy:
            </td>
      <td> 
        <?=$lead_da_huy ?> 
      (<i><?=($lead_total_status>0) ? round(($lead_da_huy/$lead_total_status)*100) : 0 ?></i>%)
    </td>
    
    </tr>
      <tr style="color:#9B59B2">
      <td>
        <i class="fa fa-square" ></i> &nbsp;
              Trả lại CSKH:
            </td>
      <td> 
        <?=$lead_tra_lai_cskh ?> 
      (<i><?=($lead_total_status>0) ? round(($lead_tra_lai_cskh/$lead_total_status)*100) : 0 ?></i>%)
    </td>
     
    </tr>
     <tr style="color:#BDC4D5">
      <td>
        <i class="fa fa-square" ></i> &nbsp;
              Đang vay:
            </td>
      <td> 
        <?=$lead_dangvay ?> 
      (<i><?=($lead_total_pgd>0) ? round(($lead_dangvay/$lead_total_pgd)*100) : 0 ?></i>%)
    </td>
    
    </tr>
      <tr style="color:#0000FF">
      <td>
        <i class="fa fa-square" ></i> &nbsp;
              Inhouse:
            </td>
      <td> 
        <?=$lead_inhouse ?> 
      (<i><?=($lead_total_pgd>0) ? round(($lead_inhouse/$lead_total_pgd)*100) : 0 ?></i>%)
    </td>
    
    </tr style="color:#A30014">
       <tr>
      <td>
        <i class="fa fa-square" ></i> &nbsp;
             Tự kiếm:
            </td>
      <td> 
        <?=$lead_tu_kiem ?> 
      (<i><?=($lead_total_pgd>0) ? round(($lead_tu_kiem/$lead_total_pgd)*100) : 0 ?></i>%)
    </td>
    
    </tr>
       <tr style="color:#445C74">
      <td>
        <i class="fa fa-square" ></i> &nbsp;
              Vãng lai:
            </td>
      <td> 
        <?=$lead_vang_lai ?> 
      (<i><?=($lead_total_pgd>0) ? round(($lead_vang_lai/$lead_total_pgd)*100) : 0 ?></i>%)
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
if ($('#DanhSachLead').length){

  var chart_doughnut_settings = {
    type: 'doughnut',
    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
    data: {
      labels: [
        "Đã Duyệt",
        "Đã Hủy",
        "Trả lại CSKH",
         "Đang vay","Inhouse", "Tự kiếm", "Vãng lai"
      ],
        datasets: [
                    {
                        data: [<?=$lead_da_duyet?>, <?=$lead_da_huy?>, <?=$lead_tra_lai_cskh?>],
                        label: 'Data 1',
                        labels: ["Đã Duyệt", "Đã Hủy", "Trả lại CSKH"],
                        percent: ["<?=$lead_da_duyet?>", "<?=$lead_da_huy?>", "<?=$lead_tra_lai_cskh?>"],
                        backgroundColor : ['#2FB39C','#3398DA','#9B59B2'],
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
                    },
                    {
                        data: [<?=$lead_dangvay?>, <?=$lead_inhouse?>, <?=$lead_tu_kiem?>,<?=$lead_vang_lai?>],
                        label: 'Data 2',
                        labels: ["Đang vay","Inhouse", "Tự kiếm", "Vãng lai"],
                        percent: ["<?=$lead_dangvay?>", "<?=$lead_inhouse?>", "<?=$lead_tu_kiem?>","<?=$lead_vang_lai?>"],
                        backgroundColor : ['#BDC4D5','#0000FF','#A30014','#445C74'],
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
                    }
                ],
    },
    options: {
       display: false,
      legend: false,
      responsive: false
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
            ],

          }]
        },

      options: {
        legend: false,
        responsive: false,
         display: false,
        title: {
          display: true,
          text: 'Chưa có thông tin'
        },
      }
    }
  $('#DanhSachLead').each(function(){

    var chart_element = $(this);
    <?php if($lead_total==0){ ?>
      var chart_doughnut = new Chart( chart_element, chart_doughnut_settings_null);
      <?php }else { ?>
      var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);
      <?php  } ?>


  });

}
</script>
