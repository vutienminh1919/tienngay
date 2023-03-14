 
function property() {
	var taisan = $('#taisan :selected').val();
	if(taisan == "xemay"){
		$('.xemay').show();
		$('.dienthoai').hide();
		$('.laptop').hide();
	}
	if(taisan == "oto"){
		$('.xemay').show();
		$('.dienthoai').hide();
		$('.laptop').hide();
	}
	if(taisan == "dienthoai"){
		$('.dienthoai').show();
		$('.xemay').hide();
		$('.laptop').hide();
	}
	if(taisan == "laptop"){
		$('.dienthoai').hide();
		$('.xemay').hide();
		$('.laptop').show();
	}
	if(taisan == "vang"){
		$('.dienthoai').hide();
		$('.xemay').hide();
		$('.laptop').hide();
	}

	console.log(taisan);
}
