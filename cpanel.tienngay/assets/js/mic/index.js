function restore_mic_kv(id){
    event.preventDefault();
   
    let urlSubmit = _url.base_url + 'mic/restore_mic_kv';
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
                    window.location.href =  _url.base_url + "mic/listMic";
                }, 2000);
            } else {
                $("#errorModal").modal("show");
                $(".msg_error").text(data.msg);
                $(".disbursement").hide();
                $(".disbursement_disabled").show();
                setTimeout(function(){ 
                    window.location.href =  _url.base_url + "mic/listMic";
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
