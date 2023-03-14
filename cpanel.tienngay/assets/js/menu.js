/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(".btn-add-new-menu").on("click", function() {
    var name = $("#name_menu").val();
    var url = $("#url").val();
    var parentId = $("#parent").val();
    var language = $("#language").val();
    var iconMenu = $("#icon_menu").val();
    var description = $("#description").val();
    var show = $("#show").prop("checked");
    $.ajax({
        method: "POST",
        url: _url.process_create_menu,
        data: {
            name: name,
            url: url,
            parent_id: parentId,
            language: language,
            icon_menu: iconMenu,
            description: description,
            show : show == true ? 1 : 2
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

$(".btn-save-modal").on("click", function() {
    var id = $(this).closest("div[name='div-modal']").find("input[name='id']").val();
    var name = $(this).closest("div[name='div-modal']").find("input[name='name_modal']").val();
    var icon = $(this).closest("div[name='div-modal']").find("input[name='icon_modal']").val();
    var url = $(this).closest("div[name='div-modal']").find("input[name='url_modal']").val();
    var show = $(this).closest("div[name='div-modal']").find("input[name='show_modal']").prop("checked");
    var parentId = $(this).closest("div[name='div-modal']").find("select[name='parent_modal']").val();
    var language = $(this).closest("div[name='div-modal']").find("select[name='language_modal']").val();
    var description = $(this).closest("div[name='div-modal']").find("textarea[name='description_modal']").val();
    $.ajax({
        method: "POST",
        url: _url.process_update_menu,
        data: {
            id: id,
            name: name,
            icon: icon,
            url: url,
            parent_id: parentId,
            language: language,
            description: description,
            show : show == true ? 1 : 2
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

$(".btn-delete").on("click", function() {
    var r = confirm("Are you sure want to delete ?");
    if (r == true) {
        var id = $(this).data("id");
        $.ajax({
            method: "POST",
            url: _url.process_delete_menu,
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