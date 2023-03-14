$(document).ready(function () {
	$('#dkx_mat_truoc').change(function () {
		var files = $(this)[0].files;
		console.log(files)
		var formData = new FormData();
		formData.append('file', files[0]);
		$.ajax({
			dataType: 'json',
			enctype: 'multipart/form-data',
			url: _url.base_url + 'ajax/upload_img',
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$(".loading").show();
			},
			success: function (data) {
				console.log(data)
				if (data.code == 200) {
					if (data.path === "") {
						$(".loading").hide();
						$('#dkx_mat_truoc').val('');
						alert('Upload không thành công!');
					} else {
						$(".loading").hide();
						$('#dkx_mat_truoc').prop('disabled', true)
						$("#img_dkx_mat_truoc").attr("src", data.path);
						$(".preview img").show(); // Display image element
					}
				} else {
					$(".loading").hide();
					$('#dkx_mat_truoc').val('');
					alert('Upload không thành công!');
				}
			},
			error: function (error) {
				$(".loading").hide();
				$('#dkx_mat_truoc').val('');
				alert('Upload không thành công!');
			}
		});
	});

	$('#dkx_mat_sau').change(function () {
		var files = $(this)[0].files;
		console.log(files)
		var formData = new FormData();
		formData.append('file', files[0]);
		$.ajax({
			dataType: 'json',
			enctype: 'multipart/form-data',
			url: _url.base_url + 'ajax/upload_img',
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$(".loading1").show();
			},
			success: function (data) {
				console.log(data)
				if (data.code == 200) {
					if (data.path === "") {
						$(".loading1").hide();
						$('#dkx_mat_sau').val('');
						alert('Upload không thành công!');
					} else {
						$(".loading1").hide();
						$('#dkx_mat_sau').prop('disabled', true)
						$("#img_dkx_mat_sau").attr("src", data.path);
						$(".preview img").show(); // Display image element
					}
				} else {
					$(".loading1").hide();
					$('#dkx_mat_sau').val('');
					alert('Upload không thành công!');
				}
			},
			error: function (error) {
				$(".loading1").hide();
				$('#dkx_mat_sau').val('');
				alert('Upload không thành công!');
			}
		});
	});
})

