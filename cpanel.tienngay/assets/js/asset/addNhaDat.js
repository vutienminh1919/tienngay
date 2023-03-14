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
		name_customer: {
			presence: {
				message: "^Tên tài sản không để trống!"
			},
			format: {
				pattern: "[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_ ]+",
				flags: "i",
				message: "^Tên không chứa kí tự số hoặc kí tự đặc biệt!"
			},
			length: {
				minimum: 3,
				message: "^Tên tối thiểu 3 kí tự trở lên"
			},

		},
		address: {
			presence: {
				message: "^Địa chỉ không để trống!"
			},
		},
		product: {
			presence: {
				message: "^Tên tài sản không để trống!"
			},
		},
		nhan_hieu_xm: {
			presence: {
				message: "^Nhãn hiệu không để trống!"
			},
		},
		model_xm: {
			presence: {
				message: "^Model không để trống!"
			},
		},
		bien_so_xm: {
			presence: {
				message: "^Biển số xe không để trống!"
			},
			format: {
				pattern: "[A-Z0-9]+",
				flags: "i",
				message: "^Biển số không kí tự đặc biệt hoặc khoảng trắng!"
			},
			length: {
				minimum: 7,
				maximum: 9,
				message: "^Biển số 7 đến 9 kí tự!"
			},
		},
		so_khung_xm: {
			presence: {
				message: "^Số khung không để trống!"
			},
			format: {
				pattern: "[A-Z0-9]+",
				flags: "i",
				message: "^Số khung không kí tự đặc biệt hoặc khoảng trắng!"
			},
			length: {
				minimum: 5,
				message: "^Số khung tối thiểu 5 kí tự!"
			},
		},
		so_may_xm: {
			presence: {
				message: "^Số máy không để trống!"
			},
			format: {
				pattern: "[A-Z0-9]+",
				flags: "i",
				message: "^Số máy không kí tự đặc biệt hoặc khoảng trắng!"
			},
			length: {
				minimum: 5,
				message: "^Số máy tối thiểu 5 kí tự!"
			},
		},
		so_dang_ki_xm: {
			presence: {
				message: "^Số đăng kí không để trống!"
			},
			length: {
				minimum: 5,
				message: "^Số máy tối thiểu 5 kí tự!"
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Số đăng kí phải dạng số"
			}
		},
		ngay_cap_xm: {
			presence: {
				message: "^Ngày cấp không để trống!"
			},
		},
		customer_name_oto: {
			presence: {
				message: "^Tên tài sản không để trống!"
			},
			format: {
				pattern: "[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_ ]+",
				flags: "i",
				message: "^Tên không chứa kí tự số hoặc kí tự đặc biệt!"
			},
			length: {
				minimum: 3,
				message: "^Tên tối thiểu 3 kí tự trở lên"
			},

		},
		address_oto: {
			presence: {
				message: "^Địa chỉ không để trống!"
			},
		},
		product_oto: {
			presence: {
				message: "^Tên tài sản không để trống!"
			},
		},
		nhan_hieu_oto: {
			presence: {
				message: "^Nhãn hiệu không để trống!"
			},
		},
		model_oto: {
			presence: {
				message: "^Model không để trống!"
			},
		},
		bien_so_xe_oto: {
			presence: {
				message: "^Biển số xe không để trống!"
			},
			format: {
				pattern: "[A-Z0-9]+",
				flags: "i",
				message: "^Biển số không kí tự đặc biệt hoặc khoảng trắng!"
			},
			length: {
				minimum: 7,
				maximum: 9,
				message: "^Biển số 7 đến 9 kí tự!"
			},
		},
		so_khung_oto: {
			presence: {
				message: "^Số khung không để trống!"
			},
			format: {
				pattern: "[A-Z0-9]+",
				flags: "i",
				message: "^Số khung không kí tự đặc biệt hoặc khoảng trắng!"
			},
			length: {
				minimum: 5,
				message: "^Số khung tối thiểu 5 kí tự!"
			},
		},
		so_may_oto: {
			presence: {
				message: "^Số máy không để trống!"
			},
			format: {
				pattern: "[A-Z0-9]+",
				flags: "i",
				message: "^Số máy không kí tự đặc biệt hoặc khoảng trắng!"
			},
			length: {
				minimum: 5,
				message: "^Số máy tối thiểu 5 kí tự!"
			},
		},
		so_dang_ki_oto: {
			presence: {
				message: "^Số đăng kí không để trống!"
			},
			length: {
				minimum: 5,
				message: "^Số máy tối thiểu 5 kí tự!"
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Số đăng kí phải dạng số"
			}
		},
		ngay_cap_oto: {
			presence: {
				message: "^Ngày cấp không để trống!"
			},
		},
		ten_khach_hang: {
			presence: {
				message: "^Tên tài sản không để trống!"
			},
			format: {
				pattern: "[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_ ]+",
				flags: "i",
				message: "^Tên không chứa kí tự số hoặc kí tự đặc biệt!"
			},
			length: {
				minimum: 3,
				message: "^Tên tối thiểu 3 kí tự trở lên"
			},

		},
		nam_sinh: {
			presence: {
				message: "^Năm sinh không để trống!"
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Năm sinh phải dạng số"
			},
			length: {
				is: 4,
				message: "^Năm sinh phải 4 kí tự!"
			},
		},
		cmt: {
			presence: {
				message: "^CMT không để trống!"
			},
			numericality: {
				onlyInteger: true,
				notValid: "^CMT phải dạng số"
			},
			length: {
				minimum: 9,
				message: "^Tên tối thiểu 9 kí tự trở lên"
			},
		},
		dia_chi: {
			presence: {
				message: "^Địa chỉ không để trống!"
			},
		},
		nguoi_lien_quan: {
			presence: {
				message: "^Tên tài sản không để trống!"
			},
			format: {
				pattern: "[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_ ]+",
				flags: "i",
				message: "^Tên không chứa kí tự số hoặc kí tự đặc biệt!"
			},
			length: {
				minimum: 3,
				message: "^Tên tối thiểu 3 kí tự trở lên"
			},
		},
		nam_sinh_nguoi_lien_quan: {
			presence: {
				message: "^Năm sinh không để trống!"
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Năm sinh phải dạng số"
			},
			length: {
				is: 4,
				message: "^Năm sinh phải 4 kí tự!"
			},
		},
		cmt_nguoi_lien_quan: {
			presence: {
				message: "^CMT không để trống!"
			},
			numericality: {
				onlyInteger: true,
				notValid: "^CMT phải dạng số"
			},
			length: {
				minimum: 9,
				message: "^Tên tối thiểu 9 kí tự trở lên"
			},
		},
		dia_chi_nguoi_lien_quan: {
			presence: {
				message: "^Địa chỉ không để trống!"
			},
		},
		thua_dat_so: {
			presence: {
				message: "^Số thửa đất không để trống!"
			},
			length: {
				minimum: 5,
				message: "^Số thửa đất tối thiểu 5 kí tự!"
			},
		},
		dia_chi_nha_dat: {
			presence: {
				message: "^Địa chỉ không để trống!"
			},
		},
		dien_tich_nha_dat: {
			presence: {
				message: "^Diện tích không để trống!"
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Diện tích phải dạng số"
			}
		},
		hinh_thuc_su_dung: {
			presence: {
				message: "^Hình thức không để trống!"
			},
		},
		muc_dich_su_dung: {
			presence: {
				message: "^Mục đích không để trống!"
			},
		},
		thoi_han_su_dung_dat: {
			presence: {
				message: "^Thời hạn không để trống!"
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Thời hạn phải dạng số"
			}
		},
		loai_nha_o: {
			presence: {
				message: "^Loại nhà không để trống!"
			},
		},
		dien_tich_nha_o: {
			presence: {
				message: "^Diện tích không để trống!"
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Diện tích phải dạng số"
			}
		},
		ket_cau_nha_o: {
			presence: {
				message: "^Kết cấu không để trống!"
			},
		},
		cap_nha_o: {
			presence: {
				message: "^Cấp nhà không để trống!"
			},
		},
		so_tang_nha_o: {
			presence: {
				message: "^Số tầng không để trống!"
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Số tầng phải dạng số"
			}
		},
		thoi_gian_song: {
			presence: {
				message: "^Thời gian sống không để trống!"
			},
			numericality: {
				onlyInteger: true,
				notValid: "^Thời gian sống phải dạng số"
			}
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
		alert("Success!");
	}
})();
$(document).ready(function () {
	$("#add_new_so_do").click(function (event) {
		event.preventDefault();
		var count = $("img[name='img_asset']").length;
		var image_sodo = {};
		if (count > 0) {
			$("img[name='img_asset']").each(function () {
				var data = {};
				data['file_type'] = $(this).attr('data-fileType');
				data['file_name'] = $(this).attr('data-fileName');
				data['path'] = $(this).attr('src');
				var key = $(this).data('key');
				image_sodo[key] = data;
			});
		}
		var formData = {
			ten_khach_hang: $("input[name='ten_khach_hang']").val(),
			nam_sinh: $("input[name='nam_sinh']").val(),
			cmt: $("input[name='cmt']").val(),
			dia_chi: $("input[name='dia_chi']").val(),
			nguoi_lien_quan: $("input[name='nguoi_lien_quan']").val(),
			nam_sinh_nguoi_lien_quan: $("input[name='nam_sinh_nguoi_lien_quan']").val(),
			cmt_nguoi_lien_quan: $("input[name='cmt_nguoi_lien_quan']").val(),
			dia_chi_nguoi_lien_quan: $("input[name='dia_chi_nguoi_lien_quan']").val(),
			thua_dat_so: $("input[name='thua_dat_so']").val(),
			dia_chi_nha_dat: $("input[name='dia_chi_nha_dat']").val(),
			dien_tich_nha_dat: $("input[name='dien_tich_nha_dat']").val(),
			hinh_thuc_su_dung: $("input[name='hinh_thuc_su_dung']").val(),
			muc_dich_su_dung: $("input[name='muc_dich_su_dung']").val(),
			thoi_han_su_dung_dat: $("input[name='thoi_han_su_dung_dat']").val(),
			loai_nha_o: $("input[name='loai_nha_o']").val(),
			dien_tich_nha_o: $("input[name='dien_tich_nha_o']").val(),
			ket_cau_nha_o: $("input[name='ket_cau_nha_o']").val(),
			cap_nha_o: $("input[name='cap_nha_o']").val(),
			so_tang_nha_o: $("input[name='so_tang_nha_o']").val(),
			thoi_gian_song: $("input[name='thoi_gian_song']").val(),
			ten_cong_trinh_khac: $("input[name='ten_cong_trinh_khac']").val(),
			dien_tich_cong_trinh_khac: $("input[name='dien_tich_cong_trinh_khac']").val(),
			hinh_thuc_so_huu: $("input[name='hinh_thuc_so_huu']").val(),
			cap_cong_trinh: $("input[name='cap_cong_trinh']").val(),
			thoi_gian_su_huu: $("input[name='thoi_gian_su_huu']").val(),
			image_sodo: image_sodo,
		};
		$.ajax({
			url: _url.base_url + 'asset_manager/add_nha_dat',
			type: "POST",
			data: formData,
			dataType: 'json',
			beforeSend: function () {
				$("#addnew_sodo_Modal").hide();
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				// console.log(data)
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						window.location.href = _url.base_url + "asset_manager/asset";
					}, 2000);
				} else if (data.code == 401) {
					$("#errorModal").modal("show");
					let html = '';
					$.each(data.msg, function (k, v) {
						html += '<li style="text-align: left">';
						html += v;
						html += '</li>';
					})
					$(".msg_error").html(html);
					setTimeout(function () {
						window.location.href = _url.base_url + "asset_manager/asset";
					}, 2000);
				}
			},
			error: function () {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
				setTimeout(function () {
					window.location.href = _url.base_url + "asset_manager/asset";
				}, 1000);
			}
		});
	})
})
