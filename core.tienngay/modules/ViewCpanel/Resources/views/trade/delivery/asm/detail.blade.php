@extends('viewcpanel::layouts.master')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet"/>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body{
        background-color: rgb(237, 237, 237);
    }

    .wrapper {
        width: 100%;
        padding: 0px 20px;
    }

    .header {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }

    .header-title h3 {
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
        color: #3B3B3B;
    }

    .header-title a {
        font-style: normal;
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        color: #676767;
        text-decoration: none;
    }

    .box-details {
        margin-top: 34px;
        display: flex;
        flex-direction: column;
        gap: 24px;;
        background-color: #FFFFFF;
        border-radius: 20px;
    }

    .box1-details,
    .box2-details,
    .box3-details {
        width: 100%;
        background: #FFFFFF;
        border: 1px solid #F0F0F0;
        border-radius: 8px;

    }

    .box1-details {
        padding: 24px 16px;
    }

    .box3-details {
        padding: 24px 16px;
    }

    .box2-details nav {
        display: flex;
        justify-content: flex-end;
        padding-right: 16px;
    }

    h5 {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 20px !important;
        color: #3B3B3B !important;
    }

    .form-ip p {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #3B3B3B;
    }

    .form-ip input {
        height: 40px;
        background: #E6E6E6;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        width: 100%;
        outline: none;
        padding-left: 5px;
        /* ----------- */
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;
    }
    .form-ip a {
        text-align:left;
    }

    .box2-details h5 {
        padding: 24px 16px;
    }

    th {
        border-bottom-width: 0px !important;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 30px;
        color: #262626;
        white-space: nowrap;
    }

    td {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 30px;
        color: #676767;
        white-space: nowrap;
    }

    .page-link {
        color: #3B3B3B !important;
    }

    .box3-details textarea {
        width: 100%;
        background: #E6E6E6;
        border: 1px solid #D8D8D8;
        border-radius: 5px;
        padding: 16px;
    }

    .box3-details textarea::placeholder {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 16px;
        color: #676767;

    }
    .is-animated {
        width:100%;
        height:1000px;
    }
    .modal-dialog {
        top: 10%;
    }
    p{
        margin-bottom: 5px;
    }

    .img{
        width:100% !important;
        height:500px !important;
    }

    .img img{
        width:100% !important;
        height:100% !important;
    }
