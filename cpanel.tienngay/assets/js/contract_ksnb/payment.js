(function ($) {

	var defaults = {
		div: '<div class="dropdown bts_dropdown col-xs-12"></div>',
		buttontext: 'Chọn nội dung thu tiền',
		button: '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span></span> <i class="caret"></i></button>',
		ul: '<ul class="dropdown-menu"></ul>',
		li: '<li><label></label></li>'
	};

	$.fn.treeselect = function (options) {
		var $select = $(this);

		var settings = $.extend(defaults, options);

		var $div = $(settings.div);
		var $button = $(settings.button);
		var $ul = $(settings.ul).click(function (e) {
			e.stopPropagation();
		});

		initialize();

		function initialize() {
			$select.after($div);
			$div.append($button);
			$div.append($ul);

			createList();
			updateButtonText();

			$select.remove();
		}

		function createStructure(selector) {
			var options = [];

			$select.children(selector).each(function (i, el) {
				$el = $(el);

				options.push({
					value: $el.val(),
					text: $el.text(),
					checked: $el.attr('selected') ? true : false,
					children: createStructure('option[data-parent=' + $el.val() + ']')
				});
			});

			return options;
		}

		function createListItem(option) {
			var $li = $(settings.li);
			$label = $li.children('label');
			$label.text(option.text);

			if ($select.attr('multiple')) {
				$input = $('<input type="checkbox" name="' + $select.attr('name').replace('[]','') + '[]" value="' + option.value + '">');
			} else {
				$input = $('<input type="radio" name="' + $select.attr('name') +'" value="' + option.value + '">');
			}


			if (option.checked)
				$input.attr('checked', 'checked');
			$label.prepend($input);

			$input.change(function () {
				updateButtonText();
			});

			if (option.children.length > 0) {
				$(option.children).each(function (i, child) {
					$childul = $('<ul></ul>').appendTo($li);
					$childul.append(createListItem(child));
				});
			}

			return $li;
		}

		function createList() {
			$(createStructure('option:not([data-parent])')).each(function (i, option) {
				$li = createListItem(option);
				$ul.append($li);
			});
		}

		function updateButtonText() {
			buttontext = [];
			array_note = [];
			$div.find('input').each(function (i, el) {
				$checkbox = $(el);
				if ($checkbox.is(':checked')) {
					buttontext.push($checkbox.parent().text());
					array_note.push($checkbox.val());
				}
			});

			if (buttontext.length > 0) {
				if (buttontext.length < 6) {
					$button.children('span').text(buttontext.join(', '));
				} else if ($div.find('input').length == buttontext.length) {
					$button.children('span').text('Đã chọn tất cả nội dung!');
				} else {
					$button.children('span').text(buttontext.length + ' nội dung được chọn');
				}
			} else {
				$button.children('span').text(settings.buttontext);
			}
		}
	};
}(jQuery));
$(document).ready(function() {
	var status = ["21","22","24","19","23"];
	var ck = status.includes($("#status_ct").val());
	var ck_tt = $("#ck_tt").val();
	// if(ck)
	// {
	// 	$("#confirm_payment").prop('disabled', true);
	// 	$("#confirm_finish_contract").prop('disabled', true);
	// 	$("#renewal_continues").prop('disabled', true);
	// }
	// if(ck_tt==1)
	// {
	//      $("#confirm_finish_contract").prop('disabled', true);
	// }
	(function () {
		$('.table-responsive').on('shown.bs.dropdown', function (e) {
			var $table = $(this),
				$menu = $(e.target).find('.dropdown-menu'),
				tableOffsetHeight = $table.offset().top + $table.height(),
				menuOffsetHeight = $menu.offset().top + $menu.outerHeight(true);

			if (menuOffsetHeight > tableOffsetHeight)
				$table.css("padding-bottom", menuOffsetHeight - tableOffsetHeight);
		});

		$('.table-responsive').on('hide.bs.dropdown', function () {
			$(this).css("padding-bottom", 0);
		})
	})();
});
if (screen.width > 960) {
	$('#payment_note').treeselect();
	$('#payment_note_finish').treeselect();
}
$("#tab003").click(function(event) {
	event.preventDefault();
	var so_ngay_qua_han = $("input[name='so_ngay_qua_han']").val();
	if(so_ngay_qua_han > 0 )
	{
		$("#errorModal").modal("show");
		$(".msg_error").text("Đã đến kỳ tất toán, nếu khách hàng đã đóng đủ bạn cần chọn tab tất toán");
		// setTimeout(function(){
		//             location.reload();
		//             }, 3000);
	}
});
$("#confirm_payment").click(function(event) {
	event.preventDefault();

	var code_contract = $("input[name='code_contract']").val();
	var payment_name = $("input[name='payment_name']").val();
	var type_payment = $("input[name='type_payment']:checked").val();
	var relative_with_contract_owner = $("input[name='relative_with_contract_owner']").val();
	var payment_phone = $("input[name='payment_phone']").val();
	var date_pay = $("#date_pay").val();
	var payment_amount = $("input[name='payment_amount']").val().split(',').join('');
	var valid_amount_payment = $(".valid_amount_payment").text().split(',').join('');
	var payment_method = $("input[name='payment_method']:checked").val();
	var penalty_pay = $("#penalty_pay").text().split(',').join('');
	var reduced_fee = $("input[name='reduced_fee']").val().split(',').join('');
	var discounted_fee = $("input[name='discounted_fee']").val().split(',').join('');
	var other_fee = $("input[name='other_fee']").val().split(',').join('');
	var total_deductible = $("#total_deductible").text().split(',').join('');
	var fee_need_gh_cc=$("input[name='fee_need_gh_cc']").val().split(',').join('');
	var payment_note = array_note;
	var amount_debt_cc=$("input[name='amount_debt_cc']").val().split(',').join('');
	var amount_cc=$("input[name='amount_cc']").val().split(',').join('');


	var store_id = $('#stores').val();
	var store_name = $('#stores :selected').text();
	var phi_phat_sinh = $("input[name='phi_phat_sinh']").val();
	var count_transaction_not_yet_approve = $("#count-status-not-yet-approve").val();
	console.log(count_transaction_not_yet_approve);
	var formData = {
		code_contract: code_contract,
		payment_name: payment_name,
		fee_need_gh_cc: fee_need_gh_cc,
		relative_with_contract_owner: relative_with_contract_owner,
		payment_phone: payment_phone,
		payment_amount: payment_amount,
		payment_method: payment_method,
		payment_note: payment_note,
		penalty_pay: penalty_pay,
		reduced_fee: reduced_fee,
		discounted_fee: discounted_fee,
		other_fee: other_fee,
		fee_reduction: total_deductible, //Tổng phí giảm trừ
		valid_amount_payment: valid_amount_payment,
		date_pay: date_pay,
		store_id: store_id,
		store_name: store_name,
		phi_phat_sinh: phi_phat_sinh,
		type_payment: type_payment,
		amount_debt_cc: amount_debt_cc,
		amount_cc: amount_cc,

	};
	// console.log(formData);
	if (count_transaction_not_yet_approve > 0) {
		var confirm_payment_event = confirm(`Đã tồn tại  ${count_transaction_not_yet_approve}  phiếu thu thanh toán chưa duyệt. Nếu tạo tiếp phiếu thu của PGD sẽ tăng lên. Bạn có chắc chắn muốn tạo?`);
		if (confirm_payment_event == true) {
			$.ajax({
				url :  _url.base_url + 'contract_ksnb/doPayment',
				type: "POST",
				data : formData,
				dataType : 'json',
				beforeSend: function(){$("#loading").show();},
				success: function(data) {
					$("#loading").hide();
					if(data.status == 200){
						$("input[name='code_contract']").val("");
						$("input[name='payment_name']").val("");
						$("input[name='payment_phone']").val("");
						$("input[name='payment_amount']").val("");
						$("#payment_note").val("");
						$("#successModal").modal("show");
						$(".msg_success").text(data.msg);
						if(payment_method == 1) {
							$(".msg_success").text("Tạo biên nhận thành công!");
							// window.open(_url.base_url +data.url_printed, '_blank');
							window.location.href = _url.base_url +data.url;
						} else if (payment_method == 2) {
							$(".msg_success").text("Hình thức chuyển khoản chỉ cần upload chi tiết giao dịch chuyển khoản!");
							window.location.href = _url.base_url +data.url;
						}
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
		} else {
			window.location.href = _url.base_url + 'contract_ksnb/view?id=' + data.transaction_id;
		}
	} else {
		var confirm_payment_event_real = confirm(`Xác nhận thanh toán?`);
		if (confirm_payment_event_real == true) {
			$.ajax({
				url :  _url.base_url + 'contract_ksnb/doPayment',
				type: "POST",
				data : formData,
				dataType : 'json',
				beforeSend: function(){$("#loading").show();},
				success: function(data) {
					$("#loading").hide();
					if(data.status == 200){
						$("input[name='code_contract']").val("");
						$("input[name='payment_name']").val("");
						$("input[name='payment_phone']").val("");
						$("input[name='payment_amount']").val("");
						$("#payment_note").val("");
						$("#successModal").modal("show");
						$(".msg_success").text(data.msg);
						if(payment_method == 1) {
							$(".msg_success").text("Tạo biên nhận thành công!");
							// window.open(_url.base_url +data.url_printed, '_blank');
							window.location.href = _url.base_url +data.url;
						} else if (payment_method == 2) {
							$(".msg_success").text("Tạo thanh toán thành công!!");
							window.location.href = _url.base_url +data.url;
						}
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
		} else {
			window.location.href = _url.base_url + 'contract_ksnb/view?id=' + data.transaction_id;
		}

	}

});

$("#confirm_finish_contract").click(function(event) {
	event.preventDefault();
	var phi_phat_sinh = $("input[name='phi_phat_sinh']").val();
	var code_contract = $("input[name='code_contract_finish']").val();
	var payment_name = $("input[name='payment_name_finish']").val();
	var relative_with_contract_owner_finish = $("input[name='relative_with_contract_owner_finish']").val();
	var payment_phone = $("input[name='payment_phone_finish']").val();
	var payment_amount =  $("input[name='payment_amount_finish']").val().split(',').join('');
	var payment_method = $("input[name='payment_method_finish']:checked").val();
	var payment_note = array_note;
	var date_pay = $("#date_pay_finish").val();
	var store_id = $('#stores_finish').val();
	var store_name = $('#stores_finish :selected').text();
	var penalty_pay = $("#penalty_pay_finish").text().split(',').join('');
	var reduced_fee = $("input[name='reduced_fee_finish']").val().split(',').join('');
	var discounted_fee = $("input[name='discounted_fee_finish']").val().split(',').join('');
	var other_fee = $("input[name='other_fee_finish']").val().split(',').join('');
	var total_deductible = $("#total_deductible_finish").text().split(',').join('');
	var valid_amount_payment = $(".valid_amount_payment_finish").text().split(',').join('');


	var formData = {
		code_contract: code_contract,
		payment_name: payment_name,
		relative_with_contract_owner_finish: relative_with_contract_owner_finish,
		payment_phone: payment_phone,
		payment_amount: payment_amount,
		fee_reduction: total_deductible,

		penalty_pay: penalty_pay,
		reduced_fee: reduced_fee,
		discounted_fee: discounted_fee,
		other_fee: other_fee,
		valid_amount_payment: valid_amount_payment,
		date_pay: date_pay,

		payment_method: payment_method,
		payment_note: payment_note,
		store_id: store_id,
		store_name: store_name,
		phi_phat_sinh: phi_phat_sinh
	};
	console.log(formData);
	var confirm_payment_finish_event_real = confirm(`Xác nhận tất toán?`);
	if (confirm_payment_finish_event_real == true) {
		$.ajax({
			url: _url.base_url + 'accountant/doFinishContract',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				$("#loading").hide();
				if (data.status == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					if (payment_method == 1) {
						$(".msg_success").text("Tạo biên nhận thành công!");
						window.open(_url.base_url + data.url_printed, '_blank');
						window.location.href = _url.base_url + data.url;
					} else if (payment_method == 2) {
						$(".msg_success").text("Tạo tất toán thành công!");
						window.location.href = _url.base_url + data.url;
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
	} else {
		window.location.href = _url.base_url + 'accountant/view?id=' + data.transaction_id;
	}
});
//thanh toán
$('.amount_debt_cc').on('input', function(e){
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){
	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});
$('.amount_cc').on('input', function(e){
	var type_payment =$("input[type=radio][name=type_payment]:checked").val();
	if(type_payment==3)
	{
		var payment_amount = $(".payment_amount").val().split(',').join('');
		var valid_amount_payment = $(".valid_amount_payment").text().split(',').join('');
		var amount_debt_cc = getFloat_pay(valid_amount_payment) - getFloat_pay(this.value)  -getFloat_pay(payment_amount);
		if(amount_debt_cc< 0 )
		{
			$("#errorModal").modal("show");
			$(".msg_error").text("Đóng cơ cấu thừa!");
			setTimeout(function(){
				location.reload();
			}, 3000);
		}
		$(".amount_debt_cc").val(numeral(amount_debt_cc).format('0,0'));
	}
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){
	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});
$('.payment_amount').on('input', function(e){
	var type_payment =$("input[type=radio][name=type_payment]:checked").val();
	if(type_payment==3)
	{
		var amount_cc = $(".amount_cc").val().split(',').join('');
		var valid_amount_payment = $(".valid_amount_payment").text().split(',').join('');
		var amount_debt_cc = getFloat_pay(valid_amount_payment) - getFloat_pay(this.value)  -getFloat_pay(amount_cc);
		if(amount_debt_cc< 0 )
		{
			$("#errorModal").modal("show");
			$(".msg_error").text("Đóng cơ cấu thừa!");
			setTimeout(function(){
				location.reload();
			}, 3000);
		}
		$(".amount_debt_cc").val(numeral(amount_debt_cc).format('0,0'));
	}
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){
	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});
$('.payment_amount_finish').on('input', function(e){
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){
	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.other_fee').on('input', function(e){
	var total_money_paid = $(".total_money_paid").text().split(',').join('');
	var reduced_fee = $(".reduced_fee").val().split(',').join('');
	var discounted_fee = $(".discounted_fee").val().split(',').join('');
	$("#total_deductible").text(numeral(getFloat_pay(this.value)  +getFloat_pay(reduced_fee)+getFloat_pay(discounted_fee)).format('0,0'));
	var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(reduced_fee)-getFloat_pay(discounted_fee);
	if(valid_amount_payment<= 0 )
	{
		$("#errorModal").modal("show");
		$(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
		setTimeout(function(){
			location.reload();
		}, 3000);
	}
	$(".valid_amount_payment").text(numeral(valid_amount_payment).format('0,0'));
	var type_payment =$("input[type=radio][name=type_payment]:checked").val();
	if(type_payment==3)
	{
		$('.payment_amount').val(0);
		$('.amount_cc').val(0);
		$('.amount_debt_cc').val(numeral(valid_amount_payment).format('0,0'));
	}
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){

	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.discounted_fee').on('input', function(e){
	var total_money_paid = $(".total_money_paid").text();
	var reduced_fee = $(".reduced_fee").val();
	var other_fee = $(".other_fee").val();
	$("#total_deductible").text(numeral(getFloat_pay(this.value)  +getFloat_pay(reduced_fee)+getFloat_pay(other_fee)).format('0,0'));
	var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(reduced_fee)-getFloat_pay(other_fee);
	if(valid_amount_payment<= 0 )
	{
		$("#errorModal").modal("show");
		$(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
		setTimeout(function(){
			location.reload();
		}, 3000);
	}
	$(".valid_amount_payment").text(numeral(valid_amount_payment).format('0,0'));
	var type_payment =$("input[type=radio][name=type_payment]:checked").val();
	if(type_payment==3)
	{
		$('.payment_amount').val(0);
		$('.amount_cc').val(0);
		$('.amount_debt_cc').val(numeral(valid_amount_payment).format('0,0'));
	}
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){

	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.reduced_fee').on('input', function(e){
	var total_money_paid = $(".total_money_paid").text();
	var other_fee = $(".other_fee").val();
	var discounted_fee = $(".discounted_fee").val();
	$("#total_deductible").text(numeral(getFloat_pay(this.value)  +getFloat_pay(other_fee)+getFloat_pay(discounted_fee)).format('0,0'));
	var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(other_fee)-getFloat_pay(discounted_fee);
	if(valid_amount_payment<= 0 )
	{
		$("#errorModal").modal("show");
		$(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
		setTimeout(function(){
			location.reload();
		}, 3000);
	}
	$(".valid_amount_payment").text(numeral(valid_amount_payment).format('0,0'));
	var type_payment =$("input[type=radio][name=type_payment]:checked").val();
	if(type_payment==3)
	{
		$('.payment_amount').val(0);
		$('.amount_cc').val(0);
		$('.amount_debt_cc').val(numeral(valid_amount_payment).format('0,0'));
	}
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){

	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});


$('.fee_reduction').on('input', function(e){
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){
	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

//tất toán

$('.payment_amount_finish').on('input', function(e){

	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){
	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.other_fee_finish').on('input', function(e){
	var total_money_paid = $(".total_money_paid_finish").text().split(',').join('');
	var reduced_fee = $(".reduced_fee_finish").val().split(',').join('');
	var discounted_fee = $(".discounted_fee_finish").val().split(',').join('');
	$("#total_deductible_finish").text(numeral(getFloat_pay(this.value)  +getFloat_pay(reduced_fee)+getFloat_pay(discounted_fee)).format('0,0'));
	var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(reduced_fee)-getFloat_pay(discounted_fee);
	if(valid_amount_payment<= 0 )
	{
		$("#errorModal").modal("show");
		$(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
		setTimeout(function(){
			location.reload();
		}, 3000);
	}
	$(".valid_amount_payment_finish").text(numeral(valid_amount_payment).format('0,0'));
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){

	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.discounted_fee_finish').on('input', function(e){
	var total_money_paid = $(".total_money_paid_finish").text();
	var reduced_fee = $(".reduced_fee_finish").val();
	var other_fee = $(".other_fee_finish").val();
	$("#total_deductible_finish").text(numeral(getFloat_pay(this.value)  +getFloat_pay(reduced_fee)+getFloat_pay(other_fee)).format('0,0'));
	var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(reduced_fee)-getFloat_pay(other_fee);
	if(valid_amount_payment<= 0 )
	{
		$("#errorModal").modal("show");
		$(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
		setTimeout(function(){
			location.reload();
		}, 3000);
	}
	$(".valid_amount_payment_finish").text(numeral(valid_amount_payment).format('0,0'));
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){

	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.reduced_fee_finish').on('input', function(e){
	var total_money_paid = $(".total_money_paid_finish").text();
	var other_fee = $(".other_fee_finish").val();
	var discounted_fee = $(".discounted_fee_finish").val();
	$("#total_deductible_finish").text(numeral(getFloat_pay(this.value)  +getFloat_pay(other_fee)+getFloat_pay(discounted_fee)).format('0,0'));
	var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(other_fee)-getFloat_pay(discounted_fee);
	if(valid_amount_payment<= 0 )
	{
		$("#errorModal").modal("show");
		$(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
		setTimeout(function(){
			location.reload();
		}, 3000);
	}
	$(".valid_amount_payment_finish").text(numeral(valid_amount_payment).format('0,0'));
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){

	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});


$('.fee_reduction_finish').on('input', function(e){
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){
	if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});


function formatCurrency(number){
	var n = number.split('').reverse().join("");
	var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
	return  n2.split('').reverse().join('');
}
var isEmpty = function(data) {
	if(typeof(data) === 'object'){
		if(JSON.stringify(data) === '{}' || JSON.stringify(data) === '[]'){
			return true;
		}else if(!data){
			return true;
		}
		return false;
	}else if(typeof(data) === 'string'){
		if(!data.trim()){
			return true;
		}
		return false;
	}else if(typeof(data) === 'undefined'){
		return true;
	}else{
		return false;
	}
}
function getFloat_pay(val) {
	var val_c =(isEmpty(val)) ? 0 : val.replace(/,/g,"");

	return parseFloat(val_c);
}
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
				$('.code_coupon').val(data.data.loan_infor.code_coupon);

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
	});

}

$('input[type=radio][name=type_payment]').change(function() {
	$("input[name='amount_cc']").val(0);
	$("input[name='payment_amount']").val(0);
	var type_payment =this.value;
	if(type_payment>=2)
	{
		if(type_payment==2)
		{
			$('.debt_cc').hide();
			$('.tr_amount_cc').hide();
		}
		if(type_payment==3)
		{
			$('.debt_cc').show();
			$('.tr_amount_cc').show();
		}
		var phi_gia_han=0;

		phi_gia_han=200000;
		var id_contract = $("#id_contract").val();
		var date_pay_gh_cc = $("#date_pay").val();
		var formData = {
			date_pay: date_pay_gh_cc,
			id_contract: id_contract
		};

		$.ajax({
			url :  _url.base_url + 'accountant/check_date_pay_finish',
			type: "POST",
			data : formData,
			dataType : 'json',
			beforeSend: function(){$("#loading").show();},
			success: function(data) {
				console.log(data);
				$("#loading").hide();
				if(data.status == 200){
					if(type_payment==2)
					{
						var tien_lai = parseInt(data.data.dataTatToanPart2.lai_chua_tra_qua_han);
						var tien_phi = parseInt(data.data.dataTatToanPart2.phi_chua_tra_qua_han);
					}
					if(type_payment==3)
					{
						var tien_lai = parseInt(data.data.dataTatToanPart2.lai_chua_tra_co_cau);
						var tien_phi = parseInt(data.data.dataTatToanPart2.phi_chua_tra_co_cau);
						var tien_goc = parseInt(data.data.dataTatToanPart2.goc_chua_tra_co_cau);
					}

					var phi_phat_cham_tra =  parseInt(data.data.contract.penalty_pay);
					var phi_phat_sinh =  parseInt(data.data.contract.phi_phat_sinh);
					var tong_can_gh_cc = 0;
					if(type_payment==2)
					{
						tong_can_gh_cc = phi_phat_cham_tra + tien_lai + tien_phi +phi_phat_sinh+phi_gia_han;
					}
					if(type_payment==3)
					{
						tong_can_gh_cc = tien_goc + phi_phat_cham_tra + tien_lai + tien_phi +phi_phat_sinh;
					}

					$("input[name='fee_need_gh_cc']").val(tong_can_gh_cc);
					$(".amount_debt_cc").val(numeral(tong_can_gh_cc).format('0,0'));
					// $(".expected_money").text("Số tiền lãi phí cần đóng để thực hiện gia hạn/cơ cấu: "+numeral(tong_can_gh_cc).format('0,0'));
					$(".total_money_paid").text(numeral(tong_can_gh_cc).format('0,0'));
					$(".valid_amount_payment").text(numeral(tong_can_gh_cc).format('0,0'));
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function(){
						$("#successModal").modal("hide");
					}, 3000);

				}else{
					$('#errorModal').modal('show');
					$('.msg_error').text(data.msg);
					$('#confirm_payment').hide();
					setTimeout(function(){
						location.reload();
					}, 3000);
				}
			},
			error: function(data) {
				console.log(data);
				$("#loading").hide();
			}
		});
	}else{
		$('.debt_cc').hide();
		$('.tr_amount_cc').hide();
		var date_pay_gh_cc = $("#date_pay").val();
		var id_contract = $("#id_contract").val();
		$(".expected_money").text("");
		var formData = {
			date_pay: date_pay_gh_cc,
			id_contract: id_contract
		};

		$.ajax({
			url :  _url.base_url + 'accountant/check_date_pay',
			type: "POST",
			data : formData,
			dataType : 'json',
			beforeSend: function(){$("#loading").show();},
			success: function(data) {
				console.log(data);
				$("#loading").hide();
				if(data.status == 200){
					$(".reduced_fee").val('0');
					$(".discounted_fee").val('0');
					$(".other_fee").val('0');
					$(".total_money_paid").text(numeral(parseInt(data.data.total_money_paid)).format('0,0'));
					$(".difference_day_payment").text(numeral(parseInt(data.data.difference_day_payment)).format('0,0'));
					$(".actual_difference_payment").text(numeral(parseInt(data.data.actual_difference_payment)).format('0,0'));
					$("#penalty_pay").text(numeral(parseInt(data.data.penalty_pay)).format('0,0'));
					$(".valid_amount_payment").text(numeral(parseInt(data.data.total_money_paid)).format('0,0'));
					$(".ky_cham_tra_top").text(numeral(parseInt(data.data.ky_cham_tra)).format('0,0'));
					$(".total_money_paid_pay_top").text(numeral(parseInt(data.data.total_money_paid)).format('0,0'));
					$(".penalty_top").text(numeral(parseInt(data.data.penalty_pay)).format('0,0'));
					$(".tong_thanh_toan_top").text(numeral(parseInt(data.data.tong_thanh_toan)).format('0,0'));
					$(".tong_da_thanh_toan_top").text(numeral(parseInt(data.data.total_paid)).format('0,0'));
					$(".tong_con_no_top").text(numeral(parseInt(data.data.tong_thanh_toan-data.data.total_paid)).format('0,0'));
					$(".so_tien_phat_sinh_top").text(numeral(parseInt(data.data.phi_phat_sinh)).format('0,0'));
					$(".total_money_paid_pay_top").text(numeral(parseInt(data.data.total_money_paid)).format('0,0'));
					$("#tien_qua_han").text(numeral(parseInt(data.data.phi_phat_sinh)).format('0,0'));
					// var $radios = $('input:radio[name=type_payment]');
					//  $radios.filter('[value=1]').prop('checked', true);
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function(){
						$("#successModal").modal("hide");
					}, 3000);

				}else{
					$('#errorModal').modal('show');
					$('.msg_error').text(data.msg);
					$('#confirm_payment').hide();
					setTimeout(function(){
						location.reload();
					}, 3000);
				}
			},
			error: function(data) {
				console.log(data);
				$("#loading").hide();
			}
		});

	}

});
