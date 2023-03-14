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
$('#type_loan').selectize({
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
$('#type_property').selectize({
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
$(".delete_coupon_bhkv").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/coupon_bhkv/deleteCoupon_bhkv',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".coupon_bhkv_" + id).remove();
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


$(".create_coupon_bhkv").click(function(event) {
    event.preventDefault();
        var code = $("input[name='code']").val();
        var start_date = $("input[name='start_date']").val();
        var end_date = $("input[name='end_date']").val();
        var note = $("textarea[name='note']").val();
        var loan_product = $("select[name='loan_product[]']").val();
        var id_coupon_bhkv = $("input[name='id_coupon_bhkv']").val();
        var type_loan = $("select[name='type_loan[]']").val();
         var number_day_loan = $("select[name='number_day_loan[]']").val();
        var type_property = $("select[name='type_property[]']").val();
        var selectize_province = $("select[name='selectize_province']").val();
        var code_store = $("select[name='code_store']").val();
         var code_area = $("select[name='code_area[]']").val();
        var status = $("input[name='status']:checked").val();
         var start_money = $("input[name='start_money']").val();
        var end_money = $("input[name='end_money']").val();
         var percent_reduction = $("input[name='percent_reduction']").val();
         var type_coupon = $("input[name='type_coupon']:checked").val();
        
        var formData = new FormData();
        formData.append('code', code);
        formData.append('start_date', start_date);
        formData.append('end_date', end_date);
        formData.append('note', note);
        formData.append('type_loan', type_loan);
         formData.append('number_day_loan', number_day_loan);
        formData.append('type_property', type_property);
        formData.append('selectize_province', selectize_province);
        formData.append('code_store', code_store);
        formData.append('id_coupon_bhkv', id_coupon_bhkv);
        formData.append('status', status);
        formData.append('loan_product', loan_product);
        formData.append('code_area', code_area);
        formData.append('start_money', getFloat(start_money));
        formData.append('end_money', getFloat(end_money));
        formData.append('percent_reduction', percent_reduction);
         formData.append('type_coupon', type_coupon);

          
    $.ajax({
        url :  _url.base_url + 'coupon_bhkv/doAddCoupon_bhkv',
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
                    window.location.href = _url.base_url + 'coupon_bhkv/listCoupon_bhkv';
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


$('.end_money').on('input', function (e) {
        $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
    }).on('keypress', function (e) {
        if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
    }).on('paste', function (e) {
        var cb = e.originalEvent.clipboardData || window.clipboardData;
        if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
    });
    $('.start_money').on('input', function (e) {
        $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g, '')));
    }).on('keypress', function (e) {
        if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
    }).on('paste', function (e) {
        var cb = e.originalEvent.clipboardData || window.clipboardData;
        if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
    });
    function formatCurrency(number){
    var n = number.split('').reverse().join("");
    var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");    
    return  n2.split('').reverse().join('');
}
function getFloat(val) {
    var val = val.replace(/,/g,"");
    return parseFloat(val);
}
 $('.percent_reduction').on('input', function (e) {
       
    }).on('keypress', function (e) {
        if (!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
    }).on('paste', function (e) {
        var cb = e.originalEvent.clipboardData || window.clipboardData;
        if (!$.isNumeric(cb.getData('text'))) e.preventDefault();
    });
