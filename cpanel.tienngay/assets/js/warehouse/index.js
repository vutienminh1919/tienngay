$(document).ready(function(){

$('#number_investment').keyup(function(event) {
    // skip for arrow keys
    if(event.which >= 37 && event.which <= 40) return;

    // format number
    $(this).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        ;
    });
});
$('#number_investment').keyup(function(event) {

    $('.number').keypress(function(event) {

        if ((event.which != 46 || $(this).val().indexOf(',') != -1) && (event.which < 48 || event.which > 57)) {

            event.preventDefault();
        }
    });
});
$("#update_en_btn").click(function(event) {

    $("input").prop('disabled', false);
    $("select").prop('disabled', false);
});
$(".delete_warehouse").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/warehouse/deletewarehouse',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".warehouse_" + id).remove();
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
            } else {
                $('#errorModal').modal('show');
                $('.msg_error').text(data.message);
            }
        },
        error: function(data) {
            console.log(data);
            $("#loading").hide();
        }
    });
 
});
$(".create_warehouse").click(function(event) {
    event.preventDefault();
        var code = $("input[name='code']").val();
        var name = $("input[name='name']").val();
        var max_xe_may = $("input[name='max_xe_may']").val();
        var max_oto = $("input[name='max_oto']").val();
        var manager_id = $("select[name='manager_id']").val();
        var address = $("input[name='address']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('code', code);
        formData.append('name', name);
        formData.append('max_xe_may', max_xe_may);
        formData.append('max_oto', max_oto);
        formData.append('manager_id', manager_id);
        formData.append('address', address);
        formData.append('status', status); 
    console.log(formData);
       
    $.ajax({
        url :  _url.base_url + 'warehouse/doAddWarehouse',
        type: "POST",
        data : formData,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
            $(".theloading").hide();
              //console.log(data);
            if (data.res) {
                  console.log(data);
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + 'warehouse/listwarehouse';
                }, 3000);
            } else {
                  console.log(data);
                $("#div_error").css("display", "block");
                $(".div_error").text(data.message);
                window.scrollTo(0, 0);
                setTimeout(function(){ 
                $("#div_error").css("display", "none");
                }, 3000);
            }
        },
        error: function(data) {
            //console.log(data);
            $(".theloading").hide();
         
                
        }
    });
 
});

