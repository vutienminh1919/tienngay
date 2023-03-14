
$(".disbursementByVimo").click(function(event) {
    event.preventDefault();
    var code_contract = $("input[name='code_contract']").val();
    var type_payout = $("input[name='type_payout']").val();
    var order_code = $("input[name='order_code']").val();
    var amount = $("input[name='amount']").val();
    var description = $("input[name='description']").val();
    var bank_account = $("input[name='bank_account']").val();
    var bank_account_holder = $("input[name='bank_account_holder']").val();
    var atm_card_number = $("input[name='atm_card_number']").val();
    var atm_card_holder = $("input[name='atm_card_holder']").val();
    var bank_id = $("input[name='bank_id']").val();
    var bank_branch = $("input[name='bank_branch']").val();
    var formData = {
        code_contract: code_contract,
        type_payout: type_payout,
        order_code: order_code,
        amount: amount,
        bank_id: bank_id,
        description: description,
        bank_account: bank_account,
        bank_account_holder: bank_account_holder,
        atm_card_number: atm_card_number,
        atm_card_holder: atm_card_holder,
        bank_branch: bank_branch
    };
    $.ajax({
        url :  _url.base_url + '/vimo/createWithdrawal',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.code == 200) {
                $("#confirmDisbursement").modal("hide");
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                setTimeout(function(){ 
                    window.location.reload();
                }, 3000);
            } else {
                $("#confirmDisbursement").modal("hide");
                $("#errorModal").modal("show");
                $(".msg_error").text(data.msg);
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

$(".hidedisbursement").click(function(event) {
    event.preventDefault();
    var code_contract = $("input[name='code_contract']").val();
    var id = $("input[name='disbursementId']").val();
    var formData = {
        code_contract: code_contract,
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/DisbursementAccounting/hideDisbursement',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $("#hideDisbursement").modal("hide");
                $("#successModal").modal("show");
                $(".msg_success").text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/disbursementAccounting';
                }, 3000);
            } else {
                $("#hideDisbursement").modal("hide");
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

