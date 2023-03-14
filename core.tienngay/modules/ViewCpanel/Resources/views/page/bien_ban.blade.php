@extends('viewcpanel::layouts.master')
@section('css')
<link href="{{ asset('viewcpanel/css/report/report.css') }}" rel="stylesheet"/>


<div class="report">
  <h2>Biên bản phạt</h2>
  <div class="ds_report">
    <div class="report_header">
      <h5>Danh sách biên bản phạt</h5>
      <div>
        <button type="button" class="btn btn-success">Tạo mới biên bản phạt</button>
        <button type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#staticBackdrop" >Tìm kiếm</button>
          <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog ">
                  <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="staticBackdropLabel">Tìm kiếm</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <p>trạng thái biên bản </p>
                          <select class="form-select" aria-label="Default select example">
                              <option selected>Open this select menu</option>
                              <option value="1">One</option>
                              <option value="2">Two</option>
                              <option value="3">Three</option>
                          </select>
                          <p>Ngày tạo biên bản </p>
                          <div class="input-group mb-3">
                              <input type="date" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                          </div>
                          <div class="input-group mb-3">
                              <input type="date" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                          </div>
                          <p>Người tạo biên bản </p>
                          <select class="form-select" aria-label="Default select example">
                              <option selected>Open this select menu</option>
                              <option value="1">One</option>
                              <option value="2">Two</option>
                              <option value="3">Three</option>
                          </select>
                          <p>Nhóm lỗi vi phạm</p>
                          <select class="form-select" aria-label="Default select example">
                              <option selected>Open this select menu</option>
                              <option value="1">One</option>
                              <option value="2">Two</option>
                              <option value="3">Three</option>
                          </select>
                          <p>Nhân viên vi phạm</p>
                          <select class="form-select" aria-label="Default select example">
                              <option selected>Open this select menu</option>
                              <option value="1">One</option>
                              <option value="2">Two</option>
                              <option value="3">Three</option>
                          </select>

                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-success">Tìm kiếm </button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Huỷ</button>
                        </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">STT</th>
          <th scope="col">Chức năng</th>
          <th scope="col">Trạng thái</th>
          <th scope="col">Tiến trình</th>
          <th scope="col">Tên Nhân Viên </th>
          <th scope="col">Email</th>
          <th scope="col">Phòng Ban</th>
          <th scope="col">Nhóm vi phạm</th>
          <th scope="col">Lỗi Vi phạm</th>
          <th scope="col">Hình thức kỉ luât</th>
          <th scope="col">Chế tài phạt</th>
          <th scope="col">Ngày tạo </th>
          <th scope="col">Người tạo </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>
          <div class="btn-group">
            <button type="button" class="btn btn-success"
            data-bs-toggle="dropdown" aria-expanded="false">
              Chức năng
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </div>
          </td>
          <td class="text-primary text-info text-danger text-warning">Mới</td>
          <td>đã xong</td>
          <td>Hà Nguyễn Thu Anh</td>
          <td>anhhnt@tienngay.vn</td>
          <td>PGD 911 Giải Phóng </td>
          <td>@Vi phạm nội quy công ty</td>
          <td>Không mặc áo đồng phục</td>
          <td>Khiển trách</td>
          <td>@30% KPI </td>
          <td>12:00:00 12/04/2022</td>
          <td>LinhLtt@tienngay.vn</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>
          <div class="btn-group">
            <button type="button" class="btn btn-success"
            data-bs-toggle="dropdown" aria-expanded="false">
              Chức năng
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </div>
          </td>
          <td class="text-primary text-info text-danger text-warning">Đã Xác nhận </td>
          <td>đã xong</td>
          <td>Hà Nguyễn Thu Anh</td>
          <td>anhhnt@tienngay.vn</td>
          <td>PGD 911 Giải Phóng </td>
          <td>@Vi phạm nội quy công ty</td>
          <td>Không mặc áo đồng phục</td>
          <td>Khiển trách</td>
          <td>@30% KPI </td>
          <td>12:00:00 12/04/2022</td>
          <td>LinhLtt@tienngay.vn</td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td>
            <div class="btn-group">
            <button type="button" class="btn btn-success"
            data-bs-toggle="dropdown" aria-expanded="false">
              Chức năng
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </div>
            </td>
            <td class="text-primary text-info text-danger text-warning">Phản hồi </td>
            <td>đã xong</td>
            <td>Hà Nguyễn Thu Anh</td>
            <td>anhhnt@tienngay.vn</td>
            <td>PGD 911 Giải Phóng </td>
            <td>@Vi phạm nội quy công ty</td>
            <td>Không mặc áo đồng phục</td>
            <td>Khiển trách</td>
            <td>@30% KPI </td>
            <td>12:00:00 12/04/2022</td>
            <td>LinhLtt@tienngay.vn</td>
        </tr>       
        <tr>
            <th scope="row">3</th>
            <td>
              <div class="btn-group">
            <button type="button" class="btn btn-success"
            data-bs-toggle="dropdown" aria-expanded="false">
              Chức năng
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </div>
            </td>
            <td class="text-primary text-info text-danger text-warning">Phản hồi </td>
            <td>đã xong</td>
            <td>Hà Nguyễn Thu Anh</td>
            <td>anhhnt@tienngay.vn</td>
            <td>PGD 911 Giải Phóng </td>
            <td>@Vi phạm nội quy công ty</td>
            <td>Không mặc áo đồng phục</td>
            <td>Khiển trách</td>
            <td>@30% KPI </td>
            <td>12:00:00 12/04/2022</td>
            <td>LinhLtt@tienngay.vn</td>
        </tr>       
        <tr>
            <th scope="row">3</th>
            <td>
            <div class="btn-group">
            <button type="button" class="btn btn-success"
            data-bs-toggle="dropdown" aria-expanded="false">
              Chức năng
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </div>
            </td>
            <td class="text-primary text-info text-danger text-warning">Phản hồi </td>
            <td>đã xong</td>
            <td>Hà Nguyễn Thu Anh</td>
            <td>anhhnt@tienngay.vn</td>
            <td>PGD 911 Giải Phóng </td>
            <td>@Vi phạm nội quy công ty</td>
            <td>Không mặc áo đồng phục</td>
            <td>Khiển trách</td>
            <td>@30% KPI </td>
            <td>12:00:00 12/04/2022</td>
            <td>LinhLtt@tienngay.vn</td>
        </tr>       
      </tbody>
    </table>
    <div class="report_footer">
          <div class="row">
          <div class="col-md-8 report_footer1"><p>Hiển thị từ 1 đến 10 trong số 949 bản ghi</p></div>
          <div class="col-6 col-md-4 report_footer2">
            <!-- <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <li class="page-item">
                      <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item"><a class="page-link" href="#">6</a></li>
                    <li class="page-item"><a class="page-link" href="#">7</a></li>
                    <li class="page-item"><a class="page-link" href="#">8</a></li>
                    <li class="page-item">
                      <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
            </nav> -->
            <div class="pagination">
                  <a href="#">«</a>
                  <a href="#">1</a>
                  <a href="#">2</a>
                  <a href="#">3</a>
                  <a href="#">4</a>
                  <a href="#">5</a>
                  <a href="#">6</a>
                  <a href="#">»</a>
          </div>
          </div>
          </div>

    </div>
</div>
</div>