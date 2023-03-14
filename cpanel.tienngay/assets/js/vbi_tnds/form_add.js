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
		ten: {
			presence: {
				message: "^Tên không để trống! "
			},
			format: {
				pattern: "[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_ ]+",
				flags: "i",
				message: "^Tên không chứa kí tự số hoặc kí tự đặc biệt! "
			},
			length: {
				minimum: 4,
				message: "^Tên tối thiểu 4 kí tự trở lên! "
			},

		},
		email: {
			presence: {
				message: "^Email không để trống! "
			},
			email: {
				message: "^Email không hợp lệ! "
			}
		},
		cmt: {
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
		sdt: {
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
		ngaysinh: {
			presence: {
				message: "^Ngày sinh không để trống! "
			}
		},
		diachi: {
			presence: {
				message: "^Số điện thoại không để trống! "
			},
		},
		bien_xe: {
			presence: {
				message: "^Biển số xe không để trống! "
			},
			format: {
				pattern: "[A-Z0-9]+",
				flags: "i",
				message: "^Biển số xe không đúng định dạng! "
			},
			length: {
				minimum: 7,
				message: "^Biển số xe tối thiểu 7 kí tự! "
			},
		},
		so_cho: {
			presence: {
				message: "^Số chỗ không để trống! "
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Số chỗ phải dạng số "
			}
		},
		trong_tai: {
			presence: {
				message: "^Trọng tải không để trống! "
			},
		},
		gia_tri_xe: {
			presence: {
				message: "^Giá trị xe không để trống! "
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

$('select[name="hang_xe"]').selectize({
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
$('select[name="hieu_xe"]').selectize({
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
$('select[name="nhom_xe"]').selectize({
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
$(document).ready(function () {
	$(".tinh_phi_vbi_tnds_btn").click(function (event) {
		event.preventDefault();
		var ten = $("input[name='ten']").val()
		var email = $("input[name='email']").val()
		var cmt = $("input[name='cmt']").val()
		var sdt = $("input[name='sdt']").val()
		var ngaysinh = $("input[name='ngaysinh']").val()
		var gioi_tinh = $("select[name='gioi_tinh']").val()
		var nam_sx = $("select[name='nam_sx']").val()
		var hang_xe = $("select[name='hang_xe']").val()
		var hieu_xe = $("select[name='hieu_xe']").val()
		var nhom_xe = $("select[name='nhom_xe']").val()
		var store = $("select[name='store']").val()
		var diachi = $("input[name='diachi']").val()
		var bien_xe = $("input[name='bien_xe']").val()
		var so_cho = $("input[name='so_cho']").val()
		var trong_tai = $("input[name='trong_tai']").val()
		var gia_tri_xe = $("input[name='gia_tri_xe']").val()
		var start_date_effect = $("input[name='start_effect_date']").val();

		var formData = new FormData();
		formData.append('ten', ten);
		formData.append('email', email);
		formData.append('cmt', cmt);
		formData.append('sdt', sdt);
		formData.append('ngaysinh', ngaysinh);
		formData.append('gioi_tinh', gioi_tinh);
		formData.append('nam_sx', nam_sx);
		formData.append('hang_xe', hang_xe);
		formData.append('hieu_xe', hieu_xe);
		formData.append('nhom_xe', nhom_xe);
		formData.append('store', store);
		formData.append('diachi', diachi);
		formData.append('bien_xe', bien_xe);
		formData.append('so_cho', so_cho);
		formData.append('trong_tai', trong_tai);
		formData.append('gia_tri_xe', gia_tri_xe);
		formData.append('start_date_effect', start_date_effect);
		$.ajax({
			url: _url.base_url + 'vbi_tnds/tinh_phi_vbi_tnds',
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
					$('.click_vbi').prop('disabled', true);
					$('#click_vbi0')[0].selectize.disable();
					$('#click_vbi1')[0].selectize.disable();
					$('#click_vbi2')[0].selectize.disable();
					$("#price_vbi").val(data.phi)
					$('#price_vbi_tnds').show();
					$('.tinh_phi_vbi_tnds_btn').hide();
					$('.ban_bao_hiem_vbi_tnds').show();
					$('.nhap_lai_vbi_tnds').show();
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
	})

	$(".ban_bao_hiem_vbi_tnds").click(function (event) {
		event.preventDefault();
		var ten = $("input[name='ten']").val()
		var email = $("input[name='email']").val()
		var cmt = $("input[name='cmt']").val()
		var sdt = $("input[name='sdt']").val()
		var ngaysinh = $("input[name='ngaysinh']").val()
		var gioi_tinh = $("select[name='gioi_tinh']").val()
		var nam_sx = $("select[name='nam_sx']").val()
		var hang_xe = $("select[name='hang_xe']").val()
		var hieu_xe = $("select[name='hieu_xe']").val()
		var nhom_xe = $("select[name='nhom_xe']").val()
		var store = $("select[name='store']").val()
		var diachi = $("input[name='diachi']").val()
		var bien_xe = $("input[name='bien_xe']").val()
		var so_cho = $("input[name='so_cho']").val()
		var trong_tai = $("input[name='trong_tai']").val()
		var gia_tri_xe = $("input[name='gia_tri_xe']").val()
		var price_vbi = $("input[name='price_vbi']").val()
		var start_date_effect = $("input[name='start_effect_date']").val();

		if (confirm("Bạn có chắc chắn muốn bán Bảo hiểm Trách nhiệm dân sự Ôtô cho biển số xe " + bien_xe + " với số tiền " + price_vbi + ' VND ?')) {
			var formData = new FormData();
			formData.append('ten', ten);
			formData.append('email', email);
			formData.append('cmt', cmt);
			formData.append('sdt', sdt);
			formData.append('ngaysinh', ngaysinh);
			formData.append('gioi_tinh', gioi_tinh);
			formData.append('nam_sx', nam_sx);
			formData.append('hang_xe', hang_xe);
			formData.append('hieu_xe', hieu_xe);
			formData.append('nhom_xe', nhom_xe);
			formData.append('store', store);
			formData.append('diachi', diachi);
			formData.append('bien_xe', bien_xe);
			formData.append('so_cho', so_cho);
			formData.append('trong_tai', trong_tai);
			formData.append('gia_tri_xe', gia_tri_xe);
			formData.append('price_vbi', price_vbi);
			formData.append('start_date_effect', start_date_effect);

			$.ajax({
				url: _url.base_url + 'vbi_tnds/fees_apply',
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
							window.location.replace(_url.base_url + "vbi_tnds");
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

	$('.nhap_lai_vbi_tnds').click(function () {
		$('.click_vbi').prop('disabled', false);
		$('#click_vbi0')[0].selectize.enable();
		$('#click_vbi1')[0].selectize.enable();
		$('#click_vbi2')[0].selectize.enable();
		$("#price_vbi").val('')
		$('#price_vbi_tnds').hide();
		$('.tinh_phi_vbi_tnds_btn').show();
		$('.ban_bao_hiem_vbi_tnds').hide();
		$('.nhap_lai_vbi_tnds').hide();
		// $("#main_1").trigger("reset");
	})

	function addCommas(str) {
		return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	$('#gia_tri_xe').on('keyup', function (event) {
		var gia_tri_xe = $("input[name='gia_tri_xe']").val()
		$('#gia_tri_xe').val(addCommas(gia_tri_xe))
	})


	//Hiện chọn ngày bắt đầu hiệu lực
	$('#choose_date').click(function () {
		$('#start_effect_date').prop('disabled', false);
		$('#start_effect_date').datetimepicker({
			defaultDate: new Date(),
			format: 'DD/MM/YYYY',
			minDate: new Date
		});
	});

})

	//Change giá trị ngày kết thúc
	$("#start_effect_date").on("dp.change", function(e) {
		let start_effect_date_string = $('#start_effect_date').val();
		console.log(start_effect_date_string);
		let start_date_convert = moment(start_effect_date_string, 'DD-MM-YYYY')
		console.log(start_date_convert)
		let end_date_effect =  start_date_convert.add(1, 'years');
		let end_date_effect_convert = moment(end_date_effect, 'DD-MM-YYYY').format('DD/MM/YYYY');
		console.log(end_date_effect_convert)
		$('#end_effect_date').empty();
		$('#end_effect_date').val(end_date_effect_convert);
		$('#end_effect_date').append(end_date_effect_convert);
	});


