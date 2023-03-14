$(document).ready(function () {

	var navListItems = $('div.setup-panel div a'),
		allWells = $('.setup-content'),
		allNextBtn = $('.nextBtn');
	allBackBtn = $('.backBtn');

	allWells.hide();

	navListItems.click(function (e) {
		e.preventDefault();
		var $target = $($(this).attr('href')),
			$item = $(this);

		if (!$item.hasClass('disabled')) {
			navListItems.removeClass('active');
			$item.addClass('active');
			allWells.hide();
			$target.show();
			$target.find('input:eq(0)').focus();
		}
	});

	allNextBtn.click(function () {

		var curStep = $(this).closest(".setup-content"),
			curStepBtn = curStep.attr("id"),
			nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
			curInputs = curStep.find("input[required]"),
			isValid = true;
		$(".form-group").removeClass("has-error");
		for (var i = 0; i < curInputs.length; i++) {
			if (!curInputs[i].validity.valid) {
				isValid = false;
				$(curInputs[i]).closest(".form-group").addClass("has-error");
			}
		}

		if (isValid) nextStepWizard.removeAttr('disabled').removeClass('disabled').trigger('click');
	});

	allBackBtn.click(function () {
		var curStep = $(this).closest(".setup-content"),
			curStepBtn = curStep.attr("id"),
			prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
		prevStepWizard.click();

	});

	$('div.setup-panel div .btn.igniter').trigger('click');

//	number price
	$('#salary').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;

		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
				;
		});
	});

	$('#money').keyup(function (event) {
		// skip for arrow keys
		if (event.which >= 37 && event.which <= 40) return;
		// format number
		$(this).val(function (index, value) {
			return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
				;
		});


	});
});

$('#customer_resources').change(function (event){
	event.preventDefault();
	var check_ctv_resources = $('#customer_resources').val();
	if (check_ctv_resources == 10){
		$('.list_ctv_hide').show();
	}
	if (check_ctv_resources != 10){
		$('.list_ctv_hide').hide();
		$('#list_ctv').val("");
	}

});

var check_ctv_resources_update = $('#customer_resources').val();
if (check_ctv_resources_update == 10){
	$('.list_ctv_hide').show();
}

$("#customer_phone_number").change(function () {
	var phone_number_source = $("#customer_phone_number").val();

	var formData = new FormData();
	formData.append('phone_number_source', phone_number_source);

	$.ajax({
		url: _url.base_url + 'lead_custom/check_phone_source',
		type: "POST",
		data: formData,
		dataType: 'json',
		processData: false,
		contentType: false,
		// beforeSend: function(){$(".theloading").show();},
		success: function (data) {
			$(".theloading").hide();
			if (data.status == 200) {
				if (typeof data.check_phone.data.source != "undefined") {
					$("#customer_resources").val(data.check_phone.data.source);
					$("#customer_resources").prop('disabled', true);
					if (data.check_phone.data.source == 10){
						$('.list_ctv_hide').show();
					}

				}
				if (typeof data.check_phone.data.source_pgd != "undefined") {
					$("#customer_resources").val(data.check_phone.data.source_pgd);
					$("#customer_resources").prop('disabled', true);
					$('.list_ctv_hide').hide();

				}
			} else {
				$("#customer_resources").val(1);
				$("#customer_resources").prop('disabled', false);
				$('.list_ctv_hide').hide();
			}
		},
		error: function (data) {
			$(".theloading").hide();
		}
	});
});
var newCustomerTab = document.getElementById('new-customer-tab');
let customerInput = document.querySelectorAll('input[name=customer]');
var oldCustomerTab = document.getElementById('old-customer-tab');
$('input[name=customer]').click(function (e) {
	e.stopPropagation();
	$('li').removeClass('active');
	$(this).parent().parent().addClass('active');
	let tabpane = $(this).parent().attr('aria-controls');
	$('#myTabContentBH').children().removeClass('active in');
	$('#' + tabpane).addClass('active in');
});
newCustomerTab.addEventListener('click', function (){
	console.log("ac")
	customerInput[0].checked = true;
})

oldCustomerTab.addEventListener('click', function (){
	console.log("ac")
	customerInput[1].checked = true;
})

