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

$(".delete_news").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/newspapers/deletenews',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".news_" + id).remove();
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


$(".create_news").click(function(event) {
    event.preventDefault();
        var inputimg=$('input[name=image]');
        var imgToUpload=inputimg[0].files[0];
        var title_vi = $("input[name='title_vi']").val();
        var title_en = $("input[name='title_en']").val();
        var link = $("input[name='link']").val();
        var source = $("input[name='source']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('image', imgToUpload);
        formData.append('title_vi', title_vi);
        formData.append('title_en', title_en);
        formData.append('link', link);
        formData.append('source', source);
        formData.append('status', status);
        
    console.log(formData);
       
    $.ajax({
        enctype: 'multipart/form-data',
        url :  _url.base_url + 'newspapers/doAddNews',
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
                    window.location.href = _url.base_url + 'newspapers/listnews';
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

$(".update_news").click(function(event) {
    event.preventDefault();
       var id = $("input[name='id_news']").val();
        var inputimg=$('input[name=image]');
        var imgToUpload=inputimg[0].files[0];
        var title_vi = $("input[name='title_vi']").val();
        var title_en = $("input[name='title_en']").val();
        var link = $("input[name='link']").val();
        var source = $("input[name='source']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('image', imgToUpload);
        formData.append('title_vi', title_vi);
        formData.append('title_en', title_en);
        formData.append('link', link);
        formData.append('source', source);
        formData.append('status', status);
        formData.append('id', id);
    $.ajax({
        url :  _url.base_url + '/newspapers/doUpdateNews',
        type: "POST",
         enctype: 'multipart/form-data',
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
                    window.location.href = _url.base_url + '/newspapers/listnews';
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


