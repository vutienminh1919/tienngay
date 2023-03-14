$(document).ready(function () {
    $('select[name="city"]').selectize({
        create: false,
        valueField: 'code',
        labelField: 'name',
        searchField: 'name',
        maxItems: 1,
        sortField: {
            field: 'name',
            direction: 'asc'
        }
    });

    $('select[name="status"]').selectize({
        create: false,
        valueField: 'code',
        labelField: 'name',
        searchField: 'name',
        maxItems: 1,
        sortField: {
            field: 'name',
            direction: 'asc'
        }
    });

    $('select[name="note"]').selectize({
        create: false,
        valueField: 'code',
        labelField: 'name',
        searchField: 'name',
        maxItems: 1,
        sortField: {
            field: 'name',
            direction: 'asc'
        }
    });

    $('select[name="job"]').selectize({
        create: false,
        valueField: 'code',
        labelField: 'name',
        searchField: 'name',
        maxItems: 1,
        sortField: {
            field: 'name',
            direction: 'asc'
        }
    });

    const anh_chan_dung_mac_dinh = window.origin + '/images/anhchandung.png';
    const anh_cmt_mat_truoc_mac_dinh = window.origin + '/images/anhcmttruoc.png';
    const anh_cmt_mat_sau_mac_dinh = window.origin + '/images/anhcmtsau.png';
    $('.btn_call_investor').click(function () {
        let id = $(this).attr('data-id')
        defaultValues();
        $.ajax({
            url: window.origin + '/investor/call_detail/' + id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                console.log('success')
                $("input[name='id']").val(id)
                $("input[name='phone_number']").val(data.data.number_phonenet)
                $("input[name='phone_investor']").val(data.data.hide_phone_number)
                $("input[name='phone_vimo']").val(data.data.hide_phone_vimo)
                $("input[name='code']").val(data.data.hide_code)
                $("#img_anh_chan_dung").attr("src", !data.data.avatar ? anh_chan_dung_mac_dinh : data.data.avatar);
                $("#img_cmt_mat_truoc").attr("src", !data.data.front_facing_card ? anh_cmt_mat_truoc_mac_dinh : data.data.front_facing_card);
                $("#img_cmt_mat_sau").attr("src", !data.data.card_back ? anh_cmt_mat_sau_mac_dinh : data.data.card_back);
                $("input[name='fullname']").val(data.data.name)
                $("input[name='email_investor']").val(data.data.email)
                $("input[name='birthday']").val(data.data.birthday)
                $("input[name='cmt']").val(data.data.identity)
                $("input[name='address']").val(data.data.address)
                check_drop_box(data.data.call.status, 'status', '- Chọn trạng thái -')
                $('select[name="status"]').data('selectize').setValue(data.data.call.status);
                check_drop_box(data.data.city, 'city', '- Chọn khu vực -')
                $('select[name="city"]').data('selectize').setValue(data.data.city);
                check_drop_box(data.data.job, 'job', '- Chọn nghề nghiệp -')
                $('select[name="job"]').data('selectize').setValue(data.data.job);
                check_drop_box(data.data.call.note, 'note', '- Chọn lý do hủy -')
                $('select[name="note"]').data('selectize').setValue(data.data.call.note);
                if (data.data.call.status !== 13) {
                    $('.ly_do_huy').hide()
                } else {
                    $('.ly_do_huy').show()
                }
                $("textarea[name='call_note']").val(data.data.call.call_note)
            },
            error: function () {
                alert('error')
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            }
        })
    })

    $('.btn_call_update_investor').click(function () {
        let id = $("input[name='id']").val()
        let name = $("input[name='fullname']").val()
        let email = $("input[name='email_investor']").val()
        let birthday = $("input[name='birthday']").val()
        let identity = $("input[name='cmt']").val()
        let address = $("input[name='address']").val()
        let city = $("select[name='city']").val()
        let job = $("select[name='job']").val()
        let status = $("select[name='status']").val()
        let note = $("select[name='note']").val()
        let call_note = $("textarea[name='call_note']").val()
        let avatar = $('.img_anh_chan_dung img').attr('src');
        let front_facing_card = $('.img_cmt_mat_truoc img').attr('src');
        let card_back = $('.img_cmt_mat_sau img').attr('src');
        let formData = new FormData();
        if (avatar == anh_chan_dung_mac_dinh) {
            avatar = '';
        }
        if (front_facing_card == anh_cmt_mat_truoc_mac_dinh) {
            front_facing_card = '';
        }
        if (card_back == anh_cmt_mat_sau_mac_dinh) {
            card_back = '';
        }
        formData.append('id', id);
        formData.append('name', name);
        formData.append('email', email);
        formData.append('identity', identity);
        formData.append('avatar', avatar);
        formData.append('front_facing_card', front_facing_card);
        formData.append('card_back', card_back);
        formData.append('birthday', birthday);
        formData.append('city', city);
        formData.append('status', status);
        formData.append('note', note);
        formData.append('call_note', call_note);
        formData.append('job', job);
        formData.append('address', address);
        $.ajax({
            url: window.origin + '/investor/call_update_investor',
            type: "POST",
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".theloading").show();
            },
            success: function (data) {
                $(".theloading").hide();
                if (data.status == 200) {
                    $('#modal-success').modal('show')
                    $('.text_message_success').text(data.message)
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text(data.message)
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                }
            },
            error: function () {
                $(".theloading").hide();
                alert('error')
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            }
        })
    })

    $('#input_img_per').change(function (event) {
        event.preventDefault();
        let files = $(this)[0].files;
        let formData = new FormData();
        formData.append('image', files[0]);
        $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: window.origin + '/upload_img',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData: false,
            beforeSend: function () {
                $(".loading_img_anh_chan_dung").show();
            },
            success: function (data) {
                if (data.data.code == 200) {
                    if (data.data.path === "") {
                        $(".loading_img_anh_chan_dung").hide();
                        $('#input_img_per').val('');
                        alert('Upload không thành công!');
                    } else {
                        $(".loading_img_anh_chan_dung").hide();
                        $("#img_anh_chan_dung").attr("src", data.data.path);
                        $(".preview img").show(); // Display image element
                    }
                } else {
                    $(".loading_img_anh_chan_dung").hide();
                    $('#input_img_per').val('');
                    alert('Upload không thành công!');
                }
            },
            error: function (error) {
                $(".loading_img_anh_chan_dung").hide();
                $('#input_img_per').val('');
                alert('Upload không thành công!');
            }
        });
    });

    $('#input_cmt_front').change(function (event) {
        event.preventDefault();
        let files = $(this)[0].files;
        let formData = new FormData();
        formData.append('image', files[0]);
        $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: window.origin + '/upload_img',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData: false,
            beforeSend: function () {
                $(".loading_img_cmt_mat_truoc").show();
            },
            success: function (data) {
                if (data.data.code == 200) {
                    if (data.data.path === "") {
                        $(".loading_img_cmt_mat_truoc").hide();
                        $('#input_cmt_front').val('');
                        alert('Upload không thành công!');
                    } else {
                        $(".loading_img_cmt_mat_truoc").hide();
                        $("#img_cmt_mat_truoc").attr("src", data.data.path);
                        $(".preview img").show(); // Display image element
                    }
                } else {
                    $(".loading_img_cmt_mat_truoc").hide();
                    $('#input_cmt_front').val('');
                    alert('Upload không thành công!');
                }
            },
            error: function (error) {
                $(".loading_img_cmt_mat_truoc").hide();
                $('#input_cmt_front').val('');
                alert('Upload không thành công!');
            }
        });
    });

    $('#input_cmt_behint').change(function (event) {
        event.preventDefault();
        let files = $(this)[0].files;
        let formData = new FormData();
        formData.append('image', files[0]);
        $.ajax({
            dataType: 'json',
            enctype: 'multipart/form-data',
            url: window.origin + '/upload_img',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData: false,
            beforeSend: function () {
                $(".loading_img_cmt_mat_sau").show();
            },
            success: function (data) {
                if (data.data.code == 200) {
                    if (data.data.path === "") {
                        $(".loading_img_cmt_mat_sau").hide();
                        $('#input_cmt_behint').val('');
                        alert('Upload không thành công!');
                    } else {
                        $(".loading_img_cmt_mat_sau").hide();
                        $("#img_cmt_mat_sau").attr("src", data.data.path);
                        $(".preview img").show(); // Display image element
                    }
                } else {
                    $(".loading_img_cmt_mat_sau").hide();
                    $('#input_cmt_behint').val('');
                    alert('Upload không thành công!');
                }
            },
            error: function (error) {
                $(".loading_img_cmt_mat_sau").hide();
                $('#input_cmt_behint').val('');
                alert('Upload không thành công!');
            }
        });
    });

    function check_drop_box(check = null, type, text) {
        remove_old_data('.no_' + type);
        if (check != null && check != 0) {
            $('[name="' + type + '"]').val(check);
        } else {
            $('[name="' + type + '"]').append('<option value="" class="no_' + type + '" selected>-- ' + text + ' --</option>');
        }
    }

    function remove_old_data(oid) {
        $(oid).remove();
    }

    function check_selectize(check = null, type, t) {
        $('#' + type).data('selectize').setValue(check);
    }

    $('#status_call').change(function () {
        let status = $(this).val()
        if (status == 13) {
            $('.ly_do_huy').show()
        } else {
            check_drop_box('', 'note', '- Chọn lý do hủy -')
            $('select[name="note"]').data('selectize').setValue('');
            $('.ly_do_huy').hide()
        }
    })

    $('.btn_call_lead').click(function () {
        let id = $(this).attr('data-id')
        $.ajax({
            url: window.origin + '/investor/call_lead_detail/' + id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                console.log('success')
                $("input[name='id']").val('')
                $("input[name='phone_number']").val('')
                $("input[name='phone_investor']").val('')
                $("input[name='phone_vimo']").val('')
                $("input[name='fullname']").val('')
                $("input[name='email_investor']").val('')
                $("input[name='birthday']").val('')
                $("input[name='cmt']").val('')
                $("textarea[name='call_note']").val('')
                $("input[name='id']").val(id)
                $("input[name='phone_number']").val(data.data.number_phonenet)
                $("input[name='phone_investor']").val(data.data.hide_phone_number)
                $("input[name='phone_vimo']").val(data.data.hide_phone_vimo)
                $("input[name='fullname']").val(data.data.name)
                $("input[name='email_investor']").val(data.data.email)
                $("input[name='birthday']").val(data.data.birthday)
                $("input[name='cmt']").val(data.data.identity)
                check_drop_box(data.data.call.status, 'status', '- Chọn trạng thái -')
                $('select[name="status"]').data('selectize').setValue(data.data.call.status);
                check_drop_box(data.data.city, 'city', '- Chọn khu vực -')
                $('select[name="city"]').data('selectize').setValue(data.data.city);
                check_drop_box(data.data.call.note, 'note', '- Chọn lý do hủy -')
                $('select[name="note"]').data('selectize').setValue(data.data.call.note);
                if (data.data.call.status !== 13) {
                    $('.ly_do_huy').hide()
                } else {
                    $('.ly_do_huy').show()
                }
                $("textarea[name='call_note']").val(data.data.call.call_note)
            },
            error: function () {
                alert('error')
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            }
        })
    })

    $('.btn_call_update_lead').click(function () {
        let id = $("input[name='id']").val()
        let name = $("input[name='fullname']").val()
        let email = $("input[name='email_investor']").val()
        let birthday = $("input[name='birthday']").val()
        let identity = $("input[name='cmt']").val()
        let city = $("select[name='city']").val()
        let status = $("select[name='status']").val()
        let note = $("select[name='note']").val()
        let call_note = $("textarea[name='call_note']").val()
        let formData = new FormData();
        formData.append('id', id);
        formData.append('name', name);
        formData.append('email', email);
        formData.append('identity', identity);
        formData.append('birthday', birthday);
        formData.append('city', city);
        formData.append('status', status);
        formData.append('note', note);
        formData.append('call_note', call_note);
        $.ajax({
            url: window.origin + '/investor/call_update_lead',
            type: "POST",
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".theloading").show();
            },
            success: function (data) {
                $(".theloading").hide();
                if (data.status == 200) {
                    $('#modal-success').modal('show')
                    $('.text_message_success').text(data.message)
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text(data.message)
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                }
            },
            error: function () {
                $(".theloading").hide();
                alert('error')
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            }
        })
    })

    $('.history_lead_call').click(function () {
        let id = $(this).attr('data-id')
        $.ajax({
            url: window.origin + '/investor/history_call_lead/' + id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                $('.title_ten_nha_dau_tu').empty('');
                $('#lich_su_cap_nhat').empty('');
                $('.title_ten_nha_dau_tu').text(data.data.name);
                if (data.data.lich_su.length > 0) {
                    $.each(data.data.lich_su, function (k, v) {
                        html = "<tr style='text-align: center'><td>" + ++k + "</td><td>" + v.status + "</td><td>" + v.note + "</td><td>" + v.call_note + "</td><td>" + v.created_at + "</td><td>" + v.created_by + "</td></tr>";
                        $("#lich_su_cap_nhat").append(html);
                    })
                } else {
                    $("#lich_su_cap_nhat").append("<tr style='text-align: center'><td class='text-danger' colspan='10'>" + "Không có dữ liệu" + "</td></tr>");
                }
            },
            error: function () {
                alert('error')
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            }
        })
    })

    $('.history_call_ndt').click(function () {
        let id = $(this).attr('data-id')
        $.ajax({
            url: window.origin + '/investor/history_call_investor/' + id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                console.log('success')
                $('.title_ten_nha_dau_tu').empty('');
                $('#lich_su_cap_nhat').empty('');
                $('.title_ten_nha_dau_tu').text(data.data.name == "" ? "" : data.data.name);
                if (data.data.lich_su.length > 0) {
                    $.each(data.data.lich_su, function (k, v) {
                        html = "<tr style='text-align: center'><td>" + ++k + "</td><td>" + v.status + "</td><td>" + v.note + "</td><td>" + v.call_note + "</td><td>" + v.created_at + "</td><td>" + v.created_by + "</td></tr>";
                        $("#lich_su_cap_nhat").append(html);
                    })
                } else {
                    $("#lich_su_cap_nhat").append("<tr style='text-align: center'><td class='text-danger' colspan='10'>" + "Không có dữ liệu" + "</td></tr>");
                }
            },
            error: function () {
                alert('error')
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            }
        })
    })

    $('.change-call').change(function () {
        let id_lead = $(this).attr('data-id')
        let user_call_id = $("select[name='user_call_" + id_lead + "']").val()
        let type = $(this).attr('data-type')
        $.ajax({
            url: window.origin + '/investor/change_call?id_lead=' + id_lead + '&user_call_id=' + user_call_id + '&type=' + type,
            type: "GET",
            dataType: 'json',
            success: function (result) {
                console.log(result)
                if (result.status == 200) {
                    toastr.success(result.message)
                } else {
                    toastr.error(result.message)
                }
            },
            error: function () {
                alert('error')
            }
        })
    })

    $('.status_call').change(function () {
        let status_call = $(this).val()
        if (status_call == 13) {
            $('.note_delete').show()
        } else {
            $('.note_delete').hide()
        }
    })

    function defaultValues() {
        let defaultValues = {
            'input': '',
            'select': '',
            'textarea': ''
        };
        Object.keys(defaultValues).forEach(function (tag) {
            $('.' + tag).each(function () {
                $(this).val(defaultValues[tag]);
            });
        });
    }
})
