$(document).ready(function () {
    $('#selectAll').click(function (event) {
        if (this.checked) {
            $('.contractCheckBox').each(function () {
                this.checked = true;
                $('.block-payment-contract').show()
            });
        } else {
            $('.contractCheckBox').each(function () {
                this.checked = false;
                $('.block-payment-contract').hide()
            });
        }
    });

    $('.contractCheckBox').click(function () {
        if ($('.contractCheckBox').is(':checked')) {
            $('.block-payment-contract').show()
            $('#selectAll').prop('checked', false)
        } else {
            $('.block-payment-contract').hide()
        }
    })

    $('.btn-confirm').click(function (event) {
        event.preventDefault();
        let contract_id = [];
        $(".contractCheckBox:checked").each(function () {
            contract_id.push($(this).val());
        });
        let formData = {
            contract_id: contract_id,
        };
        if (confirm('Bạn chắc chắn muốn cập nhật?')) {
            $.ajax({
                url: window.origin + '/contract/payment_many',
                type: "POST",
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $(".theloading").show();
                },
                success: function (data) {
                    $(".theloading").hide();
                    if (data.status == 200) {
                        toastr.success(data.message)
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
                    } else {
                        toastr.error(data.message)
                    }
                },
                error: function () {
                    $(".theloading").hide();
                    alert('error')
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                }
            });
        }
    })

    $('.cap_nhat_dao_han_som').click(function () {
        let id = $(this).attr('data-id')
        defaultValues()
        set_null_input_show_interest()
        $.ajax({
            url: window.origin + '/contract/detail_contract/' + id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                $('.name_investor').val(data.data.investor.name);
                $('.code_contract').val(data.data.code_contract_disbursement);
                $('.amount_money').val(addCommas(data.data.amount_money));
                $('.interest').val(JSON.parse(data.data.interest).interest_year);
                $('.number_day_loan').val(data.data.number_day_loan);
                $('.type_interest').val(data.data.type_interest);
                $('.contract_id').val(id);
            },
            error: function () {
                $(".theloading").hide();
                $('.text_message_fail').text("error")
            }
        });
    })

    function addCommas(str) {
        return str.toString().replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $('.punish').change(function (event) {
        let punish = $(this).val();
        let expire_date = $("input[name='expire_date']").val()
        let early_interest = $("input[name='early_interest']").val()
        let id = $("input[name='contract_id']").val()
        set_null_input_show_interest()
        if (punish === '1') {
            $('.div_early_interest').show()
        } else {
            $('.div_early_interest').hide()
        }
        if (punish && early_interest && early_interest) {
            $.ajax({
                url: window.origin + '/contract/calculator_due_before_maturity',
                type: "POST",
                data: {
                    id: id,
                    punish: punish,
                    early_interest: early_interest,
                    expire_date: expire_date,
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data)
                    if (data.status == 200) {
                        $('.div-interest').show()
                        $("input[name='interest_paid']").val(convert_number(data.data.interest_paid))
                        $("input[name='interest_early']").val(convert_number(data.data.interest_early))
                        $("input[name='interest_payable']").val(convert_number(data.data.interest_payable))
                        $("input[name='total_payable']").val(convert_number(data.data.total_payable))
                    } else {
                        toastr.error(data.message)
                    }
                },
                error: function () {
                    toastr.error('error')
                }
            });
        }
    })

    $('.expire_date').on('blur', function (event) {
        let expire_date = $("input[name='expire_date']").val()
        let early_interest = $("input[name='early_interest']").val()
        let punish = $("select[name='punish']").val()
        let id = $("input[name='contract_id']").val()
        set_null_input_show_interest()
        if (punish && early_interest && early_interest) {
            $.ajax({
                url: window.origin + '/contract/calculator_due_before_maturity',
                type: "POST",
                data: {
                    id: id,
                    punish: punish,
                    early_interest: early_interest,
                    expire_date: expire_date,
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data)
                    if (data.status == 200) {
                        $('.div-interest').show()
                        $("input[name='interest_paid']").val(convert_number(data.data.interest_paid))
                        $("input[name='interest_early']").val(convert_number(data.data.interest_early))
                        $("input[name='interest_payable']").val(convert_number(data.data.interest_payable))
                        $("input[name='total_payable']").val(convert_number(data.data.total_payable))
                    } else {
                        toastr.error(data.message)
                    }
                },
                error: function () {
                    toastr.error('error')
                }
            });
        }
    })

    $('.early_interest').on('blur', function (event) {
        let expire_date = $("input[name='expire_date']").val()
        let early_interest = $("input[name='early_interest']").val()
        let punish = $("select[name='punish']").val()
        let id = $("input[name='contract_id']").val()
        set_null_input_show_interest()
        if (punish && early_interest && early_interest) {
            $.ajax({
                url: window.origin + '/contract/calculator_due_before_maturity',
                type: "POST",
                data: {
                    id: id,
                    punish: punish,
                    early_interest: early_interest,
                    expire_date: expire_date,
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data)
                    if (data.status == 200) {
                        $('.div-interest').show()
                        $("input[name='interest_paid']").val(convert_number(data.data.interest_paid))
                        $("input[name='interest_early']").val(convert_number(data.data.interest_early))
                        $("input[name='interest_payable']").val(convert_number(data.data.interest_payable))
                        $("input[name='total_payable']").val(convert_number(data.data.total_payable))
                    } else {
                        toastr.error(data.message)
                    }
                },
                error: function () {
                    toastr.error('error')
                }
            });
        }
    })

    $('.btn_cap_nhat_dao_han_som_ndt_uq').click(function (event) {
        event.preventDefault();
        let expire_date = $("input[name='expire_date']").val()
        let early_interest = $("input[name='early_interest']").val()
        let punish = $("select[name='punish']").val()
        let id = $("input[name='contract_id']").val()
        let formData = new FormData();
        formData.append('id', id);
        formData.append('expire_date', expire_date)
        formData.append('early_interest', early_interest)
        formData.append('punish', punish)
        if (confirm("Bạn có chắc chắn cập nhật thanh toán?")) {
            $.ajax({
                url: window.origin + '/contract/due_before_maturity',
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
                        $('#cap_nhat_dao_han_som_ndt_uq').modal('hide')
                        toastr.success(data.message)
                        setTimeout(function () {
                            window.location.href = '/contract/list_uq';
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
                        window.location.href = '/contract/list_uq';
                    }, 1000);
                }
            });
        }
    })

    function set_null_input_show_interest() {
        $('.div-interest').hide()
        $("input[name='interest_paid']").val(0)
        $("input[name='interest_early']").val(0)
        $("input[name='interest_payable']").val(0)
        $("input[name='total_payable']").val(0)
    }

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

    function convert_number(number) {
        if (number < 0) {
            return '- ' + addCommas(number)
        } else {
            return number === 0 ? 0 : addCommas(number)
        }
    }
})


