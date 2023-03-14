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

$(".delete_email_template").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/email_template/deleteEmail_template',
        code_name: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".email_template_" + id).remove();
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


$(".create_email_template").click(function(event) {
    event.preventDefault();
        var code = $("input[name='code']").val();
        var message = $("textarea[name='message']").val();
        var code_name = $("input[name='code_name']").val();
        var from = $("input[name='from']").val();
        var from_name = $("input[name='from_name']").val();
        var subject = $("input[name='subject']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('code', code);
        formData.append('message', message);
        formData.append('code_name', code_name);
        formData.append('from', from);
        formData.append('from_name', from_name);
        formData.append('subject', subject);
        formData.append('status', status);
        
    console.log(formData);
       
    $.ajax({
        url :  _url.base_url + 'email_template/doAddEmail_template',
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
                    window.location.href = _url.base_url + 'email_template/listEmail_template';
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

$(".update_email_template").click(function(event) {
    event.preventDefault();
        var id = $("input[name='id_email_template']").val();
         var code = $("input[name='code']").val();
        var message = $("textarea[name='message']").val();
        var code_name = $("input[name='code_name']").val();
        var from = $("input[name='from']").val();
        var from_name = $("input[name='from_name']").val();
        var subject = $("input[name='subject']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
         formData.append('code', code);
        formData.append('message', message);
        formData.append('code_name', code_name);
        formData.append('from', from);
        formData.append('from_name', from_name);
        formData.append('subject', subject);
        formData.append('status', status);
        formData.append('id', id);
    $.ajax({
        url :  _url.base_url + '/email_template/doUpdateEmail_template',
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
                    window.location.href = _url.base_url + '/email_template/listEmail_template';
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


