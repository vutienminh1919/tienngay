$(document).ready(function () {
    $('#click_edit_ndt').click(function () {
        $('#name_ndt').prop('disabled', false)
        $('#email_ndt').prop('disabled', false)
        $('#edit_ndt').show()
        $('#click_edit_ndt').hide()
    })

    $('#edit_ndt').click(function () {
        var name = $("input[name='name_ndt']").val()
        var email = $("input[name='email_ndt']").val()
        var id = $("input[name='id_ndt']").val()
        var formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('id', id);
        if (confirm("Bạn có chắc chắn cập nhật?")) {
            $.ajax({
                url: window.origin + '/investor/update',
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
                        }, 1000);
                    }
                },
                error: function () {
                    $(".theloading").hide();
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text("Cập nhật thất bại")
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            });
        }
    })

    $('.them_phu_luc').click(function () {
        let id = $(this).attr('data-id')
        let name = $(this).attr('data-name')
        $('#id_investor').empty('');
        $('#name_investor').empty('');
        $('.code_contract').val('');
        $('.interest').val('');
        $('.ngay_dau_tu').val('');
        $('.amount_money').val('');
        $('.date_pay').val('');

        $('#name_investor').val(name);
        $('#id_investor').val(id);
    })

    $('.btn_tao_phu_luc_ndt_uq').click(function (event) {
        event.preventDefault();
        var id_investor = $("input[name='id_investor']").val()
        var code_contract = $("input[name='code_contract']").val()
        var interest = $("input[name='interest']").val()
        var ngay_dau_tu = $("input[name='ngay_dau_tu']").val()
        var amount_money = $("input[name='amount_money']").val()
        var hinh_thuc_thanh_toan = $("input[name='hinh_thuc_thanh_toan']:checked").val()
        var chu_ki_thanh_toan = $("input[name='chu_ki_thanh_toan']:checked").val()
        var hinh_thuc_tinh_lai = $("input[name='hinh_thuc_tinh_lai']:checked").val()
        var hinh_thuc_tra_lai = $("select[name='hinh_thuc_tra_lai']").val()
        var thoi_gian_dau_tu = $("select[name='thoi_gian_dau_tu']").val()
        var date_pay = $("input[name='date_pay']").val()
        var formData = new FormData();
        formData.append('id_investor', id_investor);
        formData.append('code_contract', code_contract)
        formData.append('interest', interest)
        formData.append('ngay_dau_tu', ngay_dau_tu)
        formData.append('amount_money', amount_money)
        formData.append('hinh_thuc_thanh_toan', hinh_thuc_thanh_toan)
        formData.append('chu_ki_thanh_toan', chu_ki_thanh_toan)
        formData.append('hinh_thuc_tinh_lai', hinh_thuc_tinh_lai)
        formData.append('hinh_thuc_tra_lai', hinh_thuc_tra_lai)
        formData.append('thoi_gian_dau_tu', thoi_gian_dau_tu)
        formData.append('date_pay', date_pay)
        $.ajax({
            url: window.origin + '/investor/them_phu_luc_ndt_uy_quyen',
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
                        window.location.href = window.origin + '/investor/detail/' + id_investor;
                    }, 1000);
                } else {
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text(data.message)
                }
            },
            error: function () {
                $(".theloading").hide();
                $('.text_message_fail').text('error')
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            }
        })
    })

    function addCommas(str) {
        return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $('.amount_money').on('keyup', function (event) {
        var amount_money = $("input[name='amount_money']").val()
        $('.amount_money').val(addCommas(amount_money))
    })

    $('#hinh_thuc_uyquyen').on('change', function () {
        var hinh_thuc_tra_lai = $("select[name='hinh_thuc_tra_lai']").val()
        if (hinh_thuc_tra_lai == 4) {
            $('.chon-ngay-tra').hide()
        } else if (hinh_thuc_tra_lai == 2) {
            $('.chon-ngay-tra').show()
        } else {
            $('.chon-ngay-tra').hide()
        }
    })
})

