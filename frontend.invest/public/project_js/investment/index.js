$(document).ready(function () {
    $('#btn_add_investment').click(function (event) {
        event.preventDefault();
        var amount_money = $("input[name='amount_money']").val()
        var quantity = $("input[name='quantity']").val()
        var type_interest = $("select[name='type_interest']").val()
        var month = $("select[name='month']").val()
        var formData = new FormData();
        formData.append('amount_money', amount_money);
        formData.append('quantity', quantity)
        formData.append('type_interest', type_interest)
        formData.append('month', month)
        $.ajax({
            url: window.origin + '/investment/create',
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

    function addCommas(str) {
        return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $('.amount_money').on('keyup', function (event) {
        var amount_money = $("input[name='amount_money']").val()
        $('.amount_money').val(addCommas(amount_money))
    })
})
