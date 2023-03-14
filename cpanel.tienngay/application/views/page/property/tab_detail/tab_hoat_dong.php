<div class="col-xs-12 p-0">
      <div class="x_panel">
        <div class="x_title">

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <ul class="list-unstyled timeline workflow widget">
            <?php if (!empty($history)) {
              foreach ($history as $key => $wl) {

                ?>
                <li>
                  <img class="theavatar"
                     src="<?php echo base_url("assets/imgs/avatar_none.png") ?>"
                     alt="">
                  <div class="block">
                    <div class="block_content">
                      <h2 class="title">
                        <a><?= !empty($wl->type) ? log_action($wl->type) : ""; ?></a>
                      </h2>
                      <div class="byline">
                        <p>
                          <strong><?php echo !empty($wl->created_at) ? date('d/m/Y H:i:s', $wl->created_at) : "" ?></strong>
                        </p>
                        <p>By:
                          <a><?php echo !empty($wl->created_by) ? $wl->created_by : '' ?></a>
                        </p>
                      </div>
                      <div class="excerpt">
                        <p><?php echo (!empty($wl->note) && $wl->type == 'noted') ? $wl->note : '' ?></p>
                        <p><?php echo (!empty($wl->comment) && $wl->type == 'comment') ? $wl->comment : '' ?></p>
                      </div>
                    </div>
                  </div>
                </li>
                <?php
              }
            } ?>
          </ul>
        </div>
      </div>
    </div>