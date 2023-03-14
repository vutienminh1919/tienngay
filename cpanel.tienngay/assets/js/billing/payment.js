$(".payment").click(function(event) {
    event.preventDefault();
	$('.payment').dblclick(false);
    var customer_bill_phone = $("input[name='customer_bill_phone']").val();
    var customer_bill_name = $("input[name='customer_bill_name']").val();
    var store_id = $('#stores').val();
    var store_name = $('#stores :selected').text();

    var formData = {
        customer_bill_phone: customer_bill_phone,
        customer_bill_name: customer_bill_name,
        store_id: store_id,
        store_name: store_name
       
    };
    // console.log(formData);
    $("#billingConfirm").modal("hide");
    $.ajax({
        url :  _url.base_url + '/VimoBilling/doPayment',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
            setTimeout(function(){ 
                $(".theloading").hide();
            }, 1000);
            if(data.status == 200){
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + "transaction/getBillingUtilities";
                }, 3000);
              
            }else{
                $('#errorModal').modal('show');
                $('.msg_error').text(data.msg);
            }
        },
        error: function(data) {
            setTimeout(function(){ 
                $(".theloading").hide();
            }, 1000);
        }
    });
	$(this).prop('disabled', true);
});
