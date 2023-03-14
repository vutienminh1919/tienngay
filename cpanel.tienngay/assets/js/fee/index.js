$('input[name="amount_fee"]').keyup(function(event) {
    // skip for arrow keys
    if(event.which >= 37 && event.which <= 40) return;
    // format number
    $(this).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        ;
    });
});

function getFloat(val) {
    var val = val.replace(/,/g,"");
    return parseFloat(val);
}

$(".save_fee_loan").on("click", function(event) {
    event.preventDefault();
    var fee_id = $(this).closest("div[name='div-modal']").find("input[name='id_fee']").val();
    var type_fee = $(this).closest("div[name='div-modal']").find("input[name='type_fee']").val();
    var percent_fee = 0;
    var amount_fee = 0;
    if(type_fee == 1){
        percent_fee = $(this).closest("div[name='div-modal']").find("input[name='percent_fee']").val();
    }
    if(type_fee == 2){
        amount_fee = getFloat($(this).closest("div[name='div-modal']").find("input[name='amount_fee']").val());
        // $("#salary").val().length != 0 ? getFloat($("#salary").val()) : 0;
    }
  
    var formData = {
        fee_id: fee_id,
        type_fee: type_fee,
        percent_fee: percent_fee,
        amount_fee: amount_fee
    };
    console.log(formData)
    $.ajax({
        url :   _url.base_url + '/feeLoan/update',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.code == 200) {
                $("#editModal_" + fee_id).modal("hide");
                $("#successModal").modal("show");
                $(".msg_success").text(data.message);
                setTimeout(function(){ 
                    window.location.href =  _url.base_url + "FeeLoan";
                }, 2000);
            } else {
                $("#editModal_" + fee_id).modal("hide");
                $("#errorModal").modal("show");
                $(".msg_error").text(data.message);
                // setTimeout(function(){ 
                //     window.location.reload();
                // }, 3000);
            }
        },
        error: function(data) {
            console.log(data);
            $("#loading").hide();
        }
    });
 
});