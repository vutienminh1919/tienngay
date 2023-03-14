(function () {
	// Before using it we must add the parse and format functions
	// Here is a sample implementation using moment.js
	validate.extend(validate.validators.datetime, {
		// The value is guaranteed not to be null or undefined but otherwise it
		// could be anything.
		parse: function (value, options) {
			return +moment.utc(value);
		},
		// Input is a unix timestamp
		format: function (value, options) {
			var format = options.dateOnly ? "YYYY-MM-DD" : "YYYY-MM-DD hh:mm:ss";
			return moment.utc(value).format(format);
		}
	});

	// These are the constraints used to validate the form
	var constraints = {
		ten_chu_hd: {
			presence: {
				message: "^Tên chủ hợp đồng không để trống! "
			},
			format: {
				pattern: "[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_ ]+",
				flags: "i",
				message: "^Tên chủ hợp đồng không chứa kí tự số hoặc kí tự đặc biệt! "
			},
			length: {
				minimum: 4,
				message: "^Tên chủ hợp đồng tối thiểu 4 kí tự trở lên! "
			},

		},
		email_chu_hd: {
			presence: {
				message: "^Email không để trống! "
			},
			email: {
				message: "^Email không hợp lệ! "
			}
		},
		cmt_chu_hd: {
			presence: {
				message: "^CMT/CCCD không để trống! "
			},
			length: {
				minimum: 9,
				message: "^CMT/CCCD tối thiểu 9 kí tự trở lên "
			},
			numericality: {
				onlyInteger: true,
				notValid: "^CMT/CCCD phải dạng số "
			}
		},
		sdt_chu_hd: {
			presence: {
				message: "^Số điện thoại không để trống! "
			},
			length: {
				minimum: 9,
				message: "^Số điện thoại tối thiểu 9 kí tự trở lên "
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Số điện thoại phải dạng số "
			}
		},
		ngaysinh_chu_hd: {
			presence: {
				message: "^Ngày sinh không để trống! "
			}
		},
		diachi_chu_hd: {
			presence: {
				message: "^Địa chỉ không để trống! "
			},
		},
		ten_nguoi_bh: {
			presence: {
				message: "^Tên người được bảo hiểm không để trống! "
			},
			format: {
				pattern: "[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_ ]+",
				flags: "i",
				message: "^Tên người được bảo hiểm không chứa kí tự số hoặc kí tự đặc biệt! "
			},
			length: {
				minimum: 4,
				message: "^Tên người được bảo hiểm tối thiểu 4 kí tự trở lên! "
			},

		},
		email_nguoi_bh: {
			presence: {
				message: "^Email không để trống! "
			},
			email: {
				message: "^Email không hợp lệ! "
			}
		},
		sdt_nguoi_bh: {
			presence: {
				message: "^Số điện thoại không để trống! "
			},
			length: {
				minimum: 9,
				message: "^Số điện thoại tối thiểu 9 kí tự trở lên "
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Số điện thoại phải dạng số "
			}
		},
		ngaysinh_nguoi_bh: {
			presence: {
				message: "^Ngày sinh không để trống! "
			}
		},
		diachi_nguoi_bh: {
			presence: {
				message: "^Địa chỉ không để trống! "
			},
		},

	};

	// Hook up the form so we can prevent it from being posted
	var form = document.querySelector("form#main_1");
	form.addEventListener("submit", function (ev) {
		ev.preventDefault();
		handleFormSubmit(form);
	});

	// Hook up the inputs to validate on the fly
	var inputs = document.querySelectorAll("input, textarea, select")
	for (var i = 0; i < inputs.length; ++i) {
		inputs.item(i).addEventListener("change", function (ev) {
			var errors = validate(form, constraints) || {};
			showErrorsForInput(this, errors[this.name])
		});
	}

	function handleFormSubmit(form, input) {
		// validate the form against the constraints
		var errors = validate(form, constraints);
		// then we update the form to reflect the results
		showErrors(form, errors || {});
		if (!errors) {
			showSuccess();
		}
	}

	// Updates the inputs with the validation errors
	function showErrors(form, errors) {
		// We loop through all the inputs and show the errors for that input
		_.each(form.querySelectorAll("input[name], select[name], textarea[name]"), function (input) {
			// Since the errors can be null if no errors were found we need to handle
			// that
			showErrorsForInput(input, errors && errors[input.name]);
		});
	}

	// Shows the errors for a specific input
	function showErrorsForInput(input, errors) {
		// This is the root of the input
		var formGroup = closestParent(input.parentNode, "error_messages")
			// Find where the error messages will be insert into
			, messages = formGroup.querySelector(".messages");
		// First we remove any old messages and resets the classes
		resetFormGroup(formGroup);
		// If we have errors
		if (errors) {
			// we first mark the group has having errors
			formGroup.classList.add("has-error");
			// then we append all the errors
			_.each(errors, function (error) {
				addError(messages, error);
			});
		} else {
			// otherwise we simply mark it as success
			formGroup.classList.add("has-success");
		}
	}

	// Recusively finds the closest parent that has the specified class
	function closestParent(child, className) {
		if (!child || child == document) {
			return null;
		}
		if (child.classList.contains(className)) {
			return child;
		} else {
			return closestParent(child.parentNode, className);
		}
	}

	function resetFormGroup(formGroup) {
		// Remove the success and error classes
		formGroup.classList.remove("has-error");
		formGroup.classList.remove("has-success");
		// and remove any old messages
		_.each(formGroup.querySelectorAll(".help-block.error"), function (el) {
			el.parentNode.removeChild(el);
		});
	}

	// Adds the specified error with the following markup
	// <p class="help-block error">[message]</p>
	function addError(messages, error) {
		var block = document.createElement("p");
		block.classList.add("help-block");
		block.classList.add("error");
		block.innerText = error;
		messages.appendChild(block);
	}

	function showSuccess() {
		// We made it \:D/

	}
})();