$(".nhap_kho").click(function(event) {
    event.preventDefault();

        var ma_kho = $("select[name='ma_kho']").val();
        var id_contract = $("input[name='id_contract']").val();
        var code_contract = $("input[name='code_contract']").val();
        var ten_tai_san = $("input[name='ten_tai_san']").val();
       
        var formData = new FormData();
        formData.append('ma_kho', ma_kho);
        formData.append('id_contract', id_contract);
        formData.append('code_contract', code_contract);
        formData.append('ten_tai_san', ten_tai_san);
       
    $.ajax({
        url :  _url.base_url + '/warehouse/doYeuCauNhap',
        type: "POST",
        data : formData,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
             $(".theloading").hide();
            if (data.res) {
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/warehouse/listAsset';
                }, 3000);
            } else {
                  $('#errorModal').modal('show');
                $('.msg_error').text(data.message);
                setTimeout(function(){ 
               $('#errorModal').modal('hide');
                }, 3000);

                // $("#div_error").css("display", "block");
                // $(".div_error").text(data.message);
                // window.scrollTo(0, 0);
                // setTimeout(function(){ 
                // $("#div_error").css("display", "none");
                // }, 3000);
            }
        },
        error: function(data) {
            console.log(data);
            $(".theloading").hide();
        }
    });
 
});
  $(document).on("click", "span.xac_nhan_nhap", function () {

        var id_contract = $(this).data('id');

       
        var formData = new FormData();

        formData.append('id_contract', id_contract);

       
    $.ajax({
        url :  _url.base_url + '/warehouse/doXacNhanNhap',
        type: "POST",
        data : formData,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
             $(".theloading").hide();
            if (data.res) {
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/warehouse/listAsset';
                }, 3000);
            } else {
                 $('#errorModal').modal('show');
                $('.msg_error').text(data.message);
                // $("#div_error").css("display", "block");
                // $(".div_error").text(data.message);
                // window.scrollTo(0, 0);
                setTimeout(function(){ 
               $('#errorModal').modal('hide');
                }, 3000);
            }
        },
        error: function(data) {
            console.log(data);
            $(".theloading").hide();
        }
    });
 
});
    $(document).on("click", "span.xac_nhan_xuat", function () {

       var id_contract = $(this).data('id');

        var formData = new FormData();

        formData.append('id_contract', id_contract);

       
    $.ajax({
        url :  _url.base_url + '/warehouse/doXacNhanXuat',
        type: "POST",
        data : formData,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
             $(".theloading").hide();
            if (data.res) {
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/warehouse/listAsset';
                }, 3000);
            } else {
                 $('#errorModal').modal('show');
                $('.msg_error').text(data.message);
                setTimeout(function(){ 
               $('#errorModal').modal('hide');
                }, 3000);
            }
        },
        error: function(data) {
            console.log(data);
            $(".theloading").hide();
        }
    });
 
});
$(document).on("click", "span.xac_nhan_tra_khach", function () {

       var id_contract = $(this).data('id');

        var formData = new FormData();

        formData.append('id_contract', id_contract);

       
    $.ajax({
        url :  _url.base_url + '/warehouse/doXacNhanTraKhach',
        type: "POST",
        data : formData,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
             $(".theloading").hide();
            if (data.res) {
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/warehouse/listAsset';
                }, 3000);
            } else {
                 $('#errorModal').modal('show');
                $('.msg_error').text(data.message);
                setTimeout(function(){ 
               $('#errorModal').modal('hide');
                }, 3000);
            }
        },
        error: function(data) {
            console.log(data);
            $(".theloading").hide();
        }
    });
 
});
$(document).on("click", "span.xac_nhan_thanh_ly", function () {

       var id_contract = $(this).data('id');

        var formData = new FormData();

        formData.append('id_contract', id_contract);

       
    $.ajax({
        url :  _url.base_url + '/warehouse/doXacNhanThanhLy',
        type: "POST",
        data : formData,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
             $(".theloading").hide();
            if (data.res) {
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/warehouse/listAsset';
                }, 3000);
            } else {
                 $('#errorModal').modal('show');
                $('.msg_error').text(data.message);
                setTimeout(function(){ 
               $('#errorModal').modal('hide');
                }, 3000);
            }
        },
        error: function(data) {
            console.log(data);
            $(".theloading").hide();
        }
    });
 
});
$(document).on("click", "span.yeu_cau_xuat", function () {
       var id_contract = $(this).data('id');
        var formData = new FormData();

        formData.append('id_contract', id_contract);
    $.ajax({
        url :  _url.base_url + '/warehouse/doYeuCauXuat',
        type: "POST",
        data : formData,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
             $(".theloading").hide();
            if (data.res) {
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/warehouse/listAsset';
                }, 3000);
            } else {
                $('#errorModal').modal('show');
                $('.msg_error').text(data.message);
                setTimeout(function(){ 
               $('#errorModal').modal('hide');
                }, 3000);
            }
        },
        error: function(data) {
            console.log(data);
            $(".theloading").hide();
        }
    });
 
});
$(".update_warehouse").click(function(event) {
    event.preventDefault();
        var id = $("input[name='id_warehouse']").val();
        var code = $("input[name='code']").val();
        var name = $("input[name='name']").val();
        var max_xe_may = $("input[name='max_xe_may']").val();
        var max_oto = $("input[name='max_oto']").val();
        var manager_id = $("select[name='manager_id']").val();
        var address = $("input[name='address']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('code', code);
        formData.append('name', name);
        formData.append('max_xe_may', max_xe_may);
        formData.append('max_oto', max_oto);
        formData.append('manager_id', manager_id);
        formData.append('address', address);
        formData.append('status', status); 
        formData.append('id', id);
    $.ajax({
        url :  _url.base_url + '/warehouse/doUpdateWarehouse',
        type: "POST",
        data : formData,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
             $(".theloading").hide();
            if (data.res) {
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/warehouse/listwarehouse';
                }, 3000);
            } else {
                $("#div_error").css("display", "block");
                $(".div_error").text(data.message);
                window.scrollTo(0, 0);
                setTimeout(function(){ 
                $("#div_error").css("display", "none");
                }, 3000);
            }
        },
        error: function(data) {
            console.log(data);
            $(".theloading").hide();
        }
    });
 
});

