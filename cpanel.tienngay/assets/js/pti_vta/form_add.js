 var mikExp = /[$\\@\\\\/\?/\#%\^\^^\!\&\*\(\)\[\]\+\_\{\}\~\=\|0-9]/;
    function dodacheck(val) {
        var strPass = val.value;
        var strLength = strPass.length;
        var lchar = val.value.charAt((strLength) - 1);
        if (lchar.search(mikExp) != -1) {
            var tst = val.value.substring(0, (strLength) - 1);
            val.value = tst;
        }
    }
    function doanothercheck(form) {
        return false;
    }

   $('#cmt_ttnm').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
     $('#phone_ttnm').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
      $('#cmt_another').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
         $('#phone_another').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "");
		});
	});
   $('#buy_another').on('click', function() {
           $('#sell_another').show();
           $('#ng_mua').hide();
           $("#relationship-area").show();
           check_text_cmt_gks();
        }); 
    $('#buy_me').on('click', function() {
           $('#sell_another').hide();
           $('#ng_mua').show();
           $("#relationship-area").hide();
           check_text_cmt_gks();
           $("input[name='fullname_another']").val('');
		   $("input[name='birthday_another']").val('');
		   $("input[name='email_another']").val('');
		   $("input[name='cmt_another']").val('');
		   $("input[name='phone_another']").val('');
        
        });
    $('#cmt_img').on('click', function() {
           $('#cmt').show();
           $('#gks').hide();
           check_text_cmt_gks();
           
        }); 
    $('#gks_img').on('click', function() {
           $('#cmt').hide();
           $('#gks').show();
           check_text_cmt_gks();
        });
