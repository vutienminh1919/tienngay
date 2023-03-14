/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('.number').keyup(function(event) {
    if ((event.which != 190) && (event.which < 48 || event.which > 57) && event.which != 8) {
        event.preventDefault();
        var new1 = $(this).val().replace(event.key, '');
        $(this).val(new1);
        return;
    }
    if($(this).val().length > 1 && $(this).val().indexOf(",") > -1) {
        var arr = $(this).val().split(",");
        if(arr['1'].length > 8) {
            var new1 = $(this).val().replace(event.key, '');
            $(this).val(new1);
            return;
        }
    }
//    if($(this).val().length > 19) {
//        $(this).val("0.000000");
//        $("#amount_cash").text("0.00");
//    }
});

$("#btn-create").click(function() {
    var modal = $(this).closest("div.modal-content");
    var title = $(modal).find("#title").val(); 
    var from = $(modal).find("#from").val();
    var to = $(modal).find("#to").val();
    var inforFee = getDataModal("modal_create");
    
    $.ajax({
        url: $(this).data("url"),
        method: "POST",
        data: {
            title: title,
            from: from,
            to: to,
            infor: JSON.stringify(inforFee.infor)
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

function getDataModal(modal) {
    var data = [];
    data["infor"] = {}; 
    //Forach <li>
    $("#"+modal).find("li[name='li_day']").each(function() {
        var day = $(this).data("day");
        data["infor"][day] = {};
        //Foreach <div name='div_type_30'>
        $("#"+modal).find("div[name='div_type_"+day+"']").each(function() {
            //Foreach <div detail> => CC - DKX
            $(this).find("div[name='div_detail']").each(function() {
                var type = $(this).data("type");
                data["infor"][day][type] = {};
                //Foreach input
                $(this).find("input").each(function() {
                    var name = $(this).data("name");
                    var val = 0;
                    if($(this).val() !== "" && $(this).val() != undefined) val = parseFloat($(this).val());
                    data["infor"][day][type][name] = val;
                });
            });
        });
    });
    return data;
}

$("button[name='btn-update']").click(function() {
    var modalId = $(this).data("modal-id");
    var id = $(this).data("id");
    var modal = $(this).closest("div.modal-content");
    var title = $(modal).find("#title").val(); 
    var from = $(modal).find("#from").val();
    var to = $(modal).find("#to").val();
    var inforFee = getDataModal(modalId);
    
    $.ajax({
        url: $(this).data("url"),
        method: "POST",
        data: {
            id: id,
            title: title,
            from: from,
            to: to,
            infor: JSON.stringify(inforFee.infor)
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

function getDataModalEstate(modal) {
	var data = [];
	data["infor"] = {};
	data["infor"]["percent_prepay_phase_1"] = $("#"+modal).find("input[name='percent_prepay_phase_1']").val();
	data["infor"]["percent_prepay_phase_2"] = $("#"+modal).find("input[name='percent_prepay_phase_2']").val();
	data["infor"]["percent_prepay_phase_3"] = $("#"+modal).find("input[name='percent_prepay_phase_3']").val();
	data["infor"]["penalty_percent"] = $("#"+modal).find("input[name='penalty_percent']").val();
	data["infor"]["penalty_amount"] = $("#"+modal).find("input[name='penalty_amount']").val();
	data["infor"]["extend"] = $("#"+modal).find("input[name='extend']").val();
	//Forach <li>
	$("#"+modal).find("li[name='li_day']").each(function() {
		var day = $(this).data("day");
		console.log($(this));
		data["infor"][day] = {};
		//Foreach <div name='div_type_30'>
		$("#"+modal).find("div[name='div_type_"+day+"']").each(function() {
			//Foreach <div detail> => CC - DKX
			$(this).find(".col-xs-12").each(function() {
				$(this).find("input").each(function() {
					var name = $(this).data("name");
					console.log(name);
					var val = 0;
					if($(this).val() !== "" && $(this).val() != undefined) val = parseFloat($(this).val());
					data["infor"][day][name] = val;
				});
			});
		});
	});
	return data;
}

$(".btn-estate").click(function() {
	var modalId = $(this).data("modal-id");
	var id = $(this).data("id");
	var modal = $(this).closest("div.modal-content");
	var title = $(modal).find("#title").val();
	var from = $(modal).find("#from").val();
    var to = $(modal).find("#to").val();
	var inforFee = getDataModalEstate(modalId);

	$.ajax({
		url: $(this).data("url"),
		method: "POST",
		data: {
			id: id,
			title: title,
			from: from,
            to: to,
			infor: JSON.stringify(inforFee.infor)
		},
		beforeSend: function() {

		},
		success: function(data) {
			if(data.code !== "200") {
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
