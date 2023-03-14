<style>
    .content-cart h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: rgba(103, 103, 103, 1);
    }

    .container-cart {
        display: flex;
        gap: 16px;
    }

    .cart-input {
        width: 307.4px;
        padding-left: 8px;
        height: 108px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .cart-input p {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        display: flex;
        align-items: center;
    }

    .cart-input input {
        width: 291px;
        height: 35px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        padding: 16px;
    }

    .cart-item {
        padding: 10px;
        max-width: 240px;
        padding-left: 8px;
        background: #FFFFFF;
        border: 1px solid #D8D8D8;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
        margin-bottom: 10px;
        margin-right: 50px;
    }

    .cart-item label {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #676767;
    }

    .cart-item h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #1D9752;
    }

    .cart-item h6 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        color: #C70404;
    }
    label.top-size {
        font-size: 16px;
        font-weight: 600;
        color: #676767;
        width: 60%;
    }
    label.sum-size {
        font-size: 16px;
        font-weight: 600;
        color: #1D9752;
        text-align: right;
        width: 35%;
    }
</style>

<div class="content-cart" style="margin-top: 25px;">

    <div class="container-cart form-group row" style="margin-left: 0px;">
        <div class="form-group row col-sm">
            <label class="title-top">Đang có</label>
                <div class="cart-item">
                    <label>Áo khoác </label>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">S</label>
                            <label <?= (!empty($detail['detail']['coat']['s']) && $detail['detail']['coat']['s'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['coat']['s'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XL</label>
                            <label <?= (!empty($detail['detail']['coat']['xl']) && $detail['detail']['coat']['xl'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['coat']['xl'] ?? 0}}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">M</label>
                            <label <?= (!empty($detail['detail']['coat']['m']) && $detail['detail']['coat']['m'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['coat']['m'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XXL</label>
                            <label <?= (!empty($detail['detail']['coat']['xxl']) && $detail['detail']['coat']['xxl'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['coat']['xxl'] ?? 0}}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">L</label>
                            <label <?= (!empty($detail['detail']['coat']['l']) && $detail['detail']['coat']['l'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['coat']['l'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XXXL</label>
                            <label <?= (!empty($detail['detail']['coat']['xxxl']) && $detail['detail']['coat']['xxxl'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['coat']['xxxl'] ?? 0}}</label>
                        </div>
                    </div>
                </div>
                <div class="cart-item">
                    <label>Áo phông </label>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">S</label>
                            <label <?= (!empty($detail['detail']['shirt']['s']) && $detail['detail']['shirt']['s'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['shirt']['s'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XL</label>
                            <label <?= (!empty($detail['detail']['shirt']['xl']) && $detail['detail']['shirt']['xl'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['shirt']['xl'] ?? 0}}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">M</label>
                            <label <?= (!empty($detail['detail']['shirt']['m']) && $detail['detail']['shirt']['m'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['shirt']['m'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XXL</label>
                            <label <?= (!empty($detail['detail']['shirt']['xxl']) && $detail['detail']['shirt']['xxl'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['shirt']['xxl'] ?? 0}}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">L</label>
                            <label <?= (!empty($detail['detail']['shirt']['l']) && $detail['detail']['shirt']['l'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['shirt']['l'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XXXL</label>
                            <label <?= (!empty($detail['detail']['shirt']['xxxl']) && $detail['detail']['shirt']['xxxl'] > 4) ? "" : 'style="color: red !important"' ?> class="inline-block sum-size">{{$detail['detail']['shirt']['xxxl'] ?? 0}}</label>
                        </div>
                    </div>
                </div>
        </div>

        <div class="form-group row form-group col-sm">
            <label class="title-top">Đã cấp phát</label>
                <div class="cart-item">
                    <label>Áo khoác </label>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">S</label>
                            <label class="inline-block sum-size">{{$detailExport['coat']['s'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XL</label>
                            <label class="inline-block sum-size">{{$detailExport['coat']['xl'] ?? 0}}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">M</label>
                            <label class="inline-block sum-size">{{$detailExport['coat']['m'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XXL</label>
                            <label class="inline-block sum-size">{{$detailExport['coat']['xxl'] ?? 0}}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">L</label>
                            <label class="inline-block sum-size">{{$detailExport['coat']['l'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XXXL</label>
                            <label class="inline-block sum-size">{{$detailExport['coat']['xxxl'] ?? 0}}</label>
                        </div>
                    </div>
                </div>
                <div class="cart-item">
                    <label>Áo phông </label>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">S</label>
                            <label class="inline-block sum-size">{{$detailExport['shirt']['s'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XL</label>
                            <label class="inline-block sum-size">{{$detailExport['shirt']['xl'] ?? 0}}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">M</label>
                            <label class="inline-block sum-size">{{$detailExport['shirt']['m'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XXL</label>
                            <label class="inline-block sum-size">{{$detailExport['shirt']['xxl'] ?? 0}}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm ">
                            <label class="inline-block top-size">L</label>
                            <label class="inline-block sum-size">{{$detailExport['shirt']['l'] ?? 0}}</label>
                        </div>
                        <div class="col-sm ">
                            <label class="inline-block top-size">XXXL</label>
                            <label class="inline-block sum-size">{{$detailExport['shirt']['xxxl'] ?? 0}}</label>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
