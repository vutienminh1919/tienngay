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

$(".delete_area").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/area/deletearea',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".area_" + id).remove();
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


$(".create_area").click(function(event) {
    event.preventDefault();
        var title = $("input[name='title']").val();
        var content = $("textarea[name='content']").val();
        var code = $("input[name='code']").val();
        var code_domain = $("select[name='domain']").val();
        var text_domain =$("select[name='domain'] option:selected").text()
         var code_region = $("select[name='region']").val();
        var text_region =$("select[name='region'] option:selected").text();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('title', title);
        formData.append('content', content);
        formData.append('code', code);
        formData.append('code_domain', code_domain);
        formData.append('text_domain', text_domain);
            formData.append('code_region', code_region);
        formData.append('text_region', text_region);
        formData.append('status', status);
        
    console.log(formData);
       
    $.ajax({
        url :  _url.base_url + 'area/doAddArea',
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
                    window.location.href = _url.base_url + 'area/listarea';
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

$(".update_area").click(function(event) {
    event.preventDefault();
        var id = $("input[name='id_area']").val();
        var title = $("input[name='title']").val();
        var content = $("textarea[name='content']").val();
        var code = $("input[name='code']").val();
        var status = $("input[name='status']:checked").val();
        var code_domain = $("select[name='domain']").val();
        var text_domain =$("select[name='domain'] option:selected").text();
         var code_region = $("select[name='region']").val();
        var text_region =$("select[name='region'] option:selected").text();
        var formData = new FormData();
        formData.append('title', title);
        formData.append('content', content);
        formData.append('code', code);
        formData.append('status', status);
        formData.append('id', id);
        formData.append('code_domain', code_domain);
        formData.append('text_domain', text_domain);
         formData.append('code_region', code_region);
        formData.append('text_region', text_region);
    $.ajax({
        url :  _url.base_url + '/area/doUpdateArea',
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
                    window.location.href = _url.base_url + '/area/listarea';
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


