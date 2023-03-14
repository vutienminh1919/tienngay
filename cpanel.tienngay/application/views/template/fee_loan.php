<div class="right_col" role="main">
  <div class="col-xs-12">

  </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-3">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">From : </div>
                <input type="text" class="form-control" >
              </div>
            </div>
          </div>
          <div class="col-xs-3">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">To : </div>
                <input type="text" class="form-control" >
              </div>
            </div>
          </div>

          <div class="col-xs-12">
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Kỳ 1</a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Kỳ 2</a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Kỳ 3</a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Kỳ 4</a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Kỳ 5</a>
                </li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                  <div class="row">
                    <div class="col-xs-12 col-md-6" style="border-right: 1px solid #ccc;">

                      <h4>Cầm cố : </h4>

                      <?php for ($i=1; $i < 10 ; $i++) { ?>

                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-addon">Kỳ : <?php echo $i ?> </div>
                            <input type="text" class="form-control">
                          </div>
                        </div>

                      <?php } ?>


                    </div>
                    <div class="col-xs-12 col-md-6">

                      <h4>Đăng ký xe : </h4>

                      <?php for ($i=1; $i < 10 ; $i++) { ?>

                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-addon">Kỳ : <?php echo $i ?> </div>
                            <input type="text" class="form-control">
                          </div>
                        </div>

                      <?php } ?>

                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="home-tab">
                  123123123
                </div>
              </div>
            </div>


          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" >Lưu</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
$(window).on('load',function(){
  $('#myModal').modal('show');
});
</script>
