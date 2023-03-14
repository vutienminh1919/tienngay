/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
//    var table = $('#datatable-buttons-new').DataTable();
//    var param_url_code_contract = $("#param_url_code_contract").val();
//    if(param_url_code_contract !== "") {
//        table.search(param_url_code_contract).draw();
//    }
});

$("#plan_modal").on("show.bs.modal", function(event) {
    var button = $(event.relatedTarget);
    var planId = $(button).data("plan-id");
    var codeContract = $(button).data("code-contract");
    var time = $(button).data("time");
    var modal = $(this);
    modal.find($("#plan_id")).val(planId);
    modal.find($("#code_contract")).val(codeContract);
    modal.find($("#time")).html(time);
    modal.find($("#div_error")).css("display", "none");
    //Init data modal
    var resource_pay = $.trim($(button).closest("tr").find("#resource_pay").text());
    var date_pay = $.trim($(button).closest("tr").find("#date_pay").text());
    var amount_interest_paid = $.trim($(button).closest("tr").find("#amount_interest_paid").text());
    var amount_root_paid = $.trim($(button).closest("tr").find("#amount_root_paid").text());
    modal.find($("form")).find("#resource_pay").val(resource_pay);
    modal.find($("form")).find("#date_pay").prop("defaultValue", date_pay);
    modal.find($("form")).find("#amount_interest_paid").val(numeral(amount_interest_paid).value());
    modal.find($("form")).find("#amount_root_paid").val(numeral(amount_root_paid).value());
    
});

$("#btn-update-pay-investor").click(function() {
    var btn = $(this);
    var modal = $(btn).closest("#plan_modal");
    var url = modal.find($("#url_pay_investor")).val();
    var planId = modal.find($("#plan_id")).val();
    var codeContract = modal.find($("#code_contract")).val();
    var resourcePay = modal.find($("form")).find("#resource_pay").val();
    var datePay = modal.find($("form")).find("#date_pay").val();
    var amountInterestPaid = modal.find($("form")).find("#amount_interest_paid").val();
    var amountRootPaid = modal.find($("form")).find("#amount_root_paid").val();
    var loading = $(btn).closest("div").find("i");
    $.ajax({
        url: url,
        method: "POST",
        data: {
            plan_id: planId,
            resource_pay: resourcePay,
            date_pay: datePay,
            amount_interest_paid: amountInterestPaid,
            amount_root_paid: amountRootPaid
        },
        beforeSend: function () {
            $(loading).css("display","");
            $(btn).prop("disabled", true);
        },
        success: function(data) {
            setTimeout(function() {
                $(loading).css("display","none");
            }, 1000);
            $(btn).prop("disabled", false);
            if(data.code != '200') {
                modal.find($("#div_error")).css("display", "block");
                modal.find($("#span_div_error")).text(data.message);
            } else {
                //Alert success
                alert("Cập nhật thành công");
                //Close modal
                modal.modal("hide");
                //Reload
                //window.location.href = window.location.href + "?codeContract=" + codeContract;
                window.location.href = window.location.href
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
});

function reInitPayInvestor(codeContract, planId, resourcePay, datePay, amountInterestPaid, amountRootPaid) {
    var table = $("table[name='tbl_pay_interest_investor_"+codeContract+"']");
    var tr = $(table).find("tr[plan-id='"+planId+"']");
    $(tr).find("#resource_pay").val(resourcePay);
    $(tr).find("#date_pay").val(datePay);
    $(tr).find("#amount_interest_paid").val(amountInterestPaid);
    $(tr).find("#amount_root_paid").val(amountRootPaid);
}