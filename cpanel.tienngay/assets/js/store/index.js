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

$(".delete_store").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/store/deleteStore',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".store_" + id).remove();
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


$(".create_store").click(function(event) {
    event.preventDefault();
    var name_shop = $("input[name='name_shop']").val();
    var phone_shop = $("input[name='phone_shop']").val();
    var lat = $("input[name='lat']").val();
    var lng = $("input[name='lng']").val();
    var phone_hotline = $("input[name='phone_hotline']").val();
    var province_shop = $("#selectize_province").text();
    var district_shop = $("#selectize_district").text();
    var province_id = $("#selectize_province").val();
    var district_id = $("#selectize_district").val();
    var address_shop = $("input[name='address_shop']").val();
    var representative = $("input[name='representative']").val();
    var investment = $("input[name='investment']").val();
    var code_address_store = $("input[name='code_address_store']").val();
	var code_province_store = $('#code_province_store').val();
    var company = $("select[name='company']").val();
    var status  = $("input[name='status']:checked").val();
    var type_pgd = $("input[name='type_pgd']:checked").val();
    var formData = {
        name_shop: name_shop,
        phone_shop: phone_shop,
        phone_hotline: phone_hotline,
        province_shop: province_shop,
        district_shop: district_shop,
        address_shop: address_shop,
        representative: representative,
        investment: investment,
        status: status,
        province_id: province_id,
        district_id: district_id,
        type_pgd: type_pgd,
		code_address_store: code_address_store,
        company: company,
		code_province_store: code_province_store,
        lat: lat,
        lng: lng,
    };
    $.ajax({
        url :  _url.base_url + '/store/doAddStore',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/store/listStore';
                }, 3000);
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

$(".update_store").click(function(event) {
    event.preventDefault();
    var id = $("input[name='id_shop']").val();
    var name_shop = $("input[name='name_shop']").val();
    var phone_shop = $("input[name='phone_shop']").val();
    var phone_hotline = $("input[name='phone_hotline']").val();
    var province_shop = $("#selectize_province").text();
    var district_shop = $("#selectize_district").text();
    var province_id = $("#selectize_province").val();
    var district_id = $("#selectize_district").val();
    var address_shop = $("input[name='address_shop']").val();
    var representative = $("input[name='representative']").val();
    var investment = $("input[name='investment']").val();
	var code_address_store = $("input[name='code_address_store']").val();
	var code_province_store = $('#code_province_store').val();
    var status  = $("input[name='status']:checked").val();
    var type_pgd = $("input[name='type_pgd']:checked").val();
    var lat = $("input[name='lat']").val();
    var lng = $("input[name='lng']").val();
    var formData = {
        id: id,
        name_shop: name_shop,
        phone_shop: phone_shop,
        province_shop: province_shop,
        district_shop: district_shop,
        address_shop: address_shop,
        representative: representative,
        investment: investment,
        status: status,
        type_pgd: type_pgd,
        province_id: province_id,
		district_id: district_id,
		code_address_store: code_address_store,
		code_province_store: code_province_store,
        lat: lat,
        lng: lng,
    };
    $.ajax({
        url :  _url.base_url + '/store/doUpdateStore',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/store/listStore';
                }, 3000);
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
