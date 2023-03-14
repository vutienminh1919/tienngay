//var count_add_sohokhau = $(".box_sohokhau").children().length;
//$(".add_sohokhau").click(function(event) {
//    count_add_sohokhau = count_add_sohokhau+1;
//    event.preventDefault();   
//    temp = "<div id='shk_"+count_add_sohokhau+"' class='input-group'><input type='file' name='sohokhau[]'  class='form-control'><div class='input-group-btn'><button type='button' name='deletefile' class='btn btn-danger' data-id='shk_"+count_add_sohokhau+"'  onclick='remove_add_sohokhau(this)'><i class='fa fa-close'></i> Xóa</button></div></div>";
//    $(".box_sohokhau").append(temp);
//});                        
//
//var count_add_cmnd = $(".box_cmnd").children().length;
//$(".add_cmnd").click(function(event) {
//    count_add_cmnd = count_add_cmnd+1;
//    event.preventDefault();   
//    temp = "<div id='cmnd_"+count_add_cmnd+"' class='input-group'><input type='file' name='cmnd[]'  class='form-control'><div class='input-group-btn'><button type='button' name='deletefile' class='btn btn-danger' data-id='cmnd_"+count_add_cmnd+"'  onclick='remove_add_cmnd(this)'><i class='fa fa-close'></i> Xóa</button></div></div>";
//    $(".box_cmnd").append(temp);
//});  
//
//var count_add_dangkyxe = $(".box_dangkyxe").children().length;
//$(".add_dangkyxe").click(function(event) {
//    count_add_dangkyxe = count_add_dangkyxe+1;
//    event.preventDefault();   
//    temp = "<div id='dkx_"+count_add_dangkyxe+"' class='input-group'><input type='file' name='dangkyxe[]'  class='form-control'><div class='input-group-btn'><button type='button' name='deletefile' class='btn btn-danger' data-id='dkx_"+count_add_dangkyxe+"'  onclick='remove_add_dangkyxe(this)'><i class='fa fa-close'></i> Xóa</button></div></div>";
//    $(".box_dangkyxe").append(temp);
//}); 
//
//var count_add_car = $(".box_car").children().length;
//$(".add_car").click(function(event) {
//    count_add_car = count_add_car+1;
//    event.preventDefault();   
//    temp = "<div id='car_"+count_add_car+"'  class='input-group'><input type='file' name='car[]'  class='form-control'><div class='input-group-btn'><button type='button' name='deletefile' class='btn btn-danger' data-id='car_"+count_add_car+"'  onclick='remove_add_car(this)'><i class='fa fa-close'></i> Xóa</button></div></div>";
//    $(".box_car").append(temp);
//}); 
//
//
//var count_add_expertise = $(".box_expertise").children().length;
//$(".add_expertise").click(function(event) {
//    count_add_expertise = count_add_expertise+1;
//    event.preventDefault();   
//    temp = "<div id='expertise_"+count_add_expertise+"' class='input-group'><input type='file' name='expertise[]'  class='form-control'><div class='input-group-btn'><button type='button' name='deletefile' class='btn btn-danger' data-id='expertise_"+count_add_expertise+"'  onclick='remove_add_expertise(this)'><i class='fa fa-close'></i> Xóa</button></div></div>";
//    $(".box_expertise").append(temp);
//}); 
//
//function remove_add_sohokhau(thiz){
//    var id = $(thiz).attr('data-id'); 
//    $("#" + id).remove();
//}
//function remove_add_cmnd(thiz){
//    var id = $(thiz).attr('data-id'); 
//    $("#" + id).remove();
//}
//function remove_add_dangkyxe(thiz){
//    var id = $(thiz).attr('data-id'); 
//    $("#" + id).remove();
//}
//function remove_add_car(thiz){
//    var id = $(thiz).attr('data-id'); 
//    $("#" + id).remove();
//}
//function remove_add_expertise(thiz){
//    var id = $(thiz).attr('data-id'); 
//    $("#" + id).remove();
//}


