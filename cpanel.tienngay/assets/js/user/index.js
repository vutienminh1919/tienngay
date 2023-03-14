
$("body").on('click', '.toggle-password', function() {
	$(this).toggleClass("fa-eye fa-eye-slash");
	let input = $(".input-password");
	if (input.attr("type") === "password") {
		input.attr("type", "text");
	} else {
		input.attr("type", "password");
	}
});
$('#tags_1').tagsInput({'width':'400px','defaultText':''});
$('#tags_2').tagsInput({'width':'400px','defaultText':''});
$('#tags_3').tagsInput({'width':'400px','defaultText':''});
let msg = [];
$.ajax({
	url: _url.getMsg,
	method: "GET",
	dataType: 'json',
	success: function(data) {
		msg = data;
	},
	error: function(error) {
		console.log(error);
	}
});
$(".btn-create-user").on("click", function() {
	let password = $(".input-password").val();
	let email = $(".email_create").val();
	let username = $(".username_create").val();
	let phone = $(".phone_create").val();
	let identify = $(".indentify_create").val();
	let full_name = $(".full_name_create").val();
	let group_role = $("#role_user").val();
	if (email.trim() == '') {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U1']);
		return;
	}
	if (!validateEmail(email.trim())) {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U2']);
		return;
	}
	if (username.trim() == '') {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U9']);
		return;
	}
	if (full_name.trim() == '') {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U3']);
		return;
	}
	if (phone.trim() == '' ) {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U4']);
		return;
	}
	if (phone.trim().length !== 10 ) {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U5']);
		return;
	}
	if (password.trim() == '' ) {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U6']);
		return;
	}
	if (password.trim().length < 6) {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U7']);
		return;
	}
	if (identify.trim() == '' ) {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U8']);
		return;
	}

	//Call ajax
	$.ajax({
		url: _url.process_create_user,
		method: "POST",
		data: {
			password : password,
			email : email,
			username : username,
			phone : phone,
			full_name : full_name,
			identify : identify,
			group_role : group_role,
		},
		beforeSend: function() {
			$(".theloading").show();
		},
		success: function(data) {
			setTimeout(function(){
				$(".theloading").hide();
			}, 10);
			if(data.data.status != 200) {
				$('#errorModal').modal('show');
				$("#errorModal .msg_error").html(data.data.message);
			} else {
				$('#successModal').modal('show');
				setTimeout(function(){
					window.location.href = _url.user_list;
				}, 1000);
			}
		},
		error: function(error) {
			console.log(error);
			$(".theloading").hide();
		}
	});
});
$(".btn-update-user").on("click", function() {
	let id = $(".id_user_update").val();
	let email = $(".email").val();
	let username = $(".username").val();
	let phone = $(".phone_update").val();
	let identify = $(".indentify_update").val();
	let full_name = $(".full_name_update").val();
	let status = $('select[name=status_update]').val();

	if (full_name.trim() == '') {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U3']);
		return;
	}
	if (phone.trim() == '' ) {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U4']);
		return;
	}
	if (phone.trim().length !== 10 ) {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U5']);
		return;
	}
	if (identify.trim() == '' ) {
		$('#errorModal').modal('show');
		$("#errorModal .msg_error").html(msg['U8']);
		return;
	}
	

	//Call ajax
	$.ajax({
		url: _url.process_update_user,
		method: "POST",
		data: {
			id : id,
			email : email,
			username : username,
			phone : phone,
			full_name : full_name,
			identify : identify,
			status : status
			
		},
		beforeSend: function() {
			$(".theloading").show();
		},
		success: function(data) {
			setTimeout(function(){
				$(".theloading").hide();
			}, 10);
			if(data.data.status != 200) {
				$('#errorModal').modal('show');
				$("#errorModal .msg_error").html(data.data.message);
			} else {
				$('#successModal').modal('show');
				setTimeout(function(){
					window.location.href = _url.user_list;
				}, 1000);
			}
		},
		error: function(error) {
			console.log(error);
			$(".theloading").hide();
		}
	});
});
function validateEmail(email) {
	let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}

$("#forgot_password_form").submit(function(event) {
	event.preventDefault();
	let $form = $(this);
	let url = $form.attr( "action" );
	let email = $("#email").val();
	let formData = {
		email: email
	};
	$.ajax({
		url : url,
		type: "POST",
		data : formData,
		dataType : 'json',
		beforeSend: function(){$("#loading").show();},
		success: function(data) {
			setTimeout(function(){
				$("#loading").hide();
			}, 1000);
			if (data.status === 200) {
				$('#successModal').modal('show');
			} else {
				$('#errorModal').modal('show');
				$("#errorModal .msg_error").html(data.message);
			}
		},
		error: function(data) {
			$("#loading").hide();
		}
	});

});
$("#new_password").submit(function(event) {
	event.preventDefault();
	var $form = $(this);
	var url = $form.attr( "action" );
	var password = $("#password").val();
	var password_confirm = $("#re_password").val();
	var formData = {
		password: password,
		password_confirm: password_confirm,
	};
	$.ajax({
		url : url,
		type: "POST",
		data : formData,
		dataType : 'json',
		beforeSend: function(){
			$("#loading").show();},
		success: function(data) {
			setTimeout(function(){
				$("#loading").hide();
			}, 1000);
			if (data.status === 200) {
				$('#successModal').modal('show');
			} else {
				$('#errorModal').modal('show');
				$("#errorModal .msg_error").html(data.message);
			}
		},
		error: function(data) {
			console.log(data);
			$("#loading").hide();
		}
	});

});
