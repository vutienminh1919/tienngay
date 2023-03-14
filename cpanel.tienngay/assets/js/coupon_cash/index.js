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

$('#bh_product').selectize({
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
$('#loai_khach').selectize({
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
$(".delete_coupon_cash").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/coupon_cash/deleteCoupon_cash',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".coupon_cash_" + id).remove();
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


$(".create_coupon_cash").click(function(event) {
    event.preventDefault();
        var code = $("input[name='code']").val();
        var start_date = $("input[name='start_date']").val();
        var end_date = $("input[name='end_date']").val();
        var note = $("textarea[name='note']").val();
        var bh_product = $("select[name='bh_product[]']").val();
        var id_coupon_cash = $("input[name='id_coupon_cash']").val();
        var code_store = $("select[name='code_store']").val();
         var code_area = $("select[name='code_area[]']").val();
        var status = $("input[name='status']:checked").val();
         var percent_reduction = $("input[name='percent_reduction']").val();
         var loai_khach = $("select[name='loai_khach[]']").val();
        var formData = new FormData();
        formData.append('code', code);
        formData.append('start_date', start_date);
        formData.append('end_date', end_date);
        formData.append('note', note);
        formData.append('code_store', code_store);
        formData.append('id_coupon_cash', id_coupon_cash);
        formData.append('status', status);
        formData.append('bh_product', bh_product);
        formData.append('code_area', code_area);
        formData.append('percent_reduction', percent_reduction);
         formData.append('loai_khach', loai_khach);

          
    $.ajax({
        url :  _url.base_url + 'coupon_cash/doAddCoupon_cash',
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
                    window.location.href = _url.base_url + 'coupon_cash/listCoupon_cash';
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
