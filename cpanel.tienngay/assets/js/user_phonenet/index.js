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
$('#email_user').selectize({
    create: false,
    valueField: 'email',
    labelField: 'full_name',
    searchField: 'full_name',
    maxItems: 1,
    sortField: {
        field: 'full_name',
        direction: 'asc'
    }
});
$(".delete_user_phonenet").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/user_phonenet/deleteuser_phonenet',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".user_phonenet_" + id).remove();
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


$(".create_user_phonenet").click(function(event) {
    event.preventDefault();
    
        var email_user = $("select[name='email_user']").val();
        var extension_number = $("input[name='extension_number']").val();
         var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('email_user', email_user);
        formData.append('extension_number', extension_number);
        formData.append('status', status);
           
    console.log(formData);
       
    $.ajax({
        url :  _url.base_url + 'user_phonenet/doAddUser_phonenet',
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
                    window.location.href = _url.base_url + 'user_phonenet/listuser_phonenet';
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

$(".update_user_phonenet").click(function(event) {
    event.preventDefault();
          var id = $("input[name='id']").val();
        var email_user = $("select[name='email_user']").val();
        var extension_number = $("input[name='extension_number']").val();
         var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('email_user', email_user);
        formData.append('extension_number', extension_number);
        formData.append('status', status);
        formData.append('id', id);
    $.ajax({
        url :  _url.base_url + '/user_phonenet/doUpdateUser_phonenet',
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
                    window.location.href = _url.base_url + '/user_phonenet/listuser_phonenet';
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


