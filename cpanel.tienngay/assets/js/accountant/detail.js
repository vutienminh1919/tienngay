$("#update_info").click(function(event) {
	event.preventDefault();

	var contract_id = $("input[name='contract_id_update']").val();
    var customer_phone = $("input[name='customer_phone']").val();
	var phone_1 = $("input[name='phone_1']").val();
	var phone_2 = $("input[name='phone_2']").val();
	var address_1 = $("input[name='address_1']").val();
	var address_2 = $("input[name='address_2']").val();
	var address = $("input[name='address']").val();

	var formData = {
		contract_id: contract_id,
        customer_phone: customer_phone,
		phone_1: phone_1,
		phone_2: phone_2,
		address_1: address_1,
		address_2: address_2,
		address: address
	};
	// console.log(formData);
	$.ajax({
		url :  _url.base_url + 'accountant/updatePhone',
		type: "POST",
		data : formData,
		dataType : 'json',
		beforeSend: function(){$("#loading").show();},
		success: function(data) {
			$("#loading").hide();
			if(data.status == 200){
				$("#modal_edit_phone").modal("hide");
			   $("#phone_number_relative_1").val(phone_1);
			   $("#phone_number_relative_2").val(phone_2);
			  $("#hoursehold_relative_1").val(address_1);
			  $("#hoursehold_relative_2").val(address_2);
			     document.getElementById("address").innerHTML =address;
               $("#successModal").modal("show");
              setTimeout(function(){
                    window.location.href = _url.base_url +'accountant/view_v2?id='+contract_id;
                }, 2000);
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
$(".approve_call_submit").on("click", function () {
    var note = $(".contract_v2_note").val();
    var id = $(".contract_id").val();
    var result_reminder =  $(".result_reminder").val();
    var payment_date =  $(".payment_date").val();
    var amount_payment_appointment =  $(".amount_payment_appointment").val();
    var formData = {
        note: note,
        payment_date: payment_date,
        result_reminder: result_reminder,
        amount_payment_appointment : amount_payment_appointment,
        contractId: id
    };
    
    //Call ajax
    $.ajax({
        url: _url.base_url + "accountant/doNoteReminder",
        type: "POST",
        data: formData,
        dataType: 'json',
        beforeSend: function () {
            $(".theloading").show();
        },
        success: function (data) {
            setTimeout(function () {
                $(".theloading").hide();
            }, 1000);
            if (data.code == 200) {
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                $("#approve_call").hide();
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            } else {
                $("#errorModal").modal("show");
                $(".msg_error").text(data.msg);
            }
        },
        error: function (error) {
            setTimeout(function () {
                $(".theloading").hide();
            }, 1000);
        }
    })
});
$("#approve_call_submit").on("click", function () {
    var note = $("#contract_v2_note").val();
    var id = $(".contract_id").val();
    var result_reminder =  $("#result_reminder").val();
    var payment_date =  $("#payment_date").val();
    var amount_payment_appointment =  $("#amount_payment_appointment").val();
    var formData = {
        note: note,
        payment_date: payment_date,
        result_reminder: result_reminder,
        amount_payment_appointment : amount_payment_appointment,
        contractId: id
    };
    
    //Call ajax
    $.ajax({
        url: _url.base_url + "accountant/doNoteReminder",
        type: "POST",
        data: formData,
        dataType: 'json',
        beforeSend: function () {
            $(".theloading").show();
        },
        success: function (data) {
            setTimeout(function () {
                $(".theloading").hide();
            }, 1000);
            if (data.code == 200) {
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                $("#approve_call").hide();
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            } else {
                $("#errorModal").modal("show");
                $(".msg_error").text(data.msg);
            }
        },
        error: function (error) {
            setTimeout(function () {
                $(".theloading").hide();
            }, 1000);
        }
    })
});

function call_for_customer(phone_number, contract_id, type) {
    console.log(phone_number);
    if (phone_number == undefined || phone_number == '') {
        alert("Không có số");
    } else {
       
        if(type == "customer"){
            $(".title_modal_approve").text("Gọi cho khách hàng");
        }
        if(type ==  "rel1"){
            $(".title_modal_approve").text("Gọi cho tham chiếu 1");
        }
        if(type ==  "rel2"){
            $(".title_modal_approve").text("Gọi cho tham chiếu 2");
        }
        $("#number").val(phone_number);
        $(".contract_id").val(contract_id);
        $("#approve_call").modal("show");
    }
}