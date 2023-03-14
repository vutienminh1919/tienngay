@extends('layout.master')
@section('page_name','Tạo menu')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <ol class="breadcrumb" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="#">Bảng phân quyền</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Tạo menu</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <h1 class="d-inline-block mb-3">Tạo menu</h1>
                            <div class="hr mt-0 mb-0"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    {{-- Form --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <form method="post" action="{{ route('menu_update_post', $id) }}">
                                @csrf
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right">Tên menu <span
                                            class="text-danger">*</span></label>
                                    <div class="col-6">
                                        <input type="text"
                                               class="form-control {{ (isset($error['name']) || isset($error['slug'])) ? 'is-invalid' : '' }}"
                                               placeholder="Tên menu" name="name" value="{{ $data['name'] }}"
                                               autocomplete="off">
                                        @if( isset($error['name']) )
                                            <div class="invalid-feedback">{{ $error['name'][0] }}</div>
                                        @endif
                                        @if ( isset($error['slug']) )
                                            <div class="invalid-feedback">{{ $error['slug'][0] }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right">Đường dẫn</label>
                                    <div class="col-6">
                                        <input type="text" class="form-control" placeholder="Đường dẫn" name="url"
                                               value="{{ $data['url'] }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right">Chọn danh mục cha</label>
                                    <div class="col-6">
                                        <select type="text" name="parent" class="form-select"
                                                placeholder="Chọn danh mục cha" id="select-parent">
                                            <option value="">-- Chọn danh mục cha --</option>
                                            @foreach($parent as $parent_item)
                                                <option
                                                    value="{{ $parent_item['id'] }}" {{ ($data['parent'] == $parent_item['id']) ? 'selected' : '' }}>{{ $parent_item['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right">Chọn nhóm quyền</label>
                                    <div class="col-6">
                                        <select type="text" name="role[]" class="form-select"
                                                placeholder="Chọn nhóm quyền" id="select-role" multiple>
                                            @php($arr_role = Arr::pluck($data['role'], 'id'));
                                            @foreach($role as $role_item)
                                                <option
                                                    value="{{ $role_item['id'] }}" {{ in_array($role_item['id'] , $arr_role) ? 'selected' : '' }}>{{ $role_item['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label text-right"></label>
                                    <div class="col-6">
                                        @if(in_array(\App\Service\ActionInterface::CAP_NHAT_MENU, $action_global) || $is_admin == 1)
                                            <button type="submit" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="icon icon-tabler icon-tabler-device-floppy" width="24"
                                                     height="24" viewBox="0 0 24 24" stroke-width="2"
                                                     stroke="currentColor" fill="none" stroke-linecap="round"
                                                     stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M6 4h10l4 4v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2"></path>
                                                    <circle cx="12" cy="14" r="2"></circle>
                                                    <polyline points="14 4 14 8 8 8 8 4"></polyline>
                                                </svg>
                                                Lưu lại
                                            </button>
                                        @endif
                                        <a class="btn" href="{{ route('menu_list') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                                <line x1="5" y1="12" x2="11" y2="18"></line>
                                                <line x1="5" y1="12" x2="11" y2="6"></line>
                                            </svg>
                                            Quay lại
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var select = $('#select-role').selectize();
        // var select_parent = $('#select-parent').selectize();
    </script>
@endsection
