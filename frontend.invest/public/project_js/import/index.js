$(document).ready(function () {
    $("#import_ndt_uy_quyen").click(function (event) {
        event.preventDefault();
        var inputimg = $('input[name=import_ndt_uy_quyen]');
        var fileToUpload = inputimg[0].files[0];
        var formData = new FormData();
        formData.append('upload_file', fileToUpload);
        $.ajax({
            enctype: 'multipart/form-data',
            url: window.origin + '/import/ndt_uy_quyen',
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
                    if (data.data.length > 0) {
                        $(".list_user_fail").show();
                        $.each(data.data, function (key, value) {
                            $('.text_list_user_fail').append($('<li>', {text: 'Dòng ' + value.data + ': ' + value.message}));
                        });
                    }
                } else {
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text(data.message)
                }

            },
            error: function () {
                $(".theloading").hide();
                $('#modal-danger').modal('show')
                $('.text_message_fail').text("error")
            }
        });

    });

    $("#import_hd_uy_quyen").click(function (event) {
        event.preventDefault();
        var inputimg = $('input[name=import_hd_uy_quyen]');
        var fileToUpload = inputimg[0].files[0];
        var formData = new FormData();
        formData.append('upload_file', fileToUpload);
        $.ajax({
            enctype: 'multipart/form-data',
            url: window.origin + '/import/import_contract_ndt_uy_quyen',
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
                    if (data.data.length > 0) {
                        $(".list_contract_fail").show();
                        $.each(data.data, function (key, value) {
                            $('.text_list_contract_fail').append($('<li>', {text: 'Dòng ' + value.data + ': ' + value.message}));
                        });
                    }
                } else {
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text(data.message)
                }

            },
            error: function () {
                $(".theloading").hide();
                $('#modal-danger').modal('show')
                $('.text_message_fail').text("error")
            }
        });
    });

    $("#import_transaction_uy_quyen").click(function (event) {
        event.preventDefault();
        var inputimg = $('input[name=import_transaction_uy_quyen]');
        var fileToUpload = inputimg[0].files[0];
        var formData = new FormData();
        formData.append('upload_file', fileToUpload);
        $.ajax({
            enctype: 'multipart/form-data',
            url: window.origin + '/import/import_transaction_ndt_uy_quyen',
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
                    if (data.data.length > 0) {
                        $(".list_contract_fail").show();
                        $.each(data.data, function (key, value) {
                            $('.text_list_contract_fail').append($('<li>', {text: 'Dòng ' + value.data + ': ' + value.message}));
                        });
                    }
                } else {
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text(data.message)
                }

            },
            error: function () {
                $(".theloading").hide();
                $('#modal-danger').modal('show')
                $('.text_message_fail').text("error")
            }
        });
    });

    $("#import_lead_investor").click(function (event) {
        event.preventDefault();
        var inputimg = $('input[name=import_lead_investor]');
        var fileToUpload = inputimg[0].files[0];
        var formData = new FormData();
        formData.append('upload_file', fileToUpload);
        $.ajax({
            enctype: 'multipart/form-data',
            url: window.origin + '/import/import_lead_investor',
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
                    if (data.data.length > 0) {
                        $(".list_lead_fail").show();
                        $.each(data.data, function (key, value) {
                            $('.text_list_lead_fail').append($('<li>', {text: 'Dòng ' + value.key + ': ' + value.message}));
                        });
                    }
                } else {
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text(data.message)
                }

            },
            error: function () {
                $(".theloading").hide();
                $('#modal-danger').modal('show')
                $('.text_message_fail').text("error")
            }
        });

    });

    $("#block_user_call").click(function (event) {
        event.preventDefault();
        var inputimg = $('input[name=block_user_call]');
        var fileToUpload = inputimg[0].files[0];
        var formData = new FormData();
        formData.append('upload_file', fileToUpload);
        $.ajax({
            enctype: 'multipart/form-data',
            url: window.origin + '/import/import_block_user_call',
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
                console.log(data);
                if (data.status == 200) {
                    $('#modal-success').modal('show')
                    $('.text_message_success').text(data.message)
                } else {
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text(data.message)
                }

            },
            error: function () {
                $(".theloading").hide();
                $('#modal-danger').modal('show')
                $('.text_message_fail').text("error")
            }
        });

    });

    $("#import_commission").click(function (event) {
        event.preventDefault();
        var inputimg = $('input[name=import_commission]');
        var fileToUpload = inputimg[0].files[0];
        var formData = new FormData();
        formData.append('upload_file', fileToUpload);
        $.ajax({
            enctype: 'multipart/form-data',
            url: window.origin + '/import/import_refferral_code',
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
                    if (data.data.length > 0) {
                        $(".list_commission_fail").show();
                        $.each(data.data, function (key, value) {
                            $('.text_list_commission_fail').append($('<li>', {text: 'Dòng ' + value.key + ': ' + value.message}));
                        });
                    }
                } else {
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text(data.message)
                }

            },
            error: function () {
                $(".theloading").hide();
                $('#modal-danger').modal('show')
                $('.text_message_fail').text("error")
            }
        });

    });
})
