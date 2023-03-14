

   
    <div class="x_content">
      <div class="row large-gutter">
        <div class="col-xs-12 col-md-6 col-lg-8 form-horizontal kpiitemwrapper">

     
          <?php foreach ($report_kpi as $key => $kpi) {
             if(!empty($kpi->kpi->giai_ngan_CT))   
        $giai_ngan=round(($kpi->sum_giai_ngan/ $kpi->kpi->giai_ngan_CT) * $kpi->kpi->giai_ngan_TT);
       if(!empty($kpi->kpi->bao_hiem_CT))   
        $bao_hiem=round(($kpi->sum_bao_hiem/ $kpi->kpi->bao_hiem_CT) * $kpi->kpi->bao_hiem_TT);
       if(!empty($kpi->kpi->khach_hang_moi_CT))   
        $khach_hang_moi=round(($kpi->count_khach_hang_moi/ $kpi->kpi->khach_hang_moi_CT) * $kpi->kpi->khach_hang_moi_TT);
        //$tong=$giai_ngan+$bao_hiem+$khach_hang_moi;
  
         $name=(!in_array('cua-hang-truong', $groupRoles) || (in_array('phat-trien-san-pham', $groupRoles) || in_array('quan-ly-khu-vuc', $groupRoles))) ? $kpi->store->name : $kpi->user_email;
         $link=(in_array('cua-hang-truong', $groupRoles)) ? base_url('kpi/listDetailKPI_user').'?customer_email='.$kpi->user_email : base_url('kpi/listDetailKPI_pgd').'?code_store%5B%5D='.$kpi->store->id;
          $giai_ngan=is_numeric( $giai_ngan)  ?  $giai_ngan : 0;
          $bao_hiem=is_numeric( $bao_hiem) ?  $bao_hiem : 0;
          $khach_hang_moi=is_numeric( $khach_hang_moi) ?  $khach_hang_moi : 0;
          if(empty($kpi->sum_giai_ngan))
            $giai_ngan=0;
          if(empty($kpi->count_khach_hang_moi))
            $khach_hang_moi=0;
          if(empty($kpi->sum_bao_hiem))
            $bao_hiem=0;
          $tong=$giai_ngan+$bao_hiem+$khach_hang_moi;
           ?>
            <a href="<?=$link?>"  target="_blank" class="widget_summary">
              <div class="w_left w_25">
                <span><?=$name?></span>
              </div>
              <div class="w_center w_55">
                <div class="progress">
                  <div class="progress-bar bg-green" role="progressbar" style="width: <?=$giai_ngan?>%;" title="Giải ngân: <?=$giai_ngan?>%">

                  </div>
                  <div class="progress-bar bg-red" role="progressbar" style="width: <?=$bao_hiem?>%;" title="Bảo hiểm: <?=$bao_hiem?>%">

                  </div>
                  <div class="progress-bar bg-info" role="progressbar" style="width: <?=$khach_hang_moi?>%;" title="Khách hàng mới: <?=$khach_hang_moi?>%">

                  </div>
                </div>
              </div>
              <div class="w_right w_20">
                <span><?=$tong?>%</span>
              </div>
              <div class="clearfix"></div>
            </a>
          <?php } ?>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-4 ">
       

          <script>
          $('.selectize-phonggiaodich').selectize({
            // sortField: 'text'
          });
          </script>

          <table class="table table-borderless">
            <tbody>
              <tr>
                <th style="color:#1ABB9C">
                  <i class="fa fa-square" style="color:#1ABB9C"></i> &nbsp;
                  Tổng giải ngân
                </th>
                <td style="text-align:right;color:red">
                  <?=number_format($kpi_giai_ngan)?>đ
                </td>
              </tr>
              <tr>
                <th style="color:#E74C3C">
                  <i class="fa fa-square" style="color:#E74C3C"></i> &nbsp;
                  Tổng bảo hiểm
                </th>
                <td style="text-align:right;color:red">
                  <?=$kpi_bao_hiem?>đ
                </td>
              </tr>
              <tr>
                <th style="color:#337ab7">
                  <i class="fa fa-square" style="color:#337ab7"></i> &nbsp;
                  Tổng khách hàng mới
                </th>
                <td style="text-align:right;color:red">
                   <?=number_format($kpi_kh_moi)?>
                </td>
              </tr>
        
            </tbody>
          </table>





        </div>
      </div>
    </div>

