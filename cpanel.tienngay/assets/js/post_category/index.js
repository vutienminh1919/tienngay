$('#create_category').click(function (event) {
	event.preventDefault();
	var category_name_banner = $("input[name='category_name_banner']").val();
	var category_name_post = $("input[name='category_name_post']").val();
	var type_category = $("input[name='type_category']:checked").val();
	var status = $("input[name='status']").val();

	var formData = {
		category_name_banner: category_name_banner,
		category_name_post: category_name_post,
		type_category: type_category,
		status: status,
	};

	$.ajax({
		url: _url.base_url + 'PostCategories/doAddCategory',
		type: 'POST',
		data: formData,
		dataType: "JSON",
		beforeSend: function () {$(".theloading").show();},
		success: function (data) {
		console.log(data);
			$(".theloading").hide();
			if (data.res) {
				toastr.success(data.message, {
					timeOut: 7000,
				});
				setTimeout(function(){
					window.location.href = _url.base_url + 'PostCategories/listCategory';
				}, 3000);
			} else {
				toastr.error(data.message, {
					timeOut: 7000,
				});
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});

$('#update_category').click(function (event) {
	event.preventDefault();
	var id = $("input[name='id_category']").val();
	var category_name_banner = $("input[name='category_name_banner']").val();
	var category_name_post = $("input[name='category_name_post']").val();
	var type_category = $("input[name='type_category']:checked").val();
	var status = $("input[name='status']:checked").val();

	var formData = {
		id: id,
		category_name_banner: category_name_banner,
		category_name_post: category_name_post,
		type_category: type_category,
		status: status,
	};

	$.ajax({
		url: _url.base_url + 'PostCategories/doUpdateCategory',
		type: 'POST',
		data: formData,
		dataType: "JSON",
		beforeSend: function () {$(".theloading").show();},
		success: function (data) {
			console.log(data);
			$(".theloading").hide();
			if (data.res) {
				toastr.success(data.message, {
					timeOut: 7000,
				});
				setTimeout(function(){
					window.location.href = _url.base_url + 'PostCategories/listCategory';
				}, 3000);
			} else {
				toastr.error(data.message, {
					timeOut: 7000,
				});
			}
		},
		error: function (data) {
			console.log(data);
			$(".theloading").hide();
		}
	});
});