let chooseExhibit = document.getElementById('chooseExhibit')
let exhibit = document.getElementById('exhibit')
chooseExhibit.addEventListener('change', function (){
	let selectedValue = chooseExhibit.options[chooseExhibit.selectedIndex].value;
	switch (selectedValue){
		case 'cccd':
			exhibit.type = 'number'
			exhibit.placeholder = 'Số CCCD'
			break;
		case 'passport':
			exhibit.type = 'text'
			exhibit.placeholder = 'Số hộ chiếu'
			break;
		case 'cmtnd':
			exhibit.type = 'text'
			exhibit.placeholder = 'Số CMT'
			break;
		default:
			break;
	}
})




var delta = 0;
$(document).on('click', '*[data-toggle="lightbox"]', function(event) {
	//$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
	event.preventDefault();
	return $(this).ekkoLightbox({
		onShow: function(elem) {
			var html = '<button type="button" class="rotate btn btn-link" ><i class="fa fa-repeat"></i></button>';
			$(elem.currentTarget).find('.modal-header').prepend(html);
			var delta = 0;
		},
		onNavigate: function(direction, itemIndex) {
			var delta = 0;
			if (window.console) {
				return console.log('Navigating '+direction+'. Current item: '+itemIndex);
			}
		}
	});
});
$('body').on('click', 'button.rotate', function() {
	delta = delta + 90;
	$('.ekko-lightbox-item img').css({
		'-webkit-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
		'-moz-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
		'transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)'
	});

});
$(".magnifyitem").magnify({
	initMaximized: true
});


//step 1
let step1 = document.getElementById('step-1');
let step2 = document.getElementById('step-2');
let step3 = document.getElementById('step-3');
let rightCol = document.getElementsByClassName('right_col');
let userStep1 = document.getElementById('user-step1');
let userStep2 = document.getElementById('user-step2');
let userStep3 = document.getElementById('user-step3');
let step = 1;
let nextBtn1 = document.getElementById('nextBtnCreate_1');
let backStep = document.getElementById('backStep');
setTimeout(function (){
	step1.style.display = 'block'
}, 50)
nextBtn1.addEventListener('click', function (){
	switch (step){
		case 1:
			step1.style.display = 'none';
			step2.style.display = 'block';
			step = 2;
			backStep.style.display = 'block';
			userStep2.className = 'selected';
			userStep1.className = 'done';
			rightCol[0].style.minHeight = 0
			step2.scrollIntoView();
			break;
		case 2:
			step2.style.display = 'none';
			step3.style.display = 'block';
			step = 3;
			nextBtn1.style.display = 'none';
			userStep3.className = '';
			userStep2.className = 'done';
			userStep3.className = 'selected';
			backStep.style.position = 'absolute';
			backStep.style.right = '96px';
			step3.scrollIntoView();
			break;
		case 3:
			break;
		default:
			break;
	}
})
backStep.addEventListener('click', function (){
	switch (step){
		case 2:
			step = 1;
			step2.style.display = 'none';
			step1.style.display = 'block';
			backStep.style.display = 'none';
			userStep1.className = 'selected';
			userStep2.className = 'done';
			rightCol[0].style.minHeight = 0;
			step1.scrollIntoView();
			break;
		case 3:
			step = 2;
			step2.style.display = 'block';
			step3.style.display = 'none';
			nextBtn1.style.display = 'block';
			userStep2.className = 'selected';
			userStep3.className = 'done';
			rightCol[0].style.minHeight = 0;
			step2.scrollIntoView();
			break;
		default:
			break;
	}

})
userStep1.addEventListener('click', function (){
	if (userStep2.classList.contains('done') || userStep2.classList.contains('selected') ||  userStep3.classList.contains('done')) {
		switch (step) {
			case 1:
				step = 1
				step1.style.display = 'block';
				step2.style.display = 'none';
				step3.style.display = 'none';
				userStep1.className = 'selected';
				userStep2.className = 'done';
				userStep3.className = 'done';

				return;
			case 2:
				step = 1
				step1.style.display = 'block';
				step2.style.display = 'none';
				userStep1.className = 'selected';
				userStep2.className = 'done';
				backStep.style.display = 'none';
				break;
			case 3:
				step = 1
				userStep1.className = 'selected';
				userStep2.className = 'done';
				userStep3.className = 'done';
				step1.style.display = 'block';
				step3.style.display = 'none';
				nextBtn1.style.display = 'block';
				break;
			default:
				break;
		}
	}
})
userStep2.addEventListener('click', function (){
	switch (step){
		case 1:
			if (userStep2.classList.contains('done') || userStep3.classList.contains('done')){
				step = 2
				step2.style.display = 'block';
				step1.style.display = 'none';
				step3.style.display = 'none';
				userStep2.className = 'selected';
				userStep1.className = 'done';

			}
			break;
		case 2:
			break;
		case 3:
			step = 2
			userStep2.className = 'selected';
			userStep3.className = 'done';
			step2.style.display = 'block';
			step3.style.display = 'none';
			nextBtn1.style.display = 'block';
			break;
		default:
			break;
	}


})
userStep3.addEventListener('click', function (){
	switch (step){
		case 1:

			if (userStep1.classList.contains('done') || userStep2.classList.contains('done')){
				step = 3
				step3.style.display = 'block';
				step2.style.display = 'none';
				step1.style.display = 'none';
				userStep3.className = 'selected';
				userStep1.className = 'done';
				userStep2.className = 'done';
				nextBtn1.style.display = 'none'
				backStep.style.display = 'block'
			}
			break;
		case 2:

			if (userStep1.classList.contains('done') && userStep3.classList.contains('done')){
				step = 3
				step3.style.display = 'block';
				step2.style.display = 'none';
				step1.style.display = 'none';
				userStep3.className = 'selected';
				userStep1.className = 'done';
				userStep2.className = 'done';
				nextBtn1.style.display = 'none'
			}
			break;
		case 3:
			break;
		default:
			break;
	}
})

