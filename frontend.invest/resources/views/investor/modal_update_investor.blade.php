<div class="modal modal-blur fade" id="modal_call_ndt_new" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CHI TIẾT XÁC NHẬN NHÀ ĐẦU TƯ</h5>
                @if(in_array(\App\Service\ActionInterface::CALL_INVESTOR, $action_global) || $is_admin == 1)
                    <div class="float-right d-inline-block text-right mt-2 mb-2">
                        <button id="call" class="btn btn-success" style="margin-right: 15px;"><i
                                class="fas fa-phone-alt"></i>&nbsp;
                        </button>
                        <button id="end" class="btn btn-danger"><i class="fas fa-phone-slash"></i>&nbsp;
                        </button>
                        <input id="number" name="phone_number" type="hidden" value=""/>
                        <p id="status" style="margin: 5px 0;"></p>
                        <div class="alert alert-danger alert-dismissible text-center" style="display:none"
                             id="div_error1">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <span class='div_error'></span>
                        </div>
                        <div class="alert alert-success alert-dismissible text-center" style="display:none"
                             id="div_success1">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <span class='div_success'></span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <input type="hidden" class="form-control"
                               autocomplete="off" name="id">
                        <label class="form-label">Số điện thoại</label>
                        <div class="input-group input-group-flat">
                            <input type="text" class="form-control text-danger" id="phone_investor"
                                   autocomplete="off" disabled name="phone_investor">
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label class="form-label">Số điện thoại liên kết VIMO</label>
                        <div class="input-group input-group-flat">

                            <input type="text" class="form-control text-danger" id="phone_vimo"
                                   autocomplete="off"
                                   disabled name="phone_vimo">
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label class="form-label">Mã nhà đầu tư</label>
                        <div class="input-group input-group-flat">

                            <input type="text" class="form-control text-danger" id="investor_code"
                                   autocomplete="off" disabled name="code">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <div class="img_anh_chan_dung">
                                <span class="loading_img_anh_chan_dung" style="display: none">
							<i class="fa fa-cog  fa-spin fa-3x fa-fw"></i>
								</span>
                            <label for="input_img_per">
                                <img id="img_anh_chan_dung" src="{{ asset('images/anhchandung.png') }}"
                                     style="width: 312px;height: 200px" alt="">
                                <input type="file" id="input_img_per" data-preview="imgInp001"
                                       style="visibility: hidden;" name="anh_chan_dung"></label>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="img_cmt_mat_truoc">
                                <span class="loading_img_cmt_mat_truoc" style="display: none">
							<i class="fa fa-cog  fa-spin fa-3x fa-fw"></i>
								</span>
                            <label for="input_cmt_front">
                                <img id="img_cmt_mat_truoc" src="{{ asset('images/anhcmttruoc.png') }}"
                                     style="width: 312px;height: 200px" alt="">
                                <input type="file" id="input_cmt_front" data-preview="imgInp001"
                                       style="visibility: hidden;" name="cmt_mat_truoc"></label>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="img_cmt_mat_sau">
                                 <span class="loading_img_cmt_mat_sau" style="display: none">
							<i class="fa fa-cog  fa-spin fa-3x fa-fw"></i>
								</span>
                            <label for="input_cmt_behint">
                                <img id="img_cmt_mat_sau" src="{{ asset('images/anhcmtsau.png') }}"
                                     style="width: 312px;height: 200px" alt="">
                                <input type="file" id="input_cmt_behint" data-preview="imgInp001"
                                       style="visibility: hidden;" name="cmt_mat_sau"></label>
                        </div>

                    </div>
                </div>
                <div class="row paddding">
                    <div class="col-md-12 mb-3">
                        <label class="title">THÔNG TIN NHÀ ĐẦU TƯ
                        </label>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="group">
                                    <label class="form-label">Họ và tên<span class="text-danger">*</span></label>
                                    <input type="text" name="fullname" id="fullname" class="form-control"
                                           placeholder="Họ và tên" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group">
                                    <label class="form-label">Email<span class="text-danger">*</span></label>

                                    <input type="email" name="email_investor" id="fullEmail" class="form-control"
                                           placeholder="Email" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group">
                                    <label class="form-label">Ngày tháng năm sinh</label>
                                    <input type="date" name="birthday" id="fulldate" class="form-control"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group">
                                    <label class="form-label">Số CMT/CCCD</label>

                                    <input type="number" name="cmt" id="fullCMT" class="form-control"
                                           placeholder="Số CMT/CCCD từ 9 đến 12 kí tự" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group">
                                    <label class="form-label">Nghề nghiệp</label>
                                    <select id="" class="form-control job" name="job">
                                        <option value="">- Chọn nghề nghiệp -</option>
                                        @foreach(status_job() as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group">
                                    <label class="form-label">Khu vực</label>
                                    <select id="" class="form-control city" name="city">
                                        <option value="">- Chọn khu vực -</option>
                                        @foreach(get_province_name_by_code() as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group">
                                    <label class="form-label">Địa chỉ</label>

                                    <input type="text" name="address" id="address" class="form-control"
                                           placeholder="Nhập địa chỉ" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group">
                                    <label class="form-label">Trạng thái Call</label>
                                    <select id="status_call" class="form-control status" name="status">
                                        <option value="">- Chọn trạng thái -</option>
                                        @foreach(lead_status() as $key => $value)
                                            @continue($key == 14)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 ly_do_huy" style="display: none">
                                <div class="group">
                                    <label class="form-label">Lý do hủy<span class="text-danger">*</span></label>
                                    <select id="" class="form-control note" name="note">
                                        <option value="">- Chọn lý do hủy -</option>
                                        @foreach(note_delete() as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group">
                                    <label class="form-label">Ghi chú</label>
                                    <textarea class="form-control call_note" name="call_note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="float-right">
                    <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    @if(in_array(\App\Service\ActionInterface::CALL_UPDATE_INVESTOR, $action_global) || $is_admin == 1)
                        <a href="#" class="btn btn-primary btn_call_update_investor" data-bs-dismiss="modal">
                            Lưu thông tin
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
