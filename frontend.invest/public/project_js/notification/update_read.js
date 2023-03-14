$(document).ready(function () {
    $('.update_read_noti').click(function () {
        var id = $(this).attr('data-id')
        $.ajax({
            url: window.origin + '/notification/update_read/' + id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                console.log(data)
            },
            error: function () {

            }
        });
    })

    $('#read_all_noti').click(function () {
        if (confirm('Bạn có chắc chắn không?')) {
            $.ajax({
                url: window.origin + '/notification/read_all',
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    $('#modal-success').modal('show')
                    $('.text_message_success').text(data.message)
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                },
                error: function () {

                }
            });
        }
    })

})
