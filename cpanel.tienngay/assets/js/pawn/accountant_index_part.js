//BPĐG định giá tài sản thanh lý
function bp_dinh_gia_xu_ly(id) {
	$("#debt_remain_root_bpdg").empty();
	$("#date_seize_bpdg").empty();
	$("#name_person_seize_bpdg").empty();
	$("#frame_number_bpdg").empty();
	$("#engine_number_bpdg").empty();
	$("#license_plates_bpdg").empty();
	$("#license_number_bpdg").empty();
	$("#asset_name_bpdg").empty();
	$("#asset_branch_bpdg").empty();
	$("#asset_model_bpdg").empty();
	$("#number_km_bpdg").empty();
	$("#note_create_liq").empty();
	$("#img_create_liquidation").empty();
	$.ajax({
		url: _url.base_url + 'accountant/contractInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			var liq = result.data.liquidation_info;
			var debt_remain_root = result.data.original_debt.du_no_goc_con_lai;
			var date_seize_bpdg = new Date(liq.date_seize).format('d/m/Y');
			var name_person_seize_bpdg = liq.name_person_seize;
			var frame_number_bpdg = liq.frame_number;
			var engine_number_bpdg = liq.engine_number;
			var license_plates_bpdg = liq.license_plates;
			var license_number_bpdg = liq.license_number;
			var asset_name_bpdg = liq.asset_name;
			var asset_branch_bpdg = liq.asset_branch;
			var asset_model_bpdg = liq.asset_model;
			var number_km_bpdg = liq.number_km;
			var note_create_liq = liq.note_create_liquidation;
			var html1 = "";
			var html2 = "";
			var html3 = "";
			var html4 = "";
			var html5 = "";
			var html6 = "";
			var html7 = "";
			var html8 = "";
			var html9 = "";
			var html10 = "";
			var html11 = "";
			var html12 = "";
			html1 += "<p class='text-danger' style='padding-top: 8px'>" + numeral(debt_remain_root).format('0,0') + " VNĐ" + "</p>";
			html2 += "<p style='padding-top: 8px; color: black'>" + date_seize_bpdg + "</p>";
			html3 += "<p style='padding-top: 8px; color: black'>" + name_person_seize_bpdg + "</p>";
			html4 += "<p style='padding-top: 8px; color: black'>" + frame_number_bpdg + "</p>";
			html5 += "<p style='padding-top: 8px; color: black'>" + engine_number_bpdg + "</p>";
			html6 += "<p style='padding-top: 8px; color: black'>" + license_plates_bpdg + "</p>";
			html7 += "<p style='padding-top: 8px; color: black'>" + license_number_bpdg + "</p>";
			html8 += "<p style='padding-top: 8px; color: black'>" + asset_name_bpdg + "</p>";
			html9 += "<p style='padding-top: 8px; color: black'>" + asset_branch_bpdg + "</p>";
			html10 += "<p style='padding-top: 8px; color: black'>" + asset_model_bpdg + "</p>";
			html11 += "<p style='padding-top: 8px; color: black'>" + number_km_bpdg + "</p>";
			html12 += "<textarea style='padding-top: 8px; color: black' class='col-md-12 col-xs-12 form-control' rows='3' disabled>" + note_create_liq + "</textarea>";
			$("#debt_remain_root_bpdg").append(html1);
			$("#date_seize_bpdg").append(html2);
			$("#name_person_seize_bpdg").append(html3);
			$("#frame_number_bpdg").append(html4);
			$("#engine_number_bpdg").append(html5);
			$("#license_plates_bpdg").append(html6);
			$("#license_number_bpdg").append(html7);
			$("#asset_name_bpdg").append(html8);
			$("#asset_branch_bpdg").append(html9);
			$("#asset_model_bpdg").append(html10);
			$("#number_km_bpdg").append(html11);
			$("#note_create_liq").append(html12);
			$('input[name="contract_id_liq"]').val(result.data._id.$oid);
			$("input[name='note_bpdg']").val();
			var html = "";
			if (liq.img_liquidation != "") {
				for (var j in liq.img_liquidation) {
					var loc = new URL(liq.img_liquidation[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');
					console.log()
					if (liq.img_liquidation[j].file_type == 'image/png' || liq.img_liquidation[j].file_type == 'image/jpg' || liq.img_liquidation[j].file_type == 'image/jpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' class='w-100' src='" + liq.img_liquidation[j].path + "'></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'audio/mp3' || liq.img_liquidation[j].file_type == 'audio/mpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img style='display: none' name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq.img_liquidation[j].path +"' ></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'video/mp4') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100'></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'application/pdf') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a target='_blank' href='" + liq.img_liquidation[j].path + "'  data-max-width='992' data-type='send_file'><img name='img_send_file'  data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq.img_liquidation[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'></a>";
						html += "</div>"
					}
				}
			} else {
				html += '<td></td>'
			}
			$("#img_create_liquidation").append(html);
			$("#bpdg_processing_modal").modal("show");
		}
	});
}

