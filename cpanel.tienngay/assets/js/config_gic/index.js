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

$(".delete_config_gic").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/config_gic/deleteconfig_gic',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".config_gic_" + id).remove();
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


$(".create_config_gic").click(function(event) {
    event.preventDefault();
        var TyLePhi = $("input[name='TyLePhi']").val();
        var NhanVienId = $("input[name='NhanVienId']").val();
        var id = $("input[name='id']").val();
        var name = $("input[name='name']").val();
        var code = $("input[name='code']").val();
        var ThongTinNguoiChoVay_HoTen = $("input[name='ThongTinNguoiChoVay_HoTen']").val();
        var ThongTinNguoiChoVay_CMND = $("input[name='ThongTinNguoiChoVay_CMND']").val();
        var ThongTinNguoiChoVay_DienThoai = $("input[name='ThongTinNguoiChoVay_DienThoai']").val();
        var ThongTinNguoiChoVay_Email = $("input[name='ThongTinNguoiChoVay_Email']").val();
        var ThongTinNguoiChoVay_DiaChi = $("input[name='ThongTinNguoiChoVay_DiaChi']").val();
        var LoaiNguoiThuHuongId = $("input[name='LoaiNguoiThuHuongId']").val();

        var formData = new FormData();
        formData.append('TyLePhi', TyLePhi);
        formData.append('ThongTinNguoiChoVay_HoTen', ThongTinNguoiChoVay_HoTen);
        formData.append('ThongTinNguoiChoVay_CMND', ThongTinNguoiChoVay_CMND);
        formData.append('ThongTinNguoiChoVay_DienThoai', ThongTinNguoiChoVay_DienThoai);
        formData.append('ThongTinNguoiChoVay_Email', ThongTinNguoiChoVay_Email);
        formData.append('ThongTinNguoiChoVay_DiaChi', ThongTinNguoiChoVay_DiaChi);
        formData.append('LoaiNguoiThuHuongId', LoaiNguoiThuHuongId);
        formData.append('code', code);
        formData.append('name', name);
        formData.append('id', id);
         formData.append('NhanVienId', NhanVienId);
      
        
    console.log(formData);
       
    $.ajax({
        url :  _url.base_url + 'config_gic/doAddConfig_gic',
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
                    window.location.href = _url.base_url + 'config_gic/listconfig_gic';
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

$(".update_config_gic").click(function(event) {
    event.preventDefault();
        var TyLePhi = $("input[name='TyLePhi']").val();
        var NhanVienId = $("input[name='NhanVienId']").val();
        var id = $("input[name='id']").val();
        var id_config_gic = $("input[name='id_config_gic']").val();
        var name = $("input[name='name']").val();
        var code = $("input[name='code']").val();
        var ThongTinNguoiChoVay_HoTen = $("input[name='ThongTinNguoiChoVay_HoTen']").val();
        var ThongTinNguoiChoVay_CMND = $("input[name='ThongTinNguoiChoVay_CMND']").val();
        var ThongTinNguoiChoVay_DienThoai = $("input[name='ThongTinNguoiChoVay_DienThoai']").val();
        var ThongTinNguoiChoVay_Email = $("input[name='ThongTinNguoiChoVay_Email']").val();
        var ThongTinNguoiChoVay_DiaChi = $("input[name='ThongTinNguoiChoVay_DiaChi']").val();
         var LoaiNguoiThuHuongId = $("input[name='LoaiNguoiThuHuongId']").val();

        var formData = new FormData();
        formData.append('TyLePhi', TyLePhi);
        formData.append('ThongTinNguoiChoVay_HoTen', ThongTinNguoiChoVay_HoTen);
        formData.append('ThongTinNguoiChoVay_CMND', ThongTinNguoiChoVay_CMND);
        formData.append('ThongTinNguoiChoVay_DienThoai', ThongTinNguoiChoVay_DienThoai);
        formData.append('ThongTinNguoiChoVay_Email', ThongTinNguoiChoVay_Email);
        formData.append('ThongTinNguoiChoVay_DiaChi', ThongTinNguoiChoVay_DiaChi);
        formData.append('LoaiNguoiThuHuongId', LoaiNguoiThuHuongId);
        formData.append('code', code);
        formData.append('name', name);
        formData.append('id', id);
        formData.append('id_config_gic', id_config_gic);
         formData.append('NhanVienId', NhanVienId);
    $.ajax({
        url :  _url.base_url + '/config_gic/doUpdateConfig_gic',
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
                    window.location.href = _url.base_url + '/config_gic/listconfig_gic';
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