//step2
let liTabClass = document.getElementsByClassName('li-tab');
let liTab1 = document.getElementById('li-tab1');
let liTab2 = document.getElementById('li-tab2');
let liTab3 = document.getElementById('li-tab3');
let liTab4 = document.getElementById('li-tab4');
let liTab5 = document.getElementById('li-tab5');
let bhKhoanVay = document.getElementById('bh-khoanvay');
let bhXeMay = document.getElementById('bh-xemay');
let bhPLT = document.getElementById('bh-plt');
let bhVIB = document.getElementById('bh-vib');
let bhKhac = document.getElementById('bh-khac');
let tabContent1 = document.getElementById('tab_content11');
let tabContent2 = document.getElementById('tab_content22');
let tabContent3 = document.getElementById('tab_content3');
let tabContent4 = document.getElementById('tab_content4');
let tabContent5 = document.getElementById('tab_content5');
let liTab = {
	1: true,
	2: false,
	3: false,
	4: false,
	5: false,
}
//change tabpane
bhKhoanVay.addEventListener('click', function (){
	for (const element in liTab){
		if (liTab1.getAttribute('data-id') == element){
			liTab[element] = !liTab[element]
			if (!liTab[element]){
				liTab1.classList.remove('active')
			}else {
				liTab1.classList.add('active')
			}
			liTab2.classList.remove('active')
			liTab3.classList.remove('active')
			liTab4.classList.remove('active')
			liTab5.classList.remove('active')

			//show tab content
			tabContent1.classList.add('active', 'in')
			//hide tab content
			tabContent2.classList.remove('active', 'in')
			tabContent3.classList.remove('active', 'in')
			tabContent4.classList.remove('active', 'in')
			tabContent5.classList.remove('active', 'in')
		}
	}
})
bhXeMay.addEventListener('click', function (){
	for (const element in liTab){
		if (liTab2.getAttribute('data-id') == element){
			liTab[element] = !liTab[element]
			if (!liTab[element]){
				liTab2.classList.remove('active')
			}else {
				liTab2.classList.add('active')
			}
			liTab1.classList.remove('active')
			liTab3.classList.remove('active')
			liTab4.classList.remove('active')
			liTab5.classList.remove('active')

			tabContent2.classList.add('active', 'in')


			tabContent1.classList.remove('active', 'in')
			tabContent3.classList.remove('active', 'in')
			tabContent4.classList.remove('active', 'in')
			tabContent5.classList.remove('active', 'in')
		}
	}
})
bhPLT.addEventListener('click', function (){
	for (const element in liTab){
		if (liTab3.getAttribute('data-id') == element){
			liTab[element] = !liTab[element]
			if (!liTab[element]){
				liTab3.classList.remove('active')
			}else {
				liTab3.classList.add('active')
			}
			liTab1.classList.remove('active')
			liTab2.classList.remove('active')
			liTab4.classList.remove('active')
			liTab5.classList.remove('active')

			tabContent3.classList.add('active', 'in')
			tabContent2.classList.remove('active', 'in')
			tabContent1.classList.remove('active', 'in')
			tabContent4.classList.remove('active', 'in')
			tabContent5.classList.remove('active', 'in')
		}
	}
})
bhVIB.addEventListener('click', function (){
	for (const element in liTab){
		if (liTab4.getAttribute('data-id') == element){
			liTab[element] = !liTab[element]
			if (!liTab[element]){
				liTab4.classList.remove('active')
			}else {
				liTab4.classList.add('active')
			}
		}
		liTab1.classList.remove('active')
		liTab2.classList.remove('active')
		liTab3.classList.remove('active')
		liTab5.classList.remove('active')

		tabContent4.classList.add('active', 'in')
		tabContent1.classList.remove('active', 'in')
		tabContent2.classList.remove('active', 'in')
		tabContent3.classList.remove('active', 'in')
		tabContent5.classList.remove('active', 'in')
	}
})
bhKhac.addEventListener('click', function (){
	for (const element in liTab){
		if (liTab5.getAttribute('data-id') == element){
			liTab[element] = !liTab[element]
			if (!liTab[element]){
				liTab5.classList.remove('active')
			}else {
				liTab5.classList.add('active')
			}
			liTab1.classList.remove('active')
			liTab2.classList.remove('active')
			liTab3.classList.remove('active')
			liTab4.classList.remove('active')

			tabContent5.classList.add('active', 'in')
			tabContent1.classList.remove('active', 'in')
			tabContent2.classList.remove('active', 'in')
			tabContent3.classList.remove('active', 'in')
			tabContent4.classList.remove('active', 'in')
		}
	}
})
//change tabpane
let theNganHang = document.getElementById('theNganHang');
let cayATM = document.getElementById('cayATM');
theNganHang.addEventListener('click', function (){
	let customerInput = document.querySelectorAll('input[name=atm]')
	customerInput[0].checked = true;

})
cayATM.addEventListener('click', function (){
	let customerInput = document.querySelectorAll('input[name=atm]')
	customerInput[1].checked = true;
})
$('input[name=atm]').click(function (e) {
	e.stopPropagation();
	$('li').removeClass('active');
	$(this).parent().parent().addClass('active');
	let tabpane = $(this).parent().attr('aria-controls');
	$('#myTabContent2').children().removeClass('active in');
	$('#' + tabpane).addClass('active in');
});
//add row table

