$(document).ready(function () {
	$(".update_hinh_thuc_cam_co").click(function () {
		let id = $(this).attr('data-id');
		$.ajax({
			url: _url.base_url + "property_valuation/get_hinh_thuc_cc_or_dkx?id=" + id,
			type: "GET",
			dataType: 'json',
			success: function (data) {
				$("input[name='id_hinh_thuc_cc_update']").empty()
				$("input[name='cc_xe_may']").empty()
				$("input[name='cc_o_to']").empty()
				$("input[name='id_hinh_thuc_cc_update']").val(id)
				$("input[name='cc_xe_may']").val(data.data.percent.XM)
				$("input[name='cc_o_to']").val(data.data.percent.OTO)
			}
		})
	})
})

$(document).ready(function () {
	$(".update_hinh_thuc_cho_vay").click(function () {
		let id = $(this).attr('data-id');
		$.ajax({
			url: _url.base_url + "property_valuation/get_hinh_thuc_cc_or_dkx?id=" + id,
			type: "GET",
			dataType: 'json',
			success: function (data) {
				$("input[name='id_hinh_thuc_dkx_update']").empty()
				$("input[name='dkx_xe_may']").empty()
				$("input[name='dkx_o_to']").empty()
				$("input[name='id_hinh_thuc_dkx_update']").val(id)
				$("input[name='dkx_xe_may']").val(data.data.percent.XM)
				$("input[name='dkx_o_to']").val(data.data.percent.OTO)
			}
		})
	})
})

$(document).ready(function () {
	$(".update_hinh_thuc_tin_chap").click(function () {
		let id = $(this).attr('data-id');
		$.ajax({
			url: _url.base_url + "property_valuation/get_hinh_thuc_tc?id=" + id,
			type: "GET",
			dataType: 'json',
			success: function (data) {
				$("input[name='id_hinh_thuc_tc_update']").empty()
				$("input[name='tin_chap']").empty()
				$("input[name='id_hinh_thuc_tc_update']").val(id)
				$("input[name='tin_chap']").val(data.data.percent.TC)
			}
		})
	})
})

$(document).ready(function () {
	$('#update_cho_vay_btnSave').click(function (event) {
		event.preventDefault();
		var id = $("input[name='id_hinh_thuc_dkx_update']").val();
		var xm = $("input[name='dkx_xe_may']").val()
		var oto = $("input[name='dkx_o_to']").val()
		var formData = new FormData();
		formData.append('id', id);
		formData.append('xm', xm);
		formData.append('oto', oto);
		$('#updateDepreciationModal').modal('hide');
		$.ajax({
			url: _url.base_url + 'property_valuation/update_hinh_thuc_cc_or_dkx',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				} else if (data.code == 401) {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				}
			}
		});
	})
})

$(document).ready(function () {
	$('#update_cam_co_btnSave').click(function (event) {
		event.preventDefault();
		var id = $("input[name='id_hinh_thuc_cc_update']").val();
		var xm = $("input[name='cc_xe_may']").val()
		var oto = $("input[name='cc_o_to']").val()
		var formData = new FormData();
		formData.append('id', id);
		formData.append('xm', xm);
		formData.append('oto', oto);
		$('#updateDepreciationModal').modal('hide');
		$.ajax({
			url: _url.base_url + 'property_valuation/update_hinh_thuc_cc_or_dkx',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				} else if (data.code == 401) {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				}
			}
		});
	})
})

$(document).ready(function () {
	$('#update_tin_chap_btnSave').click(function (event) {
		event.preventDefault();
		var id = $("input[name='id_hinh_thuc_tc_update']").val();
		var tc = $("input[name='tin_chap']").val()
		var formData = new FormData();
		formData.append('id', id);
		formData.append('tc', tc);
		$('#updateDepreciationModal').modal('hide');
		$.ajax({
			url: _url.base_url + 'property_valuation/update_hinh_thuc_tc',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.code == 200) {
					$("#successModal").modal("show");
					$(".msg_success").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				} else if (data.code == 401) {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				}
			}
		});
	})
})
