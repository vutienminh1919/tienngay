const pti_bhtn = function (fieldSelect, fieldOutput, selected) {
	var gois = {
		'GOI1' : "GOI1 - 20.000.000",
		'GOI2' : "GOI2 - 30.000.000",
		'GOI3' : "GOI3 - 50.000.000",
		'GOI4' : "GOI4 - 70.000.000",
		'GOI5' : "GOI5 - 100.000.000"
	};
	var phis = {
		'GOI1' : 220000,
		'GOI2' : 240000,
		'GOI3' : 280000,
		'GOI4' : 320000,
		'GOI5' : 370000
	};

	var price = {
		'GOI1' : 20000000,
		'GOI2' : 30000000,
		'GOI3' : 50000000,
		'GOI4' : 70000000,
		'GOI5' : 100000000,
	};
	var html = '<option value="">-- Chọn bảo hiểm --</option>';
	for (const [key, value] of Object.entries(gois)) {
		if (selected == key) {
  			html += '<option value="'+key+'" selected>'+value+'</option>'
	  	} else {
	  		html += '<option value="'+key+'">'+value+'</option>'
	  	}
	}
	fieldSelect.append(html);
	fieldSelect.on('change', pti_get_phi.bind(null, phis, price, fieldSelect, fieldOutput));
	$('#customer_BOD').on('change', pti_get_phi.bind(null, phis, price, fieldSelect, fieldOutput));
	$('#money').on('focusout', pti_get_phi.bind(null, phis, price, fieldSelect, fieldOutput));
	fieldSelect.change();
}
const fomatNumber = function ($value) {
    if ($value > 0 || $value < 0) {
        return $value.toLocaleString('en-US');
    }
    return 0;
}
const pti_get_phi = function(phis, price, fieldSelect, fieldOutput) {
	var age = calAge($('#customer_BOD').val());
	var money = $('#money').val();
	var loanAmount = Number(money.replace(/\D/g,''));
	$("#pti_bhtn_price").remove();
	fieldOutput.val(0);
	var val = fieldSelect.val();
	var validate = true;
	var message = "";
	if (val !== "" && val !== undefined) {
		if (age > 17 && age < 71) {
			// do nothing
		} else {
			validate = false;
			message = "PTI - Bảo Hiểm Tai Nạn chỉ áp dụng cho khách hàng từ 18->70 tuổi!";
		}

		if (loanAmount >= 7000000 && loanAmount < 15000000 && phis[val] < 240000) {
			validate = false;
			message = "Khoản vay 7-15tr phải mua bảo hiểm PTI-BHTN từ gói 30tr trở lên.";
		} else if (loanAmount >= 15000000 && loanAmount < 25000000 && phis[val] < 280000) {
			validate = false;
			message = "Khoản vay 15-25tr phải mua bảo hiểm PTI-BHTN từ gói 50tr trở lên.";
		} else if (loanAmount >= 25000000 && phis[val] < 370000) {
			validate = false;
			message = "Khoản vay từ 25tr phải mua bảo hiểm PTI-BHTN từ gói 100tr trở lên.";
		}

		if (validate) {
			fieldOutput.val(fomatNumber(phis[val]));
			fieldOutput.after('<input type="hidden" id="pti_bhtn_price" value="'+price[val]+'"/>');
		} else {
			fieldOutput.val(0);
			fieldSelect.val("");
			alert(message);
		}
		
	}
	
}

/**
* date format yyyy-mm-dd or mm/dd/yyyy
*/
const calAge = function(date) {
	var dob = new Date(date);  
	console.log(dob);
    //calculate month difference from current date in time  
    var month_diff = Date.now() - dob.getTime();  
    //convert the calculated difference in date format  
    var age_dt = new Date(month_diff);   
    //extract year from date      
    var year = age_dt.getUTCFullYear();  
    //calculate the age of the user  
    var age = Math.abs(year - 1970);
    return age;
}