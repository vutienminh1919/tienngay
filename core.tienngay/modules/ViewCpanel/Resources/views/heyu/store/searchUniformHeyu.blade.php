@extends('viewcpanel::layouts.master')

@section('title', 'Tra cứu thông tin kho đồng phục Heyu')

@section('css')
    <style type="text/css">

        /* Style the Image Used to Trigger the Modal */
        .img {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .img:hover {
            opacity: 0.7;
        }

        .modal-backdrop {
            display: none !important;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
        }

        /* Modal Content (Image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image (Image Text) - Same Width as the Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation - Zoom in the Modal */
        .modal-content, #caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }
            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }

        .box {
            display: inline-block;
            width: 55px;
            height: 55px;
            background-color: white;
            border: 3px dashed #B5B5B5;
            color: #B5B5B5;
            font-size: 30px;
            text-align: center;
        }

        .block {
            position: relative;
            display: inline-block;
            vertical-align: top;
            width: 75px;
            height: 75px;
            padding: 9px;
            margin-right: 15px;
            margin-bottom: 35px;
            background-color: #fff;
            border: 1px solid #ccc;
            margin-top: 15px;
            margin-right: 10px;
        }

        .cancelButton {
            -moz-appearance: none;
            -webkit-appearance: none;
            position: absolute;
            top: -3px;
            right: 3px;
            color: #000;
            text-align: center;
            font-weight: 700;
            background-color: transparent;
            padding: 0;
            margin: 0;
            border: 0;
            font-size: 16px;
            right: -8px;
            top: -8px;
            line-height: 15px;
            border-radius: 100%;
            background-color: #fff
        }

        .block img, video {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            max-height: 100%;
        }

        .theloading {
            position: fixed;
            z-index: 999;
            display: block;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, .7);
            top: 0;
            right: 0;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center
        }

        #overlay {
            position: absolute;
            width: 30px;
            height: 30px;
            top: 2px;
            z-index: 3;
            left: 32px;
        }
    </style>
@endsection

<div id="loading" class="theloading" style="display: none;">
    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
</div>
<h3 class="tilte_top_tabs">
    Tra cứu thông tin kho đồng phục Heyu
