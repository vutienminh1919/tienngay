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
                <a href="xnt_khotax"><button type="button" class="btn btn-success btn-top btn-item">Xuất nhập tồn <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/xnt.svg") ?>" alt=""></button></a>
                <a href="cptb"><button type="button" class="btn btn-success btn-top">Lịch sử thiết bị <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/time.svg") ?>" alt=""></button></a>
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
                    <h5>Danh sách các kho</h5>
                </div>
                <div class="form-button">
                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal">
                        Tìm kiếm <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/search.svg") ?>" alt="">
                    </button>
                    <button type="button" class="btn btn-outline-success">Xuất excel <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/excel.svg") ?>" alt=""></button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tìm kiếm</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-item">
                                        <p>Phòng giao dịch</p>
                                        <select required>
                                            <option value="" disabled selected hidden>Chọn phòng giao dịch</option>
                                            <option value="0 ">Phòng giao dịch 1</option>
                                            <option value="1">Phòng giao dịch 2</option>
                                        </select>
                                    </div>
                                    <div class="modal-item">
                                        <p>Thời gian </p>
                                        <div class="modal-content11">
                                            <input placeholder="Từ ngày" class="textbox-n" type="text" onfocus="(this.type='date')" id="date">
                                            <input placeholder="Đến ngày" class="textbox-n" type="text" onfocus="(this.type='date')" id="date">
                                        </div>
                                    </div>
                                    <div class="modal-item">
                                        <p>Tổng số lượng </p>
                                        <div class="modal-content11">
                                            <input placeholder="Từ " type="number">
                                            <input placeholder="Đến " type="number">
                                        </div>
                                    </div>
                                    <div class="modal-item">
                                        <p>Đang hoạt động</p>
                                        <div class="modal-content11">
                                            <input placeholder="Từ " type="number">
                                            <input placeholder="Đến " type="number">
                                        </div>
                                    </div>
                                    <div class="modal-item">
                                        <p>Tồn kho</p>
                                        <div class="modal-content11">
                                            <input placeholder="Từ " type="number">
                                            <input placeholder="Đến " type="number">
                                        </div>
                                    </div>
                                    <div class="modal-item">
                                        <p>Chưa thu hồi</p>
                                        <div class="modal-content11">
                                            <input placeholder="Từ " type="number">
                                            <input placeholder="Đến " type="number">
                                        </div>
                                    </div>
                                    <div class="modal-item">
                                        <p>Hỏng đổi trả</p>
                                        <div class="modal-content11">
                                            <input placeholder="Từ " type="number">
                                            <input placeholder="Đến " type="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- -------- -->
                </div>
            </div>
            <div class="form-table table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" rowspan="2">STT</th>
                            <th scope="col" rowspan="2">Tên kho - Tên PGD</th>
                            <th scope="col" rowspan="2">Tổng số lượng</th>
                            <th scope="col" rowspan="2">Đang hoạt động</th>
                            <th scope="col" colspan="2">Tồn kho</th>
                            <th scope="col" rowspan="2">Chưa thu hồi</th>
                            <th scope="col" rowspan="2">Hỏng đổi trả</th>
                            <th scope="col" rowspan="2">Chi phí đổi trả</th>
                            <th scope="col" rowspan="2">Chi tiết</th>
                        </tr>
                        <tr>
                            <th scope="col">Mới</th>
                            <th scope="col">Cũ</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-line">
                        <tr>
                            <td scope="row">1</td>
                            <td>26 Vạn phúc</td>
                            <td> 96 </td>
                            <td>12</td>
                            <td>32</td>
                            <td>32</td>
                            <td>3</td>
                            <td>3</td>
                            <td>12.000</td>
                            <td>
                                <a href="xnt_pgd">Xem chi tiết <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/eys.svg") ?>" alt=""></a>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">1</td>
                            <td>26 Vạn phúc</td>
                            <td> 96 </td>
                            <td>12</td>
                            <td>32</td>
                            <td>32</td>
                            <td>3</td>
                            <td>3</td>
                            <td>12.000</td>
                            <td>
                                <a href="xnt_pgd">Xem chi tiết <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/eys.svg") ?>" alt=""></a>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">1</td>
                            <td>26 Vạn phúc</td>
                            <td> 96 </td>
                            <td>12</td>
                            <td>32</td>
                            <td>32</td>
                            <td>3</td>
                            <td>3</td>
                            <td>12.000</td>
                            <td>
                                <a href="xnt_pgd">Xem chi tiết <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/eys.svg") ?>" alt=""></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="container-footer">
            <div class="footer-icon">
                <h3>Chọn nhà cung cấp </h3>
                <div class="btn-group">
                    <div class="btn btn-secondary btn-lg dropdown-toggle btn-select" type="button" data-toggle="dropdown" aria-expanded="false">
                        <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/dropdow.svg") ?>" alt="">
                    </div>
                    <div class="dropdown-menu dropdown1">
                        <a class="dropdown-item" href="#">Nhà cung cấp thành nam</a>
                        <a class="dropdown-item" href="#">Nhà cung cấp VSC</a>
                    </div>
                </div>
            </div>

            <!-- ----------- -->
            <div class="footer-content">
                <div class="footer-cart">
                    <p>Tổng thiết bị</p>
                    <h5>40.000</h5>
                    <h6>12.000.000</h6>
                </div>
                <div class="footer-cart">
                    <p>Tổng thiết bị</p>
                    <h5>40.000</h5>
                    <h6>12.000.000</h6>
                </div>
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

    .btn-item {
        display: flex;
        align-items: center;
    }

    .containerTop-btn {
        display: flex;
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
        height: 40px;
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
        color: rgba(103, 103, 103, 1);
    }

    .content {
        display: flex;
        gap: 20px;
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
    .footer-content {
        display: flex;
        gap: 16px;
        margin-top: 3%;
    }

    .footer-cart {
        padding: 16px;
        gap: 24px;
        width: 253.5px;
        height: 108px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
    }

    .footer-cart p {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: rgba(103, 103, 103, 1);
    }

    .footer-cart h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #1D9752;
    }

    .footer-cart h6 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #C70404;
    }

    /* ----dropdows---- */
    .btn-select {
        padding: 0px;
    }

    .dropdown1 {
        width: 200px;
        padding: 16px;
    }

    .dropdown-menu a {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        padding-top: 16px;
    }

    .dropdown-menu a:hover {
        color: #E18080;
    }

    .footer-icon {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .footer-icon h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #676767;
    }
</style>