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
				$input = $('<input type="checkbox" name="' + $select.attr('name').replace('[]', '') + '[]" value="' + option.value + '">');
			} else {
				$input = $('<input type="radio" name="' + $select.attr('name') + '" value="' + option.value + '">');
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
$(document).ready(function () {
	var status = ["21", "22", "24", "19", "23"];
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
$("#tab003").click(function (event) {
	event.preventDefault();
	var so_ngay_qua_han = $("input[name='so_ngay_qua_han']").val();
	if (so_ngay_qua_han > 0) {
		$("#errorModal").modal("show");
		$(".msg_error").text("Đã đến kỳ tất toán, nếu khách hàng đã đóng đủ bạn cần chọn tab tất toán");
		// setTimeout(function(){
		//             location.reload();
		//             }, 3000);
	}
});
$("#confirm_payment").click(function (event) {
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
	var fee_need_gh_cc = $("input[name='fee_need_gh_cc']").val().split(',').join('');
	var payment_note = array_note;
	var amount_debt_cc = $("input[name='amount_debt_cc']").val().split(',').join('');
	var amount_cc = $("input[name='amount_cc']").val().split(',').join('');
	var id_exemption = $("input[name='id_exemption']").val();
	var ky_tra_hien_tai = $("#ky_tra_hien_tai").val();
	var ngay_den_han = $("#ngay_den_han").val();

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
		ky_tra_hien_tai: ky_tra_hien_tai,
		ngay_den_han: ngay_den_han,
		id_exemption: id_exemption,

	};
	// console.log(formData);
	if (count_transaction_not_yet_approve > 0) {
		var confirm_payment_event = confirm(`Đã tồn tại  ${count_transaction_not_yet_approve}  phiếu thu thanh toán chưa duyệt. Nếu tạo tiếp phiếu thu của PGD sẽ tăng lên. Bạn có chắc chắn muốn tạo?`);
		if (confirm_payment_event == true) {
			$.ajax({
				url: _url.base_url + 'accountant/doPayment',
				type: "POST",
				data: formData,
				dataType: 'json',
				beforeSend: function () {
					$("#loading").show();
				},
				success: function (data) {
					$("#loading").hide();
					if (data.status == 200) {
						$("input[name='code_contract']").val("");
						$("input[name='payment_name']").val("");
						$("input[name='payment_phone']").val("");
						$("input[name='payment_amount']").val("");
						$("#payment_note").val("");
						$("#successModal").modal("show");
						$(".msg_success").text(data.msg);
						if (payment_method == 1) {
							$(".msg_success").text("Tạo biên nhận thành công!");
							window.open(_url.base_url + data.url_printed, '_blank');
							window.location.href = _url.base_url + data.url;
						} else if (payment_method == 2) {
							$(".msg_success").text("Hình thức chuyển khoản chỉ cần upload chi tiết giao dịch chuyển khoản!");
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
	} else {
		var confirm_payment_event_real = confirm(`Xác nhận thanh toán?`);
		if (confirm_payment_event_real == true) {
			$.ajax({
				url: _url.base_url + 'accountant/doPayment',
				type: "POST",
				data: formData,
				dataType: 'json',
				beforeSend: function () {
					$("#loading").show();
				},
				success: function (data) {
					$("#loading").hide();
					if (data.status == 200) {
						$("input[name='code_contract']").val("");
						$("input[name='payment_name']").val("");
						$("input[name='payment_phone']").val("");
						$("input[name='payment_amount']").val("");
						$("#payment_note").val("");
						$("#successModal").modal("show");
						$(".msg_success").text(data.msg);
						if (payment_method == 1) {
							$(".msg_success").text("Tạo biên nhận thành công!");
							window.open(_url.base_url + data.url_printed, '_blank');
							window.location.href = _url.base_url + data.url;
						} else if (payment_method == 2) {
							$(".msg_success").text("Tạo thanh toán thành công!!");
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

	}

});

$("#confirm_finish_contract").click(function (event) {
	event.preventDefault();
	var phi_phat_sinh = $("input[name='phi_phat_sinh']").val();
	var code_contract = $("input[name='code_contract_finish']").val();
	var payment_name = $("input[name='payment_name_finish']").val();
	var relative_with_contract_owner_finish = $("input[name='relative_with_contract_owner_finish']").val();
	var payment_phone = $("input[name='payment_phone_finish']").val();
	var payment_amount = $("input[name='payment_amount_finish']").val().split(',').join('');
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
	var id_exemption = $("input[name='id_exemption_finish']").val();


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
		phi_phat_sinh: phi_phat_sinh,
		id_exemption: id_exemption
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

// tat toan hop dong thanh ly tai san
$("#confirm_finish_liquidations_contract").click(function (event) {
	event.preventDefault();
	var phi_phat_sinh = $("input[name='phi_phat_sinh_liquidations']").val();
	var code_contract = $("input[name='code_contract_finish_liquidations']").val();
	var payment_name = $("input[name='payment_name_finish_liquidations']").val();
	var payment_amount = $("input[name='payment_amount_finish_liquidations']").val().split(',').join('');
	var payment_method = $("input[name='payment_method_finish_liquidations']:checked").val();
	var payment_note = $("input[name='payment_note_liquidations']").val();
	var date_pay = $("#date_pay_finish_liquidations").val();
	var store_id = $('#stores_finish_liquidations').val();
	var store_name = $('#stores_finish_liquidations :selected').text();
	var penalty_pay = $("#penalty_pay_finish_liquidations").text().split(',').join('');
	var reduced_fee = $("input[name='reduced_fee_finish_liquidations']").val().split(',').join('');
	var discounted_fee = $("input[name='discounted_fee_finish_liquidations']").val().split(',').join('');
	var other_fee = $("input[name='other_fee_finish_liquidations']").val().split(',').join('');
	var total_deductible = $("#total_deductible_finish_liquidations").val().split(',').join('');
	var valid_amount_payment = $(".valid_amount_payment_finish_liquidations").val().split(',').join('');
	var fee_sold_liquidation = $("input[name='fee_sold_finish_liquidations']").val().split(',').join('');
	var amount_payment_finish_system = $("input[name='amount_payment_finish_system']").val().split(',').join('');


	var formData = {
		code_contract: code_contract,
		payment_name: payment_name,
		payment_amount: payment_amount,
		fee_reduction: discounted_fee,
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
		phi_phat_sinh: phi_phat_sinh,
		fee_sold_liquidation: fee_sold_liquidation,
		amount_payment_finish_system: amount_payment_finish_system,
	};
	console.log(formData);
	var confirm_payment_finish_event_real = confirm(`Xác nhận tất toán?`);
	if (confirm_payment_finish_event_real == true) {
		$.ajax({
			url: _url.base_url + 'accountant/doFinishContractLiquidations',
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
					$(".msg_success").text("Tạo tất toán thành công!");
					window.location.href = _url.base_url + data.url;
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
$('.amount_debt_cc').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});
$('.amount_cc').on('input', function (e) {
	var type_payment = $("input[type=radio][name=type_payment]:checked").val();
	if (type_payment == 3) {
		var payment_amount = $(".payment_amount").val().split(',').join('');
		var valid_amount_payment = $(".valid_amount_payment").text().split(',').join('');
		var amount_debt_cc = getFloat_pay(valid_amount_payment) - getFloat_pay(this.value) - getFloat_pay(payment_amount);

		$(".amount_debt_cc").val(numeral(amount_debt_cc).format('0,0'));
	}
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});
$('.payment_amount').on('input', function (e) {
	var type_payment = $("input[type=radio][name=type_payment]:checked").val();
	if (type_payment == 3) {
		var amount_cc = $(".amount_cc").val().split(',').join('');
		var valid_amount_payment = $(".valid_amount_payment").text().split(',').join('');
		var amount_debt_cc = getFloat_pay(valid_amount_payment) - getFloat_pay(this.value) - getFloat_pay(amount_cc);

		$(".amount_debt_cc").val(numeral(amount_debt_cc).format('0,0'));
	}
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});
$('.payment_amount_finish').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.other_fee').on('input', function (e) {
	// var total_money_paid = $(".total_money_paid").text().split(',').join('');
	// var reduced_fee = $(".reduced_fee").val().split(',').join('');
	//  var discounted_fee = $(".discounted_fee").val().split(',').join('');
	//
	// $("#total_deductible").text(numeral(getFloat_pay(this.value)  +getFloat_pay(reduced_fee)+getFloat_pay(discounted_fee)).format('0,0'));
	// var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(reduced_fee)-getFloat_pay(discounted_fee);
	//  if(valid_amount_payment<= 0 )
	//  {
	// $("#errorModal").modal("show");
	// $(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
	// setTimeout(function(){
	//                 location.reload();
	//             }, 3000);
	// }
	// $(".valid_amount_payment").text(numeral(valid_amount_payment).format('0,0'));
	//  var type_payment =$("input[type=radio][name=type_payment]:checked").val();
	//    if(type_payment==3)
	//    {
	// $('.payment_amount').val(0);
	//  var amount_cc = $(".amount_cc").val().split(',').join('');
	// $('.amount_debt_cc').val(numeral(valid_amount_payment-amount_cc).format('0,0'));
	// }
	// $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress', function (e) {

	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.discounted_fee').on('input', function (e) {
	//   var total_money_paid = $(".total_money_paid").text();
	//  var reduced_fee = $(".reduced_fee").val();
	//  var other_fee = $(".other_fee").val();
	//
	//   $("#total_deductible").text(numeral(getFloat_pay(this.value)  +getFloat_pay(reduced_fee)+getFloat_pay(other_fee)).format('0,0'));
	//  var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(reduced_fee)-getFloat_pay(other_fee);
	//   if(valid_amount_payment<= 0 )
	//   {
	//  $("#errorModal").modal("show");
	//  $(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
	//  setTimeout(function(){
	//                  location.reload();
	//              }, 3000);
	//  }
	//  $(".valid_amount_payment").text(numeral(valid_amount_payment).format('0,0'));
	//   var type_payment =$("input[type=radio][name=type_payment]:checked").val();
	//     if(type_payment==3)
	//     {
	//  $('.payment_amount').val(0);
	// var amount_cc = $(".amount_cc").val().split(',').join('');
	//  $('.amount_debt_cc').val(numeral(valid_amount_payment-amount_cc).format('0,0'));
	//  }
	//  $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress', function (e) {

	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.reduced_fee').on('input', function (e) {
//     var total_money_paid = $(".total_money_paid").text();
//     var other_fee = $(".other_fee").val();
//      var discounted_fee = $(".discounted_fee").val();
// $("#total_deductible").text(numeral(getFloat_pay(this.value)  +getFloat_pay(other_fee)+getFloat_pay(discounted_fee)).format('0,0'));
//     var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(other_fee)-getFloat_pay(discounted_fee);
//      if(valid_amount_payment<= 0 )
//      {
//     $("#errorModal").modal("show");
//     $(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
//     setTimeout(function(){
//                 location.reload();
//                 }, 3000);
//     }
//     $(".valid_amount_payment").text(numeral(valid_amount_payment).format('0,0'));
//      var type_payment =$("input[type=radio][name=type_payment]:checked").val();
//        if(type_payment==3)
//        {
//     $('.payment_amount').val(0);
//   var amount_cc = $(".amount_cc").val().split(',').join('');
//     $('.amount_debt_cc').val(numeral(valid_amount_payment-amount_cc).format('0,0'));
//     }
//     $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress', function (e) {

	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});


$('.fee_reduction').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

//tất toán

$('.payment_amount_finish').on('input', function (e) {

	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.other_fee_finish').on('input', function (e) {
	// var total_money_paid = $(".total_money_paid_finish").text().split(',').join('');
	// var reduced_fee = $(".reduced_fee_finish").val().split(',').join('');
	//  var discounted_fee = $(".discounted_fee_finish").val().split(',').join('');
	// $("#total_deductible_finish").text(numeral(getFloat_pay(this.value)  +getFloat_pay(reduced_fee)+getFloat_pay(discounted_fee)).format('0,0'));
	// var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(reduced_fee)-getFloat_pay(discounted_fee);
	//  if(valid_amount_payment<= 0 )
	//  {
	// $("#errorModal").modal("show");
	// $(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
	// setTimeout(function(){
	//                 location.reload();
	//             }, 3000);
	// }
	// $(".valid_amount_payment_finish").text(numeral(valid_amount_payment).format('0,0'));
	// $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress', function (e) {

	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.discounted_fee_finish').on('input', function (e) {
	//  var total_money_paid = $(".total_money_paid_finish").text();
	// var reduced_fee = $(".reduced_fee_finish").val();
	// var other_fee = $(".other_fee_finish").val();
	//  $("#total_deductible_finish").text(numeral(getFloat_pay(this.value)  +getFloat_pay(reduced_fee)+getFloat_pay(other_fee)).format('0,0'));
	// var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(reduced_fee)-getFloat_pay(other_fee);
	//  if(valid_amount_payment<= 0 )
	//  {
	// $("#errorModal").modal("show");
	// $(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
	// setTimeout(function(){
	//                 location.reload();
	//             }, 3000);
	// }
	// $(".valid_amount_payment_finish").text(numeral(valid_amount_payment).format('0,0'));
	// $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress', function (e) {

	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('.reduced_fee_finish').on('input', function (e) {
//     var total_money_paid = $(".total_money_paid_finish").text();
//     var other_fee = $(".other_fee_finish").val();
//      var discounted_fee = $(".discounted_fee_finish").val();
// $("#total_deductible_finish").text(numeral(getFloat_pay(this.value)  +getFloat_pay(other_fee)+getFloat_pay(discounted_fee)).format('0,0'));
//     var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(this.value)  -getFloat_pay(other_fee)-getFloat_pay(discounted_fee);
//      if(valid_amount_payment<= 0 )
//      {
//     $("#errorModal").modal("show");
//     $(".msg_error").text("Phí giảm trừ không được lớn hơn số tiền cần thanh toán");
//     setTimeout(function(){
//                 location.reload();
//                 }, 3000);
//     }
//     $(".valid_amount_payment_finish").text(numeral(valid_amount_payment).format('0,0'));
//     $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress', function (e) {

	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});


$('.fee_reduction_finish').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});
$('#date_pay').on('keypress', function (e) {
	e.preventDefault();
});
$('#date_pay_finish').on('keypress', function (e) {
	e.preventDefault();
});

function formatCurrency(number) {
	var n = number.split('').reverse().join("");
	var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
	return n2.split('').reverse().join('');
}

var isEmpty = function (data) {
	if (typeof (data) === 'object') {
		if (JSON.stringify(data) === '{}' || JSON.stringify(data) === '[]') {
			return true;
		} else if (!data) {
			return true;
		}
		return false;
	} else if (typeof (data) === 'string') {
		if (!data.trim()) {
			return true;
		}
		return false;
	} else if (typeof (data) === 'undefined') {
		return true;
	} else {
		return false;
	}
}

function getFloat_pay(val) {
	var val_c = (isEmpty(val)) ? 0 : val.replace(/,/g, "");

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
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
				$(".percent_interest_customer").val(data.data.fee.percent_interest_customer);
				$(".percent_advisory").val(data.data.fee.percent_advisory);
				$(".percent_expertise").val(data.data.fee.percent_expertise);
				$(".penalty_percent").val(data.data.fee.penalty_percent);
				$(".penalty_amount").val(numeral(data.data.fee.penalty_amount).format('0,0'));
				$(".extend").val(numeral(data.data.fee.extend).format('0,0'));
				$(".extend_new_three").val(numeral(data.data.fee.extend_new_three).format('0,0'));
				$(".extend_new_five").val(numeral(data.data.fee.extend_new_five).format('0,0'));
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
		error: function (error) {
			console.log(error);
		}
	});

}

function edit_coupon_bhkv(thiz) {
	let contract_id = $(thiz).data("id");
	var formData = {
		id: contract_id
	};
	//Call ajax
	$.ajax({
		url: _url.base_url + "pawn/getOne_cc",
		type: "POST",
		data: formData,
		dataType: 'json',
		success: function (data) {
			if (data.code == 200) {
				$(".approve_note").val(data.data.approve_coupon_bhkv.approve_note);
				var content = "";
				for (x in data.data.approve_coupon_bhkv.image_file) {
					if (data.data.approve_coupon_bhkv.image_file[x]['file_type'] == "application/pdf") {
						content += '<div class="block"><a target="_blank" href="' + data.data.approve_coupon_bhkv.image_file[x]['path'] + '" ><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img style="width: 50%;transform: translateX(50%)translateY(-50%);" data-type="img_file" data-fileType="' + data.data.approve_coupon_bhkv.image_file[x]['file_type'] + '"  data-fileName="' + data.data.approve_coupon_bhkv.image_file[x]['file_name'] + '" name="img_transaction"  data-key="' + x + '" src="' + data.logs.new.image_file[x]['path'] + '" />';
						content += '<img  style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">';
						content += '</a></div>';
					} else {
						content += '<div class="block"><a href="' + data.data.approve_coupon_bhkv.image_file[x]['path'] + '" class="magnifyitem" data-magnify="gallery" data-src="" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery"><button type="button" onclick="deleteImage(this)"  data-type="img_file"  class="cancelButton "><i class="fa fa-times-circle"></i></button>';
						content += '<img data-type="img_file" data-fileType="' + data.data.approve_coupon_bhkv.image_file[x]['file_type'] + '"  data-fileName="' + data.data.approve_coupon_bhkv.image_file[x]['file_name'] + '" name="img_transaction"  data-key="' + x + '" src="' + data.data.approve_coupon_bhkv.image_file[x]['path'] + '" />';
						content += '</a></div>';
					}
				}
			}
			$('#uploads_img_file_cc').empty();
			$('#uploads_img_file_cc').append(content);
		}


	});
	$(".contract_id_cp_bhkv").val(contract_id);
	$("#editCouponbhkv").modal("show");

}

$('input[type=radio][name=type_payment]').change(function () {

	$("input[name='amount_cc']").val(0);
	$("input[name='payment_amount']").val(0);
	var type_payment = this.value;
	$("#date_pay").attr('disabled', false);
	if (type_payment >= 2) {
		if (type_payment == 2) {

			$('.debt_cc').hide();
			$('.tr_amount_cc').hide();
		}
		if (type_payment == 3) {
			//$("#date_pay").attr('disabled', true);
			$('.debt_cc').show();
			$('.tr_amount_cc').show();
		}

		var id_contract = $("#id_contract").val();
		var date_pay_gh_cc = $("#date_pay").val();
		var formData = {
			date_pay: date_pay_gh_cc,
			id_contract: id_contract,
			type_payment: type_payment
		};

		$.ajax({
			url: _url.base_url + 'accountant/check_date_pay_finish',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				console.log(data);
				$("#loading").hide();
				if (data.status == 200) {
					var tien_giam_tru = getFloat_pay($(".discounted_fee").val());
					if (type_payment == 2) {
						//thay thế hàm làm tròn từ parseInt (số 3.7...E ^ -17 sẽ làm tròn thành 3) => Math.round (số 3.7...E ^ -17 sẽ làm tròn thành 0)
						var tien_lai = Math.round(data.data.dataTatToanPart2.lai_chua_tra_qua_han);
						var tien_phi = Math.round(data.data.dataTatToanPart2.phi_chua_tra_qua_han);
					}
					var tien_thua_thanh_toan = Math.round(data.data.contract.tien_thua_thanh_toan);
					if (type_payment == 3) {
						var du_no_con_lai = Math.round(data.data.dataTatToanPart1.du_no_con_lai);
						var tien_chua_tra_ky_thanh_toan = Math.round(data.data.contract.tien_chua_tra_ky_thanh_toan);
						var tien_du_ky_truoc = Math.round(data.data.contract.tien_du_ky_truoc);

						var phi_phat_tat_toan_truoc_han = Math.round(data.data.debtData.phi_thanh_toan_truoc_han);
					}
					phi_phat_tat_toan_truoc_han = (phi_phat_tat_toan_truoc_han === undefined) ? 0 : phi_phat_tat_toan_truoc_han;
					var tong_so_tien_thieu = Math.round(data.data.contract.tong_so_tien_thieu);
					var phi_phat_cham_tra = Math.round(data.data.contract.penalty_pay);
					var phi_phat_sinh = Math.round(data.data.contract.phi_phat_sinh);
					var phi_gia_han = Math.round(data.data.contract.phi_gia_han);

					var tong_can_gh_cc = 0;
					var tong_can_gh_cc_sau_giam_tru = 0;
					if (type_payment == 2) {
						tong_can_gh_cc = phi_phat_cham_tra + tien_lai + tien_phi + phi_phat_sinh + phi_gia_han - tien_thua_thanh_toan + tong_so_tien_thieu;
						console.log('tong_can_gh = : ' + 'phi_phat_cham_tra: ' + phi_phat_cham_tra + ' + tien_lai: ' + tien_lai + ' + tien_phi: ' + tien_phi + ' + phi_phat_sinh: ' + phi_phat_sinh + ' + phi_gia_han: ' + phi_gia_han + ' - tien_thua_thanh_toan: ' + tien_thua_thanh_toan + ' + tong_so_tien_thieu: ' + tong_so_tien_thieu);
					}
					if (type_payment == 3) {
						tong_can_gh_cc = du_no_con_lai + phi_phat_cham_tra + phi_phat_sinh + tien_chua_tra_ky_thanh_toan + phi_phat_tat_toan_truoc_han - tien_du_ky_truoc - tien_thua_thanh_toan + tong_so_tien_thieu;
						console.log('tong_can_cc = : ' + 'du_no_con_lai: ' + du_no_con_lai + ' + phi_phat_cham_tra: ' + phi_phat_cham_tra + ' + phi_phat_sinh: ' + phi_phat_sinh + ' + tien_chua_tra_ky_thanh_toan: ' + tien_chua_tra_ky_thanh_toan + ' + phi_phat_tat_toan_truoc_han: ' + phi_phat_tat_toan_truoc_han + ' - tien_du_ky_truoc: ' + tien_du_ky_truoc + ' - tien_thua_thanh_toan: ' + tien_thua_thanh_toan+ ' + tong_so_tien_thieu: ' + tong_so_tien_thieu);
					}
					tong_can_gh_cc_sau_giam_tru = tong_can_gh_cc - tien_giam_tru;
					$("input[name='fee_need_gh_cc']").val(tong_can_gh_cc_sau_giam_tru);
					if (type_payment == 3) {
						$(".amount_debt_cc").val(numeral(tong_can_gh_cc_sau_giam_tru - data.data.logs.new.amount_money).format('0,0'));
						$(".amount_cc").val(numeral(data.data.logs.new.amount_money).format('0,0'));
					}
					$(".total_money_paid").text(numeral(tong_can_gh_cc).format('0,0'));
					$(".valid_amount_payment").text(numeral(tong_can_gh_cc_sau_giam_tru).format('0,0'));
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						$("#successModal").modal("hide");
					}, 3000);

				} else {
					$('#errorModal').modal('show');
					$('.msg_error').text(data.msg);
					$('#confirm_payment').hide();
					setTimeout(function () {
						location.reload();
					}, 3000);
				}
			},
			error: function (data) {
				console.log(data);
				$("#loading").hide();
			}
		});
	} else {
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
			url: _url.base_url + 'accountant/check_date_pay_finish',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#loading").show();
			},
			success: function (data) {
				console.log(data);
				$("#loading").hide();
				if (data.status == 200) {
					var tien_giam_tru = getFloat_pay($(".discounted_fee").val());
					var du_no_con_lai = Math.round(data.data.dataTatToanPart1.du_no_con_lai);
					var tien_lai = Math.round(data.data.dataTatToanPart1.lai_chua_tra_den_thoi_diem_hien_tai);
					var tien_phi = Math.round(data.data.dataTatToanPart1.phi_chua_tra_den_thoi_diem_hien_tai);
					var da_thanhtoan = Math.round(data.data.contract.total_paid);
					var total_money_paid = Math.round(data.data.contract.total_money_paid);
					var tien_du_ky_truoc = Math.round(data.data.contract.tien_du_ky_truoc);
					var tien_thua_thanh_toan = Math.round(data.data.contract.tien_thua_thanh_toan);
					var tien_chua_tra_ky_thanh_toan = Math.round(data.data.contract.tien_chua_tra_ky_thanh_toan);
					var phi_phat_tat_toan_truoc_han = Math.round(data.data.debtData.phi_thanh_toan_truoc_han);
					if (data.data.contract.status != 19)
						var phi_phat_cham_tra = Math.round(data.data.contract.penalty_pay);
					var phi_phat_sinh = Math.round(data.data.contract.phi_phat_sinh);

					var tong_tien_thanh_toan = 0;
					var tong_tien_thanh_toan_sau_giam_tru = 0;
					//var date_pay_js = Date.parse(date_pay);


					var newDate = new Date(date_pay_gh_cc);
					var date_pay_js = newDate.getTime();
					var ngay_ket_thuc_js = ngay_ket_thuc;
					console.log(date_pay_js);
					console.log(ngay_ket_thuc_js);
					phi_phat_tat_toan_truoc_han = (phi_phat_tat_toan_truoc_han === undefined) ? 0 : phi_phat_tat_toan_truoc_han;
					if (date_pay_js >= ngay_ket_thuc_js) {
						if (isNaN(phi_phat_tat_toan_truoc_han)) {
							phi_phat_tat_toan_truoc_han = 0;
						}
						tong_tien_thanh_toan = du_no_con_lai + phi_phat_cham_tra + phi_phat_tat_toan_truoc_han + phi_phat_sinh + tien_chua_tra_ky_thanh_toan - tien_du_ky_truoc - tien_thua_thanh_toan;

					} else {
						tong_tien_thanh_toan = total_money_paid;


					}
					tong_tien_thanh_toan_sau_giam_tru = tong_tien_thanh_toan - tien_giam_tru;

					$(".total_money_paid").text(numeral(tong_tien_thanh_toan).format('0,0'));
					$(".difference_day_payment").text(numeral(parseInt(data.data.contract.difference_day_payment)).format('0,0'));
					$(".actual_difference_payment").text(numeral(parseInt(data.data.contract.actual_difference_payment)).format('0,0'));
					$("#penalty_pay").text(numeral(parseInt(data.data.contract.penalty_pay)).format('0,0'));
					$(".valid_amount_payment").text(numeral(parseInt(tong_tien_thanh_toan_sau_giam_tru)).format('0,0'));
					$(".ky_cham_tra_top").text(numeral(parseInt(data.data.contract.ky_cham_tra)).format('0,0'));
					$(".total_money_paid_pay_top").text(numeral(parseInt(data.data.contract.total_money_paid)).format('0,0'));
					$(".penalty_top").text(numeral(parseInt(data.data.contract.penalty_pay)).format('0,0'));
					$(".tong_thanh_toan_top").text(numeral(parseInt(data.data.contract.total_money_paid)).format('0,0'));
					$(".tong_da_thanh_toan_top").text(numeral(parseInt(data.data.contract.total_paid)).format('0,0'));
					$(".tong_con_no_top").text(numeral(parseInt(data.data.contract.tien_con_no)).format('0,0'));
					$(".so_tien_phat_sinh_top").text(numeral(parseInt(data.data.contract.phi_phat_sinh)).format('0,0'));
					$(".total_money_paid_pay_top").text(numeral(parseInt(data.data.contract.total_money_paid)).format('0,0'));
					$("#tien_qua_han").text(numeral(parseInt(data.data.contract.phi_phat_sinh)).format('0,0'));
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						$("#successModal").modal("hide");
					}, 3000);

				} else {
					$('#errorModal').modal('show');
					$('.msg_error').text(data.msg);
					$('#confirm_payment').hide();
					setTimeout(function () {
						location.reload();
					}, 3000);
				}
			},
			error: function (data) {
				console.log(data);
				$("#loading").hide();
			}
		});

	}

});

// auto fill discount fee
$(document).ready(function () {
	var discounted_fee = $(".discounted_fee").val();
	var reduced_fee = $(".reduced_fee").val();
	var other_fee = $(".other_fee").val();

	$("#total_deductible").text(numeral(getFloat_pay(discounted_fee) + getFloat_pay(reduced_fee) + getFloat_pay(other_fee)).format('0,0'));
});

$('.discounted_fee').on('focus', function (e) {
	if (getFloat_pay(this.value) <= 0) {
		$("#errorModal").modal("show");
		$(".msg_error").text("Hợp đồng chưa có hoặc chưa được duyệt đơn miễn giảm!");
	}
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {

	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$(document).ready(function () {
	var reduced_fee = $(".reduced_fee_finish").val();
	var discounted_fee_finish = $(".discounted_fee_finish").val();
	var other_fee = $(".other_fee_finish").val();
	$("#total_deductible_finish").text(numeral(getFloat_pay(discounted_fee_finish) + getFloat_pay(reduced_fee) + getFloat_pay(other_fee)).format('0,0'));
});

$('.discounted_fee_finish').on('focus', function (e) {
	if (getFloat_pay(this.value) <= 0) {
		$("#errorModal").modal("show");
		$(".msg_error").text("Hợp đồng chưa có hoặc chưa được duyệt đơn miễn giảm!");
	}
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$(document).ready(function () {
	var total_money_paid = $(".total_money_paid_finish_liquidations").text();
	var reduced_fee = $(".reduced_fee_finish_liquidations").val();
	var discounted_fee_finish = $(".discounted_fee_finish_liquidations").val();
	var other_fee = $(".other_fee_finish_liquidations").val();
	$("#total_deductible_finish_liquidations").text(numeral(getFloat_pay(discounted_fee_finish) + getFloat_pay(reduced_fee) + getFloat_pay(other_fee)).format('0,0'));
	var valid_amount_payment = getFloat_pay(total_money_paid) - getFloat_pay(discounted_fee_finish) - getFloat_pay(reduced_fee) - getFloat_pay(other_fee);
	$(".valid_amount_payment_finish_liquidations").text(numeral(valid_amount_payment).format('0,0'));
});

$('#status_contract_convert').change(function () {
	var id_contract = $("input[name='id_contract']").val();
	var status_contract = $('#status_contract_convert').val();
	var formData = {
		id_contract: id_contract,
		status_contract: status_contract
	}
	if (confirm("Xác nhận đổi trạng thái hợp đồng?")) {
		$.ajax({
			url: _url.base_url + 'Pawn/change_status_contract',
			method: "POST",
			data: formData,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					toastr.success("Cập nhật thành công!", {
						timeOut: 3000,
					});
					setTimeout(function () {
						window.location.reload();
					}, 2000)
				} else {
					$(".theloading").hide();
					toastr.error("Cập nhật thất bại!", {
						timeOut: 2000,
					});
				}
			},
			error: function (data) {
				console.log(data);
				$(".theloading").hide();
			}

		})
	}
	console.log(formData)
});
