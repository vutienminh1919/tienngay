$(document).ready(function () {
	$('select[name="car_company"]').selectize({
		create: false,
		valueField: 'id',
		labelField: 'str_name',
		searchField: 'str_name',
		maxItems: 1,
		sortField: {
			field: 'str_name',
			direction: 'asc'
		}
	});

	$('select[name="vehicles"]').selectize({
		create: false,
		valueField: 'id',
		labelField: 'name',
		searchField: 'name',
		maxItems: 1,
		sortField: {
			field: 'name',
			direction: 'asc'
		}
	});

	$('select[name="property_id"]').selectize({
		create: false,
		valueField: 'id',
		labelField: 'str_name',
		searchField: 'str_name',
		maxItems: 1,
		sortField: {
			field: 'str_name',
			direction: 'asc'
		}
	});

	$('.main_property').change(function () {
		var code = $(this).val()
		var type_loan = $("select[name='type_loan']").val();
		console.log(type_loan)
		$('.car_company option').remove()
		$('.vehicles option').remove()
		$('.property_by_main option').remove()
		$('.product_property option').remove()

		var $select = $('#car_company').selectize();
		var car_company = $select[0].selectize;
		car_company.clear();
		car_company.clearOptions();

		var $select1 = $('#vehicles').selectize();
		var vehicles = $select1[0].selectize;
		vehicles.clear();
		vehicles.clearOptions();

		var $select2 = $('#property_by_main').selectize();
		var property_by_main = $select2[0].selectize;
		property_by_main.clearOptions();
		property_by_main.clear();
		if (type_loan == 'CC') {
			if (code == 'XM') {
				$('.product_property').append($('<option>', {value: '4', text: 'Cầm cố xe máy'}));
			} else if (code == 'OTO') {
				$('.product_property').append($('<option>', {value: '5', text: 'Cầm cố ô tô'}));
			}
		} else if (type_loan == 'DKX') {
			if (code == 'XM') {
				$('.product_property').append($('<option>', {
					value: '2',
					text: 'Vay theo đăng ký - cà vẹt xe máy chính chủ'
				}));
				$('.product_property').append($('<option>', {
					value: '3',
					text: 'Vay theo đăng ký - cà vẹt xe máy không chính chủ'
				}));
			} else if (code == 'OTO') {
				$('.product_property').append($('<option>', {value: '7', text: 'Vay theo đăng ký - cà vẹt ô tô'}));
			}
		} else {
			$('.product_property').append($('<option>', {value: '', text: 'Chọn sản phẩm vay'}));
		}

		$.ajax({
			url: _url.base_url + 'property_main/get_main_property?code=' + code,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				car_company.load(function (callback) {
					callback(data.data);
				});
			},
			error: function () {
				alert('error')
			}
		})
	})

	$('.car_company').change(function () {
		var id = $(this).val()
		$('.vehicles option').remove()
		$('.property_by_main option').remove()

		var $select1 = $('#vehicles').selectize();
		var vehicles = $select1[0].selectize;
		vehicles.clear();
		vehicles.clearOptions();

		var $select2 = $('#property_by_main').selectize();
		var property_by_main = $select2[0].selectize;
		property_by_main.clearOptions();
		property_by_main.clear();

		$.ajax({
			url: _url.base_url + 'property_main/get_property_by_main?id=' + id,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				vehicles.load(function (callback) {
					callback(data.data);
				});
			},
			error: function () {
				alert('error')
			}
		})
	})

	$('.vehicles').change(function () {
		var model = $(this).val()
		$('.property_by_main option').remove()
		var selectClass = $('#property_by_main').selectize();
		var selectizeClass = selectClass[0].selectize;
		selectizeClass.clear();
		selectizeClass.clearOptions();
		$.ajax({
			url: _url.base_url + 'property_main/get_property_child?model=' + model,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				selectizeClass.load(function (callback) {
					callback(data.data);
				});
			},
			error: function () {
				alert('error')
			}
		})
	})

	$('.property_by_main').change(function () {
		var id = $(this).val()
		$('.depreciation_by_property').children().remove();
		if (id) {
			$.ajax({
				url: _url.base_url + 'property_main/get_data_property_child?id=' + id,
				type: 'GET',
				dataType: 'json',
				success: function (data) {
					console.log(data.data)
					let html = "";
					if (data.status == 200) {
						for (var i = 0; i < data.data.depreciations.length; i++) {
							html += "<div class='form-check mb-0'><input class='form-check-input price_depreciation_checkbox' data-name='" + data.data.depreciations[i].name + "' data-slug='" + data.data.depreciations[i].slug + "' name='price_depreciation[]' type='checkbox' value='" + data.data.depreciations[i].price + "' ><label class='form-check-label' >" + data.data.depreciations[i].name + "</label></div>"
						}
						$(".depreciation_by_property").append(html);
					} else {
						$('.depreciation_by_property').children().remove();
					}
				},
				error: function () {
					alert('error')
				}
			})
		} else {
			$('.depreciation_by_property').children().remove();
			$('.depreciation_price').text('')
			$('.amount_money').text('')
		}

	})

	$('.property_by_main').change(function () {
		$('.depreciation_price').text('')
		$('.amount_money').text('')
		var type_loan = $("select[name='type_loan']").val();
		var code_type_property = $("select[name='code_type_property']").val();
		var property_id = $("select[name='property_id']").val();
		var product_property = $("select[name='product_property']").val();
		var data = [];
		$(".price_depreciation:checked").each(function () {
			data.push($(this).val());
		});
		var formData = {
			type_loan: type_loan,
			code_type_property: code_type_property,
			property_id: property_id,
			price_depreciation: data,
			loan_product: product_property,
		};
		if (property_id) {
			$.ajax({
				url: _url.base_url + 'property_main/getPriceProperty_new',
				type: "POST",
				data: formData,
				dataType: 'json',
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$('.depreciation_price').text(data.data.gia_tri_tai_san)
					$('.amount_money').text(data.data.so_tien_co_the_vay)
					$(".theloading").hide();
				},
				error: function (data) {
					alert('error')
					$(".theloading").hide();
				}
			});
		} else {
			$('.depreciation_price').text('')
			$('.amount_money').text('')
		}

	})

	$('body').on('click', '.price_depreciation_checkbox', function () {
		$('.depreciation_price').text('')
		$('.amount_money').text('')
		var type_loan = $("select[name='type_loan']").val();
		var code_type_property = $("select[name='code_type_property']").val();
		var property_id = $("select[name='property_id']").val();
		var product_property = $("select[name='product_property']").val();
		var data = [];
		$(".price_depreciation_checkbox:checked").each(function () {
			data.push($(this).val());
		});
		var formData = {
			type_loan: type_loan,
			code_type_property: code_type_property,
			property_id: property_id,
			depreciation_price: data,
			loan_product: product_property,
		}
		if (property_id) {
			$.ajax({
				url: _url.base_url + 'property_main/getPriceProperty_new',
				type: "POST",
				data: formData,
				dataType: 'json',
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$('.depreciation_price').text(data.data.gia_tri_tai_san)
					$('.amount_money').text(data.data.so_tien_co_the_vay)
					$(".theloading").hide();
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
				}
			});
		}
	});

	$('#type_finance').change(function () {
		$('.main_property').val('')
		$('.product_property option').remove()
		$('.product_property').append($('<option>', {value: '', text: 'Chọn sản phẩm vay'}));
		var $select = $('#car_company').selectize();
		var car_company = $select[0].selectize;
		car_company.clear();
		car_company.clearOptions();

		var $select1 = $('#vehicles').selectize();
		var vehicles = $select1[0].selectize;
		vehicles.clear();
		vehicles.clearOptions();

		var $select2 = $('#property_by_main').selectize();
		var property_by_main = $select2[0].selectize;
		property_by_main.clearOptions();
		property_by_main.clear();

		$('.depreciation_by_property').children().remove();
		$('.depreciation_price').text('')
		$('.amount_money').text('')
	})

	$('body').on('change', '.product_property', function () {
		$('.depreciation_price').text('')
		$('.amount_money').text('')
		var type_loan = $("select[name='type_loan']").val();
		var code_type_property = $("select[name='code_type_property']").val();
		var property_id = $("select[name='property_id']").val();
		var product_property = $("select[name='product_property']").val();
		var data = [];
		$(".price_depreciation_checkbox:checked").each(function () {
			data.push($(this).val());
		});
		var formData = {
			type_loan: type_loan,
			code_type_property: code_type_property,
			property_id: property_id,
			depreciation_price: data,
			loan_product: product_property,
		}
		if (property_id) {
			$.ajax({
				url: _url.base_url + 'property_main/getPriceProperty_new',
				type: "POST",
				data: formData,
				dataType: 'json',
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$('.depreciation_price').text(data.data.gia_tri_tai_san)
					$('.amount_money').text(data.data.so_tien_co_the_vay)
					$(".theloading").hide();
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
				}
			});
		}
	});
})