$('#input_cmt_search_cmt').on('change', function () {
	var files = $(this)[0].files[0];
	//console.log(files.size);
	if (files.size > 2097152) {
		$(".alert-danger").text("Ảnh dung lượng phải nhỏ hơn 2MB!");
		$(".alert-danger").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert-danger").slideUp(500);
		});
		return;
	}
	var formData = new FormData();

	formData.append('file', files);
	$.ajax({
		dataType: 'json',
		enctype: 'multipart/form-data',
		url: _url.base_url + 'ajax/upload_img',
		type: 'POST',
		data: formData,
		processData: false, // tell jQuery not to process the data
		contentType: false, // tell jQuery not to set contentType
		success: function (data) {
			if (data.code == 200 && data.path !== "") {

				if (data.path != null && data.path != "") {
					$('#img_xac_minh_cmt').attr('src', data.path);
					isUploaded = true;
				}

				// Set image for user avatar on the header

			} else {

				$(".alert-danger").text('Không tải được ảnh do Ảnh quá cỡ hoặc định dạng không đúng');
			}
		}
	});
});
$('#input_cmt_search_gks').on('change', function () {
	var files = $(this)[0].files[0];
	//console.log(files.size);
	if (files.size > 2097152) {
		$(".alert-danger").text("Ảnh dung lượng phải nhỏ hơn 2MB!");
		$(".alert-danger").fadeTo(2000, 500).slideUp(500, function () {
			$(".alert-danger").slideUp(500);
		});
		return;
	}
	var formData = new FormData();

	formData.append('file', files);
	$.ajax({
		dataType: 'json',
		enctype: 'multipart/form-data',
		url: _url.base_url + 'ajax/upload_img',
		type: 'POST',
		data: formData,
		processData: false, // tell jQuery not to process the data
		contentType: false, // tell jQuery not to set contentType
		success: function (data) {
			if (data.code == 200 && data.path !== "") {

				if (data.path != null && data.path != "") {
					$('#img_xac_minh_gks').attr('src', data.path);
					isUploaded = true;
				}

				// Set image for user avatar on the header

			} else {

				$(".alert-danger").text('Không tải được ảnh do Ảnh quá cỡ hoặc định dạng không đúng');
			}
		}
	});
});
function check_text_cmt_gks() {
   if($("input[name='obj']:checked").val()=="nguoithan" && $("input[name='checked_img']:checked").val()=="tren18")
   {
   	$('.text_cmt_gks_nm').html("CMT/CCCD:<span class='text-danger'>*</span>");
   	$('.text_cmt_gks_nt').html("CMT/CCCD:<span class='text-danger'>*</span>");
   }
   if($("input[name='obj']:checked").val()=="banthan" && $("input[name='checked_img']:checked").val()=="tren18")
   {
   	$('.text_cmt_gks_nm').html("CMT/CCCD:<span class='text-danger'>*</span>");
   	$('.text_cmt_gks_nt').html("CMT/CCCD:<span class='text-danger'>*</span>");
   }
   if($("input[name='obj']:checked").val()=="nguoithan" && $("input[name='checked_img']:checked").val()=="duoi18")
   {
   	$('.text_cmt_gks_nm').text("CMT/CCCD:");
   	$('.text_cmt_gks_nt').text("Số khai sinh (12 số):");

   }
   if($("input[name='obj']:checked").val()=="banthan" && $("input[name='checked_img']:checked").val()=="duoi18")
   {
   	$('.text_cmt_gks_nm').text("Số khai sinh (12 số):");
   	$('.text_cmt_gks_nt').text("CMT/CCCD:");
   }
}
function fee_pti_vta() {
	var code_pti_vta = $("#sel_ql").val();
	var year_pti_vta = $("#sel_year").val();
	var formData = {
		packet: code_pti_vta,
		period: year_pti_vta
	}
	$.ajax({
		url: _url.base_url + 'Pti_vta_fee/getAllFee',
		method: "POST",
		data: formData,
		success: function (data) {
			result = data.data;
			if (data.status == 200) {
				$('#code_fee').val(result._id.$oid);
				$('.tvdtn').text(result.died_fee + " VND");
				$('.cpdt').text(result.therapy_fee + " VND");
				if(code_pti_vta=="G1" && year_pti_vta=="3M")
				{
					$('#price_pti_vta').text(result.three_month + " VND");
					$('#price_pti_vta').val(result.three_month);
				}else if(code_pti_vta=="G1" && year_pti_vta=="6M")
				{
					$('#price_pti_vta').text(result.six_month + " VND");
					$('#price_pti_vta').val(result.six_month);
				}else if(code_pti_vta=="G1" && year_pti_vta=="1Y")
				{
					$('#price_pti_vta').text(result.twelve_month + " VND");
					$('#price_pti_vta').val(result.twelve_month);
				}else if(code_pti_vta=="G2" && year_pti_vta=="3M")
				{
					$('#price_pti_vta').text(result.three_month + " VND");
					$('#price_pti_vta').val(result.three_month);
				}else if(code_pti_vta=="G2" && year_pti_vta=="6M")
				{
					$('#price_pti_vta').text(result.six_month + " VND");
					$('#price_pti_vta').val(result.six_month);
				}else if(code_pti_vta=="G2" && year_pti_vta=="1Y")
				{
					$('#price_pti_vta').text(result.twelve_month + " VND");
					$('#price_pti_vta').val(result.twelve_month);
				}else if(code_pti_vta=="G3" && year_pti_vta=="3M")
				{
					$('#price_pti_vta').text(result.three_month + " VND");
					$('#price_pti_vta').val(result.three_month);
				}else if(code_pti_vta=="G3" && year_pti_vta=="6M")
				{
					$('#price_pti_vta').text(result.six_month + " VND");
					$('#price_pti_vta').val(result.six_month);
				}else if(code_pti_vta=="G3" && year_pti_vta=="1Y")
				{
					$('#price_pti_vta').text(result.twelve_month + " VND");
					$('#price_pti_vta').val(result.twelve_month);
				}
			}
		},
		error: function (data) {

		}
	});
}
$('#sel_ql').change(function () {
       $('#price_pti_vta').text(fee_pti_vta()+" VND");
		});