</style>
@endsection
@section('content')
<section id="details_publications">
    <div class="wrapper">
        <div class="header">
            <div class="header-title">
                <h3>Chi tiết xuất ấn phẩm</h3>
                <small>
                    <a class="redirect" style="text-decoration:none;" href="{{route('viewcpanel::warehouse.pgdIndex')}}"><i class="fa fa-home"></i> Home</a> /
                    <a class="redirect" style="text-decoration:none;" href='{{route("viewcpanel::warehouse.detail",["id" => $detail->_id])}}'>Chi tiết xuất ấn phẩm</a>
                </small>
            </div>
            <a type="button" class="btn redirect" style="background: #D8D8D8; color: #676767; font-weight: 600;" href="{{route('viewcpanel::warehouse.pgdIndex')}}">Trở về <i class="fa fa-arrow-left" aria-hidden="true" style="color: #676767; margin-left: 5px;"></i></a>
        </div>
        <div class="box-details">
            <div class="box1-details">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <h5>Thông tin chung </h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="form-ip">
                            <p>Phòng giao dịch</p>
                            <input style="color:#676767;" disabled type="text" value="{{$detail['stores']['name']}}" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="form-ip">
                            <p>Ngày tạo</p>
                            <input style="color:#676767;" disabled type="text" value="{{date('Y-m-d H:i:s', $detail['created_at'])}}" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="form-ip">
                            <p>Chứng từ</p>
                            @if (count($detail['license']) == 0)
                            <input style="background-color:#F4CDCD; color:#C70404; border:solid #D8D8D8; font-weight: bold;" disabled type="text" value="Thiếu chứng từ"/>
                            @else
                            <a data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop"
                                style="height:40px;border:1px solid #D8D8D8;background-color:#E6E6E6; display:block; font-weight: 600;" href="" class="text-success btn btn lisence">Xem chứng từ</a>
                            @endif
                            <div id="imgInput" class="block">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box2-details">
                <h5>Danh sách ấn phẩm</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background: #E8F4ED;">
                            <tr>
                                <th style="text-align:center" scope="col">STT</th>
                                <th style="text-align:center" scope="col">Mã ấn phẩm</th>
                                <th style="text-align:center" scope="col">Hạng mục</th>
                                <th style="text-align:center" scope="col">Mục tiêu triển khai</th>
                                <th style="text-align:center" scope="col">Tên ấn phẩm</th>
                                <th style="text-align:center" scope="col">Loại ấn phẩm</th>
                                <th style="text-align:center" scope="col">Quy cách </th>
                                <th style="text-align:center" scope="col">Ảnh mô tả </th>
                                <th style="text-align:center" scope="col">Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($detail)
                                @foreach($detail['list'] as $key => $item)
                                <tr>
                                    <td style="text-align:center">{{++$key}}</td>
                                    <td style="text-align:center">{{$item['name']}}</td>
                                    <td style="text-align:center">{{$item['category']}}</td>
                                    <td style="text-align:center">{{$item['taget_goal']}}</td>
                                    <td style="text-align:center">{{$item['name_item']}}</td>
                                    <td style="text-align:center">{{$item['type']}}</td>
                                    <td style="text-align:center">{{str_replace(',' ,', ' , $item['specification'])}}</td>
                                    <td style="text-align:center">
                                        <a style="text-decoration:none; color:#4299E1;" href=""
                                        class="image" data-path={{json_encode($item['path'])}}>Ảnh mô tả</a>
                                    </td>
                                    <td style="text-align:center">{{$item['amount']}}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @if(!empty($paginate))
                    <nav aria-label="Page navigation" style="margin-top: 20px;">
                    {{ $paginate->withQueryString()->render('viewcpanel::trade.paginate') }}
                    </nav>
                @endif
            </div>
            <div class="box3-details">
                <h5>Ghi chú</h5>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <textarea placeholder="" disabled>{{$detail['note']}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalLisence" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Chứng từ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (count($detail['license']) > 0)
                    <img style="width: 100%; height: 500px;" src="{{$detail['license'][0]}}" alt="" class="underline cursor-pointer" data-fancybox-trigger="gallery">
                    <div style="display:none">
                        @foreach($detail['license'] as $license)
                            <a data-fancybox="gallery" href="{{$license}}"><img class="rounded" src="{{$license}}"></a>
                        @endforeach
                    </div>
                    <h5 style="position: absolute; top: 50%; left: 45%; color:white; font-weight: bold;" data-fancybox-trigger="gallery" class="underline cursor-pointer xt">+{{count($detail['license'])}}</h5>
                @else
                    Chưa có chứng từ
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="msg_error"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Ảnh sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body img">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</section>
@section('script')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    $(document).ready(function() {
        $("a.lisence").click(function() {
            $("#modalLisence").modal('show');
        });
        $("img").click(function() {
            $("#modalLisence").modal('hide');
            $("#modalImage").modal('hide');
        });
        $("a.image").click(function() {
            $("#modalImage").modal('show');
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".image").on('click', function(e) {
            $("#modalImage").find('.img').html('');
            e.preventDefault();
            let _el = $(e.target);
            let itemPath = JSON.parse($(_el).attr('data-path'));
            if (itemPath.length > 0) {
                let html = '<img style="width: 100%; height: 200px;" src="'+itemPath[0]+'" alt="" class="underline cursor-pointer" data-fancybox-trigger="gallery-modal">';
                html += '<div style="display:none">';
                for(let i = 0; i < itemPath.length; i++) {
                    html += '<a data-fancybox="gallery-modal" href="'+itemPath[i]+'"><img class="rounded" src="'+itemPath[i]+'"></a>';
                }
                    html += '</div>';
                    html += '<h5 style="position: absolute; top: 50%; left: 45%; color:white;" data-fancybox-trigger="gallery-modal" class="underline cursor-pointer xt">+'+itemPath.length+'</h5>';
                $("#modalImage").find('.img').html(html);
            } else {
                $("#modalImage").find('.img').html('<span>Không có ảnh</span>');
            }

            $("#modalImage").modal('show');
        })
        $(".img").click(function() {
            $("#modalImage").modal('hide');
        });
    })
</script>
<script type="text/javascript">
    const iframeMode = "<?= (!empty($_GET['iframe']) && $_GET['iframe'] == 1) ?>";
    console.log(iframeMode)
    const Redirect = (_url, _timeout) => {
        if (parseInt(iframeMode) != 1) {
            if (!_timeout) {
                window.location.href = _url;
                // window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
            } else {
                setTimeout(function(){window.location.href = _url}, _timeout);
                // setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
            }
        } else {
            _url = _url.replace(window.location.origin + '/', "");
            if (!_timeout) {
                // window.location.href = _url;
                window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");
            } else {
                // setTimeout(function(){window.location.href = _url}, _timeout);
                setTimeout(function () {window.parent.postMessage({targetLink: _url}, "{{$cpanelPath}}");}, _timeout);
            }
        }
    }
</script>
<script>
    $('.image').click(function (e) {
        e.preventDefault();
        document.body.scrollIntoView();
    })
    $('a.redirect').on('click', (e) => {
        e.preventDefault();
        let url = $(e.target).attr('href');
        Redirect(url, false);
    })
</script>
@endsection
