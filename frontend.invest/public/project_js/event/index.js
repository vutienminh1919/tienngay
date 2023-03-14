$(document).ready(function () {
    $('.repeat').on('change', function () {
        let month = $("select[name='month']").val('');
        let day = $("select[name='day']").val('');
        let hour = $("select[name='hour']").val('');
        let date = $("input[name='date']").val('');
        let repeat = $(this).val();
        if (repeat == 1) {
            $('.div-month').hide();
            $('.div-day').hide();
            $('.div-hour').show();
            $('.div-date').hide();
        } else if (repeat == 2) {
            $('.div-month').hide();
            $('.div-day').show();
            $('.div-hour').show();
            $('.div-date').hide();
        } else if (repeat == 3) {
            $('.div-month').show();
            $('.div-day').hide();
            $('.div-hour').show();
            $('.div-date').hide();
        } else if (repeat == 4) {
            $('.div-month').hide();
            $('.div-day').hide();
            $('.div-hour').show();
            $('.div-date').show();
        } else {
            $('.div-month').hide();
            $('.div-day').hide();
            $('.div-hour').hide();
            $('.div-date').hide();
        }
    })

    const anh_mac_dinh = window.origin + '/images/default.jpg';
    $('.btn-add-event').click(function (e) {
        e.preventDefault();
        let event = $("input[name='event']").val();
        let title = $("input[name='title']").val();
        let month = $("select[name='month']").val();
        let day = $("select[name='day']").val();
        let hour = $("select[name='hour']").val();
        let repeat = $("select[name='repeat']").val();
        let object = $("select[name='object']").val();
        let date = $("input[name='date']").val();
        let short_description = $("textarea[name='short_description']").val();
        let long_description = CKEDITOR.instances['long_description'].getData();
        let image = $('.img_anh_chan_dung img').attr('src');
        if (image == anh_mac_dinh) {
            image = '';
        }
        let formData = new FormData();
        formData.append('event', event);
        formData.append('title', title);
        formData.append('month', month);
        formData.append('day', day);
        formData.append('hour', hour);
        formData.append('object', object);
        formData.append('repeat', repeat);
        formData.append('date', date);
        formData.append('short_description', short_description);
        formData.append('long_description', long_description);
        formData.append('image', image);
        $.ajax({
            url: window.origin + '/event/store',
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
                        window.location.href = window.origin + '/event/list';
                    }, 1000);
                } else {
                    $('#modal-danger').modal('show')
                    $('.text_message_fail').text(data.message)
                }
            },
            error: function () {
                $(".theloading").hide();
                alert('error')

            }
        })
    })

    $('.toggle-status').on('click', function (e) {
        if (confirm('Bạn có chắc chắn muốn thay đổi')) {
            let data = new FormData();
            data.append('id', $(this).data('id'));
            $.ajax({
                url: window.origin + '/event/update_status',
                type: 'POST',
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
            }).success(function (result) {
                toastr.success(result.message)
            }).error(function (result) {
                toastr.success("Cập nhật thất bại")
            });
        } else {
            e.preventDefault();
        }
    });

    $('.btn-update-event').click(function (e) {
        e.preventDefault();
        let id = $("input[name='id']").val();
        let event = $("input[name='event']").val();
        let title = $("input[name='title']").val();
        let month = $("select[name='month']").val();
        let day = $("select[name='day']").val();
        let hour = $("select[name='hour']").val();
        let repeat = $("select[name='repeat']").val();
        let object = $("select[name='object']").val();
        let date = $("input[name='date']").val();
        let short_description = $("textarea[name='short_description']").val();
        let long_description = CKEDITOR.instances['long_description'].getData();
        let image = $('.img_anh_chan_dung img').attr('src');
        if (image == anh_mac_dinh) {
            image = '';
        }
        let formData = new FormData();
        formData.append('id', id);
        formData.append('event', event);
        formData.append('title', title);
        formData.append('month', month);
        formData.append('day', day);
        formData.append('hour', hour);
        formData.append('object', object);
        formData.append('repeat', repeat);
        formData.append('date', date);
        formData.append('short_description', short_description);
        formData.append('long_description', long_description);
        formData.append('image', image);
        $.ajax({
            url: window.origin + '/event/update',
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
                }
            },
            error: function () {
                $(".theloading").hide();
                alert('error')

            }
        })
    })

    $('#input_img_per').change(function (event) {
        event.preventDefault();
        var files = $(this)[0].files;
        var formData = new FormData();
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
})
