function updateLanguage(id, language) {
	let id_lang = 'VN';
	if (language === 'english') {
		id_lang = 'EN';
	}
	if (language === 'vietnamese') {
		id_lang = 'VN';
	}
	if (id === id_lang) {
		return false;
	}

	let formData = {
		language: id,
	};
	$.ajax({
		url: _url.process_change_language,
		method: "POST",
		data : formData,
		dataType : 'json',
		beforeSend: function() {
			$(".theloading").show();
		},
		success: function(data) {
			console.log('data', data);
			setTimeout(function(){
				$(".theloading").hide();
			}, 10);
			if (data['status'] == 200) {
				location.reload();
			} else {
				$('#errorModal').modal('show');
				$('.msg_error').text(data.message);
			}
		},
		error: function(data) {
			$(".theloading").hide();
			$('#errorModal').modal('show');
			$('.msg_error').text(data.message);
		}
	});
}
  function showModalRecoding(id) {

        $.ajax({
            url: 'https://clientapi.phonenet.io/call/'+id+'/recording',
            type: "GET",
             headers: {
        "token": _url.token_phonenet
    },
            dateType: "JSON",
            success: function (result) {
                console.log(result.url);
                 var audio = $("#player");      
                    $("#audio").attr("src", result.url);
                    /****************/
                    audio[0].pause();
                    audio[0].load();//suspends and restores all audio element

                    //audio[0].play(); changed based on Sprachprofi's comment below
                    setTimeout(function () {   
                    audio[0].oncanplaythrough = audio[0].play();
                    }, 150);
    /****************/
               $('#listentoRecord').modal('show');
                  }
        });
    }