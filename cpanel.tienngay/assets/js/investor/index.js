
$(document).ready(function() {
$('#bank').selectize({
    create: false,
    valueField: 'bank_id',
    labelField: 'name',
    searchField: 'name',
    maxItems: 1,
    sortField: {
        field: 'name',
        direction: 'asc'
    }
});
$("#btn-create").click(function() {
    var modal = $(this).closest("div.modal-content");
    var name = $(modal).find("#name").val(); 
    var code = $(modal).find("#code_investor").val(); 
    var percentInterestInvestor = $(modal).find("#percent_interest_investor").val();
    $.ajax({
        url: $(this).data("url"),
        method: "POST",
        data: {
            name: name,
            code: code,
            percent_interest_investor: percentInterestInvestor
        },
        beforeSend: function() {
            
        },
        success: function(data) {
            if(data.code != '200') {
                alert(data.message);
            } else {
                window.location.reload();
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
});

$("button[name='btn-update']").click(function() {
    var id = $(this).data("id");
    var modal = $(this).closest("div.modal-content");
    var name = $(modal).find("input[name='name']").val(); 
    var code = $(modal).find("input[name='code_investor']").val(); 
    var status = $(modal).find("#status").val(); 
    var percentInterestInvestor = $(modal).find("input[name='percent_interest_investor']").val();
    $.ajax({
        url: $(this).data("url"),
        method: "POST",
        data: {
            id: id,
            name: name,
            code: code,
            status: status,
            percent_interest_investor: percentInterestInvestor,
        },
        beforeSend: function() {
            
        },
        success: function(data) {
            if(data.code != '200') {
                alert(data.message);
            } else {
                window.location.reload();
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
    
});

$('#percent_interest_investor').keyup(function(event) {
    // skip for arrow keys
    const re = /[^\d.]+|^(0{2}|\.)|(0$)|\.(?=\.|.+\.)/;
    if(event.which >= 37 && event.which <= 40) return;
    // format number
    $(this).val(function(index, value) {
        return value.replace(re, "");
    });
});
$('.percent_interest_investor_update').keyup(function(event) {
    // skip for arrow keys
    const re = /[^\d.]+|^(0{2}|\.)|(0$)|\.(?=\.|.+\.)/;
    if(event.which >= 37 && event.which <= 40) return;
    // format number
    $(this).val(function(index, value) {
        return value.replace(re, "");
    });
});

$('.number').keypress(function(event) {
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});
});