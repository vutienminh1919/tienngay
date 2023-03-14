$(document).ready(function () {
    $('.fdate').change(function () {
        var fdate = $("input[name='fdate']").val()
        var tdate = $("input[name='tdate']").val()
        if (fdate && tdate) {
            var formData = new FormData();
            formData.append('fdate', fdate);
            formData.append('tdate', tdate);
            $.ajax({
                url: window.origin + '/investor/total_excel_call',
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
                        $('.total').text('(' + data.data + ')')
                    } else {
                        $('.total').text('(0)')
                    }
                },
                error: function () {
                    $(".theloading").hide();
                    alert('error')
                    $('.total').text('(0)')
                }
            })
        } else {
            $('.total').text('(0)')
        }
    })

    $('.tdate').change(function () {
        var fdate = $("input[name='fdate']").val()
        var tdate = $("input[name='tdate']").val()
        if (fdate && tdate) {
            var formData = new FormData();
            formData.append('fdate', fdate);
            formData.append('tdate', tdate);
            $.ajax({
                url: window.origin + '/investor/total_excel_call',
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
                        $('.total').text('(' + data.data + ')')
                    } else {
                        $('.total').text('(0)')
                    }
                },
                error: function () {
                    $(".theloading").hide();
                    alert('error')
                    $('.total').text('(0)')
                }
            })
        } else {
            $('.total').text('(0)')
        }
    })

    $('.fdate_lead').change(function () {
        var fdate = $("input[name='fdate_lead']").val()
        var tdate = $("input[name='tdate_lead']").val()
        if (fdate && tdate) {
            var formData = new FormData();
            formData.append('fdate', fdate);
            formData.append('tdate', tdate);
            $.ajax({
                url: window.origin + '/investor/total_excel_call_lead',
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
                        $('.total_lead').text('(' + data.data + ')')
                    } else {
                        $('.total_lead').text('(0)')
                    }
                },
                error: function () {
                    $(".theloading").hide();
                    alert('error')
                    $('.total_lead').text('(0)')
                }
            })
        } else {
            $('.total_lead').text('(0)')
        }
    })

    $('.tdate_lead').change(function () {
        var fdate = $("input[name='fdate_lead']").val()
        var tdate = $("input[name='tdate_lead']").val()
        if (fdate && tdate) {
            var formData = new FormData();
            formData.append('fdate', fdate);
            formData.append('tdate', tdate);
            $.ajax({
                url: window.origin + '/investor/total_excel_call_lead',
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
                        $('.total_lead').text('(' + data.data + ')')
                    } else {
                        $('.total_lead').text('(0)')
                    }
                },
                error: function () {
                    $(".theloading").hide();
                    alert('error')
                    $('.total_lead').text('(0)')
                }
            })
        } else {
            $('.total_lead').text('(0)')
        }
    })
})