//Show thông tin update BP Định giá lại tài sản thanh lý
function bp_dinh_gia_lai(id) {
	$("#debt_remain_root_bpdg_update").empty();
	$("#date_seize_bpdg_update").empty();
	$("#name_person_seize_bpdg_update").empty();
	$("#frame_number_bpdg_update").empty();
	$("#engine_number_bpdg_update").empty();
	$("#license_plates_bpdg_update").empty();
	$("#license_number_bpdg_update").empty();
	$("#note_create_liq_update").empty();
	$("#img_create_liquidation_update").empty();
	$("#img_thn_return").empty();
	$("#img_bpdg_update").empty();
	$("#name_valuation_update").empty();
	$("#phone_valuation_update").empty();
	$("#price_suggest_bpdg_update").empty();
	$("#note_bpdg_update").empty();
	$("#date_effect_bpdg_update").empty();
	$.ajax({
		url: _url.base_url + 'accountant/contractInfo/' + id,
		type: "GET",
		dateType: "JSON",
		success: function (result) {
			var liq = result.data.liquidation_info;
			var liq_thn = result.data.liquidation_info.thn;
			var liq_bpdg = result.data.liquidation_info.bpdg;
			var debt_remain_root = result.data.original_debt.du_no_goc_con_lai;
			var date_seize_bpdg = new Date(liq.date_seize).format('d/m/Y');
			var name_person_seize_bpdg = liq.name_person_seize;
			var frame_number_bpdg = liq.frame_number;
			var engine_number_bpdg = liq.engine_number;
			var license_plates_bpdg = liq.license_plates;
			var license_number_bpdg = liq.license_number;
			var note_thn_return = liq.thn.note;
			var html1 = "";
			var html2 = "";
			var html3 = "";
			var html4 = "";
			var html5 = "";
			var html6 = "";
			var html7 = "";
			var html8 = "";
			html1 += "<p class='text-danger' style='padding-top: 8px'>" + numeral(debt_remain_root).format('0,0') + " VNĐ" + "</p>";
			html2 += "<p style='padding-top: 8px; color: black'>" + date_seize_bpdg + "</p>";
			html3 += "<p style='padding-top: 8px; color: black'>" + name_person_seize_bpdg + "</p>";
			html4 += "<p style='padding-top: 8px; color: black'>" + frame_number_bpdg + "</p>";
			html5 += "<p style='padding-top: 8px; color: black'>" + engine_number_bpdg + "</p>";
			html6 += "<p style='padding-top: 8px; color: black'>" + license_plates_bpdg + "</p>";
			html7 += "<p style='padding-top: 8px; color: black'>" + license_number_bpdg + "</p>";
			html8 += "<textarea style='padding-top: 8px; color: black' class='col-md-12 col-xs-12 form-control' rows='3' disabled>" + note_thn_return + "</textarea>";
			$("#debt_remain_root_bpdg_update").append(html1);
			$("#date_seize_bpdg_update").append(html2);
			$("#name_person_seize_bpdg_update").append(html3);
			$("#frame_number_bpdg_update").append(html4);
			$("#engine_number_bpdg_update").append(html5);
			$("#license_plates_bpdg_update").append(html6);
			$("#license_number_bpdg_update").append(html7);
			$("#note_create_liq_update").append(html8);
			var nf = Intl.NumberFormat();
			$('input[name="contract_id_liq"]').val(result.data._id.$oid);
			$("input[name='note_bpdg_update']").val();
			$('input[name="name_valuation_update"]').val(liq.bpdg.name_valuation);
			$('input[name="phone_valuation_update"]').val(liq.bpdg.phone_valuation);
			$('input[name="date_effect_bpdg_update"]').val(liq.bpdg.date_effect_bpdg);
			$('input[name="price_suggest_bpdg_update"]').val(nf.format(Math.floor(liq.bpdg.price_suggest_bpdg)));
			$('#note_bpdg_update').val(liq.bpdg.note);
			var html = "";
			var html_img_thn = "";
			var html_img_bpdg = "";
			if (liq.img_liquidation != "") {
				for (var j in liq.img_liquidation) {
					var loc = new URL(liq.img_liquidation[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');
					if (liq.img_liquidation[j].file_type == 'image/png' || liq.img_liquidation[j].file_type == 'image/jpg' || liq.img_liquidation[j].file_type == 'image/jpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' class='w-100' src='" + liq.img_liquidation[j].path + "'></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'audio/mp3' || liq.img_liquidation[j].file_type == 'audio/mpeg') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq.img_liquidation[j].path +"' ></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'video/mp4') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a href='" + liq.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq.img_liquidation[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display:none;' name='img_send_file' data-key='"+ liq.img_liquidation[j].key +"' data-fileName='"+ liq.img_liquidation[j].file_name +"' data-fileType='"+ liq.img_liquidation[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq.img_liquidation[j].path +"'></a>";
						html += "</div>"
					}
					if (liq.img_liquidation[j].file_type == 'application/pdf') {
						html += "<div class='block'>";
						html += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html += "<a target='_blank' href='" + liq.img_liquidation[j].path + "'  data-max-width='992' data-type='send_file'><img name='img_send_file'  data-key='" + liq.img_liquidation[j].key + "' data-fileName='" + liq.img_liquidation[j].file_name + "' data-fileType='" + liq.img_liquidation[j].file_type + "' data-type='send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq.img_liquidation[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'></a>";
						html += "</div>"
					}
				}
			} else {
				html += '<td></td>'
			}
			if (liq_thn.image_from_email_ceo != "") {
				for (var j in liq_thn.image_from_email_ceo) {
					var loc = new URL(liq_thn.image_from_email_ceo[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s');
					if (liq_thn.image_from_email_ceo[j].file_type == 'image/png' || liq_thn.image_from_email_ceo[j].file_type == 'image/jpg' || liq_thn.image_from_email_ceo[j].file_type == 'image/jpeg') {
						html_img_thn += "<div class='block'>";
						html_img_thn += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_thn += "<a href='" + liq_thn.image_from_email_ceo[j].path + "' class='magnifyitem' data-magnify='gallery' data-group='thegallery' data-gallery='uploads_identify_1' data-max-width='992' data-type='send_file' data-title='Thông báo'><img name='img_send_file' data-key='" + liq_thn.image_from_email_ceo[j].key + "' data-fileName='" + liq_thn.image_from_email_ceo[j].file_name + "' data-fileType='" + liq_thn.image_from_email_ceo[j].file_type + "' data-type='send_file' class='w-100' src='" + liq_thn.image_from_email_ceo[j].path + "'></a>";
						html_img_thn += "</div>"
					}
					if (liq_thn.image_from_email_ceo[j].file_type == 'audio/mp3' || liq_thn.image_from_email_ceo[j].file_type == 'audio/mpeg') {
						html_img_thn += "<div class='block'>";
						html_img_thn += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_thn += "<a href='" + liq_thn.image_from_email_ceo[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_thn.image_from_email_ceo[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_send_file' data-key='"+ liq_thn.image_from_email_ceo[j].key +"' data-fileName='"+ liq_thn.image_from_email_ceo[j].file_name +"' data-fileType='"+ liq_thn.image_from_email_ceo[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq_thn.image_from_email_ceo[j].path +"' ></a>";
						html_img_thn += "</div>"
					}
					if (liq_thn.image_from_email_ceo[j].file_type == 'video/mp4') {
						html_img_thn += "<div class='block'>";
						html_img_thn += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_thn += "<a href='" + liq_thn.image_from_email_ceo[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_thn.image_from_email_ceo[j].file_name +"</span><img name='img_send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display: none' name='img_send_file' data-key='"+ liq_thn.image_from_email_ceo[j].key +"' data-fileName='"+ liq_thn.image_from_email_ceo[j].file_name +"' data-fileType='"+ liq_thn.image_from_email_ceo[j].file_type +"'  data-type='send_file' class='w-100' src='"+ liq_thn.image_from_email_ceo[j].path +"'></a>";
						html_img_thn += "</div>"
					}
					if (liq_thn.image_from_email_ceo[j].file_type == 'application/pdf') {
						html_img_thn += "<div class='block'>";
						html_img_thn += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_thn += "<a target='_blank' href='" + liq_thn.image_from_email_ceo[j].path + "'  data-max-width='992' data-type='send_file'><img name='img_send_file'  data-key='" + liq_thn.image_from_email_ceo[j].key + "' data-fileName='" + liq_thn.image_from_email_ceo[j].file_name + "' data-fileType='" + liq_thn.image_from_email_ceo[j].file_type + "' data-type='send_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq_thn.image_from_email_ceo[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'></a>";
						html_img_thn += "</div>"
					}
				}
			} else {
				html_img_thn += '<td></td>'
			}
			if (liq_bpdg.img_liquidation != "") {
				for (var j in liq_bpdg.img_liquidation) {
					var loc = new URL(liq_bpdg.img_liquidation[j].path);
					const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s')
					if (liq_bpdg.img_liquidation[j].file_type == "image/png" || liq_bpdg.img_liquidation[j].file_type == "image/jpg" || liq_bpdg.img_liquidation[j].file_type == "image/jpeg") {
						html_img_bpdg += "<div class='block'>";
						html_img_bpdg += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_bpdg += "<a href='" + liq_bpdg.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-src='" + liq_bpdg.img_liquidation[j].path + "' data-group='thegallery' data-gallery='img_liquidation' data-max-width='992' data-type='img_liqui'><img data-type='img_liqui' data-filetype='" + liq_bpdg.img_liquidation[j].file_type + "' data-filename='" + liq_bpdg.img_liquidation[j].file_name + "' name='img_file' data-key='" + liq_bpdg.img_liquidation[j].key + "' src='" + liq_bpdg.img_liquidation[j].path + "'>" + "</a>";
						html_img_bpdg +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html_img_bpdg +=	"</div>";
					} else if (liq_bpdg.img_liquidation[j].file_type == "audio/mp3" || liq_bpdg.img_liquidation[j].file_type == 'audio/mpeg') {
						html_img_bpdg += "<div class='block'>";
						html_img_bpdg += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_bpdg += "<a href='" + liq_bpdg.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_bpdg.img_liquidation[j].file_name +"</span><img name='img_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://image.flaticon.com/icons/png/512/81/81281.png'><img name='img_file' data-key='"+ liq_bpdg.img_liquidation[j].key +"' data-fileName='"+ liq_bpdg.img_liquidation[j].file_name +"' data-fileType='"+ liq_bpdg.img_liquidation[j].file_type +"'  data-type='img_liqui' class='w-100' src='"+ liq_bpdg.img_liquidation[j].path +"' >" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html_img_bpdg +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html_img_bpdg += "</div>"
					} else if (liq_bpdg.img_liquidation[j].file_type == "video/mp4") {
						html_img_bpdg += "<div class='block'>";
						html_img_bpdg += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_bpdg += "<a href='" + liq_bpdg.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_bpdg.img_liquidation[j].file_name +"</span><img name='img_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg'><img style='display: none' name='img_file' data-key='"+ liq_bpdg.img_liquidation[j].key +"' data-fileName='"+ liq_bpdg.img_liquidation[j].file_name +"' data-fileType='"+ liq_bpdg.img_liquidation[j].file_type +"'  data-type='img_liqui' class='w-100' src='"+ liq_bpdg.img_liquidation[j].path +"'>" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html_img_bpdg +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html_img_bpdg += "</div>"
					} else if (liq_bpdg.img_liquidation[j].file_type == "application/pdf") {
						html_img_bpdg += "<div class='block'>";
						html_img_bpdg += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
						html_img_bpdg += "<a target='_blank' href='" + liq_bpdg.img_liquidation[j].path + "' data-max-width='992' data-type='img_liqui'><img name='img_file' data-key='" + liq_bpdg.img_liquidation[j].key + "' data-fileName='" + liq_bpdg.img_liquidation[j].file_name + "' data-fileType='" + liq_bpdg.img_liquidation[j].file_type + "' data-type='img_liqui' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='" + liq_bpdg.img_liquidation[j].path + "'><img  style='width: 50%;transform: translateX(50%)translateY(-50%);' src='https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png'>" + liq_bpdg.img_liquidation[j].file_name + "</a>";
						html_img_bpdg +=	"<button type='button' onclick='deleteImage(this)' data-id='undefined' data-type='img_liqui' data-key='' class='cancelButton '><i class='fa fa-times-circle'></i></button>";
						html_img_bpdg += "</div>"
					}
				}
			}
			$("#img_create_liquidation_update").append(html);
			$("#img_thn_return").append(html_img_thn);
			$("#img_bpdg_update").append(html_img_bpdg);
			$("#bpdg_update_modal").modal("show");
		}
	});
}

//BP Định giá duyệt định giá tài sản
$('#bpdg_approve').click(function (event) {
	event.preventDefault();
	var id_contract = $('.contract_id_liq').val();
	var action = 'approve';
	var status = 46;
	var name_valuation = $('#name_valuation').val();
	var phone_valuation = $('#phone_valuation').val();
	var price_suggest_bpdg = $('#price_suggest_bpdg').val();
	var date_effect_bpdg = $('#date_effect_bpdg').val();
	var note_bpdg = $('#note_bpdg').val();
	var count = $("img[name='img_file']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'img_liqui') {
				image_file[key] = data;
			}
		});
	}
	if (confirm("Xác nhận gửi thông tin định giá tài sản thanh lý ?")) {
		var formData = {
			_id: id_contract,
			action: action,
			status: status,
			name_valuation: name_valuation,
			phone_valuation: phone_valuation,
			price_suggest_bpdg: price_suggest_bpdg,
			date_effect_bpdg: date_effect_bpdg,
			image_file: image_file,
			note: note_bpdg
		}
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: "POST",
			data: formData,
			beforeSend: function () {
				$('.theloading').show();
			},
			success: function (data) {
				if (data.status == 200) {
					$('.theloading').hide();
					$('#bpdg_processing_modal').modal('hide');
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$('.theloading').hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					});
				}
			},
			error: function (data) {
				$('.theloading').hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				});
			}
		})
	}
});

