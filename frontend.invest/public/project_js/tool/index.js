$(document).ready(function () {
    function addCommas(str) {
        return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $('.amount_money').on('keyup', function (event) {
        var amount_money = $("input[name='amount_money']").val()
        $('.amount_money').val(addCommas(amount_money))
    })

    $('.calculator_interest').click(function (event) {
        event.preventDefault();
        var amount_money = $("input[name='amount_money']").val()
        var created_at = $("input[name='created_at']").val()
        var type_interest = $("select[name='type_interest']").val()
        var number_day_loan = $("select[name='number_day_loan']").val()
        var formData = new FormData();
        formData.append('amount_money', amount_money);
        formData.append('type_interest', type_interest)
        formData.append('number_day_loan', number_day_loan)
        formData.append('created_at', created_at)
        $.ajax({
            url: window.origin + '/tool/tool_calculator_interest',
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
                $("#calculator-data td").remove();
                $(".theloading").hide();
                if (data.status == 200) {
                    $.each(data.data, function (k, v) {
                        temp = "<tr style='text-align: center'><td>" + v.ky_tra + "</td><td>" + v.interest + "</td><td>" + v.goc_lai_1ky + "</td><td>" + v.tien_goc_1ky_phai_tra + "</td><td>" + v.tien_lai_1ky_phai_tra + "</td><td>" + v.ngay_ky_tra + "</td></tr>";
                        $("#calculator-data").append(temp);
                    });
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

        $('.clear_calculator_interest').click(function () {
            $("#calculator-data td").remove();
        })
    })

    $('.calculator_commission').click(function (event) {
        event.preventDefault();
        var amount_money = $("input[name='amount_money']").val()
        var created_at = $("input[name='created_at']").val()
        var number_day_loan = $("select[name='number_day_loan']").val()
        var formData = new FormData();
        formData.append('amount_money', amount_money);
        formData.append('number_day_loan', number_day_loan)
        formData.append('created_at', created_at)
        $.ajax({
            url: window.origin + '/tool/tool_calculator_commission',
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
                $("#calculator-data-commission td").remove();
                $(".theloading").hide();
                if (data.status == 200) {
                    $.each(data.data, function (k, v) {
                        temp = "<tr style='text-align: center'><td>" + v.ky + "</td><td>" + v.so_ngay + "</td><td>" + v.so_tien_tinh_hoa_hong_thuc_te + "</td><td>" + v.hoa_hong + "</td><td>" + v.ti_le + "</td><td>" + v.thang + "</td></tr>";
                        $("#calculator-data-commission").append(temp);
                    });
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

    $('.clear_calculator_commission').click(function () {
        $("#calculator-data-commission td").remove();
    })
})
