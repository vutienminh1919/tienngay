function restore_gic_plt(id){
    event.preventDefault();
   
    let urlSubmit = _url.base_url + '/gic/restore_gic_plt';
    var formData = {
        id_contract: id
    };
    $.ajax({
        url :  urlSubmit,
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
            $(".theloading").hide();
            if (data.code == 200) {
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                setTimeout(function(){ 
                    window.location.href =  _url.base_url + "gic/listGic_plt";
                }, 2000);
            } else {
                $("#errorModal").modal("show");
                $(".msg_error").text(data.msg);
                $(".disbursement").hide();
                $(".disbursement_disabled").show();
                setTimeout(function(){ 
                    window.location.href =  _url.base_url + "gic/listGic_plt";
                }, 2000);
            }
        },
        error: function(data) {
            $(".theloading").hide();
            console.log(data);
            $("#loading").hide();
        }
    });
 
}
function restore_gic_easy(id){
    event.preventDefault();
   $("#id_contract").val(id);
    $("#checkmodal").modal("show");
    }
$("#apply_resore").click(function(event) {

    event.preventDefault();
    var id=$("#id_contract").val();
   var date_easy=$("#date_easy").val();
    let urlSubmit = _url.base_url + '/gic/restore_gic_easy';
    var formData = {
        id_contract: id,
         date: date_easy
    };
    $.ajax({
        url :  urlSubmit,
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
            $(".theloading").hide();
            if (data.code == 200) {
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                setTimeout(function(){ 
                    window.location.href =  _url.base_url + "gic/listGic_easy";
                }, 2000);
            } else {
                $("#errorModal").modal("show");
                $(".msg_error").text(data.msg);
                $(".disbursement").hide();
                $(".disbursement_disabled").show();
               setTimeout(function(){ 
                    window.location.href =  _url.base_url + "gic/listGic_easy";
                }, 2000);
            }
        },
        error: function(data) {
            $(".theloading").hide();
            console.log(data);
            $("#loading").hide();
        }
    });
 
 });
function restore_gic_kv(id){
    event.preventDefault();
   
    let urlSubmit = _url.base_url + '/gic/restore_gic_kv';
    var formData = {
        id_contract: id
    };
    $.ajax({
        url :  urlSubmit,
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
            $(".theloading").hide();
            if (data.code == 200) {
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                setTimeout(function(){ 
                    window.location.href =  _url.base_url + "gic/listGic";
                }, 2000);
            } else {
                $("#errorModal").modal("show");
                $(".msg_error").text(data.msg);
                $(".disbursement").hide();
                $(".disbursement_disabled").show();
                setTimeout(function(){ 
                    window.location.href =  _url.base_url + "gic/listGic_easy";
                }, 2000);
            }
        },
        error: function(data) {
            $(".theloading").hide();
            console.log(data);
            $("#loading").hide();
        }
    });
 
}
