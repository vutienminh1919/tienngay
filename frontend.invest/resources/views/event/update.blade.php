@extends('layout.master')
@section('page_name','Cập nhật event')
@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Cấu hình</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('event.list')}}"
                                                                   class="text-success">Danh sách event</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href=""
                                                                   class="text-info">Cập nhật event</a></li>
            </ol>
        </div>
    </div>
    @include('layout.alert_success')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="border-radius: 10px">
                        <div class="card-body">
                            {{-- Head --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h1 class="d-inline-block">Cập nhật event</h1>
                                    {{-- Search --}}
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            {{-- Table --}}
                            <div class="row flex justify-content-center">
                                <div class="col-xs-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <input type="hidden" value="{{$data['id']}}" name="id">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label text-bold">Tên event :<span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control event" type="text"
                                                           placeholder="Nhập Tên event"
                                                           name="event" value="{{$data['event'] ?? ''}}">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label text-bold">Tiêu đề :<span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control title" type="text"
                                                           placeholder="Nhập tiêu đề"
                                                           name="title" value="{{$data['title'] ?? ''}}">
                                                </div>
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label text-bold">Nội dung rút gọn :<span
                                                            class="text-danger">*</span></label>
                                                    <textarea class="form-control short_description" type="text"
                                                              placeholder="Nhập tiêu đề" id="short_description"
                                                              name="short_description">{{$data['short_description'] ?? ''}}</textarea>
                                                </div>
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label text-bold">Nội dung đầy đủ :<span
                                                            class="text-danger">*</span></label>
                                                    <textarea class="form-control long_description ckeditor" type="text"
                                                              placeholder="Nhập tiêu đề" id="long_description"
                                                              name="long_description">{!! $data['long_description'] ?? '' !!}</textarea>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label text-bold">Nhắc lại :<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control repeat" type="text"
                                                            name="repeat">
                                                        <option value="">Chọn nhắc lại</option>
                                                        @foreach(event_repeat() as $er => $r)
                                                            <option
                                                                value="{{$er}}" {{ $data['repeat'] == $er ? 'selected' : '' }}>{{$r}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-4 div-month"
                                                     style="display: {{ $data['repeat'] == '3' ? 'inline' : 'none' }}">
                                                    <label class="form-label text-bold">Chọn số lần trong tháng:<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control month" type="text"
                                                            name="month">
                                                        <option value="">Chọn số lần trong tháng</option>
                                                        @foreach(event_month() as $em => $m)
                                                            <option
                                                                value="{{$em}}" {{ $data['month'] == $em ? 'selected' : '' }}>{{$m}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-4 div-day"
                                                     style="display: {{ $data['repeat'] == '2' ? 'inline' : 'none' }}">
                                                    <label class="form-label text-bold">Chọn ngày trong tuần:<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control day" type="text"
                                                            name="day">
                                                        <option value="">Chọn ngày trong tuần</option>
                                                        @foreach(event_day() as $ed => $d)
                                                            <option
                                                                value="{{$ed}}" {{ $data['day'] == $ed ? 'selected' : '' }}>
                                                                {{$d}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-4 div-date"
                                                     style="display: {{ $data['repeat'] == '4' ? 'inline' : 'none' }}">
                                                    <label class="form-label text-bold">Chọn ngày :<span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control date" type="date"
                                                           placeholder="YYYY-mm-dd"
                                                           name="date" value="{{$data['event_day']}}">
                                                </div>
                                                <div class="mb-3 col-md-4 div-hour">
                                                    <label class="form-label text-bold">Chọn khung giờ :<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control hour" type="text"
                                                            name="hour">
                                                        <option value="">Chọn khung giờ</option>
                                                        @foreach(event_hour() as $eh => $h)
                                                            <option
                                                                value="{{$eh}}" {{ $data['hour'] == $eh ? 'selected' : '' }}>
                                                                {{$h}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label text-bold">Chọn đối tượng :<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control object" type="text"
                                                            name="object">
                                                        <option value="">Chọn đối tượng</option>
                                                        @foreach(event_object() as $eo => $o)
                                                            <option
                                                                value="{{$eo}}" {{ $data['object'] == $eo ? 'selected' : '' }}>
                                                                {{$o}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label text-bold">Ảnh thông báo :<span
                                                            class="text-danger">*</span></label>
                                                    <div class="img_anh_chan_dung">
                                                        <span class="loading_img_anh_chan_dung" style="display: none">
							                                <i class="fa fa-cog  fa-spin fa-3x fa-fw"></i>
                                                        </span>
                                                        <label for="input_img_per">
                                                            <img id="img_anh_chan_dung"
                                                                 src="{{ !empty($data['image']) ? $data['image'] : asset('images/default.jpg') }}"
                                                                 style="width: 312px;height: 200px" alt="">
                                                            <input type="file" id="input_img_per"
                                                                   data-preview="imgInp001"
                                                                   style="visibility: hidden;"
                                                                   name="anh_chan_dung">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="float-right">
                                                <button class="btn btn-primary btn-update-event">Cập nhật</button>
                                                <a href="{{route('event.list')}}" class="btn btn-secondary">Quay lại</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('project_js/event/index.js')}}"></script>
@endsection