$(document).ready(function () {
	const img_default = "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png";
	$('.nhap_lai_dkx').click(function () {
		$('.btn_check_dkx').prop('disabled', true)
		$('#dkx_mat_truoc').prop('disabled', false)
		$('#dkx_mat_sau').prop('disabled', false)
		$('#dkx_mat_truoc').val('')
		$('#dkx_mat_sau').val('')
		$("#img_dkx_mat_truoc").attr("src", img_default);
		$("#img_dkx_mat_sau").attr("src", img_default);
		$('.phan_tram_mt').text('')
		$('.phan_tram_ms').text('')
	})

	$(".nhan_dang_dkx").click(function () {
		let img1 = $('.wait img').attr('src');
		let img2 = $('.wait1 img').attr('src');
		console.log(img1)
		console.log(img2)
		$.ajax({
			url: _url.base_url + 'check_dkx/check_info_dkx?img1=' + img1 + '&img2=' + img2,
			type: 'GET',
			dataType: 'json',
			contentType: false,
			processData: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				$('.btn_check_dkx').prop('disabled', false)
				console.log(data)
				if (data.code == 200) {
					if (data.data.mat_sau === undefined) {
						str1 = '';
					} else {
						str1 = data.data.mat_sau.bien_so_xe
					}
					$('#nhan-hieu').val(data.data.mat_sau === undefined ? '' : data.data.mat_sau.nhan_hieu)
					$('#model').val(data.data.mat_sau === undefined ? '' : data.data.mat_sau.model)
					$('#bien-so-xe').val(str1 === '' ? '' : str1.replace(/\s/g, ''))
					$('#so-khung').val(data.data.mat_sau === undefined ? '' : data.data.mat_sau.so_khung)
					$('#so-may').val(data.data.mat_sau === undefined ? '' : data.data.mat_sau.so_may)
					$('#ho-ten-chu-xe').val(data.data.mat_sau === undefined ? '' : data.data.mat_sau.ten_chu_xe)
					$('#dia-chi-dang-ky').val(data.data.mat_sau === undefined ? '' : data.data.mat_sau.dia_chi)
					$('#so-dang-ky').val(data.data.mat_truoc === undefined ? '' : data.data.mat_truoc.so_dang_ky)
					$('#ngay-cap').val(data.data.mat_sau === undefined ? '' : convertDate(data.data.mat_sau.ngay_cap).toISOString().slice(0, 10))
					$('#ngay-cap-dang-ky').val(data.data.mat_sau === undefined ? '' : data.data.mat_sau.ngay_cap)
					$('.phan_tram_mt').text(data.data.mat_truoc === undefined ? 'Tỉ lệ nhận dạng 0 %' : 'Tỉ lệ nhận dạng ' + data.data.mat_truoc.phan_tram)
					$('.phan_tram_ms').text(data.data.mat_sau === undefined ? 'Tỉ lệ nhận dạng 0 %' : 'Tỉ lệ nhận dạng ' + data.data.mat_sau.phan_tram)
				} else {
					alert(data.message)
				}
			},
			error: function (error) {
				$('.btn_check_dkx').prop('disabled', false)
				$(".theloading").hide();
				alert('Nhận dạng không thành công, bạn nhập đầy đủ thông tin và bấm tiếp tục')
			}
		})
	})

	$('#type_property').change(function () {
		let code = $(this).find(":selected").attr('data-code');
		if (code == 'NĐ') {
			$('.form_gan_dinh_vi').hide();
			$('.form_o_to_ngan_hang').hide();
			$('.btn_check_dkx').prop('disabled', false)
			$('.image-tai-san').hide();
			$('#dkx_mat_truoc').prop('disabled', true)
			$('#dkx_mat_sau').prop('disabled', true)
			$('#dkx_mat_truoc').val('')
			$('#dkx_mat_sau').val('')
			$("#img_dkx_mat_truoc").attr("src", img_default);
			$("#img_dkx_mat_sau").attr("src", img_default);
			$('.phan_tram_mt').text('')
			$('.phan_tram_ms').text('')
			$('#type_tnds').prop('disabled', true)
			$('#type_tnds').val('')
			$('.mic_tnds').hide()
			$('#phi_tnds').val('0')
		} else {
			$('.btn_check_dkx').prop('disabled', true)
			$('.image-tai-san').show();
			$('#dkx_mat_truoc').prop('disabled', false)
			$('#dkx_mat_sau').prop('disabled', false)
			$('#dkx_mat_truoc').val('')
			$('#dkx_mat_sau').val('')
			$("#img_dkx_mat_truoc").attr("src", img_default);
			$("#img_dkx_mat_sau").attr("src", img_default);
			$('.phan_tram_mt').text('')
			$('.phan_tram_ms').text('')
			if(code == 'OTO'){

				$('.form_gan_dinh_vi').show();
				if($('#type_loan').find(":selected").attr('data-code')=="CC")
				$('.form_o_to_ngan_hang').show();
				$('#type_tnds').val('')

				$('.mic_tnds').hide()
			    $('.vbi_tnds').hide()
				$("#type_tnds option").each(function () {
					$(this).remove();
				});
             $('#type_tnds').append($('<option>', {value: '', text: '-- Chọn bảo hiểm --'}));
		     $('#type_tnds').append($('<option>', {value: 'VBI_TNDS', text: 'Bảo hiểm TNDS ô tô'}));
			}else {

				$('.form_gan_dinh_vi').hide();
				$('.form_o_to_ngan_hang').hide();
				$('#type_tnds').prop('disabled', false)
				$('#type_tnds').val('')

				$('.mic_tnds').hide()
			    $('.vbi_tnds').hide()
				$("#type_tnds option").each(function () {
					$(this).remove();
				});
             $('#type_tnds').append($('<option>', {value: '', text: '-- Chọn bảo hiểm --'}));
		     $('#type_tnds').append($('<option>', {value: 'MIC_TNDS', text: 'Bảo hiểm TNDS xe máy'}));
			}

		}
	})

	$('#type_loan').change(function () {
		let code = $(this).find(":selected").attr('data-code');
		if (code == 'TC') {
			$('.form_o_to_ngan_hang').hide();
			$('.btn_check_dkx').prop('disabled', false)
			$('.image-tai-san').hide();
			$('#dkx_mat_truoc').prop('disabled', true)
			$('#dkx_mat_sau').prop('disabled', true)
			$('#dkx_mat_truoc').val('')
			$('#dkx_mat_sau').val('')
			$("#img_dkx_mat_truoc").attr("src", img_default);
			$("#img_dkx_mat_sau").attr("src", img_default);
			$('.phan_tram_mt').text('')
			$('.phan_tram_ms').text('')
		} else {
			$('.form_o_to_ngan_hang').hide();
			$('.btn_check_dkx').prop('disabled', true)
			$('.image-tai-san').show();
			$('#dkx_mat_truoc').prop('disabled', false)
			$('#dkx_mat_sau').prop('disabled', false)
			$('#dkx_mat_truoc').val('')
			$('#dkx_mat_sau').val('')
			$("#img_dkx_mat_truoc").attr("src", img_default);
			$("#img_dkx_mat_sau").attr("src", img_default);
			$('.phan_tram_mt').text('')
			$('.phan_tram_ms').text('')
			if(code=="CC" && $('#type_property').find(":selected").attr('data-code')== 'OTO')
				$('.form_o_to_ngan_hang').show();
		}
	})

	function convertDate(str) {
		let arr = str.split('-');
		mydate = new Date(arr[2] + '-' + arr[1] + '-' + arr[0]);
		return mydate
	}
})
