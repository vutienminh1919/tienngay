/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function showModalUser(thiz) {
    //Get user selected
    var userids = [];
    if($("#tbl_user tbody").find("tr").length > 0) {
        $("#tbl_user tbody").find("tr").each(function() {
            var userId = $(this).find("#user_id").val();
            userids.push(userId);
        });
    }
    //Get user in DB except user-selected
    $.ajax({
        method: "POST",
        url: _url.get_user_in_role,
        data: {
            user_ids: JSON.stringify(userids)
        },
        success: function(data) {
            $("#tbl_modal_user").DataTable().destroy();
            $('#tbl_modal_user').DataTable({
                "info": false,
                data: data.data,
                columns: [
                    { data: 'id', visible: false },
                    { data: 'email' },
                    /* CHECKBOX */ 
                    {
                        mRender: function (data, type, row) {
                            return '<input type="checkbox" class="check_id_user" name="check_id_user" value="' + row.id + '" >'
                        }
                    }
                ]
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
    $("#modal_select_user").modal("show");
}

function saveModalUser(thiz) {
    var arrUsers = [];
    $('#tbl_modal_user').DataTable().rows().iterator('row', function(context, index){
        var section = {};
        // haveDivSection = true;
        var id = $(this.row(index).data())[0].id;
        var node = $(this.row(index).node());
        var isChecked = $(node).closest("tr").find("input[type='checkbox']"). prop("checked");
        if(isChecked) {
            var des = $(node).closest("tr").find("td").html();
            section['id'] = id;
            section['email'] = des;
            arrUsers.push(section);
        }
    });
    //Init data for tables
    var temp = "";
    if(arrUsers.length > 0) {
        for(var i=0; i < arrUsers.length; i++) {
            temp += "<tr>";
                temp += "<input type='hidden' id='email' value='"+arrUsers[i].email+"'>";
                temp += "<input type='hidden' id='user_id' value='"+arrUsers[i].id+"'>";
                temp += "<td>"+arrUsers[i].email+"</td>";
                temp += "<td><a onclick='remove(this)' class='close-link' data-user-id='"+arrUsers[i].id+"'><i class='fa fa-close'></i></a></td>";
            temp += "</tr>";
        }
        //Append HTML
        $("#tbl_user tbody").append(temp);
    }
    $("#modal_select_user").modal("hide");
}

function remove(thiz) {
    $(thiz).closest("tr").remove();
}

$(".btn-create-group-role").on("click", function() {
    //Get user
    var users = getDataUser();
    $.ajax({
        method: "POST",
        url: _url.process_create_group_role,
        data: {
            role_name: $("#role_name").val(),
            users: JSON.stringify(users),
        },
        success: function(data) {
            window.location.href = _url.process_search_group_role;
        },
        error: function(error) {
            
        }
    });
});

$(".btn-update-group-role").on("click", function() {
    //Get user
    var users = getDataUser();
    $.ajax({
        method: "POST",
        url: _url.process_update_group_role,
        data: {
            role_id: $("#role_id").val(),
            role_name: $("#role_name").val(),
            users: JSON.stringify(users),
        },
        success: function(data) {
            if(data.code != '200') {
                alert(data.message);
            } else {
                window.location.href = _url.process_search_group_role;
            }
            
        },
        error: function(error) {
            
        }
    });
});

function getDataUser() {
    var arr = [];
    $("#tbl_user tbody").find("tr").each(function() {
        var data = {};
        var id = $(this).find("#user_id").val();
        var email = $(this).find("#email").val();
        var infor = {};
        infor.email = email;
        data[id] = infor;
        arr.push(data);
    });
    return arr;
}
