
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">
        <div class="title_left">
          <h3>Một List</h3>
        </div>
        <div class="title_right text-right">
          <form class="form-inline">
            <strong>Upload cái gì đó &nbsp;</strong>
            <div class="form-group">
              <input type="file" class="form-control" placeholder="sothing">
            </div>
            <button type="submit" class="btn btn-primary" style="margin:0">Upload</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">

        <div class="row">
          <div class="col-xs-12 col-lg-1">
            <h2>Dữ liệu</h2>
          </div>
          <div class="col-xs-12 col-lg-11">
            <div class="row">
              <div class="col-lg-4 text-right ">


              </div>
              <div class="col-lg-3">
                <input type="text" class="form-control" placeholder="somthing">
              </div>
              <div class="col-lg-3">
                <select class="form-control">
                  <option>Tất cả phòng giao dịch</option>
                  <option>Option one</option>
                  <option>Option two</option>
                  <option>Option three</option>
                  <option>Option four</option>
                </select>
              </div>

              <div class="col-lg-2 text-right">
                <button class="btn btn-primary w-100"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</button>

              </div>
            </div>

          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div class="col-xs-12">
            <div class="row">

            </div>
          </div>
          <div class="col-xs-12">

            <div class="table-responsive">
              <table id="datatable-buttons" class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Phòng giao dịch</th>
                    <th>Địa chỉ</th>
                    <th>Điện thoại</th>
                    <th>Vốn đầu tư</th>
                    <th>Ngày tạo</th>
                    <th>Tình trạng</th>
                    <th>Chức năng</th>
                  </tr>
                </thead>

                <tbody>
                  <!-- <tr>
                  <td colspan="13" class="text-center">Không có dữ liệu</td>
                </tr> -->
                <?php for ($i=1; $i < 100; $i++) { ?>
                  <tr>
                    <td><?php echo $i ?></td>
                    <td>demodemo</td>
                    <td>modemode</td>
                    <td>acb</td>
                    <td>1234</td>
                    <td>qwer</td>
                    <td>235</td>
                    <td>
                      <a href="#">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a href="#">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php } ?>

              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<!-- /page content -->