//BPG trả lại THN
$('.return_create_liq').click(function (event) {
	event.preventDefault();
	var contract_id = $("input[name='contract_id_liq']").val();
	var status_return = 45;
	var note_bpdg = $("#note_bpdg").val();
	var action = 'return';
	if(confirm("Xác nhận trả lại bộ phận quản lý HĐ vay ?")) {
		var formData = {
			_id: contract_id,
			action: action,
			status: status_return,
			note: note_bpdg,
		}
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: 'POST',
			data: formData,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$("#bpdg_processing_modal").modal("hide");
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					});
				}
			},
			error: function (data) {
				$(".theloading").hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				});
			}
		})
	}
});

//BPĐG định giá lại
$('#bpdg_approve_again').click(function (event) {
	event.preventDefault();
	var id_contract = $('.contract_id_liq').val();
	var action = 'resend';
	var status = 46;
	var name_valuation = $('#name_valuation_update').val();
	var phone_valuation = $('#phone_valuation_update').val();
	var price_suggest_bpdg = $('#price_suggest_bpdg_update').val();
	var date_effect_bpdg = $('#date_effect_bpdg_update').val();
	var note_bpdg = $('#note_bpdg_update').val();
	var count = $("img[name='img_file']").length;
	var image_file = {};
	if (count > 0) {
		$("img[name='img_file']").each(function () {
			var data = {};
			type = $(this).data('type');
			data['file_type'] = $(this).attr('data-fileType');
			data['file_name'] = $(this).attr('data-fileName');
			data['path'] = $(this).attr('src');
			data['key'] = $(this).attr('data-key');
			var key = $(this).data('key');
			if (type == 'img_liqui') {
				image_file[key] = data;
			}
		});
	}
	if (confirm("Xác nhận gửi lại thông tin định giá tài sản thanh lý ?")) {
		var formData = {
			_id: id_contract,
			action: action,
			status: status,
			name_valuation: name_valuation,
			phone_valuation: phone_valuation,
			price_suggest_bpdg: price_suggest_bpdg,
			date_effect_bpdg: date_effect_bpdg,
			image_file: image_file,
			note: note_bpdg
		}
		$.ajax({
			url: _url.base_url + 'accountant/approve_liquidations',
			type: "POST",
			data: formData,
			beforeSend: function () {
				$('.theloading').show();

			},
			success: function (data) {
				if (data.status == 200) {
					$(".theloading").hide();
					$('#ApproveInstate').modal('hide');
					toastr.success(data.msg, {
						timeOut: 7000,
					});
					setTimeout(function () {
						window.location.reload();
					},5000)
				} else {
					$(".theloading").hide();
					toastr.error(data.msg, {
						timeOut: 7000,
					})
				}
			},
			error: function (data) {
				$('.theloading').hide();
				toastr.error(data.msg, {
					timeOut: 7000,
				})
			}
		})
	}
});

$('#price_suggest_bpdg').on('input', function (e) {
	$(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
}).on('keypress', function (e) {
	if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function (e) {
	var cb = e.originalEvent.clipboardData || window.clipboardData;
	if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
});

$('#price_suggest_bpdg').keyup(function (event) {
	// skip for arrow keys
	if (event.which >= 37 && event.which <= 40) return;
	// format number
	$(this).val(function (index, value) {
		return value
			.replace(/\D/g, "")
			.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
			;
	});
});
