//Event change input type file and show file to UI
function upload_file_to_service (thiz) {
	let input_name = $(thiz).data("inputname");
	let contain = $(thiz).data("contain");
	let title = $(thiz).data("title");
	let type = $(thiz).data("type");
	let upload_input = thiz;
	let id_input_jquery = '#' + thiz.id;
	let upload_type = $(thiz).data("unique");
	let block_input_css = '.' + contain;
	if (upload_type == 'unique') {
		$(block_input_css).hide();
		$(id_input_jquery).prop('disabled', true);
	}
	$(id_input_jquery).simpleUpload(_url.base_url + "pawn/upload_img", {
		//$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", {
		allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4","pdf"],
		maxFileSize: 20000000, //10MB,
		multiple: true,
		limit: 10,
		start: function(file){
			fileType = file.type;
			fileName = file.name;
			//upload started
			this.block = $('<div class="block"></div>');
			this.progressBar = $('<div class="progressBar"></div>');
			this.block.append(this.progressBar);
			$('#' + contain).append(this.block);
		},
		data: {
			'type_img': type
		},
		progress: function(progress){
			//received progress
			this.progressBar.width(progress + "%");
		},
		success: function(response){
			//upload successful
			this.progressBar.remove();
			let html = "";
			if (response.code == 200) {
				let param_pass = {};
				param_pass = {
					response: response,
					file_type: fileType,
					file_name: fileName,
					title: title,
					type: type,
					contain: contain,
					block_input_css: block_input_css,
					id_input_jquery: id_input_jquery,
					input_name: input_name,
					block_append: this.block
				}
				//Show file uploaded to view
				display_html_file_upload_to_view(param_pass);
			} else {
				// Our application returned an error
				let error = response.msg;
				this.block.remove();
				alert(error);
			}
		},
		error: function(error){
			var msg = error.msg;
			this.block.remove();
			alert("File không đúng định dạng");
		}
	});
};

// Fnc show file upload to view
function display_html_file_upload_to_view(param_pass) {
	let html = "";
	let alt_video_img = "";
	let alt_audio_img = "";
	let alt_pdf_img = "https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png";
	let alt_image = "";
		fileType = param_pass.file_type;
	//Video Mp4
	if(fileType == 'video/mp4') {
		html = generate_html(alt_video_img, param_pass);
	}
	//Mp3
	else if(fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
		html = generate_html(alt_audio_img, param_pass);
	}
	//Pdf
	else if(fileType == 'application/pdf') {
		html = generate_html(alt_pdf_img, param_pass);
	}
	//Image
	else {
		html = generate_html(alt_image, param_pass);
	}
	//Display html image uploaded into view
	let result_img_html = $('<div ></div>').html(html);
		param_pass.block_append.append(result_img_html);
	return;
}

// Fnc Generate html file upload
function generate_html(alt_image_src, param_pass) {
	let html = "";
	fileType = param_pass.file_type;
	fileName = param_pass.file_name;
	response = param_pass.response;
	input_name = param_pass.input_name;
	type = param_pass.type;
	title = param_pass.title;
	contain = param_pass.contain;
	id_input_jquery = param_pass.id_input_jquery;
	block_input_css = param_pass.block_input_css;
	if (in_array(fileType, ['video/mp4','audio/mp3','audio/mpeg','application/pdf'])) {
		html +=
			'<a  href="'+response.path+'" target="_blank">' +
			'<span style="z-index: 9">'+fileName+'</span>' +
			'<input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" ' +
				'src="'+ alt_image_src +'" alt="">' +
			'<img style="display:none" ' +
				'data-type="'+type+'" ' +
				'data-fileType="'+fileType+'" ' +
				'data-fileName="'+fileName+'" ' +
				'name="'+ input_name +'" ' +
				'data-key="'+response.key+'" ' +
				'src="'+response.path+'" />' +
			'</a>';
	} else {
		html +=
			'<a href="'+response.path+'" class="magnifyitem" ' +
				'data-magnify="gallery" data-src="" ' +
				'data-group="thegallery" ' +
				'data-gallery="'+contain+'" ' +
				'data-max-width="992" ' +
				'data-type="image" ' +
				'data-title="'+title+'">' +
			'<img data-type="'+type+'" ' +
				'data-fileType="'+fileType+'"  ' +
				'data-fileName="'+fileName+'" ' +
				'name="'+ input_name +'"  ' +
				'data-key="'+response.key+'" ' +
				'src="'+response.path+'" />' +
			'</a>';
	}
		html +=
			'<button type="button" ' +
				'onclick="deleteImage(this)" ' +
				'data-type="'+type+'" ' +
				'data-idinput="'+id_input_jquery+'" ' +
				'data-blockinput="'+block_input_css+'" ' +
				'data-key="'+response.key+'" ' +
				'data-filetype="'+fileType+'"  ' +
				'class="cancelButton "><i class="fa fa-times-circle"></i>' +
			'</button>';

	return html;
}

// Xóa file display tạm ở UI
function deleteImage(thiz) {
	let thiz_ = $(thiz);
	let key = $(thiz).data("key");
	let type = $(thiz).data("type");
	let file_type = $(thiz).data("filetype");
	let element_input = $(thiz).data("idinput");
	let block_input_css = $(thiz).data("blockinput");
	let message = "";
	let file_text = "";
	if (in_array(file_type, ['video/mp4','audio/mp3','audio/mpeg','application/pdf'])) {
		message = "Xóa file thành công";
		file_text = "file";
	} else {
		message = "Xóa ảnh thành công";
		file_text = "ảnh";
	}
	if ( confirm('Bạn có chắc chắn muốn xóa '+ file_text +' này ?') ){
		$(thiz_).closest("div .block").remove();
		if (element_input) {
			$(element_input).prop('disabled', false);
		}
		if (block_input_css) {
			$(block_input_css).show();
		}
		toastr.success(message, {
			timeOut: 2000,
		});
	}
}

function in_array(needle, haystack) {
	let length = haystack.length;
	for (let i = 0; i < length; i++) {
		if (haystack[i] == needle) {
			return true;
		}
	}
	return false;
}
