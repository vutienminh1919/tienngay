<div class="col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Hoạt động</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <ul class="list-unstyled timeline workflow widget">
              <?php if(!empty($logs)){ 
                  foreach($logs as $key => $wl){
                ?>
                <li>
                  <img class="theavatar" src="<?php echo base_url("assets/imgs/avatar_none.png")?>" alt="">
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a><?= !empty($wl->action) ? $wl->action : "";?></a>
                      </h2>
                      <div class="byline">
                        <p><strong><?php echo !empty($wl->created_at) ? date('d/m/Y H:i:s', intval($wl->created_at) + 7*60*60) : "" ?></strong> </p>
                        <p>By: <a><?php echo !empty($wl->created_by) ? $wl->created_by : ''?></a> </p>
                        <!-- <p>To: <a>Smith Jane</a></p> -->

                      </div>
                      <div class="excerpt">
                        <p><?php echo !empty($wl->new->note) ? $wl->new->note : ''?></p>
                        <?php if(!empty($wl->action) && $wl->action =='approve'){ 
                            $old_status = $wl->old->status;
                            $new_status = $wl->new->status;
                          ?>
                        <p>
                        <?php
                          if($old_status == 0){
                              echo "Nháp";
                          }else if($old_status == 1){
                            echo "Mới";
                          }else if($old_status == 2) {
                            echo "Chờ trưởng PGD duyệt";
                          }else if($old_status == 3) {
                              echo "Đã hủy";
                          }else if($old_status == 4) {
                              echo "Trưởng PGD không duyệt";
                          }else if($old_status == 5) {
                              echo "Chờ hội sở duyệt";
                          }else if($old_status == 6) {
                              echo "Đã duyệt";
                          }else if($old_status == 7) {
                              echo "Kế toán không duyệt";
                          }else if($old_status == 15) {
                              echo "Chờ giải ngân";
                          }else if($old_status == 16) {
                              echo "Tạo lệnh giải ngân thành công";
                          }else if($old_status == 17) {
                              echo "Giải ngân thành công";
                          }else if($old_status == 18) {
                              echo "Giải ngân thất bại";
                          }
                          ?>
                            =>   
                            <?php
                          if($new_status == 0){
                              echo "Nháp";
                          }else if($new_status == 1){
                            echo "Mới";
                          }else if($new_status == 2) {
                            echo "Chờ trưởng PGD duyệt";
                          }else if($new_status == 3) {
                              echo "Đã hủy";
                          }else if($new_status == 4) {
                              echo "Trưởng PGD không duyệt";
                          }else if($new_status == 5) {
                              echo "Chờ hội sở duyệt";
                          }else if($new_status == 6) {
                              echo "Đã duyệt";
                          }else if($new_status == 7) {
                              echo "Kế toán không duyệt";
                          }else if($new_status == 15) {
                              echo "Chờ giải ngân";
                          }else if($new_status == 16) {
                              echo "Tạo lệnh giải ngân thành công";
                          }else if($new_status == 17) {
                              echo "Giải ngân thành công";
                          }else if($new_status == 18) {
                              echo "Giải ngân thất bại";
                          }
                          ?>
                        </p>
                        <?php }?>
                        <!-- <ul>
                          <li>Một nội dung nào đó</li>
                          <li><strong>Tiêu đề:</strong> ghi chú một điều gì đó</li>
                          <li>123123</li>
                        </ul> -->
                      </div>
                    </div>
                  </div>
                </li>
              <?php } }?>
            </ul>

        </div>
      </div>
    </div>