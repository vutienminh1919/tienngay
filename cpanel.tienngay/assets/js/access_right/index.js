$(".btn-add").on("click", function() {
    var name = $("#name_menu").val();
    var description = $("#description").val();
    $.ajax({
        method: "POST",
        url: _url.process_create_access_right,
        data: {
            name: name,
            description: description,
        },
        success: function(data) {
            console.log(data);
            if(data.data.status != 200) {
                alert(data.data.message);
            } else {
                window.location.reload();
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
});

function btnDelete(thiz) {
    var r = confirm("Are you sure want to delete ?");
    if (r == true) {
        var id = $(thiz).data("id");
        $.ajax({
            method: "POST",
            url: _url.process_delete_access_right,
            data:{id:id},
            success: function(data) {
                if(data.code != 200) {
                    alert(data.message);
                } else {
                    window.location.reload();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
}

$(".btn-save-modal").on("click", function() {
    var id = $(this).closest("div[name='div-modal']").find("input[name='id']").val();
    var name = $(this).closest("div[name='div-modal']").find("input[name='name_modal']").val();
    var description = $(this).closest("div[name='div-modal']").find("textarea[name='description_modal']").val();
    $.ajax({
        method: "POST",
        url: _url.process_update_access_right,
        data: {
            id: id,
            name: name,
            description: description
        },
        success: function(data) {
            if(data.code != 200) {
                alert(data.message);
            } else {
                window.location.reload();
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
});