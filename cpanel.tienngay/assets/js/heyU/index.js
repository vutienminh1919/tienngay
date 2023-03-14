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
		code_driver: {
			presence: {
				message: "^Mã tài xế không để trống!"
			},
			format: {
				pattern: "^[A-Za-z0-9]+$",
				message: "^Tên không đúng định dạng!"
			}
		},

		money_driver: {
			presence: {
				message: "^Số tiền không để trống!"
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
		_.each(form.querySelectorAll("input[name], select[name]"), function (input) {
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
	$(".recharge_the_driver_btnSave").click(function (event) {
		event.preventDefault();
		$('.recharge_the_driver_btnSave').prop('disabled', true)
		var code_driver = $("input[name='code_driver']").val()
		var name_driver = $("input[name='name_driver']").val()
		var money = $("input[name='money_driver']").val()
		var store = $("select[name='store']").val()
		if (confirm('Bạn có chắc chắn nạp ' + money + ' VND cho tài xế ' + name_driver + '?')) {
			var formData = new FormData();
			formData.append('code_driver', code_driver);
			formData.append('money', money);
			formData.append('store', store);
			$.ajax({
				url: _url.base_url + 'heyU/recharge_the_driver',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$("#themgiaodienModal").hide();
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					console.log(data)
					if (data.code == 200) {
						$("#successModal").modal("show");
						$(".msg_success").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + "heyU/index";
						}, 2000);
					} else if (data.code == 401) {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + "heyU/index";
						}, 1000);
					}
				},
				error: function () {
					$(".theloading").hide();
					$("#errorModal").modal("show");
					$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
					setTimeout(function () {
						window.location.href = _url.base_url + "heyU/index";
					}, 2000);
				}
			});
		}

	})


	$('#code_driver').on('keyup', function (event) {
		event.preventDefault();
		var code_driver = $("input[name='code_driver']").val()
		if (code_driver.length >= 5) {
			$.ajax({
				url: _url.base_url + 'heyU/get_name?code_driver=' + code_driver,
				type: "GET",
				dataType: 'json',
				success: function (data) {
					console.log(data)
					if (data.code == 200) {
						$('.checkNameTaiXe1').show();
						$('.checkNameTaiXe2').show();
						$('#name_driver').val(data.name)
						$('.recharge_the_driver_btnSave').prop('disabled', false)
					} else if (data.code == 401) {
						$('.checkNameTaiXe1').hide();
						$('.checkNameTaiXe2').hide();
						$('#name_driver').val('')
						$('.recharge_the_driver_btnSave').prop('disabled', true)

					}
				},
				error: function () {
					alert('Có lỗi xảy ra!')
				}
			});
		}
	})

	function addCommas(str) {
		return str.replace(/^0+/, '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	$('#money_driver').on('keyup', function (event) {
		var money_driver = $("input[name='money_driver']").val()
		$('#money_driver').val(addCommas(money_driver))
	})

})