function formatDate(timestamp)
{
    try {
      var offset = new Date().getTimezoneOffset();
      date = new Date(timestamp * 1000 + offset*60*1000);
      return  date.getDate()+'/'+ (Number(date.getMonth())+1) +'/'+date.getFullYear();
       } catch (e) {
          console.log(e)
        }
}

function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
  try {
    decimalCount = Math.abs(decimalCount);
    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

    const negativeSign = amount < 0 ? "-" : "";

    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
    let j = (i.length > 3) ? i.length % 3 : 0;

    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
  } catch (e) {
    console.log(e)
  }
};
});
function isEmpty(obj) {
    if(!obj || Object.keys(obj).length === 0)
    return "";
}

$("input[type='file']").change(function(){
    var contain = $(this).data("contain");
    var type = $(this).data("type");
    var title=(type=='chung_tu_nhapxuat_kho') ? 'Chứng từ nhập xuất kho' : 'Ảnh tài sản';
    var contractId = $("#contract_id").val();
    $(this).simpleUpload(_url.base_url+'warehouse/doUploadImage', {
        allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png"],
       
        maxFileSize: 10000000, //10MB
        start: function(file){
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
            'contract_id': contractId,
        },
        progress: function(progress){
            //received progress
            this.progressBar.width(progress + "%");
        },
        success: function(data){
            //upload successful
            this.progressBar.remove();
            if (data.data.status == 200) {
                //Video Mp4
                if(fileType == 'video/mp4') {
                  
                }
                //Mp3
                else if(fileType == 'audio/mp3') {
                 
                }
                //Image
                else {
                    // var data = $('<div ></div>').html('<img src="'+data.data.path+'" /><button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.data.key+'" class="cancelButton "><i class="fa fa-times-circle"></i></button>');
                    // var data1 = "<div class='description'><textarea ></textarea></div>";
                    var data2 = $('<div ></div>').html('<a class="magnifyitem" data-magnify="gallery" data-src="" data-caption="'+title+'" data-group="thegallery" href="'+data.data.path+'"><img src="'+data.data.path+'" /><button type="button" onclick="deleteImage(this)" data-id="'+contractId+'" data-type="'+type+'" data-key="'+data.data.key+'" class="cancelButton "></a><i class="fa fa-times-circle"></i></button> <script>$(".magnifyitem").magnify({initMaximized: true});');
                    this.block.append(data2);
                }
            } else {
                //our application returned an error
                var error = data.data.error.message;
                var errorDiv = $('<div class="error"></div>').text(error);
                this.block.append(errorDiv);
            }
        },
        error: function(error){
            //upload failed
            this.progressBar.remove();
            var error = error.message;
            var errorDiv = $('<div class="error"></div>').text(error);
            this.block.append(errorDiv);
        }
    });
});

function deleteImage(thiz) {
    var thiz_ = $(thiz);
    var key = $(thiz).data("key");
    var type = $(thiz).data("type");
    var id = $(thiz).data("id");
    var res = confirm("Are you sure want to delete ?");
    if (res == true) {
        $.ajax({
            url: _url.process_contract_delete_image,
            method: "POST",
            data: {
                id: id,
                key: key,
                type_img: type
            },
            success: function(data) {
                if(data.data.status == 200) {
                    $(thiz_).closest("div .block").remove();
                }
            },
            error: function(error) {
                
            }
        });
    }
}