let themThongTinTinDung = document.getElementById('themThongTinTinDung');
let themNguoiThamChieu = document.getElementById('themNguoiThamChieu');

themThongTinTinDung.addEventListener('click', function (){
	$('#table-tindung tr:last').after('<tr>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" />\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t<select class="form-control choose-relationsip">\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>- Chọn tổ chức cho vay -</option>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option one</option>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option two</option>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option three</option>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option four</option>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t</select>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t<td class="text-right">\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" />\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t<td class="text-right">\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" />\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t<td class="text-right">\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" />\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t<td class="text-right">\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" />\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t<textarea class="input-form" name="" id="" cols="5" rows="1"></textarea>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t\t<button class="btn btn-secondary" onclick="deleteRow(this)">X</button>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
		'\t\t\t\t\t\t\t\t\t\t\t</tr>');

});
themNguoiThamChieu.addEventListener('click', function (){
	if (window.matchMedia('(max-width: 767px)').matches) {
		$('#table-thamchieu tbody.mobile-table__reference').after('<tbody class="mobile-table__reference">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t<tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td class="text-nowrap">Họ và tên <span class="red">*</span></td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" placeholder="Họ và tên">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t</tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t<tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td class="text-nowrap">Mối quan hệ <span class="red">*</span></td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<select class="form-control choose-relationsip">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>- Chọn mối quan hệ -</option>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option one</option>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option two</option>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option three</option>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option four</option>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t</select>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t</tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t<tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td class="text-nowrap">Địa chỉ <span class="red">*</span></td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" placeholder="Địa chỉ">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t</tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t<tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td class="text-nowrap">SĐT <span class="red">*</span></td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" placeholder="SĐT">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t</tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t<tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td class="text-nowrap">Ghi chú</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" placeholder="Ghi chú">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t</tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t<tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td></td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td class="text-right"><a class="btn btn-primary " data-toggle="modal" data-target="#kiemTraThamChieu">Kiểm tra</a></td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t</tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t</tbody>')
	} else {
		$('#table-thamchieu tbody.desktop-table__reference tr:last').after('<tr>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" placeholder="...">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" placeholder="...">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<select class="form-control choose-relationsip">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>- Chọn mối quan hệ -</option>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option one</option>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option two</option>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option three</option>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<option>Option four</option>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t</select>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" placeholder="...">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control input-form" placeholder="...">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<textarea class="input-form" rows="1" cols="5" name="" id="" >\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t</textarea>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t<td class="text-right">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<a type="submit" class="btn btn-primary" data-toggle="modal" data-target="#kiemTraThamChieu">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class="fa fa-file-text-o mr-1" aria-hidden="true" style="margin-right: 3px"></i>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\tKiểm tra\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t</a>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t<button type="submit" class="btn btn-secondary" onclick="deleteRow(this)">\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t\tX\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t\t</button>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t\t</td>\n' +
			'\t\t\t\t\t\t\t\t\t\t\t</tr>')
	}

});
let VBI = $('#select-bh-vbi').selectize({
	maxItems: null,
	valueField: 'id',
	labelField: 'title',
	searchField: 'title',
	options: [
		{id: 1, title: 'Sốt xuất huyết cá nhân gói bạc', value: 'Sốt xuất huyết cá nhân gói bạc'},
		{id: 2, title: 'Sốt xuất huyết cá nhân gói vàng', value: 'Sốt xuất huyết cá nhân gói vàng'},
		{id: 3, title: 'Sốt xuất huyết cá nhân gói kim cương', value: 'Sốt xuất huyết cá nhân gói kim cương'}
	],
	create: false,
});
/*
$('#select-depreciation').selectize({
	maxItems: null,
	valueField: 'id',
	labelField: 'title',
	searchField: 'title',
	options: [
		{id: 1, title: '1 năm', value: '1 năm'},
		{id: 2, title: '2 năm', value: '2 năm'},
		{id: 3, title: '3 năm', value: '3 năm'}
	],
	create: false
});



let bhDaChon = {
	"Bảo hiểm xe máy": '',
	"Bảo hiểm Phúc Lộc Thọ": '',
	"Bảo Hiểm VBI": ['Sốt xuất huyết cá nhân gói bạc'],
	"CT Ưu đãi khác": '',
};

$('#myTabContentBaoHiem select').on('change', function (){
	if (bhXeMay.checked){
		bhDaChon["Bảo hiểm xe máy"] = $('select[name="bh-xemay"] option').filter(':selected').text();
	}else {
		bhDaChon["Bảo hiểm xe máy"] = '';
	}
	if (bhPLT.checked){
		bhDaChon["Bảo hiểm Phúc Lộc Thọ"] = $('select[name="bh-plt"] option').filter(':selected').text();
	}else{
		bhDaChon["Bảo hiểm Phúc Lộc Thọ"] = ''
	}
	if (bhKhac.checked){
		bhDaChon["CT Ưu đãi khác"] = $('select[name="bh-vib"] option').filter(':selected').text();
	}else{
		bhDaChon["CT Ưu đãi khác"] = ''
	}
	if (bhKhac.checked){
		bhDaChon["Bảo Hiểm VBI"] = $('select[name="bh-khac"] option').filter(':selected').text();
	}else{
		bhDaChon["Bảo Hiểm VBI"] = ''
	}

	let boxTotal = $('#box__total');
	boxTotal.html('')
	let index = 0;
	let total = 0;
	for (const property in bhDaChon) {
		let html = '';
		index++;
		html = `\t<div class="col-md-9 col-xs-9">
\t\t\t\t\t\t\t\t\t\t\t<p>
\t\t\t\t\t\t\t\t\t\t\t\t<span class="text-bold">${index}. ${property}</span>
\t\t\t\t\t\t\t\t\t\t\t\t<span> ${bhDaChon[property]}</span>
\t\t\t\t\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div class="col-md-3 col-xs-3 text-right">
\t\t\t\t\t\t\t\t\t\t\t<span class="float-right" style="font-size: 18px">0 VNĐ</span>
\t\t\t\t\t\t\t\t\t\t</div>`
		boxTotal.append(html)
		if (index == 4){
			boxTotal.append(`<div class="col-md-9 col-xs-9">
\t\t\t\t\t\t\t\t\t\t\t<p>
\t\t\t\t\t\t\t\t\t\t\t\t<span class="text-bold"></span>
\t\t\t\t\t\t\t\t\t\t\t\t<span></span>
\t\t\t\t\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div class="col-md-3 col-xs-3 text-right" style="border-bottom: 2px solid #cccccc;">
\t\t\t\t\t\t\t\t\t\t\t<span class="float-right" style="font-size: 18px"></span>
\t\t\t\t\t\t\t\t\t\t</div><div class="col-md-9">
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div class="col-md-3 col-xs-3">
\t\t\t\t\t\t\t\t\t\t\t<div style="display: inline">
\t\t\t\t\t\t\t\t\t\t\t\t<span class="span-desktop" style="font-size: 16px ">Tổng</span>
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t<div class="pull-right" style="display: inline">
\t\t\t\t\t\t\t\t\t\t\t\t<span style="font-size: 24px">${total} </span>
\t\t\t\t\t\t\t\t\t\t\t\t<span style="font-size: 16px">VNĐ</span>
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t</div>`)
		}
	}
})
*/