$(document).ready(function () {
	$(".ban_bao_hiem_vbi_sxh").click(function (event) {
		event.preventDefault();
		var ten_chu_hd = $("input[name='ten_chu_hd']").val()
		var email_chu_hd = $("input[name='email_chu_hd']").val()
		var sdt_chu_hd = $("input[name='sdt_chu_hd']").val()
		var cmt_chu_hd = $("input[name='cmt_chu_hd']").val()
		var diachi_chu_hd = $("input[name='diachi_chu_hd']").val()
		var ngaysinh_chu_hd = $("input[name='ngaysinh_chu_hd']").val()
		var gioi_tinh_chu_hd = $("select[name='gioi_tinh_chu_hd']").val()
		var ten_nguoi_bh = $("input[name='ten_nguoi_bh']").val()
		var email_nguoi_bh = $("input[name='email_nguoi_bh']").val()
		var sdt_nguoi_bh = $("input[name='sdt_nguoi_bh']").val()
		var cmt_nguoi_bh = $("input[name='cmt_nguoi_bh']").val()
		var cmt_ngay_cap_nguoi_bh = $("input[name='cmt_ngay_cap_nguoi_bh']").val()
		var cmt_noi_cap_nguoi_bh = $("input[name='cmt_noi_cap_nguoi_bh']").val()
		var diachi_nguoi_bh = $("input[name='diachi_nguoi_bh']").val()
		var ngaysinh_nguoi_bh = $("input[name='ngaysinh_nguoi_bh']").val()
		var gioi_tinh_nguoi_bh = $("select[name='gioi_tinh_nguoi_bh']").val()
		var moi_quan_he = $("select[name='moi_quan_he']").val()
		var goi_bao_hiem = $("select[name='goi_bao_hiem']").val()
		var store = $("select[name='store']").val()
		var price = $("input[name='price']").val()

		if (confirm("Bạn có chắc chắn muốn bán Bảo hiểm VBI Sốt xuất huyết?")) {
			var formData = new FormData();
			formData.append('ten_chu_hd', ten_chu_hd);
			formData.append('email_chu_hd', email_chu_hd);
			formData.append('sdt_chu_hd', sdt_chu_hd);
			formData.append('cmt_chu_hd', cmt_chu_hd);
			formData.append('diachi_chu_hd', diachi_chu_hd);
			formData.append('ngaysinh_chu_hd', ngaysinh_chu_hd);
			formData.append('gioi_tinh_chu_hd', gioi_tinh_chu_hd);
			formData.append('ten_nguoi_bh', ten_nguoi_bh);
			formData.append('email_nguoi_bh', email_nguoi_bh);
			formData.append('sdt_nguoi_bh', sdt_nguoi_bh);
			formData.append('cmt_nguoi_bh', cmt_nguoi_bh);
			formData.append('cmt_ngay_cap_nguoi_bh', cmt_ngay_cap_nguoi_bh);
			formData.append('cmt_noi_cap_nguoi_bh', cmt_noi_cap_nguoi_bh);
			formData.append('diachi_nguoi_bh', diachi_nguoi_bh);
			formData.append('ngaysinh_nguoi_bh', ngaysinh_nguoi_bh);
			formData.append('gioi_tinh_nguoi_bh', gioi_tinh_nguoi_bh);
			formData.append('moi_quan_he', moi_quan_he);
			formData.append('goi_bao_hiem', goi_bao_hiem);
			formData.append('store', store);
			formData.append('price', price);
			$.ajax({
				url: _url.base_url + 'baoHiemVbi/fees_apply_sxh',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.code == 200) {
						console.log(data)
						$("#successModal").modal("show");
						$(".msg_success").text(data.msg);
						setTimeout(function () {
							window.location.replace(_url.base_url + "baoHiemVbi/sxh");
						}, 500);
					} else if (data.code == 401) {
						$("#errorModal").modal("show");
						let html = '';
						$.each(data.msg, function (k, v) {
							html += '<li style="text-align: left">';
							html += v;
							html += '</li>';
						})
						$(".msg_error").html(html);
					}
				},
				error: function () {
					$(".theloading").hide();
					$("#errorModal").modal("show");
					$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
				}
			});
		}
	})

	// $('#ngaysinh_nguoi_bh').on('keyup', function () {
	// 	var ngaysinh_nguoi_bh = $("input[name='ngaysinh_nguoi_bh']").val()
	// 	var gioi_tinh_nguoi_bh = $("select[name='gioi_tinh_nguoi_bh']").val()
	// 	$("#goi_bao_hiem option").remove();
	// 	$.ajax({
	// 		url: _url.base_url + 'baoHiemVbi/check_gioi_tinh?ngaysinh_nguoi_bh=' + ngaysinh_nguoi_bh + '&gioi_tinh_nguoi_bh=' + gioi_tinh_nguoi_bh,
	// 		type: "GET",
	// 		dataType: 'json',
	// 		success: function (data) {
	// 			console.log(data)
	// 			if (data.code == 200) {
	// 				$('#goi_bao_hiem').prop('disabled', false)
	// 				$('#goi_bao_hiem').append($('<option>', {value: '', text: "Chọn gói BH:"}));
	// 				$.each(data.data, function (k, v) {
	// 					$('#goi_bao_hiem').append($('<option>', {value: v.ma, text: v.ten}));
	// 				})
	// 			} else if (data.code == 401) {
	// 				$("#goi_bao_hiem option").remove();
	// 				$('#goi_bao_hiem').prop('disabled', true)
	// 			}
	// 		},
	// 		error: function () {
	// 			$(".theloading").hide();
	// 			$("#errorModal").modal("show");
	// 			$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
	// 		}
	// 	})
	// })

	$('#goi_bao_hiem').change(function () {
		let ngaysinh_nguoi_bh = $("input[name='ngaysinh_nguoi_bh']").val()
		var gioi_tinh_nguoi_bh = $("select[name='gioi_tinh_nguoi_bh']").val()
		let goi_bao_hiem = $('#goi_bao_hiem').val();
		console.log(ngaysinh_nguoi_bh)
		$.ajax({
			url: _url.base_url + 'baoHiemVbi/get_price_goi_bh_sxh',
			type: "POST",
			data: {
				ngaysinh_nguoi_bh: ngaysinh_nguoi_bh,
				gioi_tinh_nguoi_bh: gioi_tinh_nguoi_bh,
				goi_bao_hiem: goi_bao_hiem
			},
			dataType: 'json',
			success: function (data) {
				if (data.code == 200) {
					$('#price').val(data.data)
				} else {
					$('#price').val('')
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
				}
			},
			error: function () {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
			}
		});
	})
	$('#ngaysinh_nguoi_bh').on('blur',function () {
		let ngaysinh_nguoi_bh = $("input[name='ngaysinh_nguoi_bh']").val()
		var gioi_tinh_nguoi_bh = $("select[name='gioi_tinh_nguoi_bh']").val()
		let goi_bao_hiem = $('#goi_bao_hiem').val();
		console.log(ngaysinh_nguoi_bh)
		$.ajax({
			url: _url.base_url + 'baoHiemVbi/get_price_goi_bh_sxh',
			type: "POST",
			data: {
				ngaysinh_nguoi_bh: ngaysinh_nguoi_bh,
				gioi_tinh_nguoi_bh: gioi_tinh_nguoi_bh,
				goi_bao_hiem: goi_bao_hiem
			},
			dataType: 'json',
			success: function (data) {
				if (data.code == 200) {
					$('#price').val(data.data)
				} else {
					$('#price').val('')
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
				}
			},
			error: function () {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
			}
		});
	})
	$('#gioi_tinh_nguoi_bh').change(function () {
		let ngaysinh_nguoi_bh = $("input[name='ngaysinh_nguoi_bh']").val()
		var gioi_tinh_nguoi_bh = $("select[name='gioi_tinh_nguoi_bh']").val()
		let goi_bao_hiem = $('#goi_bao_hiem').val();
		console.log(ngaysinh_nguoi_bh)
		$.ajax({
			url: _url.base_url + 'baoHiemVbi/get_price_goi_bh_sxh',
			type: "POST",
			data: {
				ngaysinh_nguoi_bh: ngaysinh_nguoi_bh,
				gioi_tinh_nguoi_bh: gioi_tinh_nguoi_bh,
				goi_bao_hiem: goi_bao_hiem
			},
			dataType: 'json',
			success: function (data) {
				if (data.code == 200) {
					$('#price').val(data.data)
				} else {
					$('#price').val('')
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
				}
			},
			error: function () {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
			}
		});
	})
})


