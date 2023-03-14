<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<div class="right_col" role="main">
    <div class="container container-xt">
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
        <div class="container-cart">
            <h6>Công ty Cổ Phần Công Nghệ Tài Chính Việt</h6>
            <div class="content">
                <div class="content-cart">
                    <p>Tổng thiết bị </p>
                    <h5>100</h5>
                </div>
                <div class="content-cart">
                    <p>Thiết bị đang hoạt động</p>
                    <h5>56</h5>
                </div>
                <div class="content-cart">
                    <p>Thiết bị chưa thu hồi </p>
                    <h5>44</h5>
                </div>
            </div>
            <div class="content">
                <a href="warning">
                    <div class="content-cart-notify">
                        <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/power.svg") ?>" alt="">
                        <p>Báo động cắt điện </p>
                        <h5>3</h5>
                    </div>
                </a>
                <a href="warning">
                    <div class="content-cart-notify">
                        <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/radio.svg") ?>" alt="">
                        <p>Báo động ngoài hàng rào</p>
                        <h5>16</h5>
                    </div>
                </a>
                <a href="warning">
                    <div class="content-cart-notify">
                        <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/rss.svg") ?>" alt="">
                        <p>Báo động ngoại tuyến </p>
                        <h5>4</h5>
                    </div>
                </a>
            </div>
        </div>
        <div class="container-form">
            <div class="form-content">
                <div class="form-text">
                    <h5>Danh sách thiết bị</h5>
                </div>
                <div class="form-button">
                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal">
                        Tìm kiếm
                        <img class="the-icon" src="<?php echo base_url("assets/imgs/ql_xnt/search.svg") ?>" alt="">
                    </button>
                    <button type="button" class="btn btn-outline-success">
                        Xuất excel
                        <img class="the-icon" src="<?php echo base_url("assets/imgs/ql_xnt/excel.svg") ?>" alt="">
                    </button>

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
                                        <p>Thiết bị hoạt động</p>
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
                                        <p>Thiết bị đang chờ</p>
                                        <div class="modal-content11">
                                            <input placeholder="Từ " type="number">
                                            <input placeholder="Đến " type="number">
                                        </div>
                                    </div>
                                    <div class="modal-item">
                                        <p>Chọn nhân viên</p>
                                        <select required>
                                            <option value="" disabled selected hidden>Chọn nhân viên</option>
                                            <option value="0">Phòng giao dịch 1</option>
                                            <option value="1">Phòng giao dịch 2</option>
                                        </select>
                                    </div>
                                    <div class="modal-item">
                                        <p>Số hợp đồng</p>
                                        <input type="text" placeholder="Nhập số hợp đồng">
                                    </div>
                                    <div class="modal-item">
                                        <p>Phòng giao dịch</p>
                                        <select required>
                                            <option value="" disabled selected hidden>Chọn phòng giao dịch</option>
                                            <option value="0">Phòng giao dịch 1</option>
                                            <option value="1">Phòng giao dịch 2</option>
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
                            <th scope="col">Nhân viên</th>
                            <th scope="col">Tổng số lượng</th>
                            <th scope="col">Thiết bị hoạt động</th>
                            <th scope="col">Thiết bị chưa thu hồi</th>
                            <th scope="col">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-line">
                        <tr>
                            <th scope="row">1</th>
                            <td>linhltt@tienngay.vn</td>
                            <td>50</td>
                            <td>14</td>
                            <td>4</td>
                            <td><a href="cvthn">Xem chi tiết <img class="theavatar" src="<?php echo base_url("assets/imgs/ql_xnt/eys.svg") ?>" alt=""></a></td>
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

    .content {
        display: flex;
        gap: 16px;
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

    .content-cart {
        width: 307.4px;
        height: 80px;
        padding-top: 16px;
        padding-left: 16px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
    }

    .container-cart h6 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
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

    .thead-light {
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
    }

    .tbody-line {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: rgba(103, 103, 103, 1);
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

    @media only screen and (max-width: 1440px) {
        .content p {
            font-size: 12px;
        }
    }
</style>