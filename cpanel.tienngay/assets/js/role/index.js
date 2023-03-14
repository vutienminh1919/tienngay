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

function showModalStore(thiz) {
    //Get user selected
    var storeids = [];
    if($("#tbl_store tbody").find("tr").length > 0) {
        $("#tbl_store tbody").find("tr").each(function() {
            var storeId = $(this).find("#store_id").val();
            storeids.push(storeId);
        });
    }
    //Get user in DB except user-selected
    $.ajax({
        method: "POST",
        url: _url.get_store_in_role,
        data: {
            store_ids: JSON.stringify(storeids)
        },
        success: function(data) {
        	console.log(data)
            $("#tbl_modal_store").DataTable().destroy();
            $('#tbl_modal_store').DataTable({
                "info": false,
                data: data.data,

                columns: [
                    { data: 'id', visible: false },
                    { data: 'name' },
                    { data: 'province' },
                    { data: 'district' },
                    { data: 'address' },
                    { data: 'code_area' },
                    /* CHECKBOX */
                    {
                        mRender: function (data, type, row) {
                            return '<input type="checkbox" class="check_id_store checkbox_tran_kt" name="check_id_store" value="' + row.id + '" >'
                        }
                    }
                ]
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
    $("#modal_select_store").modal("show");
}

function saveModalStore(thiz) {
    var arrStores = [];
    $('#tbl_modal_store').DataTable().rows().iterator('row', function(context, index){
        var section = {};
        // haveDivSection = true;
        var id = $(this.row(index).data())[0].id;
        var node = $(this.row(index).node());
        var isChecked = $(node).closest("tr").find("input[type='checkbox']"). prop("checked");
        if(isChecked) {
            $(node).closest("tr").find("td").each(function() {
                if($(this).index() == 0) section['name'] = $(this).html();
                if($(this).index() == 1) section['province'] = $(this).html();
                if($(this).index() == 2) section['district'] = $(this).html();
                if($(this).index() == 3) section['address'] = $(this).html();
                if($(this).index() == 4) section['code_area'] = $(this).html();
            });
            section['id'] = id;
            arrStores.push(section);
        }
    });
    //Init data for tables
    var temp = "";
    if(arrStores.length > 0) {
        for(var i=0; i < arrStores.length; i++) {
            temp += "<tr>";
                temp += "<input type='hidden' id='store_id' value='"+arrStores[i].id+"'>";
                temp += "<input type='hidden' id='name' value='"+arrStores[i].name+"'>";
                temp += "<input type='hidden' id='province' value='"+arrStores[i].province+"'>";
                temp += "<input type='hidden' id='district' value='"+arrStores[i].district+"'>";
                temp += "<input type='hidden' id='address' value='"+arrStores[i].address+"'>";
                temp += "<input type='hidden' id='code_area' value='"+arrStores[i].code_area+"'>";
                temp += "<td>"+arrStores[i].name+"</td>";
                temp += "<td>"+arrStores[i].province+"</td>";
                temp += "<td>"+arrStores[i].district+"</td>";
                temp += "<td>"+arrStores[i].address+"</td>";
                temp += "<td>"+arrStores[i].code_area+"</td>";
                temp += "<td><a onclick='remove(this)' class='close-link' data-store-id='"+arrStores[i].id+"'><i class='fa fa-close'></i></a></td>";
            temp += "</tr>";
        }
        //Append HTML
        $("#tbl_store tbody").append(temp);
    }
    $("#modal_select_store").modal("hide");
}

function showModalMenu(thiz) {
    //Get menu selected
    var menuids = [];
    if($("#tbl_menu tbody").find("tr").length > 0) {
        $("#tbl_menu tbody").find("tr").each(function() {
            var menuId = $(this).find("#menu_id").val();
            menuids.push(menuId);
        });
    }
    //Get menu in DB except menu-selected
    $.ajax({
        method: "POST",
        url: _url.get_menu_in_role,
        data: {
            menu_ids: JSON.stringify(menuids)
        },
        success: function(data) {
            $("#tbl_modal_menu").DataTable().destroy();
            $('#tbl_modal_menu').DataTable({
                "info": false,
                data: data.data,
                columns: [
                    { data: 'id', visible: false },
                    { data: 'menu' },
                    /* CHECKBOX */ 
                    {
                        mRender: function (data, type, row) {
                            return '<input type="checkbox" class="check_id_menu" name="check_id_menu" value="' + row.id + '" >'
                        }
                    }
                ]
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
    $("#modal_select_menu").modal("show");
}

function saveModalMenu(thiz) {
    var arrMenus = [];
    $('#tbl_modal_menu').DataTable().rows().iterator('row', function(context, index){
        var section = {};
        // haveDivSection = true;
        var id = $(this.row(index).data())[0].id;
        var node = $(this.row(index).node());
        var isChecked = $(node).closest("tr").find("input[type='checkbox']"). prop("checked");
        if(isChecked) {
            var des = $(node).closest("tr").find("td").html();
            section['id'] = id;
            section['menu'] = des;
            arrMenus.push(section);
        }
    });
    //Init data for tables
    var temp = "";
    if(arrMenus.length > 0) {
        for(var i=0; i < arrMenus.length; i++) {
            temp += "<tr>";
                temp += "<input type='hidden' id='name' value='"+arrMenus[i].menu+"'>";
                temp += "<input type='hidden' id='menu_id' value='"+arrMenus[i].id+"'>";
                temp += "<td>"+arrMenus[i].menu+"</td>";
                temp += "<td><a onclick='remove(this)' class='close-link' data-menu-id='"+arrMenus[i].id+"'><i class='fa fa-close'></i></a></td>";
            temp += "</tr>";
        }
        //Append HTML
        $("#tbl_menu tbody").append(temp);
    }
    $("#modal_select_menu").modal("hide");
}

$(".btn-create-role").on("click", function() {
    //Get user
    var users = getDataUser();
    //Get store
    var stores = getDataStore();
    //Get menu
    var menus = getDataMenu();
    //Get access right
    var accessRights = getDataAccessRight();
    $.ajax({
        method: "POST",
        url: _url.process_create_role,
        data: {
            role_name: $("#role_name").val(),
            users: JSON.stringify(users),
            stores: JSON.stringify(stores),
            menus: JSON.stringify(menus),
            accessRights: JSON.stringify(accessRights)
        },
        success: function(data) {
            window.location.href = _url.process_search_role;
        },
        error: function(error) {
            
        }
    });
});

$(".btn-update-role").on("click", function() {
    //Get user
    var users = getDataUser();
    //Get store
    var stores = getDataStore();
    //Get menu
    var menus = getDataMenu();
    //Get access right
    var accessRights = getDataAccessRight();
    $.ajax({
        method: "POST",
        url: _url.process_update_role,
        data: {
            role_id: $("#role_id").val(),
            role_name: $("#role_name").val(),
            users: JSON.stringify(users),
            stores: JSON.stringify(stores),
            menus: JSON.stringify(menus),
            accessRights: JSON.stringify(accessRights)
        },
        success: function(data) {
            if(data.code != '200') {
                alert(data.message);
            } else {
                window.location.href = _url.process_search_role;
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

function getDataMenu() {
    var arr = [];
    $("#tbl_menu tbody").find("tr").each(function() {
        var data = {};
        var id = $(this).find("#menu_id").val();
        var name = $(this).find("#name").val();
        var infor = {};
        infor.name = name;
        data[id] = infor;
        arr.push(data);
    });
    return arr;
}

function getDataAccessRight() {
    var arr = [];
    $("#tbl_access_right tbody").find("tr").each(function() {
        var data = {};
        var id = $(this).find("#access_right_id").val();
        var name = $(this).find("#name").val();
        var slug = $(this).find("#slug").val();
        var infor = {};
        infor.name = name;
        infor.slug = slug;
        data[id] = infor;
        arr.push(data);
    });
    return arr;
}

function getDataStore() {
    var arr = [];
    $("#tbl_store tbody").find("tr").each(function() {
        var data = {};
        //Get data from hidden
        var id = $(this).find("#store_id").val();
        var name = $(this).find("#name").val();
        var province = $(this).find("#province").val();
        var district = $(this).find("#district").val();
        var address = $(this).find("#address").val();
        var code_area = $(this).find("#code_area").val();
        //Init infor
        var infor = {};
        infor.name = name;
        infor.province = province;
        infor.district = district;
        infor.address = address;
        infor.code_area = code_area;
        //Push to array
        data[id] = infor;
        arr.push(data);
    });
    return arr;
}

function showModalAccessRight(thiz) {
    //Get menu selected
    var accessRights = [];
    if($("#tbl_access_right tbody").find("tr").length > 0) {
        $("#tbl_access_right tbody").find("tr").each(function() {
            var menuId = $(this).find("#access_right_id").val();
            accessRights.push(menuId);
        });
    }
    //Get menu in DB except menu-selected
    $.ajax({
        method: "POST",
        url: _url.get_access_right_in_role,
        data: {
            access_rights: JSON.stringify(accessRights)
        },
        success: function(data) {
            $("#tbl_modal_access_right").DataTable().destroy();
            $('#tbl_modal_access_right').DataTable({
                "info": false,
                data: data.data,
                columns: [
                    { data: 'id', visible: false },
                    { data: 'name' },
                    { data: 'slug' },
                    /* CHECKBOX */ 
                    {
                        mRender: function (data, type, row) {
                            return '<input type="checkbox" class="check_id_access_right" name="check_id_access_right" value="' + row.id + '" >'
                        }
                    }
                ]
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
    $("#modal_select_access_right").modal("show");
}

function saveModalAccessRight(thiz) {
    var arrAccessRights = [];
    $('#tbl_modal_access_right').DataTable().rows().iterator('row', function(context, index){
        var section = {};
        // haveDivSection = true;
        var id = $(this.row(index).data())[0].id;
        var node = $(this.row(index).node());
        var isChecked = $(node).closest("tr").find("input[type='checkbox']"). prop("checked");
        if(isChecked) {
            var name = $(node).closest("tr").find("td").eq(0).html();
            var slug = $(node).closest("tr").find("td").eq(1).html();
            section['id'] = id;
            section['name'] = name;
            section['slug'] = slug;
            arrAccessRights.push(section);
        }
    });
    //Init data for tables
    var temp = "";
    if(arrAccessRights.length > 0) {
        for(var i=0; i < arrAccessRights.length; i++) {
            temp += "<tr>";
                temp += "<input type='hidden' id='name' value='"+arrAccessRights[i].name+"'>";
                temp += "<input type='hidden' id='slug' value='"+arrAccessRights[i].slug+"'>";
                temp += "<input type='hidden' id='access_right_id' value='"+arrAccessRights[i].id+"'>";
                temp += "<td>"+arrAccessRights[i].name+"</td>";
                temp += "<td>"+arrAccessRights[i].slug+"</td>";
                temp += "<td><a onclick='remove(this)' class='close-link' data-menu-id='"+arrAccessRights[i].id+"'><i class='fa fa-close'></i></a></td>";
            temp += "</tr>";
        }
        //Append HTML
        $("#tbl_access_right tbody").append(temp);
    }
    $("#modal_select_access_right").modal("hide");
}
