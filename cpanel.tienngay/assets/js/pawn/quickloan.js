
function edit_fee(thiz) {
	let contract_id = $(thiz).data("id");
	$(".contract_id_fee").val(contract_id);
	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne",
		type: "POST",
		data : formData,
		dataType : 'json',
		success: function(data) {
			if (data.code == 200) {
				$(".percent_interest_customer").val(data.data.fee.percent_interest_customer);
				$(".percent_advisory").val(data.data.fee.percent_advisory);
				$(".percent_expertise").val(data.data.fee.percent_expertise);
				$(".penalty_percent").val(data.data.fee.penalty_percent);
				$(".penalty_amount").val(numeral(data.data.fee.penalty_amount).format('0,0'));
				$(".extend").val(numeral(data.data.fee.extend).format('0,0'));
				$(".percent_prepay_phase_1").val(data.data.fee.percent_prepay_phase_1);
				$(".percent_prepay_phase_2").val(data.data.fee.percent_prepay_phase_2);
				$(".percent_prepay_phase_3").val(data.data.fee.percent_prepay_phase_3);

				// $(".amount_loan").val(numeral(data.data.loan_infor.amount_money-money_gic).format('0,0'));
				$("#editFee").modal("show");

			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text("edit fee error");
			}
		},
		error: function(error) {
			console.log(error);
		}
	})

}




$(".submit_edit_fee").on("click", function() {
	//Get fee infor
	var percent_advisory = $(".percent_advisory").val();
	var percent_expertise =   $(".percent_expertise").val();
	// var note =   $(".fee_note").val();
	$("#editFee").modal("hide");
	//Call ajax
	$.ajax({
		url:  _url.base_url + "pawn/updateFee",
		method: "POST",
		data: {
			id: $(".contract_id_fee").val(),
			percent_advisory : percent_advisory,
			percent_expertise : percent_expertise,
			// note : note
		},
		beforeSend: function(){$(".theloading").show();},
		success: function(data) {
			$(".theloading").hide();
			if(data.code != 200) {
				$("#errorModal").modal("show");
				$(".msg_error").text(ata.msg);
			} else {
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function(){
					window.location.href = _url.contract;
				}, 2000);

			}
		},
		error: function(error) {
			console.log(error);
		}
	})
});


