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
$('#number_day_loan').selectize({
    create: false,
    valueField: 'code',
    labelField: 'name',
    searchField: 'name',
    maxItems: 100,
    sortField: {
        field: 'name',
        direction: 'asc'
    }
});
$('#loan_product').selectize({
    create: false,
    valueField: 'code',
    labelField: 'name',
    searchField: 'name',
    maxItems: 100,
    sortField: {
        field: 'name',
        direction: 'asc'
    }
});
$('#code_area').selectize({
    create: false,
    valueField: 'code',
    labelField: 'name',
    searchField: 'name',
    maxItems: 100,
    sortField: {
        field: 'name',
        direction: 'asc'
    }
});
$(".delete_coupon").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/coupon/deletecoupon',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".coupon_" + id).remove();
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


$(".create_coupon").click(function(event) {
    event.preventDefault();
        var code = $("input[name='code']").val();
        var start_date = $("input[name='start_date']").val();
        var end_date = $("input[name='end_date']").val();
        var event = $("input[name='event']").val();
        var note = $("textarea[name='note']").val();
        var loan_product = $("select[name='loan_product[]']").val();
        var percent_interest_customer = $("input[name='percent_interest_customer']").val();
        var percent_advisory = $("input[name='percent_advisory']").val();
        var percent_expertise = $("input[name='percent_expertise']").val();
        var penalty_percent = $("input[name='penalty_percent']").val();
        var penalty_amount = $("input[name='penalty_amount']").val();
        var extend = $("input[name='extend']").val();
        var percent_prepay_phase_1 = $("input[name='percent_prepay_phase_1']").val();
        var percent_prepay_phase_2 = $("input[name='percent_prepay_phase_2']").val();
        var percent_prepay_phase_3 = $("input[name='percent_prepay_phase_3']").val();
        var id_coupon = $("input[name='id_coupon']").val();
        var type_loan = $("select[name='type_loan']").val();
        var number_day_loan = $("select[name='number_day_loan[]']").val();
        var type_property = $("select[name='type_property']").val();
        var selectize_province = $("select[name='selectize_province']").val();
        var code_store = $("select[name='code_store']").val();
        var set_by_coupon = $("input[name='set_by_coupon']:checked").val();
        var chon_tu_dong = $("input[name='chon_tu_dong']:checked").val();
        var code_area = $("select[name='code_area[]']").val();
        var status = $("input[name='status']:checked").val();
        var reduction_interest = $("input[name='reduction_interest']:checked").val();
        var down_interest_on_month = $("input[name='down_interest_on_month']:checked").val();
        var formData = new FormData();
        formData.append('code', code);
        formData.append('start_date', start_date);
        formData.append('end_date', end_date);
        formData.append('event', event);
        formData.append('note', note);
        formData.append('percent_interest_customer', percent_interest_customer);
        formData.append('percent_advisory', percent_advisory);
        formData.append('percent_expertise', percent_expertise);
        formData.append('penalty_percent', penalty_percent);
        formData.append('penalty_amount', penalty_amount);
        formData.append('extend', extend);
        formData.append('percent_prepay_phase_1', percent_prepay_phase_1);
        formData.append('percent_prepay_phase_2', percent_prepay_phase_2);
        formData.append('percent_prepay_phase_3', percent_prepay_phase_3);
        formData.append('type_loan', type_loan);
         formData.append('number_day_loan', number_day_loan);
        formData.append('type_property', type_property);
        formData.append('selectize_province', selectize_province);
        formData.append('code_store', code_store);
        formData.append('id_coupon', id_coupon);
        formData.append('status', status);
        formData.append('reduction_interest', reduction_interest);
        formData.append('down_interest_on_month', down_interest_on_month);
        formData.append('loan_product', loan_product);
        formData.append('set_by_coupon', set_by_coupon);
        formData.append('code_area', code_area);
        formData.append('chon_tu_dong', chon_tu_dong);
          
    $.ajax({
        url :  _url.base_url + 'coupon/doAddCoupon',
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
                    window.location.href = _url.base_url + 'coupon/listcoupon';
                }, 1000);
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

$(".update_coupon").click(function(event) {
    event.preventDefault();
        var id = $("input[name='id_coupon']").val();
        var title_vi = $("input[name='title_vi']").val();
        var content_vi = CKEDITOR.instances.content_vi.getData();
        var title_en = $("input[name='title_en']").val();
        var content_en = CKEDITOR.instances.content_en.getData();
        var type = $("select[name='type_coupon']").val();
        var status = $("input[name='status']:checked").val();
        var reduction_interest = $("select[name='reduction_interest']").val();
        var down_interest_on_month = $("select[name='down_interest_on_month']").val();
        var set_by_coupon = $("input[name='set_by_coupon']:checked").val();
        var formData = new FormData();
        formData.append('title_vi', title_vi);
        formData.append('content_vi', content_vi);
        formData.append('title_en', title_en);
        formData.append('content_en', content_en);
        formData.append('type_coupon', type);
        formData.append('status', status);
        formData.append('id', id);
        formData.append('reduction_interest', reduction_interest);
        formData.append('down_interest_on_month', down_interest_on_month);
        formData.append('set_by_coupon', set_by_coupon);
    $.ajax({
        url :  _url.base_url + '/coupon/doUpdateCoupon',
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
                    window.location.href = _url.base_url + '/coupon/listcoupon';
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


