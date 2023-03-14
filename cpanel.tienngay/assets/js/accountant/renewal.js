$("#renewal_continues").click(function (event) {
	event.preventDefault();
	var id = $("input[name='id_contract']").val();

	var customer_name = $("input[name='customer_name']").val();
	var customer_phone_number = $("input[name='customer_phone_number']").val();
	var amount_money = $("input[name='amount_money']").val().length != 0 ? getFloat($("input[name='amount_money']").val()) : 0;
	var fee_extend = $("input[name='fee_extend']").val().length != 0 ? getFloat($("input[name='fee_extend']").val()) : 0;
	var tong_phi_no = $("input[name='tong_phi_no']").val().length != 0 ? getFloat($("input[name='tong_phi_no']").val()) : 0;
	var tong_thanh_toan = $("input[name='tong_thanh_toan']").val().length != 0 ? getFloat($("input[name='tong_thanh_toan']").val()) : 0;
	var so_tien_thanh_toan = $("input[name='so_tien_thanh_toan']").val().length != 0 ? getFloat($("input[name='so_tien_thanh_toan']").val()) : 0;

	var store_id = $("#stores_finish").val();
	var store_name = $("#stores_finish :selected").text();
	var method = $("input[name='payment_method6']:checked").val();

	var code_contract = $("input[name='code_contract']").val();
	var renewal_number = $("input[name='renewal_number']").val();
	var reason = $("textarea[name='reason']").val();

	var formData = {
		id: id,
		customer_name: customer_name,
		customer_phone_number: customer_phone_number,
		amount_money: amount_money,
		fee_extend: fee_extend,
		tong_phi_no: tong_phi_no,
		tong_thanh_toan: tong_thanh_toan,
		so_tien_thanh_toan: so_tien_thanh_toan,
		store_id: store_id,
		store_name: store_name,
		code_contract: code_contract,
		renewal_number: renewal_number,
		reason: reason,
		payment_method: method
	};
	$('#renewal').modal('hide');
	$.ajax({
		url: _url.base_url + 'accountant/renewalContinues',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
		},
		success: function (data) {
			if (data.status == 200) {
				if (method == 1) {
					window.open(_url.base_url + data.url, '_blank');
					window.location.href = _url.base_url + "accountant/view?id=" + id;
				} else {
					window.location.href = _url.base_url + 'accountant/renewalUpload?id=' + data.transaction_id;
				}

			} else {
				$('#errorModal').modal('show');
				$('.msg_error').text(data.msg);
			}
		},
		error: function (data) {
			console.log(data);
			$("#loading").hide();
		}
	});

});

$("input[name='so_tien_thanh_toan']").keyup(function (event) {
	// skip for arrow keys
	if (event.which >= 37 && event.which <= 40) return;

	// format number
	$(this).val(function (index, value) {
		return value
			.replace(/\D/g, "")
			.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			;
	});
});

function getFloat(val) {
	var val = val.replace(/,/g, "");
	return parseFloat(val);
}

// $(".submit_extension_img").on("click", function(event) {
//     event.preventDefault();
//     var contractId = $("#contract_id").val();
//     var count = $("textarea[name='description_img']").length;
//     var arrDescription = [];
//     if(count > 0) {
//         $("textarea[name='description_img']").each(function() {
//             var data = {};
//             data['key'] = $(this).data('key');
//             data['description'] = $(this).val();
//             data['path'] = $(this).data('path');
//             arrDescription.push(data);
//         });
//     }
//     var formData = {
//         contractId: contractId,
//         arrDescription: arrDescription
//     };
//     $.ajax({
//         url :  _url.base_url + '/Accountant/doUploadImage',
//         type: "POST",
//         data : formData,
//         dataType : 'json',
//         beforeSend: function(){$("#loading").show();},
//         success: function(data) {
//             if (data.code == 200) {
//                 // $("#approve_disbursement").modal("hide");
//                 $("#successModal").modal("show");
//                 $(".msg_success").text(data.msg);
//                 setTimeout(function(){ 
//                     window.location.href =  _url.base_url + "accountant";
//                 }, 2000);
//             } else {
//                 // $("#approve_disbursement").modal("hide");
//                 $("#errorModal").modal("show");
//                 $(".msg_error").text(data.msg);
//                 // setTimeout(function(){ 
//                 //     window.location.reload();
//                 // }, 3000);
//             }
//         },
//         error: function(data) {
//             $("#loading").hide();
//         }
//     });

