<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />

<div class="right_col" role="main">
    <div class="container container-xt">
        <div class="wrapper-top">
            <div class="container-top">
                <h3>Quản lý thiết vị định vị</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
            <div class="containerTop-btn">
                <a href="xnt_local">
                    <button type="button" class="btn btn-success btn-top">Xuất nhập tồn <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/xnt.svg") ?>" alt=""></button>
                </a>
                <a href="xnt_tax">
                    <button type="button" class="btn btn-success btn-top">Danh sách kho <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/dsk.svg") ?>" alt=""></button>
                </a>


            </div>

        </div>
        <div class="container-cart">
            <h6>Công ty Cổ Phần Công Nghệ Tài Chính Việt</h6>
            <div class=" content">
                <div class=" content-cart">
                    <p>Tổng thiết bị </p>
                    <h5>100</h5>
                    <h6>11.234.256.000<span>vnđ</span></h6>
                </div>
                <div class=" content-cart">
                    <p>Đang hoạt động</p>
                    <h5>56</h5>
                    <h6>11.234.256.000<span>vnđ</span></h6>
                </div>

                <div class=" content-cart">
                    <p>Tồn kho mới</p>
                    <h5>12</h5>
                    <h6>11.234.256.000<span>vnđ</span></h6>
                </div>
                <div class=" content-cart">
                    <p>Tồn kho cũ</p>
                    <h5>12</h5>
                    <h6>11.234.256.000<span>vnđ</span></h6>
                </div>
                <div class=" content-cart">
                    <p>Chưa thu hồi </p>
                    <h5>44</h5>
                    <h6>11.234.256.000<span>vnđ</span></h6>
                </div>
                <div class=" content-cart">
                    <p>Hỏng - đổi trả</p>
                    <h5>3</h5>
                    <h6>11.234.256.000<span>vnđ</span></h6>
                </div>
                <div class=" content-cart">
                    <p>Chi phí sử dụng</p>
                    <h5>3</h5>
                    <h6>11.234.256.000<span>vnđ</span></h6>
                </div>
            </div>
        </div>
        <div class="container-form">
            <div class="form-content">
                <div class="form-text">
                    <h5>Lịch sử thiết bị</h5>
                </div>
                <div class="form-button">
                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal">Tìm kiếm <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/search.svg") ?>" alt=""></button>
                    <button type="button" class="btn btn-outline-success">Xuất excel <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/excel.svg") ?>" alt=""></button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel">Tìm kiếm</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-item">
                                        <p>Thời gian </p>
                                        <div class="modal-content11">
                                            <input placeholder="Từ ngày" class="textbox-n" type="text" onfocus="(this.type='date')" id="date">
                                            <input placeholder="Đến ngày" class="textbox-n" type="text" onfocus="(this.type='date')" id="date">
                                        </div>
                                    </div>
                                    <div class="modal-item">
                                        <p>Mã seri </p>
                                        <input type="text" placeholder="Nhập seri">
                                    </div>
                                    <div class="modal-item">
                                        <p>Số hợp đồng</p>
                                        <input type="text" placeholder="Nhập số hợp đồng">
                                    </div>
                                    <div class="modal-item">
                                        <p>Biển số xe </p>
                                        <input type="text" placeholder="Nhập biển số xe">
                                    </div>
                                    <div class="modal-item">
                                        <p>Giá trị thiết bị </p>
                                        <div class="modal-content11">
                                            <input placeholder="Từ " type="number">
                                            <input placeholder="Đến" type="number">
                                        </div>
                                    </div>
                                    <div class="modal-item">
                                        <p>Trạng thái </p>
                                        <select required>
                                            <option value="" disabled selected hidden>Chọn trạng thái</option>
                                            <option value="0">Open when powered (most valves do this)</option>
                                            <option value="1">Closed when powered, auto-opens when power is cut</option>
                                        </select>
                                    </div>
                                    <div class="modal-item">
                                        <p>Tên khách hàng </p>
                                        <input type="text" placeholder="Nhập tên khách hàng">
                                    </div>
                                    <div class="modal-item">
                                        <p>Phòng giao dịch</p>
                                        <select required>
                                            <option value="" disabled selected hidden>Chọn PGD</option>
                                            <option value="0">Nhà cung cấp 1</option>
                                            <option value="1">Nhà cung cấp 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-table table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Ngày biến động</th>
                            <th scope="col">Mã Seri</th>
                            <th scope="col">Giá trị thiết bị</th>
                            <th scope="col">Chi phí sử dụng</th>
                            <th scope="col">Số HĐ đang SD</th>
                            <th scope="col">Biển số xe</th>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Phòng giao dịch</th>
                            <th scope="col">Tình trạng</th>
                            <th scope="col">Ảnh đính kèm</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-line">
                        <tr>
                            <td scope="row">1</td>
                            <td>28/04/2022</td>
                            <td> <a href="cttb">000001178 </a></td>
                            <td>400000</td>
                            <td>320890</td>
                            <td><a href="">HĐCC/ĐKXM/TPHN310PTT/2204/26</a> </td>
                            <td>60F3-65828</td>
                            <td>NGUYỄN VĂN HÙNG</td>
                            <td>434 Lê Đức Thọ</td>
                            <td>Đang sử dụng</td>
                            <td><a data-fancybox="gallery" href="https://lipsum.app/id/60/1600x1200">
                                    Xem ảnh
                                </a>
                                <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/eys.svg") ?>" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">1</td>
                            <td>28/04/2022</td>
                            <td> <a href="cttb">000001178 </a></td>
                            <td>400000</td>
                            <td>320890</td>
                            <td><a href="">HĐCC/ĐKXM/TPHN310PTT/2204/26</a> </td>
                            <td>60F3-65828</td>
                            <td>NGUYỄN VĂN HÙNG</td>
                            <td>434 Lê Đức Thọ</td>
                            <td>Đang sử dụng</td>
                            <td><a data-fancybox="gallery" href="https://lipsum.app/id/60/1600x1200">
                                    Xem ảnh
                                </a>
                                <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/eys.svg") ?>" alt="">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
