if (liq_bpdg.img_liquidation != "") {
	for (var j in liq_bpdg.img_liquidation) {
		var loc = new URL(liq_bpdg.img_liquidation[j].path);
		console.log(loc.pathname);
		const date_upload_img = new Date((loc.pathname).slice(16,26)*1000).format('d/m/Y H:i:s')
		if (liq_bpdg.img_liquidation[j].file_type == "image/png" || liq_bpdg.img_liquidation[j].file_type == "image/jpg" || liq_bpdg.img_liquidation[j].file_type == "image/jpeg") {
			html_img_bpdg += "<div class='block'>";
			html_img_bpdg += "<span class='timestamp'>" + date_upload_img.toLocaleString() + "</span>";
			html_img_bpdg += "<a href='" + liq_bpdg.img_liquidation[j].path + "' class='magnifyitem' data-magnify='gallery' data-src='" + liq_bpdg.img_liquidation[j].path + "' data-group='thegallery' data-gallery='img_liquidation' data-max-width='992' data-type='img_liqui'><img data-type='img_liqui' data-filetype='" + liq_bpdg.img_liquidation[j].file_type + "' data-filename='" + liq_bpdg.img_liquidation[j].file_name + "' name='img_file' data-key='" + liq_bpdg.img_liquidation[j].key + "' src='" + liq_bpdg.img_liquidation[j].path + "'>" + liq_bpdg.img_liquidation[j].file_name + "</a>";
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
			html_img_bpdg += "<a href='" + liq_bpdg.img_liquidation[j].path + "' target='_blank'><span style='z-index: 9'>"+ liq_bpdg.img_liquidation[j].file_name +"</span><img name='img_file' style='width: 50%;transform: translateX(50%)translateY(-50%);' src='<?php echo base_url(); ?>assets/imgs/mp4.jpg'><img name='img_file' data-key='"+ liq_bpdg.img_liquidation[j].key +"' data-fileName='"+ liq_bpdg.img_liquidation[j].file_name +"' data-fileType='"+ liq_bpdg.img_liquidation[j].file_type +"'  data-type='img_liqui' class='w-100' src='" + liq_bpdg.img_liquidation[j].path + "' >" + liq_bpdg.img_liquidation[j].file_name + "</a>";
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
