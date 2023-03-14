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



$("#add_one_month_pgd").click(function(event) {
    event.preventDefault();
        var fdate_export = $("input[name='fdate_export']").val();
       
        var formData = new FormData();
        formData.append('fdate_export', fdate_export);

        
        
    console.log(formData);
       
    $.ajax({
        url :  _url.base_url + 'kpi/doAddKpi_pgd',
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
                    window.location.href = _url.base_url + 'kpi/listKPI_pgd';
                }, 3000);
            } else {
                  console.log(data);
                $("#errorModal").css("display", "block");
                $(".errorModal").text(data.message);
                window.scrollTo(0, 0);
                setTimeout(function(){ 
                $("#errorModal").css("display", "none");
                }, 3000);
            }
        },
        error: function(data) {
            //console.log(data);
            $(".theloading").hide();
         
                
        }
    });
 
});
$("#add_one_month_gdv").click(function(event) {
    event.preventDefault();
        var fdate_export = $("input[name='fdate_export']").val();
          var code_store = $("select[name='code_store']").val();
        var formData = new FormData();
        formData.append('fdate_export', fdate_export);
         formData.append('code_store', code_store);
        
        
    console.log(formData);
       
    $.ajax({
        url :  _url.base_url + 'kpi/doAddKpi_gdv',
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
                    window.location.href = _url.base_url + 'kpi/listKPI_gdv';
                }, 3000);
            } else {
                  console.log(data);
                $("#errorModal").css("display", "block");
                $(".errorModal").text(data.message);
                window.scrollTo(0, 0);
                setTimeout(function(){ 
                $("#errorModal").css("display", "none");
                }, 3000);
            }
        },
        error: function(data) {
            //console.log(data);
            $(".theloading").hide();
         
                
        }
    });
 
});
$("#add_one_month_area").click(function(event) {
    event.preventDefault();
        var fdate_export = $("input[name='fdate_export']").val();
        
        var formData = new FormData();
        formData.append('fdate_export', fdate_export);
        
        
    console.log(formData);
       
    $.ajax({
        url :  _url.base_url + 'kpi/doAddKpi_area',
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
                    window.location.href = _url.base_url + 'kpi/listKPI_area';
                }, 3000);
            } else {
                  console.log(data);
                $("#errorModal").css("display", "block");
                $(".errorModal").text(data.message);
                window.scrollTo(0, 0);
                setTimeout(function(){ 
                $("#errorModal").css("display", "none");
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
        var formData = new FormData();
        formData.append('title', title);
        formData.append('content', content);
         formData.append('code', code);
        formData.append('status', status);
        formData.append('id', id);
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


$('select[name="code_store"]').selectize({
    create: false,
    valueField: 'code',
    labelField: 'name',
    searchField: 'name',
    sortField: {
        field: 'name',
        direction: 'asc'
    }
});