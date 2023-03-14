$(".nextBtnBill").click(function(event) {
    event.preventDefault();

    var curStep = $(this).closest(".setup-content");
    var curStepBtn = curStep.attr("id");
    var nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
    var curInputs = curStep.find("input[required]");
    var isValid = true;


    var sevice_code_vimo = $("input[name='sevice_code_vimo']").val();
    var customer_code = $("input[name='customer_code']").val();
    var publisher_code = $("input[name='publisher_code']").val();
    var publisher_name = $("input[name='publisher_name']").val();
    var formData = {
        service_code: sevice_code_vimo,
        customer_code: customer_code,
        publisher_code: publisher_code
    };
    $.ajax({
        url :  _url.base_url + '/VimoBilling/getTransactionQueryBill',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {

            if(data.status == 200){
                $(".theloading").hide();
                $(".publisher_name").text(publisher_name);
                $(".custumer_code").text(customer_code);
                $(".customer_name").text(data.data.customerInfo.customerName);
                $(".customer_address").text(data.data.customerInfo.customerAddress);
                let html = "";
                let content = data.data.billDetail;
                let total_amount = 0;
                // console.log(content);
                for(var i = 0; i < content.length; i++) {
                    html += "<li>Kỳ "+content[i].period+"<span>"+numeral(content[i].amount).format('0,0')+" đ </span></li>"
                    total_amount += content[i].amount;
                }
                $(".total_amount").text(numeral(total_amount).format('0,0')+" đ");
                $(".billDetail").html('');
                $(".billDetail").append(html);
                // $(html).insertBefore(".hrBillDetail");
                $(".total_amount_billing").val(total_amount);

                $(".arrBillingDetaile").val(JSON.stringify(content));
                $(".arrCustomerInfor").val(JSON.stringify(data.data.customerInfo));
    
                
                
                $(".form-group").removeClass("has-error");
                for (var i = 0; i < curInputs.length; i++) {
                  if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                  }
                }
            
                if (isValid) nextStepWizard.removeAttr('disabled').removeClass('disabled').trigger('click');
    
            }else{
                $(".theloading").hide();
                $('#errorModal').modal('show');
                $('.msg_error').text(data.msg);
            }
        },
        error: function(data) {
            $(".theloading").hide();
            $("#loading").hide();
        }
    });
 
});


$(".electric_order_cart").click(function(event) {
    event.preventDefault();

    var sevice_code_vimo = $("input[name='sevice_code_vimo']").val();
    var customer_code = $("input[name='customer_code']").val();
    var publisher_code = $("input[name='publisher_code']").val();
    var sevice_name_vimo = $("input[name='sevice_name_vimo']").val();
    var publisher_name = $("input[name='publisher_name']").val();
    var total_amount_billing = $("input[name='total_amount_billing']").val();
    var arrBillingDetaile = $("input[name='arrBillingDetaile']").val();
    var arrCustomerInfor = $("input[name='arrCustomerInfor']").val();
    // var money_card_active = 0;
    var qty = 1;
    var formData = {
        service_code: sevice_code_vimo,
        customer_code: customer_code,
        publisher_code: publisher_code,
        sevice_name_vimo: sevice_name_vimo,
        publisher_name: publisher_name,
        total_amount_billing: total_amount_billing,
        arrBillingDetaile: arrBillingDetaile,
        arrCustomerInfor: arrCustomerInfor,
        // money_card_active: money_card_active,
        qty: qty
    };
    // console.log(formData);
    $.ajax({
        url :  _url.base_url + '/VimoBilling/addCart',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if(data.status == 200){
                window.location.href = _url.base_url + '/VimoBilling/listCart';
            }else{
                $('#errorModal').modal('show');
                $('.msg_error').text(data.msg);
            }
        },
        error: function(data) {
            console.log(data);
            $("#loading").hide();
        }
    });
 
});

