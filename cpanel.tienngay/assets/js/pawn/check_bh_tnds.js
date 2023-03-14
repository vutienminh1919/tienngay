$(document).ready(function () {
	$('#hieu_xe').selectize({
	create: false,
	valueField: 'hieu_xe',
	labelField: 'hieu_xe',
	searchField: 'hieu_xe',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}

});
	$("#type_tnds").change(function () {
		let type_tnds = $(this).val()
		if (type_tnds == 'MIC_TNDS') {
			let loai_xe = $('#mic_dung_tich_xe').val();
			let muc_trach_nhiem = $("#mic_muc_trach_nhiem").val();
			let thoi_han_hieu_luc = '1';
			console.log(muc_trach_nhiem)
			$.ajax({
				url: _url.base_url + "mic_tnds/get_price_mic_tnds?loai_xe=" + loai_xe + '&muc_trach_nhiem=' + muc_trach_nhiem + '&thoi_han_hieu_luc=' + thoi_han_hieu_luc,
				type: "GET",
				dataType: 'json',
				beforeSend: function () {
			$(".theloading").show();
		},
				success: function (data) {
					$("input[name='phi_tnds']").val(data.data);
					$(".theloading").hide();
				},
				error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
			})
			$('.mic_tnds').show()
			$('.vbi_tnds').hide()
		} else if (type_tnds == 'VBI_TNDS') {
			let nhom_xe = $('#nhom_xe').val();
			let hieu_xe = $("#hieu_xe").val();
			let hang_xe = $("#hang_xe").val();
			let thoi_han_hieu_luc = '1';
		
			$.ajax({
				url: _url.base_url + "vbi_tnds/get_phi_vbi_tnds?nhom_xe=" + nhom_xe + '&hieu_xe=' + hieu_xe + '&hang_xe=' + hang_xe,
				type: "GET",
				dataType: 'json',
				beforeSend: function () {
			$(".theloading").show();
		},
				success: function (data) {
					$("input[name='phi_tnds']").val(data.phi);
					$(".theloading").hide();
				},
				error: function () {
					$(".theloading").hide();
				}
			})
			$('.mic_tnds').hide()
			$('.vbi_tnds').show()
		} else {
			$('.mic_tnds').hide()
			$('.vbi_tnds').hide()
			$("input[name='phi_tnds']").val('0')
		}
	})

	$("#mic_dung_tich_xe").on("change", function () {
		let loai_xe = $('#mic_dung_tich_xe').val();
		let muc_trach_nhiem = $("#mic_muc_trach_nhiem").val();
		let thoi_han_hieu_luc = '1';
		console.log(muc_trach_nhiem)
		$.ajax({
			url: _url.base_url + "mic_tnds/get_price_mic_tnds?loai_xe=" + loai_xe + '&muc_trach_nhiem=' + muc_trach_nhiem + '&thoi_han_hieu_luc=' + thoi_han_hieu_luc,
			type: "GET",
			dataType: 'json',
			beforeSend: function () {
			$(".theloading").show();
		},
			success: function (data) {
				$("input[name='phi_tnds']").val(data.data);
				$(".theloading").hide();
			},
			error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
			}, 1000);
		}
		})
	});

	$("#mic_muc_trach_nhiem").on("change", function () {
		let loai_xe = $('#mic_dung_tich_xe').val();
		let muc_trach_nhiem = $("#mic_muc_trach_nhiem").val();
		let thoi_han_hieu_luc = '1';
		console.log(muc_trach_nhiem)
		$.ajax({
			url: _url.base_url + "mic_tnds/get_price_mic_tnds?loai_xe=" + loai_xe + '&muc_trach_nhiem=' + muc_trach_nhiem + '&thoi_han_hieu_luc=' + thoi_han_hieu_luc,
			type: "GET",
			dataType: 'json',
			beforeSend: function () {
			$(".theloading").show();
		},
			success: function (data) {
				$("input[name='phi_tnds']").val(data.data);
				$(".theloading").hide();
			},
			error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
					}, 1000);
				}
		})
	});

//ô tô
	$("#nhom_xe").on("change", function () {
			let nhom_xe = $('#nhom_xe').val();
			let hieu_xe = $("#hieu_xe").val();
			let hang_xe = $("#hang_xe").val();
			let thoi_han_hieu_luc = '1';
		
			$.ajax({
				url: _url.base_url + "vbi_tnds/get_phi_vbi_tnds?nhom_xe=" + nhom_xe + '&hieu_xe=' + hieu_xe + '&hang_xe=' + hang_xe,
				type: "GET",
				dataType: 'json',
				beforeSend: function () {
			$(".theloading").show();
		},
				success: function (data) {
					$("input[name='phi_tnds']").val(data.phi);
					$(".theloading").hide();
				},
				error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
					}, 1000);
				}
			})
		});
	$("#hieu_xe").on("change", function () {
			let nhom_xe = $('#nhom_xe').val();
			let hieu_xe = $("#hieu_xe").val();
			let hang_xe = $("#hang_xe").val();
			let thoi_han_hieu_luc = '1';
			
			$.ajax({
				url: _url.base_url + "vbi_tnds/get_phi_vbi_tnds?nhom_xe=" + nhom_xe + '&hieu_xe=' + hieu_xe + '&hang_xe=' + hang_xe,
				type: "GET",
				dataType: 'json',
				beforeSend: function () {
						$(".theloading").show();
					},
				success: function (data) {
					$("input[name='phi_tnds']").val(data.phi);
					$(".theloading").hide();
				},
				error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
					}, 1000);
				}
			})
		});
	$("#hang_xe").on("change", function () {
			let nhom_xe = $('#nhom_xe').val();
			let hieu_xe = $("#hieu_xe").val();
			let hang_xe = $("#hang_xe").val();
			let thoi_han_hieu_luc = '1';
			
			$.ajax({
				url: _url.base_url + "vbi_tnds/get_phi_vbi_tnds?nhom_xe=" + nhom_xe + '&hieu_xe=' + hieu_xe + '&hang_xe=' + hang_xe,
				type: "GET",
				dataType: 'json',
				beforeSend: function () {
						$(".theloading").show();
					},
				success: function (data) {
					$("input[name='phi_tnds']").val(data.phi);
					$(".theloading").hide();
				},
				error: function (error) {
			setTimeout(function () {
				$(".theloading").hide();
					}, 1000);
				}
			})
		});

})
