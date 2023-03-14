@extends('viewcpanel::layouts.master')
@section('css')
<link href="{{ asset('viewcpanel/css/report/report1.css') }}" rel="stylesheet"/>
<div class="create_report">
   <h2>Biên Bản Phạt </h2>
   <div class="new_report">
     <h4>Tạo mới biên bản phạt</h4>
     <div class="report_left">
            <h5>Thông tin lỗi vi phạm </h5>
            <div>
                <p>Nhóm lỗi vi phạm *</p>
                <select class="form-select" aria-label="Default select example">
                <option selected>Chọn nhóm lỗi vi phạm</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                </select>
            </div>
            <div>
                <p>Lỗi vi phạm *</p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nhập lỗi vi phạm" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div>
                <p>Hình thức kỷ luật *</p>
                <select class="form-select" aria-label="Default select example">
                <option selected>Chọn trạng thái </option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                </select>
            </div>
            <div>
                <p>Chế tài phạt </p>
                <select class="form-select" aria-label="Default select example">
                <option selected>Chế tài phạt </option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                </select>
            </div>
            <div>
                <p>Chọn ngày vi phạm *</p>
                <div class="input-group mb-3">
                    <input type="date" class="form-control" placeholder="Chọn ngày vi phạm" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div>
                <p>Mô Tả</p>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Viết mô tả" id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Comments</label>
                </div>
            </div>
            <div>
                <p>Ảnh mô tả vi phạm</p>
                <img src="..." class="img-thumbnail" alt="...">
            </div>
            <div>
                <button type="button" 
                class="btn btn-success"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                 Tạo biên bản mới 
                </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel">TẠO MỚI BIÊN BẢN</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="modal1">
                                    <h5> Thông tin biên bản </h5>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                       <p> Mã lỗi </p>
                                        </div>
                                        <div class="col col-lg-7">
                                         <input type="text">
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                       <p> Nhóm vi phạm</p>
                                        </div>
                                        <div class="col col-lg-7">
                                            <select ">
                                                <option selected>Tất cả</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                        <p>Chế tài phạt</p>
                                        </div>
                                        <div class="col col-lg-7">
                                         <input type="text">
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                       <p> Hình thức kỉ luật </p>
                                        </div>
                                        <div class="col col-lg-7">
                                            <select >
                                                <option selected>Tất cả</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                        <p>Trạng thái</p> 
                                        </div>
                                        <div class="col col-lg-7">
                                            <select >
                                                <option selected>new</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                      <p>  Tiến trình :</p>
                                        </div>
                                        <div class="col col-lg-7">
                                            <select >
                                                <option selected>Chờ xác nhận</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                       <p> Tên nhân viên</p> 
                                        </div>
                                        <div class="col col-lg-7">
                                         <input type="text">
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                       <p> Email nhân viên </p> 
                                        </div>
                                        <div class="col col-lg-7">
                                         <input type="text">
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                        <p>Ảnh vi phạm</p>
                                        </div>
                                        <div class="col col-lg-7">
                                        <input type="file"
                                        id="avatar" name="avatar"
                                        accept="image/png, image/jpeg">
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                        <p>Tên ảnh </p>
                                        </div>
                                        <div class="col col-lg-7">
                                         <input type="text">
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                        <p>Tên PGD:</p>
                                        </div>
                                        <div class="col col-lg-7">
                                         <input type="text">
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                        <p>Email Trường PGD:</p>
                                        </div>
                                        <div class="col col-lg-7">
                                         <input type="text">
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                        <p>Email Quản lý KV:</p>
                                        </div>
                                        <div class="col col-lg-7">
                                         <input type="text">
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="col col-lg-5">
                                       <p> Mô tả vi phạm</p>
                                        </div>
                                        <div class="col col-lg-7">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Viết mô tả" id="floatingTextarea2" >
                                            </textarea>
                                            <label for="floatingTextarea2">Comments</label>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Trở lại </button>
                                <button type="button" class="btn btn-primary">Tạo biên bản </button>
                            </div>
                            </div>
                        </div>
                    </div>

                <button type="button" 
                class="btn btn-success">Huỷ
                </button>
            </div>
     </div>
     <div class="report_right">
     <h5>Thông tin lỗi vi phạm </h5>
            <div>
                <p>Chọn phòng ban *</p>
                <select class="form-select" aria-label="Default select example">
                    <option selected >Chọn phòng ban</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div>
            <p>Trưởng phòng</p>
                <select class="form-select" aria-label="Default select example">
                <option selected>Chọn phòng ban</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                </select>
            </div>
            <div>
                <p>Nhân viên vi phạm *</p>
                <select class="form-select" aria-label="Default select example">
                <option selected>Tên nhân viên vi phạm</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                </select>
            </div>
            <div>
                <p>Email nhân viên *</p>
                <select class="form-select" aria-label="Default select example">
                <option selected>Tên nhân viên vi phạm </option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                </select>
            </div>
     </div>
   </div>
</div>