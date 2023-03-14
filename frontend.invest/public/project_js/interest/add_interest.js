$(document).ready(function () {
    $('#btn_add_interest').click(function (event) {
        event.preventDefault();
        var interest = $("input[name='interest']").val()
        $.ajax({
            url: window.origin + '/interest/create_general?interest=' + interest,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
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
                $('#modal-danger').modal('show')
                $('.text_message_fail').text('Thêm mới không thành công')
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        })
    })

    $('.toggle-status').click(function (event) {
        event.preventDefault();
        var id = $(this).attr('data-id')
        if (confirm("Bạn chắc chắn muốn thay đổi?")) {
            $.ajax({
                url: window.origin + '/interest/active_interest_general?id=' + id,
                type: 'GET',
                dataType: 'json',
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
        }
    })

    $('#add_interest').click(function () {
        $("input[name='interest']").val('')
    })

    $('#add_interest_period').click(function () {
        $("input[name='period']").val('')
        $("input[name='interest_period']").val('')
    })

    $('#btn_add_interest_period').click(function (event) {
        event.preventDefault();
        var period = $("select[name='period']").val()
        var interest = $("input[name='interest_period']").val()
        var type_interest = $("select[name='type_interest_period']").val()
        $.ajax({
            url: window.origin + '/interest/create_period?interest=' + interest + '&period=' + period + '&type_interest=' + type_interest,
            type: 'GET',
            dataType: 'json',
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
                $('.text_message_fail').text('Thêm mới không thành công')
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        })
    })

    $('.toggle-status-period').click(function (event) {
        event.preventDefault();
        var id = $(this).attr('data-id')
        console.log(id)
        if (confirm("Bạn chắc chắn muốn thay đổi?")) {
            $.ajax({
                url: window.origin + '/interest/update_interest_period?id=' + id,
                type: 'GET',
                dataType: 'json',
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
        }
    })

    $('.update_new_interest_period').click(function () {
        var id = $(this).attr('data-id')
        var period = $(this).attr('data-period')
        var type = $(this).attr('data-type')
        if (type == 1) {
            type_interest = 'Dư nợ giảm dần'
        } else if (type == 2) {
            type_interest = 'Lãi hàng tháng, gốc cuối kỳ'
        } else if (type == 4) {
            type_interest = 'Gốc lãi cuối kỳ'
        } else {
            type_interest = 'Áp dụng chung'
        }
        $.ajax({
            url: window.origin + '/interest/show?id=' + id,
            type: "GET",
            dataType: 'json',
            success: function (result) {
                console.log(result.data.interest)
                $('.title-update-period').text('')
                $('.interest_period_now').val('')
                $('.interest_period_edit').val('')
                $('.interest_period_id').val('')
                $('.type_interest_period_now').val('')
                text = 'Cập nhật lãi suất kì hạn ' + '<span class="text-danger">' + period + '</span>' + ' tháng'
                $('.title-update-period').append(text)
                $('.type_interest_period_now').val(type_interest)
                $('.interest_period_now').val(result.data.interest)
                $('.interest_period_id').val(id)
            },
            error: function () {
                alert('error')
            }
        })
    })

    $('#btn_edit_add_interest_period').click(function (event) {
        event.preventDefault();
        var interest = $("input[name='interest_period_edit']").val()
        var id = $("input[name='interest_period_id']").val()
        $.ajax({
            url: window.origin + '/interest/edit_add_interest_period?id=' + id + '&interest=' + interest,
            type: 'GET',
            dataType: 'json',
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
})
