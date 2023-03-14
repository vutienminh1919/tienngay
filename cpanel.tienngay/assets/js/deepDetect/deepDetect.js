$(document).ready(function () {
	$('.contract_deepDetect').click(function () {
		$('#data_deepDetect').empty('');
		var avatar = $(this).attr('data-avatar');
		$.ajax({
			url: _url.base_url + 'ajax/deepDetect?link=' + avatar,
			type: "GET",
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".loading-modal-contract-deepDetect").show();
			},
			success: function (data) {
				$(".loading-modal-contract-deepDetect").hide();
				if (data.data.length > 0) {
					$.each(data.data, function (k, v) {
						if (v.type == 1) {
							const detail = _url.base_url + 'pawn/detail?id=' + v.id;
							html = "<tr style='text-align: center'><td><a href='" + v.avatar + "' data-fancybox='gallery'>" + "<img style='width: 100px; height: 100px' src=" + v.avatar + "></a>" + "</td><td class='text-danger'>" + v.score + " %" + "</td><td>" + v.customer_name + "</td><td><a href='" + detail + "' target='_blank'>" + v.code_contract_disbursement + "</a></td><td>" + v.amount_money + "</td><td>" + v.store + "</td><td>" + v.status + "</td></tr>";
							$("#data_deepDetect").append(html);
						}
					})
				} else {
					$("#data_deepDetect").append("<tr style='text-align: center'><td class='text-danger' colspan='10'>" + "Không có dữ liệu" + "</td></tr>");
				}
			},
			error: function () {
				$(".loading-modal-contract-deepDetect").hide();
				alert('error')
			}
		})
	})
});