function gui_cht_duyet(thiz) {
	$(".title_modal_approve").text("Gửi trưởng PGD duyệt");
	$(".status_approve").val(2);
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}
function yeu_cau_giai_ngan(thiz) {
	$(".title_modal_approve").text("Yêu cầu giải ngân");
	$(".status_approve").val(15);
	let contract_id = $(thiz).data("id");
	console.log(contract_id);
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}
function cht_tu_choi(thiz) {
	$(".title_modal_approve").text("Trưởng PGD từ chối");
	$(".status_approve").val(4);
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}
function chuyen_hoi_so(thiz) {
	$(".title_modal_approve").text("Chuyển lên hội sở duyệt");
	$(".status_approve").val(5);
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}
function fee_gic()
{
	tilekhoanvay=getFloat($('.tilekhoanvay').val());
	money=getFloat($('.amount_money').val());
	fee_gi=Number((Number(money)*120)/100)*(tilekhoanvay)/100;
	fee=numeral(fee_gi).format('0,0');
	return fee
}
function amount_loan()
{

	money=getFloat($('.amount_money').val());
	money_gic=getFloat($('.fee_gic').val());
	total=Number(money-money_gic);
	fee=numeral(total).format('0,0');
	return fee
}
function hsduyet(thiz) {
	$(".title_modal_approve").text("Hội sở duyệt");
	$(".status_approve").val(6);
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne",
		type: "POST",
		data : formData,
		dataType : 'json',
		success: function(data) {
			console.log(data.data);
			var money_gic=(data.data.loan_infor.amount_GIC==undefined) ? 0 : data.data.loan_infor.amount_GIC;
			console.log();
			if (data.code == 200) {
				$(".amount_money_max").val(numeral(data.data.loan_infor.amount_money_max).format('0,0'));
				$(".amount_loan").val(numeral(data.data.loan_infor.amount_money-money_gic).format('0,0'));
				$(".fee_gic").val(numeral(money_gic).format('0,0'));
				$(".amount_money").val(numeral(data.data.loan_infor.amount_money).format('0,0'));
				$("#insurrance_contract").val(data.data.loan_infor.insurrance_contract);
				$("#hsduyet").modal("show");

			} else {
				$("#hsduyet").modal("show");
			}
		},
		error: function(error) {
			console.log(error);
		}
	})

}
function hoi_so_khong_duyet(thiz) {
	$(".title_modal_approve").text("Hội sở không duyệt hợp đồng");
	$(".status_approve").val(8);
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

function hsduyetgiahan(thiz) {
	$(".title_modal_approve").text("Hội sở duyệt gia hạn");
	$(".status_approve").val(22);
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}
function hshuygiahan(thiz) {
	$(".title_modal_approve").text("Hội sở hủy gia hạn");
	$(".status_approve").val(17);
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}
function kthuygiahan(thiz) {
	$(".title_modal_approve").text("Kế toán hủy gia hạn");
	$(".status_approve").val(17);
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}
function ketoan_tu_choi(thiz) {
	$(".title_modal_approve").text("Kế toán từ chối");
	$(".status_approve").val(7);
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}
function huy_hop_dong(thiz) {
	$(".title_modal_approve").text("Hủy hợp đồng");
	$(".status_approve").val(3);
	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$("#approve").modal("show");
}

function ktduyetgiahan(thiz) {
	let contract_id = $(thiz).data("id");
	$(".title_modal_approve").text("Kế toán duyệt gia hạn");
	$(".contract_id_extension").val(contract_id);
	$("#extension").modal("show");
}

$(".approve_submit").on("click", function() {
	var note =  $(".approve_note").val();
	var status =  $(".status_approve").val();
	var id = $(".contract_id").val();
	var amount_money = 0;
	var amount_loan = 0;
	var amount_GIC = 0;
	if(status == 6){
		amount_money = getFloat($(".amount_money").val());
		amount_loan = getFloat($(".amount_loan").val());
		amount_GIC = getFloat($(".fee_gic").val());
		note =  $(".approve_note_hs").val();
	}
	var formData = {
		note: note,
		status: status,
		id: id,
		amount_money: amount_money,
		amount_loan: amount_loan,
		amount_GIC: amount_GIC
	};
	$("#approve").modal("hide");
	$("#hsduyet").modal("hide");

	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/approveContractForQuickLoan",
		type: "POST",
		data : formData,
		dataType : 'json',
		beforeSend: function(){$(".theloading").show();},
		success: function(data) {

			setTimeout(function(){
				$(".theloading").hide();
			}, 1000);
			if (data.code == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function(){
					window.location.reload();
				}, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
			}
		},
		error: function(error) {
			setTimeout(function(){
				$(".theloading").hide();
			}, 1000);
		}
	});
});

$(".approve_submit_extension").on("click", function() {
	var note =  $(".approve_note_extension").val();
	var status =  $(".status_approve_extension").val();
	var contractId = $(".contract_id_extension").val();
	var formData = {
		note: note,
		status: status,
		contractId: contractId,
	};
	//Call ajax
	$("#approve").modal("hide");
	$("#extension").modal("hide");
	$.ajax({
		url: _url.base_url + "accountant/approveExtensionContract",
		type: "POST",
		data : formData,
		dataType : 'json',
		beforeSend: function(){$(".theloading").show();},
		success: function(data) {
			setTimeout(function(){
				$(".theloading").hide();
			}, 1000);
			if (data.code == 200) {
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function(){
					window.location.reload();
				}, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
				// setTimeout(function(){
				//     window.location.reload();
				// }, 3000);
			}
		},
		error: function(error) {
			setTimeout(function(){
				$(".theloading").hide();
			}, 1000);
		}
	})
});


