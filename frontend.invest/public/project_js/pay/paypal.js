$(document).ready(function () {
    $('.xac_nhan_thanh_toan').click(function (event) {
        event.preventDefault();
        var id = $(this).attr('data-id')
        var note = $("textarea[name='note_paypal']").val()
        var formData = new FormData();
        formData.append('id', id);
        formData.append('note', note)
        if (confirm("Bạn có chắc chắn thanh toán?")) {
            $.ajax({
                url: window.origin + '/pay/paypal_investor',
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
                            window.location.href = '/pay/list';
                        }, 1000);
                    } else {
                        $('#modal-danger').modal('show')
                        $('.text_message_fail').text(data.message)
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    }
                },
                error: function () {
                    $(".theloading").hide();
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text("Gặp vấn đề trong quá trình thanh toán")
                    setTimeout(function () {
                        window.location.href = '/pay/list';
                    }, 1000);
                }
            });
        }
    })

    $(document).ready(function () {
        $('.update_payment').click(function () {
            if (confirm('Bạn có chắc chắn cập nhật')) {
                let id = $(this).attr('data-id');
                $.ajax({
                    url: window.origin + '/pay/update_wait_payment/' + id,
                    type: "POST",
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
                            }, 3000);
                        } else {
                            $('#modal-danger').modal('show')
                            $('.text_message_fail').text(data.message)
                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);
                        }
                    },
                    error: function () {
                        $(".theloading").hide();
                        $('#modal-danger').modal('show')
                        $('.text_message_fail').text("Gặp vấn đề trong quá trình thanh toán")
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    }
                });
            }
        })
    })
})
