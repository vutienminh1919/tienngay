/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(".btn-save-modal").on("click", function() {
    $.ajax({
        url: _url.process_create_depre,
        method: 'POST',
        data: {
            name: $("#name_modal").val(),
            property_id: $("#property_id").val()
        },
        success: function(data) {
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

$(".btn-edit-modal").on("click", function() {
    var id = $(this).closest("div[name='div-modal']").find("input[name='id']").val();
    var name = $(this).closest("div[name='div-modal']").find("input[name='name_modal']").val();
    var property_id = $('#property_id_' + id).val();
    $.ajax({
        url: _url.process_update_depre,
        method: 'POST',
        data: {
            name: name,
            id: id,
            property_id: property_id
        },
        success: function(data) {
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

$(".btn-delete").on("click", function() {
    var r = confirm("Are you sure want to delete ?");
    if (r == true) {
        var id = $(this).data("id");
        $.ajax({
            method: "POST",
            url: _url.process_delete_depre,
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
});