$('#sel_year').change(function () {
       $('#price_pti_vta').text(fee_pti_vta()+" VND");
		});
$('select[name="store"]').selectize({
	create: false,
	valueField: 'code',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
});

$(document).ready(function () {
	$(".add_pti_vta_btnSave").click(function (event) {
		event.preventDefault();
		var fullname = $("input[name='fullname']").val()
		var gender = $("input[name='gender']:checked").val()
		var cmt = $("input[name='cmt']").val()
		var relationship = $("select[name='relationship']").val()
		var address = $("input[name='address']").val()
		var id_pgd = $("select[name='store']").val()
		var obj = $("input[name='obj']:checked").val();
		var checked_img = $("input[name='checked_img']:checked").val();
		var phone = $("input[name='phone']").val()
		var email = $("input[name='email']").val()
		var birthday = $("input[name='birthday']").val()

		var fullname_another = $("input[name='fullname_another']").val()
		var birthday_another = $("input[name='birthday_another']").val()
		var email_another = $("input[name='email_another']").val()
		var cmt_another = $("input[name='cmt_another']").val()
		var phone_another = $("input[name='phone_another']").val()
		var address_another = $("input[name='address_another']").val()
        var gender_another = $("input[name='gender_another']:checked").val();

		var sel_ql = $("#sel_ql").val()
		var sel_year = $("#sel_year").val()
		var price = $('#price_pti_vta').val();
		var code_fee = $('#code_fee').val();
        if(checked_img=="tren18")
        {
        	var img_xac_minh = $('#img_xac_minh_cmt').attr('src')
        }else{
        	var img_xac_minh = $('#img_xac_minh_gks').attr('src')
        }

		var ck1 = $("input[name='ck1']:checked").val();
		var ck2 = $("input[name='ck2']:checked").val();
		var ck3 = $("input[name='ck3']:checked").val();
		if ($('#img_xac_minh').attr('src') == "https://service.tienngay.vn/uploads/avatar/1632647661-0775aee6e8b255f2266e4e58198f5b65.png") {
				alert("GIẤY TỜ XÁC MINH đang trống!");
				return;
			}else{
		if (price==0 )
		{
			alert("THÔNG TIN TRÁCH NHIỆM đang trống!")
			return;
		}
        if(ck1==undefined || ck2==undefined || ck3==undefined)
		{
          alert("XÁC NHẬN THÔNG TIN đang trống!")
         return;
		}
		if(obj=="nguoithan")
		{
			if (!fullname_another || !email_another || !cmt_another || !phone_another || !birthday_another || !relationship) 
			{
			alert("Ô nhập liệu người thân đang trống!")
			return;
		    }
			if(checked_img=="duoi18" && cmt_another.length != 12)
			{
				alert("Số khai sinh phải là 12 số")
				return;
			}

		}
		if(obj=="banthan")
		{
			relationship = "BT";
			if (!birthday) {
				alert("Ngày sinh đang trống!")
				return;
			}
			if(checked_img=="duoi18" && cmt.length != 12)
			{
				alert("Số khai sinh phải là 12 số")
				return;
			}
		}
		if (price==0  || !fullname || !cmt || !address || !obj || !phone || !email) 
		{
			alert("Ô nhập liệu đang trống!")
			return;
		} else 
		{
			if (confirm("Bạn có chắc chắn muốn bán Bảo hiểm Vững Tâm An với số tiền " + price)) {
				var formData = new FormData();
				formData.append('fullname', fullname);
				formData.append('gender', gender);
				formData.append('cmt', cmt);
				formData.append('relationship', relationship);
				formData.append('address', address);
				formData.append('id_pgd', id_pgd);
				formData.append('obj', obj);
				formData.append('phone', phone);
				formData.append('email', email);
				formData.append('birthday', birthday);
				formData.append('fullname_another', fullname_another);
				formData.append('birthday_another', birthday_another);
				formData.append('email_another', email_another);
				formData.append('cmt_another', cmt_another);
				formData.append('phone_another', phone_another);
				formData.append('address_another', address_another);
				formData.append('gender_another', gender_another);
				formData.append('sel_ql', sel_ql);
				formData.append('sel_year', sel_year);
			    formData.append('price', getFloat(price));
			    formData.append('code_fee', code_fee);
			    formData.append('ck1', ck1);
			    formData.append('ck2', ck2);
			    formData.append('ck3', ck3);
			    formData.append('img_xac_minh', img_xac_minh);
			    formData.append('checked_img', checked_img);
				$.ajax({
					url: _url.base_url + 'pti_vta/add_pti_vta',
					type: "POST",
					data: formData,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function () {
						$(".theloading").show();
					},
					success: function (data) {
						$(".theloading").hide();
						console.log(data.file)
						if (data.code == 200) {
							$("#successModal").modal("show");
							$(".msg_success").text(data.msg);
							setTimeout(function () {
								window.location.replace(_url.base_url + "pti_vta");
								window.open(data.file);
							}, 500);
						} else if (data.code == 401) {
							$("#errorModal").modal("show");
							$(".msg_error").text(data.msg);
						}
					},
					error: function () {
						$(".theloading").hide();
						$("#errorModal").modal("show");
						$(".msg_error").text('Có lỗi xảy ra, liên hệ IT để được hỗ trợ!');
					}
				});
			}
		}
	}
	})
})
function getFloat(val) {
	var val = val.replace(/,/g, "");
	return parseFloat(val);
}
$(document).ready(function () {

$('[name="pti_vta"]').change(function () {
		$('#fee_pti_vta').val(numeral($(this).val()).format('0,0'));
	});
})

