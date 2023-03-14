$(document).ready(function () {
    const LAI_HANG_THANG_GOC_CUOI_KY = 2;
    const GOC_LAI_CUOI_KY = 4;

    $('.cap_nhat_thanh_toan').click(function () {
        var id = $(this).attr('data-id')
        defaultValues();
        $.ajax({
            url: window.origin + '/pay/detail_paypal_hd_uq/' + id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                $('.full_name').val(data.data.contract.investor.name);
                $('.code_contract').val(data.data.contract.code_contract_disbursement);
                $('.ky_tra').val(data.data.ky_tra);
                $('.amount_money').val(data.data.goc_lai_1ky);
                $('.tien_goc').val(data.data.tien_goc_1ky);
                $('.tien_lai').val(data.data.lai_ky);
                $('.ngay_tra').val(data.data.ngay_ky_tra);
                $('.id_pay').val(id);
                $("input[name='date_pay']").val(convert_unix_time(data.data.unix_ky_tra));
            },
            error: function () {
                $(".theloading").hide();
                $('.text_message_fail').text("error")
            }
        });
    })

    $('.xac_nhan_cap_nhat_thanh_toan').click(function (event) {
        event.preventDefault();
        defaultValues();
        var formData = new FormData();
        formData.append('id', id);
        formData.append('date_pay', date_pay)
        if (confirm("Bạn có chắc chắn cập nhật thanh toán?")) {
            $.ajax({
                url: window.origin + '/pay/cap_nhat_ki_thanh_toan_ndt_uq',
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
                        $('#cap_nhat_thanh_toan_ndt_uq').modal('hide')
                        toastr.success(data.message)
                        setTimeout(function () {
                            window.location.href = '/pay/list_uq';
                        }, 1000);
                    } else {
                        toastr.error(data.message)
                    }
                },
                error: function () {
                    $(".theloading").hide();
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text("Gặp vấn đề trong quá trình thanh toán")
                    setTimeout(function () {
                        window.location.href = '/pay/list_uq';
                    }, 1000);
                }
            });
        }
    })

    $('.cap_nhat_dao_han').click(function () {
        var id = $(this).attr('data-id')
        $('.option_expire option').remove()
        $('.display_amount_money_new').hide()
        defaultValues();
        $.ajax({
            url: window.origin + '/pay/detail_paypal_hd_uq/' + id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                $('.name_investor').val(data.data.contract.investor.name);
                $('.code_contract').val(data.data.contract.code_contract_disbursement);
                $('.amount_money').val(data.data.tien_goc_1ky);
                $('.money_interest').val(data.data.lai_ky);
                $('.interest').val(JSON.parse(data.data.contract.interest).interest_year);
                $('.number_day_loan').val(data.data.contract.number_day_loan);
                $('.type_interest').val(data.data.contract.type_interest);
                $('.code_contract_new').val(data.data.contract.code_contract_disbursement + '.1');
                $('.created_at').val(convert_unix_time(data.data.contract.due_date));
                $('.pay_id').val(id);

                const options = [
                    {value: '', text: 'Chọn'},
                    {value: '2', text: 'Tái đầu tư gốc'},
                    {value: '3', text: 'Tái đầu tư 1 phần gốc'},
                    {
                        value: '4',
                        text: 'Tái đầu tư gốc lãi',
                        condition: data.data.contract.type_interest == GOC_LAI_CUOI_KY
                    }
                ];

                options.forEach(option => {
                    if (!option.condition || option.condition) {
                        $('.option_expire').append($('<option>', option));
                    }
                });
            },
            error: function () {
                $(".theloading").hide();
                $('.text_message_fail').text("error")
            }
        });
    })

    $('.option_expire').change(function () {
        let option = $(this).val();
        if (Number(option) === 3) {
            $('.display_amount_money_new').show()
        } else {
            $('.display_amount_money_new').hide()
        }
    })

    $('.btn_cap_nhat_dao_han_ndt_uq').click(function (event) {
        event.preventDefault();
        let id = $("input[name='pay_id']").val()
        let created_at = $("input[name='created_at']").val()
        let code_contract_new = $("input[name='code_contract_new']").val()
        let type_interest_new = $("select[name='type_interest_new']").val()
        let number_day_loan_new = $("select[name='number_day_loan_new']").val()
        let interest_new = $("input[name='interest_new']").val()
        let type_extend = $("select[name='option_expire']").val()
        let amount_money_new = $("input[name='amount_money_new']").val()
        let formData = new FormData();
        formData.append('id', id);
        formData.append('created_at', created_at)
        formData.append('code_contract_new', code_contract_new)
        formData.append('type_interest_new', type_interest_new)
        formData.append('number_day_loan_new', number_day_loan_new)
        formData.append('interest_new', interest_new)
        formData.append('type_extend', type_extend)
        formData.append('amount_money_new', amount_money_new)
        if (confirm("Bạn có chắc chắn cập nhật thanh toán?")) {
            $.ajax({
                url: window.origin + '/pay/expire_contract',
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
                        $('#cap_nhat_dao_han_ndt_uq').modal('hide')
                        toastr.success(data.message)
                        setTimeout(function () {
                            window.location.href = '/pay/list_uq';
                        }, 1000);
                    } else {
                        toastr.error(data.message)
                    }
                },
                error: function () {
                    $(".theloading").hide();
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text("Gặp vấn đề trong quá trình thanh toán")
                    setTimeout(function () {
                        window.location.href = '/pay/list_uq';
                    }, 1000);
                }
            });
        }
    })

    function addCommas(str) {
        return str.toString().replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $('.amount_money_new').on('keyup', function (event) {
        let amount_money_new = $("input[name='amount_money_new']").val()
        $('.amount_money_new').val(addCommas(amount_money_new))
    })

    function convert_unix_time(unix) {
        let dateObj = new Date(unix * 1000);

        let year = dateObj.getFullYear();
        let month = dateObj.getMonth() + 1;
        let day = dateObj.getDate();

        return year + "-" + month.toString().padStart(2, "0") + "-" + day.toString().padStart(2, "0");
    }

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
