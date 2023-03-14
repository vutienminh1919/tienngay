// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional

var firebaseConfig = {
	apiKey: "AIzaSyArBV4HCs5tHQGsk_SvYkwH0WTmSepz7s0",
	authDomain: "vfc-cpanel.firebaseapp.com",
	projectId: "vfc-cpanel",
	storageBucket: "vfc-cpanel.appspot.com",
	messagingSenderId: "889822303635",
	appId: "1:889822303635:web:1def8b4ac72135fdeec466",
	measurementId: "G-YM7F1KYZ3V"
};
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.requestPermission()
	.then(function () {
		console.log('Notification permission granted.');
		getRegToken();
	})
	.catch(function (err) {
		console.log('Unable to get permission to notify.', err);
	});

function getRegToken() {
	messaging.getToken()
		.then(function (currentToken) {
			if (currentToken) {
				console.log(currentToken);
				saveToken(currentToken);
			} else {
				console.log('No Instance ID token available. Request permission to generate one.');
			}
		})
		.catch(function (err) {
			console.log('An error occurred while retrieving token. ', err);
		});
}

function saveToken(currentToken) {
	var formData = {
		token: currentToken
	};
	$.ajax({
		url: _url.base_url + 'app/index',
		method: "POST",
		dataType: 'json',
		data: formData,
	})
}

messaging.onMessage(function(payload) {
	console.log('onMessage',payload);
		const notificationTitle = payload.data.title;
		const notificationOptions = {
			body: payload.data.body,
			icon: payload.data.icon,
			data: payload.data.click_action
		};
	if (!("Notification" in window)) {
		console.log("This browser does not support system notifications");
	}
	// Let's check whether notification permissions have already been granted
	else if (Notification.permission === "granted") {
		// If it's okay let's create a notification
		var notification = new Notification(notificationTitle,notificationOptions);
		notification.onclick = function(event) {
			event.preventDefault(); // prevent the browser from focusing the Notification's tab
			window.open(payload.data.click_action , '_blank');
			notification.close();
		}
	}
});