function deleteImage(thiz) {
	var thiz_ = $(thiz);
	var key = $(thiz).data("key");
	var type = $(thiz).data("type");
	var id = $(thiz).data("id");
	var res = confirm("Are you sure want to delete ?");
	$(thiz_).closest("div .block").remove();
}

$('input[type=file]').change(function () {
	var contain = $(this).data("contain");
	var title = $(this).data("title");
	var type = $(this).data("type");
	$(this).simpleUpload(_url.base_url + "pti_vta/upload_img", {
		allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif"],
		maxFileSize: 20000000, //10MB,
		multiple: true,
		limit: 10,
		start: function (file) {
			fileType = file.type;
			fileName = file.name;
			//upload started
			this.block = $('<div class="block"></div>');
			this.progressBar = $('<div class="progressBar"></div>');
			this.block.append(this.progressBar);
			$('#' + contain).append(this.block);
		},
		data: {
			'type_img': type,
		},
		progress: function (progress) {
			//received progress
			this.progressBar.width(progress + "%");
		},
		success: function (data) {
			//upload successful
			this.progressBar.remove();
			if (data.code == 200) {
				var content = "";
				content += '<a href="' + data.path + '" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery" data-gallery="' + contain + '" data-max-width="992" data-type="image" data-title="' + title + '">';
				content += '<img data-type="' + type + '" data-fileType="' + fileType + '"  data-fileName="' + fileName + '" name="img_asset"  data-key="' + data.key + '" src="' + data.path + '" /><button type="button" onclick="deleteImage(this)" data-type="' + type + '" data-key="' + data.key + '" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
				content += '</a>';
				var data = $('<div ></div>').html(content);
				this.block.append(data);
			} else {
				//our application returned an error
				var error = data.msg;
				this.block.remove();
				alert(error);
			}
		},
		error: function (error) {
			var msg = error.msg;
			this.block.remove();
			alert(msg);
		}
	});
});

$('#selectize_district_current_address').selectize({
	create: false,
	valueField: 'code',
	labelField: 'name',
	searchField: 'name',
	maxItems: 1,
	sortField: {
		field: 'name',
		direction: 'asc'
	}
	});