function deleteRow(btn) {
	let row = btn.parentNode.parentNode;
	row.parentNode.removeChild(row);
}

//back to top
$(window).scroll(function() {
	if ($(this).scrollTop()) {
		$('#toTop').fadeIn();
	} else {
		$('#toTop').fadeOut();
	}
});

$("#toTop").click(function() {
	$("html, body").animate({scrollTop: 0}, 500);
});

//collapse
var main = document.querySelector('.main_container .right_col');
var headingOne1 = document.getElementById('headingOne1');
var headingTwo1 = document.getElementById('headingTwo1');
var headingThree1 = document.getElementById('headingThree1');
var collapseOne1 = document.getElementById('collapseOne1');
var collapseTwo1 = document.getElementById('collapseTwo1');
var collapseThree1 = document.getElementById('collapseThree1');
headingOne1.addEventListener('click', function (){
	rightCol[0].style.minHeight = 0;
	collapseOne1.scrollIntoView();
});
headingTwo1.addEventListener('click', function (){
	rightCol[0].style.minHeight = 0;
	collapseTwo1.scrollIntoView();
});
headingThree1.addEventListener('click', function (){
	rightCol[0].style.minHeight = 0;
	collapseThree1.scrollIntoView();
});
//change exception
let selectNgoaiLeE1 = $('#select-ngoai-le-e1').selectize({
	maxItems: null,
	valueField: 'id',
	labelField: 'title',
	searchField: 'title',
	options: [
		{id: 1, title: 'E1.1: Ngoại lệ về tuổi vay'},
		{id: 2, title: 'E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều kiện'},
	],
	create: false
});
let selectNgoaiLeE2 = $('#select-ngoai-le-e2').selectize({
	maxItems: null,
	valueField: 'id',
	labelField: 'title',
	searchField: 'title',
	options: [
		{id: 1, title: 'E1.1: Ngoại lệ về tuổi vay'},
		{id: 2, title: 'E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều kiện'},
	],
	create: false
});
let selectNgoaiLeE3 = $('#select-ngoai-le-e3').selectize({
	maxItems: null,
	valueField: 'id',
	labelField: 'title',
	searchField: 'title',
	options: [
		{id: 1, title: 'E1.1: Ngoại lệ về tuổi vay'},
		{id: 2, title: 'E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều kiện'},
	],
	create: false
});
let selectNgoaiLeE4 = $('#select-ngoai-le-e4').selectize({
	maxItems: null,
	valueField: 'id',
	labelField: 'title',
	searchField: 'title',
	options: [
		{id: 1, title: 'E1.1: Ngoại lệ về tuổi vay'},
		{id: 2, title: 'E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều kiện'},
	],
	create: false
});
let selectNgoaiLeE5 = $('#select-ngoai-le-e5').selectize({
	maxItems: null,
	valueField: 'id',
	labelField: 'title',
	searchField: 'title',
	options: [
		{id: 1, title: 'E1.1: Ngoại lệ về tuổi vay'},
		{id: 2, title: 'E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều kiện'},
	],
	create: false
});
let selectNgoaiLeE6 = $('#select-ngoai-le-e6').selectize({
	maxItems: null,
	valueField: 'id',
	labelField: 'title',
	searchField: 'title',
	options: [
		{id: 1, title: 'E1.1: Ngoại lệ về tuổi vay'},
		{id: 2, title: 'E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều kiện'},
	],
	create: false
});
let selectNgoaiLeE7 = $('#select-ngoai-le-e7').selectize({
	maxItems: null,
	valueField: 'id',
	labelField: 'title',
	searchField: 'title',
	options: [
		{id: 1, title: 'E1.1: Ngoại lệ về tuổi vay'},
		{id: 2, title: 'E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều kiện'},
	],
	create: false
});
let selectException = document.getElementById('change_exception')
selectException.addEventListener('change', function (event){
	let element = document.querySelector(`.${event.target.value}`);
	if (element.style.display === 'none'){
		element.style.display = 'block';
	}else {
		element.style.display = 'none';
	}
});