// });


$(".submit_contract_img").on("click", function (event) {
	event.preventDefault();
	var contractId = $("#contract_id").val();
	var count = $("img[name='img_contract']").length;
	// console.log(count);
	var identify = {};
	var household = {};
	var driver_license = {};
	var vehicle = {};
	var agree = {};
	if (count > 0) {
		$("img[name='img_contract']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			var key = $(this).data('key');
			if (type == 'identify') {
				identify[key] = data;
			}
			if (type == 'household') {
				household[key] = data;
			}
			if (type == 'driver_license') {
				driver_license[key] = data;
			}
			if (type == 'vehicle') {
				vehicle[key] = data;
			}
			if (type == 'agree') {
				agree[key] = data;
			}
		});
	}
	var formData = {
		contractId: contractId,
		identify: identify,
		household: household,
		driver_license: driver_license,
		vehicle: vehicle,
		agree: agree
	};
	$.ajax({
		url: _url.base_url + '/pawn/doUploadContract',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$(".theloading").show();
		},
		success: function (data) {
			$(".theloading").hide();
			if (data.code == 200) {
				$("#approve_disbursement").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "accountant/view_v2?id=" + contractId;
				}, 2000);
			} else {
				$("#approve_disbursement").modal("hide");
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
				// setTimeout(function(){
				//     window.location.reload();
				// }, 3000);
			}
		},
		error: function (data) {
			$(".theloading").hide();
		}
	});

});

$(".submit_extension_img").on("click", function (event) {
	event.preventDefault();
	var transactionId = $("#contract_id").val();
	var count = $("textarea[name='description_img']").length;
	// var arrDescription = [];
	var extension = {};
	var img_contract = $("img[name='img_contract']").length;
	if (img_contract > 0) {
		$("img[name='img_contract']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['description'] = "";
			var key = $(this).data('key');
			extension[key] = data;
		});
	}
	if (count > 0) {
		$("textarea[name='description_img']").each(function () {
			var data = {};
			var key_tera = $(this).data('key');
			data['key'] = $(this).data('key');
			data['description'] = $(this).val();
			extension[key_tera]['description'] = $(this).val();
			// arrDescription.push(data);
		});
	}
	var formData = {
		transaction_id: transactionId,
		extension: extension,
		// arrDescription: arrDescription
	};
	$.ajax({
		url: _url.base_url + '/Accountant/doUploadImage',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
		},
		success: function (data) {
			if (data.code == 200) {
				// $("#approve_disbursement").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function () {
					window.location.href = _url.base_url + "accountant";
				}, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
			}
		},
		error: function (data) {
			$("#loading").hide();
		}
	});

});


function deleteImage(thiz) {
	var thiz_ = $(thiz);
	var key = $(thiz).data("key");
	var type = $(thiz).data("type");
	var id = $(thiz).data("id");
	var res = confirm("Bạn có chắc chắn muốn xóa ảnh này ?");
	if (res == true) {
		$(thiz_).closest("div .block").remove();
		// $.ajax({
		//     url: _url.process_contract_delete_image,
		//     method: "POST",
		//     data: {
		//         id: id,
		//         key: key,
		//         type_img: type
		//     },
		//     success: function(data) {
		//         if(data.data.status == 200) {
		//             $(thiz_).closest("div .block").remove();
		//         }
		//     },
		//     error: function(error) {

		//     }
		// });
	}
}
