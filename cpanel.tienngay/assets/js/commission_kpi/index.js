$("#save_commission").click(function (event) {
	event.preventDefault();
	
	var title_commission = $("input[name='title_commision']").val();
	var start_date = $("input[name='start_date']").val();
	var end_date = $("input[name='end_date']").val();
	var status = $("input[name='status']:checked").val();
	var note_commission = $("textarea[name='note_commission']").val();
	var dkxm_commission_1 = $("input[name='dkxm_commission_1']").val();
	var dkxm_commission_2 = $("input[name='dkxm_commission_2']").val();
	var dkxm_commission_dv = $(".dkxm_commission_dv").text();
	var vnuttxcn_commission_1 = $("input[name='vnuttxcn_commission_1']").val();
	var vnuttxcn_commission_2 = $("input[name='vnuttxcn_commission_2']").val();
	var vnuttxcn_commission_dv = $(".vnuttxcn_commission_dv").text();
	var vqdkccot_commission_1 = $("input[name='vqdkccot_commission_1']").val();
	var vqdkccot_commission_2 = $("input[name='vqdkccot_commission_2']").val();
	var vqdkccot_commission_dv = $(".vqdkccot_commission_dv").text();
	var bhplt_commission_1 = $("input[name='bhplt_commission_1']").val();
	var bhplt_commission_2 = $("input[name='bhplt_commission_2']").val();
	var bhplt_commission_dv = $(".bhplt_commission_dv").text();
	var vqbds_commission_1 = $("input[name='vqbds_commission_1']").val();
	var vqbds_commission_2 = $("input[name='vqbds_commission_2']").val();
	var vqbds_commission_dv = $(".vqbds_commission_dv").text();
	var ptivta_commission_1 = $("input[name='ptivta_commission_1']").val();
	var ptivta_commission_2 = $("input[name='ptivta_commission_2']").val();
	var ptivta_commission_dv = $(".ptivta_commission_dv").text();
	var sxh_commission_1 = $("input[name='sxh_commission_1']").val();
	var sxh_commission_2 = $("input[name='sxh_commission_2']").val();
	var sxh_commission_dv = $(".sxh_commission_dv").text();
	var utv_commission_1 = $("input[name='utv_commission_1']").val();
	var utv_commission_2 = $("input[name='utv_commission_2']").val();
	var utv_commission_dv = $(".utv_commission_dv").text();
	var easy_commission_1 = $("input[name='easy_commission_1']").val();
	var easy_commission_2 = $("input[name='easy_commission_2']").val();
	var easy_commission_dv = $(".easy_commission_dv").text();
	var bhtnds_commission_1 = $("input[name='bhtnds_commission_1']").val();
	var bhtnds_commission_2 = $("input[name='bhtnds_commission_2']").val();
	var bhtnds_commission_dv = $(".bhtnds_commission_dv").text();

	var dkxm_commission_new_3 = $("input[name='dkxm_commission_new_3']").val();
	var dkxm_commission_new_4 = $("input[name='dkxm_commission_new_4']").val();

	var vay_nhanh_lap_dinh_vi_new_1 = $("input[name='vay_nhanh_lap_dinh_vi_new_1']").val();
	var vay_nhanh_lap_dinh_vi_new_2 = $("input[name='vay_nhanh_lap_dinh_vi_new_2']").val();
	var vay_nhanh_lap_dinh_vi_dv = $(".vay_nhanh_lap_dinh_vi_dv").text();

	var topup_commission = $("input[name='topup_commission']").val();
	var topup_commission_dv = $(".topup_commission_dv").text();

	var dkoto_commission_1 = $("input[name='dkoto_commission_1']").val();
	var dkoto_commission_2 = $("input[name='dkoto_commission_2']").val();
	var dkoto_commission_3 = $("input[name='dkoto_commission_3']").val();
	var dkoto_commission_4 = $("input[name='dkoto_commission_4']").val();
	var dkoto_commission_dv = $(".dkoto_commission_dv").text();


	//
	// var formData = {
	//
	//
	//
	// };
	// console.log(formData);
	$.ajax({
		url: _url.base_url + "Commission_kpi/doCreateCommission",
		type: "POST",
		dataType: "JSON",
		data: {
			title_commission: title_commission,
			start_date: start_date,
			end_date: end_date,
			status: status,
			note_commission: note_commission,
			dkxm_commission_1: dkxm_commission_1,
			dkxm_commission_2: dkxm_commission_2,
			dkxm_commission_dv: dkxm_commission_dv,
			vnuttxcn_commission_1: vnuttxcn_commission_1,
			vnuttxcn_commission_2: vnuttxcn_commission_2,
			vnuttxcn_commission_dv: vnuttxcn_commission_dv,
			vqdkccot_commission_1: vqdkccot_commission_1,
			vqdkccot_commission_2: vqdkccot_commission_2,
			vqdkccot_commission_dv: vqdkccot_commission_dv,
			bhplt_commission_1: bhplt_commission_1,
			bhplt_commission_2: bhplt_commission_2,
			bhplt_commission_dv: bhplt_commission_dv,
			vqbds_commission_1: vqbds_commission_1,
			vqbds_commission_2: vqbds_commission_2,
			vqbds_commission_dv: vqbds_commission_dv,
			ptivta_commission_1: ptivta_commission_1,
			ptivta_commission_2: ptivta_commission_2,
			ptivta_commission_dv: ptivta_commission_dv,
			sxh_commission_1: sxh_commission_1,
			sxh_commission_2: sxh_commission_2,
			sxh_commission_dv: sxh_commission_dv,
			utv_commission_1: utv_commission_1,
			utv_commission_2: utv_commission_2,
			utv_commission_dv: utv_commission_dv,
			easy_commission_1: easy_commission_1,
			easy_commission_2: easy_commission_2,
			easy_commission_dv: easy_commission_dv,
			bhtnds_commission_1: bhtnds_commission_1,
			bhtnds_commission_2: bhtnds_commission_2,
			bhtnds_commission_dv: bhtnds_commission_dv,

			dkxm_commission_new_3: dkxm_commission_new_3,
			dkxm_commission_new_4: dkxm_commission_new_4,
			vay_nhanh_lap_dinh_vi_new_1:vay_nhanh_lap_dinh_vi_new_1,
			vay_nhanh_lap_dinh_vi_new_2:vay_nhanh_lap_dinh_vi_new_2,
			vay_nhanh_lap_dinh_vi_dv:vay_nhanh_lap_dinh_vi_dv,
			topup_commission:topup_commission,
			topup_commission_dv:topup_commission_dv,
			dkoto_commission_1:dkoto_commission_1,
			dkoto_commission_2:dkoto_commission_2,
			dkoto_commission_3:dkoto_commission_3,
			dkoto_commission_4:dkoto_commission_4,
			dkoto_commission_dv:dkoto_commission_dv,
		},
		beforeSend: function () {
			$('.theloading').show();
		},
		success: function (data) {
			console.log(data);
			if (data.status == 200) {
				$('.theloading').hide();
				toastr.success(data.msg, {
					timeOut: 5000,
				});
				setTimeout(function () {
					 window.location.href = _url.base_url + 'Commission_kpi/listCommission';
				}, 2000);
			} else {
				$('.theloading').hide();
				toastr.error(data.msg, {
					timeOut: 2000,
				});
			}
		},
		error: function (data) {
			$('.theloading').hide();
			toastr.error(data.msg, {
				timeOut: 2000,
			});
		}
	});

});