//validate form
(function (){
	validate.extend(validate.validators.datetime, {
		// The value is guaranteed not to be null or undefined but otherwise it
		// could be anything.
		parse: function(value, options) {
			return +moment.utc(value);
		},
		// Input is a unix timestamp
		format: function(value, options) {
			var format = options.dateOnly ? "YYYY-MM-DD" : "YYYY-MM-DD hh:mm:ss";
			return moment.utc(value).format(format);
		}
	});
	var constraints = {

		customer_name: {
			presence: {
				message: "^Tên không được để trống"
			},
			// And it must be between 3 and 20 characters long
			length: {
				minimum: 3,
				maximum: 30,
				message: "^Ghi đầy đủ họ và tên"
			},

		},

		customer_identify: {
			presence: {
				message: "^Không được để trống"
			},
			// length: {
			// 	minimum: 9,
			// 	maximum: 12,
			// 	message: "^Chứng minh thư từ 9-12 số"
			// },
			// format: {
			// 	pattern: "[0-9]+",
			// 	message: "^Chứng minh thư không đúng định dạng"
			// }
		},

		customer_BOD: {
			presence: {
				message: "^Ngày sinh không được để trống"
			},
		},
		customer_email: {
			presence: {
				message: "^Email không được để trống"
			},
			email: {
				message: "^Email không đúng định dạng"
			},
		},
		customer_phone_number: {
			presence: {
				message: "^Số điện thoại không được để trống"
			},
			length: {
				is: 10,
				message: "^Số điện thoại phải 10 số"
			},
			format: {
				pattern: "[0-9]+",
				message: "^Số điện thoại không đúng định dạng"
			}
		},
		current_stay_current_address: {
			presence: {
				message: "^Không được để trống"
			},
		},
		time_life_current_address: {
			presence: {
				message: "^Không được để trống"
			},
		},
		address_household: {
			presence: {
				message: "^Không được để trống"
			},
		},

		name_company: {
			presence: {
				message: "^Tên công ty không được để trống"
			},
			// And it must be between 3 and 20 characters long
			length: {
				minimum: 3,
				maximum: 30,
				message: "^Ghi đầy đủ tên công ty"
			},

		},
		phone_number_company: {
			presence: {
				message: "^Số điện thoại không được để trống"
			},
			length: {
				is: 10,
				message: "^Số điện thoại phải 10 số"
			},
			format: {
				pattern: "[0-9]+",
				message: "^Số điện thoại không đúng định dạng"
			}
		},
		address_company: {
			presence: {
				message: "^Địa chỉ không được để trống"
			},
		},
		salary: {
			presence: {
				message: "^Số tiền không được để trống"
			},
			format: {
				pattern: "[0-9,]+",
				message: "^Số tiền không đúng định dạng"
			}
		},

		fullname_relative_1: {
			presence: {
				message: "^Tên không được để trống"
			},
			// And it must be between 3 and 20 characters long
			length: {
				minimum: 3,
				maximum: 30,
				message: "^Ghi đầy đủ họ và tên"
			},

		},
		phone_number_relative_1: {
			presence: {
				message: "^Số điện thoại không được để trống"
			},
			length: {
				is: 10,
				message: "^Số điện thoại phải 10 số"
			},
			format: {
				pattern: "[0-9]+",
				message: "^Số điện thoại không đúng định dạng"
			}
		},
		hoursehold_relative_1: {
			presence: {
				message: "^Địa chỉ cư trú không được để trống"
			},
		},
		confirm_relativeInfor1: {
			presence: {
				message: "^Ghi chú không được để trống"
			},
		},
		type_relative_1:{
			presence: {
				message: "^Mối quan hệ không được để trống"
			},
		},
		fullname_relative_2: {
			presence: {
				message: "^Tên không được để trống"
			},
			// And it must be between 3 and 20 characters long
			length: {
				minimum: 3,
				maximum: 30,
				message: "^Ghi đầy đủ họ và tên"
			},

		},
		phone_number_relative_2: {
			presence: {
				message: "^Số điện thoại không được để trống"
			},
			length: {
				is: 10,
				message: "^Số điện thoại phải 10 số"
			},
			format: {
				pattern: "[0-9]+",
				message: "^Số điện thoại không đúng định dạng"
			}
		},
		hoursehold_relative_2: {
			presence: {
				message: "^Địa chỉ cư trú không được để trống"
			},
		},
		confirm_relativeInfor2: {
			presence: {
				message: "^Ghi chú không được để trống"
			},
		},
		type_relative_2:{
			presence: {
				message: "^Mối quan hệ không được để trống"
			},
		},

		bank_branch:{
			presence: {
				message: "^Chi nhánh không được để trống"
			},
		},
		bank_account:{
			presence: {
				message: "^Stk không được để trống"
			},
			format: {
				pattern: "[0-9]+",
				message: "^Số tài khoản không đúng định dạng"
			}
		},
		atm_card_number:{
			presence: {
				message: "^Số thẻ không được để trống"
			},
			format: {
				pattern: "[0-9]+",
				message: "^Số thẻ không đúng định dạng"
			}
		},
		atm_card_holder:{
			presence: {
				message: "^Tên chủ thẻ không được để trống"
			},
		},
		money:{
			presence: {
				message: "^Số tiền vay không được để trống"
			},
			format: {
				pattern: "[0-9,]+",
				message: "^Số tiền vay không đúng định dạng"
			}
		},
		number_day_loan: {
			presence: {
				message: "^Thời gian vay không được để trống"
			},
		},
		expertise_file: {
			presence: {
				message: "^Thẩm định hồ sơ không được để trống"
			},
		},
		expertise_field: {
			presence: {
				message: "^Thẩm định thực địa không được để trống"
			},
		},
		company_debt: {
			format: {
				pattern: "[0-9,]+",
				message: "^Số tiền không đúng định dạng"
			}
		},
		company_out_of_date: {
			format: {
				pattern: "[0-9,]+",
				message: "^Số tiền không đúng định dạng"
			}
		},
		property_infor: {
			presence: {
				message: "^Thông tin tài sản không được để trống"
			},
		}






	};
	var form = document.querySelector("form#main_1");
	form.addEventListener("submit", function(event) {
		event.preventDefault();
		handleFormSubmit(form);
	});
// Hook up the inputs to validate on the fly
	var inputs = document.querySelectorAll("input, textarea, select")
	for (var i = 0; i < inputs.length; ++i) {
		inputs.item(i).addEventListener("change", function(ev) {
			var errors = validate(form, constraints) || {};
			showErrorsForInput(this, errors[this.name])
		});
	}
	function handleFormSubmit(form, input) {
		// validate the form against the constraints
		var errors = validate(form, constraints);
		// then we update the form to reflect the results
		showErrors(form, errors || {});
		if (!errors) {
			showSuccess();
		}
	}

// Shows the errors for a specific input
	function showErrorsForInput(input, errors) {
		// This is the root of the input
		var formGroup = closestParent(input.parentNode, "error_messages")
			// Find where the error messages will be insert into
			, messages = formGroup.querySelector(".messages");
		// First we remove any old messages and resets the classes
		resetFormGroup(formGroup);
		// If we have errors
		if (errors) {
			// we first mark the group has having errors
			formGroup.classList.add("has-error");
			// then we append all the errors
			_.each(errors, function(error) {
				addError(messages, error);
			});
		} else {
			// otherwise we simply mark it as success
			formGroup.classList.add("has-success");
		}
	}
// Recusively finds the closest parent that has the specified class
	function closestParent(child, className) {
		if (!child || child == document) {
			return null;
		}
		if (child.classList.contains(className)) {
			return child;
		} else {
			return closestParent(child.parentNode, className);
		}
	}

	function resetFormGroup(formGroup) {
		// Remove the success and error classes
		formGroup.classList.remove("has-error");
		formGroup.classList.remove("has-success");
		// and remove any old messages
		_.each(formGroup.querySelectorAll(".help-block.error"), function(el) {
			el.parentNode.removeChild(el);
		});
	}

// Adds the specified error with the following markup
	function addError(messages, error) {
		var block = document.createElement("p");
		block.classList.add("help-block");
		block.classList.add("error");
		block.innerText = error;
		messages.appendChild(block);
	}
// Updates the inputs with the validation errors
	function showErrors(form, errors) {
		// We loop through all the inputs and show the errors for that input
		_.each(form.querySelectorAll("input[name], select[name]"), function(input) {
			// Since the errors can be null if no errors were found we need to handle
			// that
			showErrorsForInput(input, errors && errors[input.name]);
		});
	}
// These are the constraints used to validate the form

	function showSuccess() {
		// We made it \:D/
		alert("Success!");
	}
}())