$(".investors_disbursement_submit").on("click", function(event) {
	event.preventDefault();
	var disbursement_date =  $("#timeCheckIn").val();// giải ngân qua vfc
	var disbursement_date1 =  $("#timeCheckIn1").val()// giải ngân qua các nhà đầu tư
	var contract_id =  $("input[name='contract_id']").val();
	var code_contract = $("input[name='code_contract']").val();
	var type_payout = $("input[name='type_payout']").val();
	var order_code = $("input[name='code_contract']").val();
	var amount = $("input[name='amount']").val();

	var codeTransactionBankDisbursement = $("#code_transaction_bank_disbursement").val();
	var bankName = $("#bank_name").val();
	var contentTransfer = $("#content_transfer").val();

	var bank_id = $("input[name='bank_id']").val();
	var investor_selected = $('input[name=investor_selected]:checked').val()
	let urlSubmit = _url.base_url + '/pawn/investorsDisbursement';
	if(investor_selected == "2"){
		urlSubmit =  _url.base_url + '/pawn/createWithdrawalVimo';
		if(type_payout == 2){
			var bank_account = $(".bank_account").val();
			var bank_account_holder = $(".bank_account_holder").val();
			var bank_branch = $(".bank_branch").val();
			type_payout = $(".type_payout_bank").val();
			var atm_card_number = "";
			var atm_card_holder = "";

		} else if(type_payout == 3){
			var bank_account = "";
			var bank_account_holder = "";
			var bank_branch = "";
			var atm_card_number = $(".atm_card_number").val();
			var atm_card_holder = $(".atm_card_holder").val();
		}
		var percentInterestInvestor =  $("input[name='percent_interest_investor_vimo']").val();
		var formData = {
			content_transfer: contentTransfer,
			code_transaction_bank_disbursement: codeTransactionBankDisbursement,
			bank_name: bankName,
			code_contract: code_contract,
			type_payout: type_payout,
			order_code: order_code,
			amount: amount,
			bank_id: bank_id,
			bank_account: bank_account,
			bank_account_holder: bank_account_holder,
			atm_card_number: atm_card_number,
			atm_card_holder: atm_card_holder,
			bank_branch: bank_branch,
			investor_selected: investor_selected,
			percent_interest_investor: percentInterestInvestor,
			investor_code: 'vimo',
		};
	}else if(investor_selected == "1"){
		var percentInterestInvestor =  $("input[name='percent_interest_investor_vfc']").val();
		var formData = {
			content_transfer: contentTransfer,
			code_transaction_bank_disbursement: codeTransactionBankDisbursement,
			bank_name: bankName,
			code_contract: code_contract,
			type_payout: type_payout,
			investor_code: "vfc",
			contract_id: contract_id,
			percent_interest_investor: percentInterestInvestor,
			disbursement_date: disbursement_date,

		};
	}else if(investor_selected == "3"){
		var investorId = $("#investor").val();
		// var percentInterestInvestor = $("#investor option:selected").attr('data-percent');
		var formData = {
			content_transfer: contentTransfer,
			code_transaction_bank_disbursement: codeTransactionBankDisbursement,
			bank_name: bankName,
			code_contract: code_contract,
			type_payout: type_payout,
			investor_id: investorId,
			contract_id: contract_id,
			investor_code: '',
			percent_interest_investor: '',
			disbursement_date: disbursement_date1,
		};
	}
	$("#approve_disbursement").modal("hide");
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
					if(investor_selected == '2'){
						window.location.href =  _url.base_url + "pawn/contract";
					}else{
						window.location.href =  _url.base_url + "pawn/accountantUpload?id=" + contract_id;
					}
				}, 2000);
			} else {
				$("#errorModal").modal("show");
				$(".msg_error").text(data.msg);
				// setTimeout(function(){
				//     window.location.reload();
				// }, 3000);
			}
		},
		error: function(data) {
			$(".theloading").hide();
			console.log(data);
			$("#loading").hide();
		}
	});

});