$(".submit_contract_img").on("click", function(event) {
    event.preventDefault();
    var contractId = $("#contract_id").val();
    var count = $("img[name='img_contract']").length;
    // console.log(count);
    var identify = {};
    var household = {};
    var driver_license = {};
    var vehicle = {};
    var agree = {};
    var digital = {};
    var locate = {};
    if(count > 0) {
        $("img[name='img_contract']").each(function() {
            var data = {};
            type = $(this).data('type');
            data['file_type'] = $(this).attr('data-fileType');
            data['file_name'] = $(this).attr('data-fileName');
            data['path'] = $(this).attr('src');
            var key = $(this).data('key');
            if(type == 'identify'){
                identify[key] = data;
            }
            if(type == 'household'){
                household[key] = data;
            }
            if(type == 'driver_license'){
                driver_license[key] = data;
            }
            if(type == 'vehicle'){
                vehicle[key] = data;
            }
            if(type == 'agree'){
                agree[key] = data;
            }
            if(type == 'digital'){
				digital[key] = data;
            }
			if(type == 'locate'){
				locate[key] = data;
			}
        });
    }
    var formData = {
        contractId: contractId,
        identify: identify,
        household: household,
        driver_license: driver_license,
        vehicle: vehicle,
        agree: agree,
        digital: digital,
		locate: locate,
    };
    $.ajax({
        url :  _url.base_url + '/pawn/doUploadContract',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
            $(".theloading").hide();
            if (data.code == 200) {
                $("#approve_disbursement").modal("hide");
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                setTimeout(function(){
                    window.location.href =  _url.base_url + "pawn/contract";
                }, 2000);
            } else {
                $("#approve_disbursement").modal("hide");
                $("#errorModal").modal("show");
                $(".msg_error").text(data.msg);
                // setTimeout(function(){
                //     window.location.reload();
                // }, 3000);
            }
        },
        error: function(data) {
            $(".theloading").hide();
        }
    });
 
});

$('input[type=file]').change(function(){
    var contain = $(this).data("contain");
    var title = $(this).data("title");
    var type = $(this).data("type");
    var contractId = $("#contract_id").val();
    $(this).simpleUpload(_url.base_url + "pawn/upload_img", { 
    //$(this).simpleUpload(_url.base_url + "pawn/upload_img_contract", { 
        allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif", "mp3", "mp4","pdf"],
        //allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
        maxFileSize: 20000000, //10MB,
        multiple: true,
        limit: 10,
        start: function(file){
					console.log(file)
            fileType = file.type;
            fileName = file.name;
            //upload started
            this.block = $('<div class="block"></div>');
            this.progressBar = $('<div class="progressBar"></div>');
            this.block.append(this.progressBar);
            $('#'+contain).append(this.block);
        },
        data: {
            'type_img': type,
            'contract_id': contractId
        },
        progress: function(progress){
            //received progress
            this.progressBar.width(progress + "%");
        },
        success: function(data){
        	console.log(data)
            //upload successful
            this.progressBar.remove();
            if (data.code == 200) {
                //Video Mp4
                if(fileType == 'video/mp4') {
                	var  item = "";
                	item += '<a  href="'+data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt=""><img style="display:none" data-type="'+type+'" data-fileType="'+fileType+'"  data-fileName="'+fileName+'" name="img_contract"  data-key="'+data.key+'" src="'+data.path+'" /></a>';
                    item += '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
                    var data = $('<div ></div>').html(item);
                    this.block.append(data);
                }
                //Mp3
                else if(fileType == 'audio/mp3' || fileType == 'audio/mpeg') {
                	var item = "";
                    item += '<a  href="'+data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt=""><img style="display:none" data-type="'+type+'" data-fileType="'+fileType+'"  data-fileName="'+fileName+'" name="img_contract"  data-key="'+data.key+'" src="'+data.path+'" /></a>';
                    item += '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
                    var data = $('<div ></div>').html(item);
                    this.block.append(data);
                }
                //pdf
								else if(fileType == 'application/pdf') {
									var item = "";
									item += '<a  href="'+data.path+'" target="_blank"><span style="z-index: 9">'+fileName+'</span><input type="hidden"><img style="width: 50%;transform: translateX(50%)translateY(-50%);" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt=""><img style="display:none" data-type="'+type+'" data-fileType="'+fileType+'"  data-fileName="'+fileName+'" name="img_contract"  data-key="'+data.key+'" src="'+data.path+'" /></a>';
									item += '<button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
									var data = $('<div ></div>').html(item);
									this.block.append(data);
								}
				//Image
				else {
					var content = "";
					content += '<a href="'+data.path+'" class="magnifyitem" data-magnify="gallery" data-src="" data-group="thegallery" data-gallery="'+contain+'" data-max-width="992" data-type="image" data-title="'+title+'">';
					content += '<img data-type="'+type+'" data-fileType="'+fileType+'"  data-fileName="'+fileName+'" name="img_contract"  data-key="'+data.key+'" src="'+data.path+'" /><button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>';
					content += '</a>';

					var data = $('<div ></div>').html(content);
					this.block.append(data);
				}
            } else {
                //our application returned an error
                var error = data.msg;
                this.block.remove();
                alert(error);
            }
        },
        error: function(error){
            //upload failed
//            this.progressBar.remove();
//            var error = error.message;
//            var errorDiv = $('<div class="error"></div>').text(error);
//            this.block.append(errorDiv);

			var msg = error.msg;
			this.block.remove();
			alert("File không đúng định dạng");
		}
	});
});

function deleteImage(thiz) {
    var thiz_ = $(thiz);
    var key = $(thiz).data("key");
    var type = $(thiz).data("type");
    var id = $(thiz).data("id");
    // var res = confirm("Are you sure want to delete ?");
	if (confirm("Bạn có chắc chắn muốn xóa ?")){
		$(thiz_).closest("div .block").remove();
	}

}