</h3>
<div class="row">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="col-md-6 col-sm-6">
        <select class="form-control select" style="width: 100%px" name="" id="select">
            <option value="">--Chọn PGD--</option>
            @foreach($pgd_active as $value)
                <option value="{{$value->id}}">{{$value->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 col-sm-3">
        {{--        <button type="submit" class="btn btn-success searchHeyu">Tra cứu</button>--}}
        <a type="button" href="{{url('/cpanel/heyu')}}" class="btn btn-danger">Quay lại</a>
    </div>
    <div class="col-md-3 col-sm-3">
        <div class="detailTotal">
{{--            <label>Total helmet:&nbsp;</label><span class="text-danger"></span>{{$dataTotal['totalHelmet']}}<br>--}}
            <label>Tổng áo khoác:&nbsp;</label><span class="text-danger">{{$dataTotal['totalCoat']}}</span><br>
            <label>Tổng áo phông:&nbsp;</label><span class="text-danger">{{$dataTotal['totalShirt']}}</span><br>
        </div>
        <div class="detailTotal1">

        </div>
    </div>


</div>


<div class="detail">
    <table class="table table-bordered" style="margin-bottom: 100px">
        <thead>
        <tr style="text-align: center">
            <th class="text-success" scope="col" rowspan="2"
                style="text-align: center;vertical-align: middle; min-width: 200px;">PGD
            </th>
            <th class="text-success" scope="col" colspan="7" style="text-align: center; min-width: 200px;">ÁO KHOÁC</th>
            <th class="text-success" scope="col" colspan="7" style="text-align: center; min-width: 200px;">ÁO PHÔNG</th>
        </tr>
        <tr>
            <th class="text-success" style="text-align: center">S</th>
            <th class="text-success" style="text-align: center">M</th>
            <th class="text-success" style="text-align: center">L</th>
            <th class="text-success" style="text-align: center">XL</th>
            <th class="text-success" style="text-align: center">XXL</th>
            <th class="text-success" style="text-align: center">XXXL</th>
            <th style="text-align: center" class="text-danger" >TOTAL</th>
            <th class="text-success" style="text-align: center">S</th>
            <th class="text-success" style="text-align: center">M</th>
            <th class="text-success" style="text-align: center">L</th>
            <th class="text-success" style="text-align: center">XL</th>
            <th class="text-success" style="text-align: center">XXL</th>
            <th class="text-success" style="text-align: center">XXXL</th>
            <th style="text-align: center" class="text-danger">TOTAL</th>
        </tr>
        </thead>
        <tbody class="body">

            @foreach($dataDetailByid as $value)
                <tr>
                    <td style="text-align: center" scope="row">{{$value['name']}}</td>
                    <td style="text-align: center">{{$value['detail']['coat']['s']}}</td>
                    <td style="text-align: center">{{$value['detail']['coat']['m']}}</td>
                    <td style="text-align: center">{{$value['detail']['coat']['l']}}</td>
                    <td style="text-align: center">{{$value['detail']['coat']['xl']}}</td>
                    <td style="text-align: center">{{$value['detail']['coat']['xxl']}}</td>
                    <td style="text-align: center">{{$value['detail']['coat']['xxxl']}}</td>
                    <td style="text-align: center" class="text-danger">{{$value['totalCoat']}}</td>
                    <td style="text-align: center">{{$value['detail']['shirt']['s']}}</td>
                    <td style="text-align: center">{{$value['detail']['shirt']['m']}}</td>
                    <td style="text-align: center">{{$value['detail']['shirt']['l']}}</td>
                    <td style="text-align: center">{{$value['detail']['shirt']['xl']}}</td>
                    <td style="text-align: center">{{$value['detail']['shirt']['xxl']}}</td>
                    <td style="text-align: center">{{$value['detail']['shirt']['xxxl']}}</td>
                    <td style="text-align: center" class="text-danger">{{$value['totalShirt']}}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>


@section('script')

    <script>
        $(document).ready(function () {
            function clearRemovedItemCacheSelectizePlugin() {
                const self = this;

                this.removeItem = (function () {
                    const original = self.removeItem;

                    return function (...args) {
                        original.apply(self, args);

                        const [value] = args;

                        if (self.renderCache && self.renderCache.item) {
                            delete self.renderCache.item[value];
                        }
                    };
                }());
            }
            Selectize.define('clear_removed_item_cache', clearRemovedItemCacheSelectizePlugin);
            $(function () {
                var select = $("#select").selectize({
                    maxItems: 1000,
                    persist: true,
                    closeAfterSelect: true,
                    plugins: ["remove_button", "clear_removed_item_cache"],
                });
            });

            // $('.searchHeyu').click(function (event) {
            $('.select').change(function (event) {
                event.preventDefault();

                let store_id = $('#select').val();
                let arr_id = "";
                if (store_id == "") {
                    $('.detailTotal').show();
                    $('.detailTotal1').hide()
                    arr_id = @json($pgd_id)
                } else {
                    $('.detailTotal').hide();
                    $('.detailTotal1').show()
                    arr_id = store_id
                }
                console.log(arr_id);
                let formData = new FormData();
                formData.append('store_id', arr_id);
                $.ajax({
                    enctype: 'multipart/form-data',
                    url: '{{$inventoryHeyu}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('.body').html("");
                        $(".theloading").show();
                    },
                    success: function (data) {
                        $('.detailTotal1').html('')
                        $(".theloading").hide();
                        console.log(data);
                        if (data.status == 200) {
                            console.log(data.data)
                            $.each(data.data.detailById, function (key, value) {
                                $('.body').append('<tr> <td style="text-align: center" scope="row">'+value.name+'</td> <td style="text-align: center">'+value.detail.coat.s+'</td> <td style="text-align: center">'+value.detail.coat.m+'</td><td style="text-align: center">'+value.detail.coat.l+'</td style="text-align: center"> <td>'+value.detail.coat.xl+'</td><td style="text-align: center">'+value.detail.coat.xxl+'</td> <td style="text-align: center">'+value.detail.coat.xxxl+'</td><td style="text-align: center" class="text-danger">'+value.totalCoat+'</td> <td>'+value.detail.shirt.s+'</td> <td style="text-align: center">'+value.detail.shirt.m+'</td> <td style="text-align: center">'+value.detail.shirt.l+'</td> <td style="text-align: center">'+value.detail.shirt.xl+'</td> <td style="text-align: center">'+value.detail.shirt.xxl+'</td> <td style="text-align: center">'+value.detail.shirt.xxxl+'</td> <td style="text-align: center" class="text-danger">'+value.totalShirt+'</td> </tr>')
                            });
                            $('.detailTotal1').append('<label>Tổng áo khoác:&nbsp;</label><span class="text-danger">'+data.data.totalCoat+'</span><br> <label>Tổng áo phông :&nbsp;</label><span class="text-danger">'+data.data.totalShirt+'</span><br>')
                        } else {
                            $('#errorModal').modal('show')
                            $('.msg_error').text(data.message)
                        }
                    },
                    error: function () {
                        $(".theloading").hide();
                        $('#modal-danger').modal('show')
                        $('.msg_error').text("error")
                    }
                });

            })

        });
    </script>
@endsection
