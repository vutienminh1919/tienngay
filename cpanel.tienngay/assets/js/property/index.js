$(".delete_property").click(function(event) {
    event.preventDefault();
    var id = $(".delete_property").attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/property/delete_property',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".property_" + id).remove();
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

$(".delete_main_property").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/property_main/deletePropertyMain',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".property_main_" + id).remove();
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

var count_properties = $("#add_properties").children().length - 1;
$(".properties").click(function(event) {
    count_properties = count_properties+1;
    event.preventDefault();   
    temp = "<div id='form_"+count_properties+"' class='form-group'><label style='text-align: left;' class='control-label col-md-4 col-sm-3 col-xs-12' for='first-name'>Thuộc tính</label><div class='col-md-8 col-sm-6 col-xs-12'><div class='input-group'><input type='text' name='properties["+count_properties +"]' class='form-control' /> <span class='input-group-btn'><a href='javascript:void(0);' class='btn btn-danger' data-id='form_"+count_properties+"'  onclick='remove_properties(this)'> <i class='fa fa-times'></i> XÓA </a></span> </div> </div> </div>";
    $("#add_properties").append(temp);
});

$(".propertiesEdit").click(function(event) {
    count_properties = count_properties+1;
    event.preventDefault();   
    temp = "<div id='form_"+count_properties+"' class='form-group'><label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Thuộc tính</label><div class='col-md-6 col-sm-6 col-xs-12'><div class='input-group'><input type='text' name='properties["+count_properties +"]' class='form-control' /> <span class='input-group-btn'><a href='javascript:void(0);' class='btn btn-danger' data-id='form_"+count_properties+"'  onclick='remove_properties(this)'> <i class='fa fa-times'></i> XÓA </a></span> </div> </div> </div>";
    $("#add_properties").append(temp);
});


function remove_properties(thiz){
    var id = $(thiz).attr('data-id'); 
    $("#" + id).remove();
}

var count_product_pricing = $("#add_product_pricing").children().length - 1;
$(".product_pricing").click(function(event) {
    event.preventDefault();
    var formData = {
        parent_property_id: $("#parent_package_create :selected").val(),
    };
    $.ajax({
        url :  _url.base_url + '/property_main/getDepreciation',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                count_product_pricing = count_product_pricing+1;

                let option = "";
                let select = "";
                let content = data.data;
                for(var i = 0; i < content.length; i++) {
                    //li += "<li class='sub-category' data-path='"+content[i].path+"' data-level='"+levelSub+"'><span><a>"+content[i].name+"</a></span></li>";
                    // li += "<li class='sub-category' data-path='"+content[i].path+"' data-id='"+content[i].id+"' data-level='"+levelSub+"'><a>"+content[i].name+"sbbbb</a></li>";
                    option += "<option value='"+content[i].name+"'>"+content[i].name+"</option>";
                }
                select = "  <select name='depreciation["+count_product_pricing+"]' class='form-control'>"+option+"</select>";
                //Append to current content
                //<input type='text' name='depreciation["+count_product_pricing +"]' class='form-control' />
                temp = "<div id='form_product_pricing_"+count_product_pricing+"' class='form-group'><label class='control-label' for='first-name'>Khấu hao</label><div><div class='input-group row'><div class='col-xs-6'>"+select+"</div> <div class='col-xs-4'><input type='text' data-id='1' name='price_depreciation["+count_product_pricing +"]' class='form-control' /> </div><span class='input-group-btn'><a href='javascript:void(0);' class='btn btn-danger' data-id='form_product_pricing_"+count_product_pricing+"'  onclick='remove_product_pricing(this)'> <i class='fa fa-times'></i> XÓA </a></span> </div> </div> </div>";
                $("#add_product_pricing").append(temp);
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

$(".product_pricing_update").click(function(event) {
    event.preventDefault();
    var formData = {
        parent_property_id: $("#parent_package_create :selected").val(),
    };
    $.ajax({
        url :  _url.base_url + '/property_main/getDepreciation',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                count_product_pricing = count_product_pricing+1;

                let option = "";
                let select = "";
                let content = data.data;
                for(var i = 0; i < content.length; i++) {
                    option += "<option value='"+content[i].name+"'>"+content[i].name+"</option>";
                }
                select = "  <select name='depreciation["+count_product_pricing+"]' class='form-control'>"+option+"</select>";
                //Append to current content
                temp = "<div id='form_product_pricing_"+count_product_pricing+"' class='form-group'><label class='control-label col-md-3 col-sm-3 col-xs-12' for='first-name'>Khấu hao</label><div class='col-md-6 col-sm-6 col-xs-12'><div class='input-group row'><div class='col-xs-6'>"+select+"</div> <div class='col-xs-4'><input type='text' data-id='2' name='price_depreciation["+count_product_pricing +"]' class='form-control' /> </div><span class='input-group-btn'><a href='javascript:void(0);' class='btn btn-danger' data-id='form_product_pricing_"+count_product_pricing+"'  onclick='remove_product_pricing(this)'> <i class='fa fa-times'></i> XÓA </a></span> </div> </div> </div>";
                $("#add_product_pricing").append(temp);
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

$(".appraise").click(function(event) {
    event.preventDefault();
    
    var formality = $('#percent_type_loan').val();
    console.log(formality);
    var property_id = $('#selectize_property_by_main').val();
    var depreciation_price = 0;
    $(".depreciation_by_property input[type=checkbox]:checked").each(function() {
        let price_dep = $(this).val()
        depreciation_price = parseInt(depreciation_price) + parseInt(price_dep) ;
    });
    var formData = {
        property_id: property_id,
        depreciation_price: depreciation_price,
        formality: formality
    };
    if(property_id=="" || formality==0) return;
    $.ajax({
        url :  _url.base_url + 'property_main/getPriceProperty',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".create_contract").show();
                $(".result_appraise").show();
                $(".depreciation_price").text(data.price);
                $(".amount_money").text(data.amount_money);

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

function chang_formality(thiz){
    var formality = $(this).val();
    $(".depreciation_price").text(data.price);
    $(".amount_money").text(data.amount_money);
}

function get_property_by_main(thiz){
    var id = $(thiz).val();
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/property_main/getPopertyByMain',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                var selectClass = $('#selectize_property_by_main').selectize();
                var selectizeClass = selectClass[0].selectize;
                selectizeClass.clear();
                selectizeClass.clearOptions();
                selectizeClass.load(function(callback) {
                    callback(data.data);
                });
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
 
};

function remove_product_pricing(thiz){
    var id = $(thiz).attr('data-id'); 
    $("#" + id).remove();
}

$('#selectize_property_by_main').selectize({
    create: false,
    valueField: 'id',
    labelField: 'name',
    searchField: 'name',
    maxItems: 1,
    sortField: {
        field: 'name',
        direction: 'asc'
    },
    onChange: function(value) {
        var formData = {
            id: value,
             code_type_property: $('input[name="selecttype"]:checked').attr("code"),
            type_loan: $("#type_finance :selected").data("code"),
        };
        $.ajax({
            url :  _url.base_url + '/Ajax/getDepreciationByProperty',
            type: "POST",
            data : formData,
            dataType : 'json',
            beforeSend: function(){$("#loading").show();},
            success: function(data) {
                if (data.res) {
                    $('.depreciation_by_property').children().remove();
                    let html = "";
                    let content = data.data;
                     var percent_formality = data.percent;
                        $("#percent_type_loan").val(data.percent);
                    for(var i = 0; i < content.length; i++) {
                      html += "<div class='form-check mb-0'><input class='form-check-input appraise' data-name='"+content[i].name+"' data-slug='"+content[i].slug+"' name='price_depreciation["+i+"]' type='checkbox' value='"+content[i].price+"' ><label class='form-check-label' >"+content[i].name+"</label></div>"
                    }
                    $(".depreciation_by_property").append(html);
                } else {
                  $('.depreciation_by_property').children().remove();
                    // $('#errorModal').modal('show');
                    // $('.msg_error').text(data.message);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
});

$(".btn-create-contract").on("click", function() {
    var typeFinance = $("#type_finance :selected").data("id");
    var typeMain = $('.selecttype.step1 input:checked').val();
    var minuses = "";
    $(". input[type=checkbox]:checked").each(function() {
        minuses += $(this).data("slug") + ",";
    });
    var rootPrice = getFloat($(".depreciation_price").text());
    var editPrice = getFloat($(".amount_money").text());
    window.location.href = _url.display_create_contract + '?finance='+typeFinance+
                                                         '&main='+typeMain+
                                                         '&sub='+$('#selectize_property_by_main').val()+
                                                         '&subName='+$('#selectize_property_by_main').text()+
                                                         '&minus='+minuses+
                                                         '&rootPrice='+rootPrice+
                                                         '&editPrice='+editPrice;
});

function getFloat(val) {
    var val = val.replace(/,/g,"");
    return parseFloat(val);
}

// Lấy mã code ô tô, xe máy và generate loại xe
function get_property_infor(thiz) {
	let property_code = $(thiz).val();
	console.log(property_code)
	if (property_code == "OTO") {
		$('.img_detail_dang_kiem_box').show();
	} else {
		$('.img_detail_dang_kiem_box').hide();
	}
	let formData = {property_code: property_code};
	$.ajax({
		url: _url.base_url + '/Ajax/get_brandname_property',
		type: "POST",
		data: formData,
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
		},
		success: function (response) {
			if (response.status == 200) {
				var selectClass = $('#selectize_property_by_main').selectize();
				var selectizeClass = selectClass[0].selectize;
				selectizeClass.clear();
				selectizeClass.clearOptions();
				selectizeClass.load(function (callback) {
					callback(response.data);
				});
			} else {
				var selectClass = $('#selectize_property_by_main').selectize();
				var selectizeClass = selectClass[0].selectize;
				selectizeClass.clear();
				selectizeClass.clearOptions();
				selectizeClass.load(function (callback) {
					callback('');
				});
				$('.properties').children().remove();
				console.log('error')
			}
		},
		error: function (response) {
			console.log(response);
			$("#loading").hide();
		}
	});


}