$(".deleteCart").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var rowid  = $(this).attr('data-rowid');
    var formData = {
        id: id,
        rowid : rowid,
    };
    $.ajax({
        url : _url.base_url + '/VimoBilling/deleteCart',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#preloader").show();},
        success: function(data) {
            setTimeout(function(){
                $("#preloader").hide();
            }, 1000);
            if (data.res) {
                if(data.total_items == 0){
                    $("#successModal").modal("show");
                    $(".msg_success").text(data.msg);
                    setTimeout(function(){ 
                        window.location.href = _url.base_url + '/VimoBilling';
                    }, 3000);
                }else{
                    $(".billing_"+id).remove();
                    $(".total_cart").text(data.total_cart);
                    $(".total_items").text(data.total_items);
                    
                    $("#successModal").modal("show");
                    $(".msg_success").text(data.msg);
                    
                }
            } else {
                $('#errorModal').modal('show');
                $('.msg_error').text(data.msg);
            }
        },
        error: function(data) {
            console.log(data);
            $("#preloader").hide();
        }
    });
});

$(".deleteAllCart").click(function(event) {
    event.preventDefault();
    var formData = {
        id: ""
    };
    $.ajax({
        url : _url.base_url + "VimoBilling/deleteAll",
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#preloader").show();},
        success: function(data) {
            setTimeout(function(){
                $("#preloader").hide();
            }, 1000);
            if (data.res) {
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/VimoBilling';
                }, 3000);
            }
        },
        error: function(data) {
            $("#preloader").hide();
        }
    });
});


function selectPublisher(thiz) {
    var publisher_code = $(thiz).data('code');
    var publisher_name = $(thiz).data('name');
    var publisher_logo = $(thiz).data('logo');
    $("input[name='publisher_code']").val(publisher_code);
    $("input[name='publisher_name']").val(publisher_name);
    $("input[name='publisher_logo']").val(publisher_logo);
    var src = _url.base_url + publisher_logo;
    $('.src_publisher').attr("src",src );
};

function selectMoneyCard(thiz) {
    var money_card = $(thiz).data('money');
    var qty =  $("input[name='number_card']").val();
    money_card = money_card*qty;
    $("input[name='money_card_active']").val(money_card);
    $("input[name='money_card']").val(money_card);
    $(".money_card").html(numeral(money_card).format('0,0')+'đ');
};


$(".pincode_order_cart").click(function(event) {
    event.preventDefault();

    var sevice_code_vimo = $("input[name='sevice_code_vimo']").val();
    var publisher_code = $("input[name='publisher_code']").val();
    var customer_phone = "";
    if(sevice_code_vimo != 'PINCODE_TELCO'){
        customer_phone = $("input[name='customer_phone']").val();
    }
 
    var sevice_name_vimo = $("input[name='sevice_name_vimo']").val();
    var publisher_name = $("input[name='publisher_name']").val();
    var total_amount_billing = $("input[name='money_card_active']").val();
    // var money_card_active = $("input[name='money_card_active']").val();
    var arrBillingDetaile = "";
    var arrCustomerInfor = "";
    var qty = $("input[name='number_card']").val();

    var formData = {
        service_code: sevice_code_vimo,
        customer_code: customer_phone,
        publisher_code: publisher_code,
        sevice_name_vimo: sevice_name_vimo,
        publisher_name: publisher_name,
        total_amount_billing: total_amount_billing,
        arrBillingDetaile: arrBillingDetaile,
        arrCustomerInfor: arrCustomerInfor,
        // money_card_active: money_card_active,
        qty: qty
    };
    // console.log(formData);
    $.ajax({
        url :  _url.base_url + '/VimoBilling/addCart',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if(data.status == 200){
                window.location.href = _url.base_url + '/VimoBilling/listCart';
            }else{
                $('#resultModal').modal('hide');
                $('#errorModal').modal('show');
                $('.msg_error').text(data.msg);
            }
        },
        error: function(data) {
            console.log(data);
            $("#loading").hide();
        }
    });
 
});



