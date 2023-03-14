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
$('#selectize_province').selectize({
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
$(".delete_landing_page").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/landing_page/deletelanding_page',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".landing_page_" + id).remove();
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


$(".create_landing_page").click(function(event) {
    event.preventDefault();
        var province_id = $("#selectize_province").val();
        var province_name = $("#selectize_province").text();
        var url = $('#url').val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('url', url);
        formData.append('province_id', province_id);
         formData.append('province_name', province_name);
        formData.append('status', status);
        
    console.log(formData);
       
    $.ajax({
        url :  _url.base_url + 'landing_page/doAddLanding_page',
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
                    window.location.href = _url.base_url + 'landing_page/listlanding_page';
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

$(".update_landing_page").click(function(event) {
    event.preventDefault();
        var id = $("input[name='id_landing_page']").val();
        var province_id = $("#selectize_province").val();
        var province_name = $("#selectize_province").text();
        var url = $('#url').val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
         formData.append('url', url);
        formData.append('province_id', province_id);
         formData.append('province_name', province_name);
        formData.append('status', status);
        formData.append('id', id);
    $.ajax({
        url :  _url.base_url + '/landing_page/doUpdateLanding_page',
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
                    window.location.href = _url.base_url + '/landing_page/listlanding_page';
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