</div>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .breadcrumb {
        margin: 0px;
        padding: 0px;
    }

    .container-xt {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 24px;

    }

    .btn-top {
        padding: 8px 16px;
        gap: 8px;
        width: 169px;
        /* height: 40px; */
        background: #1D9752;
    }

    .wrapper-top {
        display: flex;
        justify-content: space-between;
    }

    .container-top h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .container-cart {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 24px
    }

    .container-cart h6 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #676767;
    }

    .content {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .content p {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #676767;
    }

    .content h5 {
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #1D9752;

    }

    .content h6 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #C70404;
    }

    .content span {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #C70404;
        padding-left: 5px;
    }

    .content-cart {
        width: 215px;
        height: 108px;
        padding-top: 16px;
        padding-left: 16px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
    }

    .content-cart-notify {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        gap: 8px;
        width: 307.4px;
        height: 64px;
        background: linear-gradient(0deg, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.4)), #F4CDCD;
        border: 1px solid #D8D8D8;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 4px;
    }

    .content-cart-notify p {
        margin: 0;
    }

    .content-cart-notify h5 {
        color: #3B3B3B;
    }

    .tbody-line {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: rgba(103, 103, 103, 1);
    }

    .tbody-line tr td {
        text-align: center;
    }

    /* ------------------- */
    .container-form {
        width: 100%;
        height: 592px;
        background: #FFFFFF;
        border: 1px solid #EBEBEB;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
    }

    .form-content {
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 20px 16px;
    }

    .form-text h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .thead-light {
        background-color: #E8F4ED;
    }

    .thead-light {
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;

    }

    .thead-light tr th {
        text-align: center;
    }

    /* ------modal-------- */
    .modal-body {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .modal-header h4 {
        text-align: center;
    }

    .modal-item input {
        padding: 16px;
        gap: 8px;
        width: 100%;
        height: 30px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
    }

    .modal-item select {
        gap: 8px;
        width: 100%;
        height: 35px;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
    }

    .modal-content11 {
        display: flex;
        gap: 24px;
    }

    .footer-select select {
        width: 250px;
        height: 30px;
        border: none;
    }

    /* -------footer--------- */
    @media only screen and (max-width: 1440px) {
        .content p {
            font-size: 12px;
        }
    }
</style>