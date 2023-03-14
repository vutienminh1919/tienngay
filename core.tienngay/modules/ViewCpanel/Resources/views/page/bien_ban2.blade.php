@extends('viewcpanel::layouts.master')
@section('css')
@section('image')
<link href="{{ asset('viewcpanel/css/report/report2.css') }}" rel="stylesheet"/>

<div class="detail-report">
    <h2>Biên Bản Phạt</h2>
    <div class="detail">
          <div class="detail-text">
              <h5>Chi tiết biên bản phạt </h5>
              <div>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Chỉnh sửa</button>
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thông tin chi tiết của biên bản</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="row">
                        <div class="col-5">
                            <p>Mã Lỗi :</p> 
                        </div>
                        <div class="col-7">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Nhóm vi phạm :</p>
                        </div>
                        <div class="col-7">
                        <select class="form-select"   aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Chế tài phạt :</p>
                        </div>
                        <div class="col-7">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Hình thức kỉ luật :</p>
                        </div>
                        <div class="col-7">
                        <select class="form-select"   aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Trạng thái :</p>
                        </div>
                        <div class="col-7">
                        <select class="form-select"   aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Tên Nhân viên :</p>
                        </div>
                        <div class="col-7">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Email nhân viên :</p>
                        </div>
                        <div class="col-7">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Tên PGD :</p>
                        </div>
                        <div class="col-7">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Quản lý KV:</p>
                        </div>
                        <div class="col-7">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Ngày tạo :</p>
                        </div>
                        <div class="col-7">
                            <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Mô Tả vi phạm</p>
                        </div>
                        <div class="col-7">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Viết mô tả" id="floatingTextarea2" >
                                </textarea>
                                <label for="floatingTextarea2">Comments</label>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại</button>
                    </div>
                    </div>
                </div>
                </div>

              <button type="button" class="btn btn-primary">Huỷ biên bản </button>
              </div>
          </div>
          <div class="form-detail">
               <div class="form-detail-left">
                   <h5>Thông tin lỗi vi phạm</h5>
                   <div>
                       <p>Nhóm lỗi vi phạm*</p>
                        <select class="form-select"   aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                   </div>
                   <div>
                       <p>Lỗi vi phạm*</p>
                        <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                   </div>
                   <div>
                       <p>Hình thức kỉ luật*</p>
                        <select class="form-select"   aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                   </div>
                   <div>
                       <p>Chế tài phạt*</p>
                        <select class="form-select"   aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                   </div>
                   <div>
                       <p>Chọn ngày vi phạm*</p>
                       <div class="input-group mb-3">
                        <input type="date" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                   </div>
                   <div>
                       <p>Ngày lập*</p>
                       <div class="input-group mb-3">
                        <input type="date" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                   </div>
                   <div>
                       <p>Người lập *</p>
                       <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                   </div>
                   <div>
                       <p>Mô tả*</p>
                       <div class="form-floating">
                            <textarea class="form-control" id="floatingTextarea2" >
                            </textarea>
                        </div>
                   </div>
                   <div>
                       <p>Ảnh mô tả lỗi vi phạm</p>
                       <div >
                           <img src="https://upload.tienvui.vn/uploads/avatar/1652154110-3d8ccc8de9387e4a9c7f497b46b13171.PNG" alt="" style="width:282px; height:300px">
                       </div>
                   </div>
                   <div>
                   <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Xác nhận</button>
                   <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Xác nhận biên bản phạt </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Nếu bạn nhấn xác nhận biên bản phạt, bạn đã chấp nhận hình thức kỷ luật và chế tài phạt
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đồng ý </button>
                                <button type="button" class="btn btn-primary">Huỷ</button>
                            </div>
                            </div>
                        </div>
                        </div>
                   <button type="button" class="btn btn-warning"data-bs-toggle="modal" data-bs-target="#exampleModal1" data-bs-whatever="@mdo" >Gủi phản hồi</button>
                   <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Phản hồi biên bản </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Mô tả</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đồng ý </button>
                            <button type="button" class="btn btn-primary">Huỷ</button>
                        </div>
                        </div>
                    </div>
                    </div>
                   </div>
               </div>
               <div class="form-detail-right">
                  <h5>Thông tin nhân viên </h5>
                  <div>
                       <p>Chọn phòng ban*</p>
                        <select class="form-select"   aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                   </div>
                   <div>
                       <p>Trưởng phòng *</p>
                        <select class="form-select"   aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                   </div>
                   <div>
                       <p>Nhân viên vi phạm*</p>
                        <select class="form-select"   aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                   </div>
                   <div>
                       <p>Email nhân viên *</p>
                        <select class="form-select"   aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                   </div>
               </div>
          </div>
          <div class="form-detail1">
              <h5>Tiến trình xử lý </h5>
              <div>
                  <h6>Tạo biên bản </h6>
                  <p>12:00:00 12/04/2022</p>
                  <p>Tạo biên bản phạt</p>
              </div>
              <div class=boder1>

              </div>
              <div>
                  <h5>Phản hồi </h5>
                  <p>12:00:00 12/04/2022</p>
                  anhnth@tienngay.vn
              </div>
              <div>
                  <p>Nội dung phản hồi</p>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Viết mô tả" id="floatingTextarea2" >
                        </textarea>
                        <label for="floatingTextarea2">Nhân viên không có đồng phục</label>
                    </div>
              </div>
          </div>    
</div>