$(".approve_disbursement_submit").on("click", function(event) {
	event.preventDefault();

	var code_contract = $("input[name='code_contract']").val();
	var type_payout = $("input[name='type_payout']").val();
	var order_code = $("input[name='code_contract']").val();
	var amount = $("input[name='amount']").val();
	var description = $("input[name='description']").val();
	var bank_id = $("input[name='bank_id']").val();
	if(type_payout == 2){
		var bank_account = $(".bank_account").text();
		var bank_account_holder = $(".bank_account_holder").text();
		var bank_branch = $(".bank_branch").text();
		type_payout = $("input[name='type_payout_bank']:checked").val();
		var atm_card_number = "";
		var atm_card_holder = "";

	} else if(type_payout == 3){
		var bank_account = "";
		var bank_account_holder = "";
		var bank_branch = "";
		var atm_card_number = $(".atm_card_number").text();
		var atm_card_holder = $(".atm_card_holder").text();
	}



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
		url :  _url.base_url + '/pawn/createWithdrawalVimo',
		type: "POST",
		data : formData,
		dataType : 'json',
		beforeSend: function(){$("#loading").show();},
		success: function(data) {
			if (data.code == 200) {
				$("#approve_disbursement").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function(){
					window.location.href =  _url.base_url + "pawn/contract";
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
		error: function(data) {
			console.log(data);
			$("#loading").hide();
		}
	});

});
$('#approve').on('hidden.bs.modal', function (e) {

	// do something...
	$(".approve_note").val('');
	$(".approve_note").html('');
	$(".approve_note").text('');

})

$(".edit_amount_money").on("click", function() {
	$('.amount_money').removeAttr('disabled');
});

$('.amount_money').keyup(function(event) {
	// skip for arrow keys
	if(event.which >= 37 && event.which <= 40) return;

	// format number
	$(this).val(function(index, value) {
		return value
			.replace(/\D/g, "")
			.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			;
	});
	if($('#insurrance_contract').val()==1)
	{
		$('.fee_gic').val(fee_gic());
		$('.amount_loan').val(amount_loan());
	}else{
		$('.fee_gic').val(0);
		$('.amount_loan').val(amount_loan());
	}

});
function getFloat(val) {
	var val = val.replace(/,/g,"");
	return parseFloat(val);
}

$('#hsduyet').on('hidden.bs.modal', function (e) {
	console.log('qưe');
	$('.amount_money').attr("disabled", true);
})


$('input[type=file]').change(function(){
	var contain = $(this).data("contain");
	var type = $(this).data("type");
	var contractId = $("#contract_id").val();
	// $(this).simpleUpload(_url.process_upload_image, {
	$(this).simpleUpload(_url.base_url + "pawn/upload_img", {
		allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4"],
		//allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
		maxFileSize: 20000000, //10MB
		start: function(file){
			fileType = file.type;
			fileName = file.name;
			//upload started
			this.block = $('<div class="block"></div>');
			this.progressBar = $('<div class="progressBar"></div>');
			this.block.append(this.progressBar);
			$('#'+contain).append(this.block);
		},
		data: {
			'type_img': type,
			'contract_id': contractId,
		},
		progress: function(progress){
			//received progress
			this.progressBar.width(progress + "%");
		},
		success: function(data){
			//upload successful
			this.progressBar.remove();
			if (data.code == 200) {
				//Video Mp4
				if(fileType == 'video/mp4') {
					// var item = '<a href="'+data.data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""></a>'
					// var data = $('<div ></div>').html(item + '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>');
					// this.block.append(data);

					var item = '<a  href="'+data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="'+type+'" data-fileType="'+fileType+'"  data-fileName="'+fileName+'" name="img_contract"  data-key="'+data.key+'" src="'+data.path+'" /></a>'
					var data = $('<div ></div>').html(item + '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button><div class="description"><textarea rows="6" data-key="'+data.key+'" name="description_img" ></textarea></div>');
					this.block.append(data);
				}
				//Mp3
				else if(fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
					// var item = '<a href="'+data.data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""></a>'
					// var data = $('<div ></div>').html(item + '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>');
					// this.block.append(data);


					var item = '<a  href="'+data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="'+type+'" data-fileType="'+fileType+'"  data-fileName="'+fileName+'" name="img_contract"  data-key="'+data.key+'" src="'+data.path+'" /></a>'
					var data = $('<div ></div>').html(item + '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button><div class="description"><textarea rows="6" data-key="'+data.key+'" name="description_img" ></textarea></div>');
					this.block.append(data);
				}
				//Image
				else {

					// var data2 = $('<div ></div>').html('<img src="'+data.data.path+'" /><button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button><div class="description"><textarea rows="6" data-key="'+data.data.key+'" name="description_img" ></textarea></div>');
					// this.block.append(data2);


					var content = "";
					content += '<a href="'+data.path+'" data-toggle="lightbox" data-gallery="'+contain+'" data-max-width="992" data-type="image" >';
					content += '<img data-type="'+type+'" data-fileType="'+fileType+'"  data-fileName="'+fileName+'" name="img_contract"  data-key="'+data.key+'" src="'+data.path+'" />';
					content += '</a>';
					content += '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button> <div class="description"><textarea rows="6" data-key="'+data.key+'" name="description_img" ></textarea></div>';
					var data = $('<div ></div>').html(content);
					this.block.append(data);


				}
			} else {
				//our application returned an error
				// var error = data.data.error.message;
				// var errorDiv = $('<div class="error"></div>').text(error);
				// this.block.append(errorDiv);
				var error = data.msg.error;
				this.block.remove();
				alert(error);
			}
		},
		error: function(error){
			//upload failed
			// this.progressBar.remove();
			// var error = error.message;
			// var errorDiv = $('<div class="error"></div>').text(error);
			// this.block.append(errorDiv);

			var msg = error.message;
			this.block.remove();
			alert(msg);
		}
	});
});

function deleteImage(thiz) {
	var thiz_ = $(thiz);
	var key = $(thiz).data("key");
	var type = $(thiz).data("type");
	var id = $(thiz).data("id");
	var res = confirm("Are you sure want to delete ?");
	$(thiz_).closest("div .block").remove();
	// if (res == true) {
	//     $.ajax({
	//         url: _url.process_contract_delete_image,
	//         method: "POST",
	//         data: {
	//             id: id,
	//             key: key,
	//             type_img: type
	//         },
	//         success: function(data) {
	//             if(data.data.status == 200) {
	//                 $(thiz_).closest("div .block").remove();
	//             }
	//         },
	//         error: function(error) {

	//         }
	//     });
	// }
}

$(".submit_description_img").on("click", function(event) {
	event.preventDefault();
	var contractId = $("#contract_id").val();
	var count = $("textarea[name='description_img']").length;
	// var arrDescription = [];
	var expertise = {};
	var img_contract = $("img[name='img_contract']").length;
	if(img_contract > 0) {
		$("img[name='img_contract']").each(function() {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['description'] = "";
			var key = $(this).data('key');
			expertise[key] = data;
		});
	}
	if(count > 0) {
		$("textarea[name='description_img']").each(function() {
			var data = {};
			var key_tera = $(this).data('key');
			data['key'] = $(this).data('key');
			data['description'] = $(this).val();
			expertise[key_tera]['description'] = $(this).val();
			// arrDescription.push(data);
		});
	}
	var formData = {
		contractId: contractId,
		expertise: expertise,
		// arrDescription: arrDescription
	};
	$.ajax({
		url :  _url.base_url + '/pawn/updateDescriptionImage',
		type: "POST",
		data : formData,
		dataType : 'json',
		beforeSend: function(){$("#loading").show();},
		success: function(data) {
			if (data.code == 200) {
				$("#approve_disbursement").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text(data.msg);
				setTimeout(function(){
					window.location.href =  _url.base_url + "pawn/contract";
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
		error: function(data) {
			$("#loading").hide();
		}
	});

});

$(".update_disbursement_contract").on("click", function(event) {
	event.preventDefault();
	console.log(123);
	//Get receiver infor
	var receiverInfor = getReceiverInfor();
	//Call ajax
	$.ajax({
		url: _url.base_url + '/pawn/updateDisbursementContract',
		method: "POST",
		data: {
			id: $("#contract_id").val(),
			receiver_infor: receiverInfor,
		},
		beforeSend: function(){$(".theloading").show();},
		success: function(data) {
			$(".theloading").hide();
			if(data.data.status != 200) {
				$("#saveContract").modal("hide");
				$("#div_error").css("display", "block");
				$(".div_error").text(data.data.message);
				// window.scrollTo(0, 0);
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#div_error").offset().top
				}, 500);


				setTimeout(function(){
					$("#div_error").css("display", "none");
				}, 3000);
			} else {
				$("#saveContract").modal("hide");
				$("#successModal").modal("show");
				$(".msg_success").text('Lưu hợp đồng thành công');
				setTimeout(function(){
					window.location.href = _url.contract;
				}, 2000);

			}
		},
		error: function(error) {
			console.log(error);
		}
	});
});


function getReceiverInfor() {
	var ReceiverInfor = {};
	var type_payout = $("#type_payout :checked").val();
	var amount = getFloat($("#money").val());
	var bank_id = $("#selectize_bank_vimo :checked").val();
	var bank_name = $("#selectize_bank_vimo :checked").text();
	// var description = $("#description_bank").val();
	var atm_card_number = $("#atm_card_number").val();
	var atm_card_holder = $("#atm_card_holder").val();
	var bank_account = $("#bank_account").val();
	var bank_account_holder = $("#bank_account_holder").val();
	var bank_branch = $("#bank_branch").val();
	ReceiverInfor['type_payout'] = type_payout;
	ReceiverInfor['amount'] = amount;
	ReceiverInfor['bank_id'] = bank_id;
	ReceiverInfor['bank_name'] = bank_name;
	// ReceiverInfor['description'] = description;
	ReceiverInfor['atm_card_number'] = atm_card_number;
	ReceiverInfor['atm_card_holder'] = atm_card_holder;
	ReceiverInfor['bank_account'] = bank_account;
	ReceiverInfor['bank_account_holder'] = bank_account_holder;
	ReceiverInfor['bank_branch'] = bank_branch;
	return ReceiverInfor;
}

$('#bank_account').keyup(function(event) {
	// skip for arrow keys
	if(event.which >= 37 && event.which <= 40) return;
	// format number
	$(this).val(function(index, value) {
		return value
			.replace(/\D/g, "");
	});
});

$('#atm_card_number').keyup(function(event) {
	// skip for arrow keys
	if(event.which >= 37 && event.which <= 40) return;
	// format number
	$(this).val(function(index, value) {
		return value
			.replace(/\D/g, "");
	});
});


$('.number').keypress(function(event) {
	if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		event.preventDefault();
	}
});


function getFloat(val) {
	var val = val.replace(/,/g,"");
	return parseFloat(val);
}


// $('#investor').selectize({
//     create: false,
//     valueField: 'percent_interest_investor',
//     labelField: 'name',
//     searchField: 'name',
//     maxItems: 1,
//     sortField: {
//         field: 'name',
//         direction: 'asc'
//     }
// });


$('#investor').selectize({
	create: false,
	valueField: 'code',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

function show_popup_print_contract(thiz) {
	$(".title_modal_approve_printed").text("In chứng từ");

	let contract_id = $(thiz).data("id");
	$(".contract_id").val(contract_id);
	$(".printed_contract").attr("href", _url.base_url + '/pawn/printed?id=' + contract_id);
	$(".printedNotification").attr("href", _url.base_url + '/pawn/printedNotification?id=' + contract_id );
	$(".printedReceipt").attr("href", _url.base_url + '/pawn/printedReceipt?id=' + contract_id);

	$('#print_contract').modal('show');
}
