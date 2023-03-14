importScripts('https://www.gstatic.com/firebasejs/8.6.8/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.6.8/firebase-messaging.js');


/*Update this config*/
var config = {
    apiKey: "AIzaSyArBV4HCs5tHQGsk_SvYkwH0WTmSepz7s0",
    authDomain: "vfc-cpanel.firebaseapp.com",
    projectId: "vfc-cpanel",
    storageBucket: "vfc-cpanel.appspot.com",
    messagingSenderId: "889822303635",
    appId: "1:889822303635:web:1def8b4ac72135fdeec466",
    measurementId: "G-YM7F1KYZ3V"
};
firebase.initializeApp(config);

const messaging = firebase.messaging();
self.addEventListener('notificationclick', function(event) {
    console.log('[firebase-messaging-sw.js] Received notificationclick event ', event);

    var click_action = event.notification.data;
    event.notification.close();
// This looks to see if the current is already open and
// focuses if it is
    event.waitUntil(clients.matchAll({
        type: "window"
    }).then(function(clientList) {
        for (var i = 0; i < clientList.length; i++) {
            var client = clientList[i];
            if (client.url == click_action  && 'focus' in client)
                return client.focus();
        }
        if (clients.openWindow)
            return clients.openWindow(click_action);
    }));

});

// received notification from Background
messaging.setBackgroundMessageHandler(function(payload) {
    self.registration.hideNotification();
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = payload.data.title;
    const notificationOptions = {
        body: payload.data.body,
        icon: payload.data.icon,
        click_action: payload.data.click_action,
        data: payload.data.click_action,
    };
    self.registration.hideNotification();
    return self.registration.showNotification(notificationTitle,
        notificationOptions);
    self.registration.hideNotification();
});

// received notification from Foreground if ssl is https instead http
messaging.onBackgroundMessage(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = payload.data.title;
    const notificationOptions = {
        body: payload.data.body,
        icon: payload.data.icon,
        click_action: payload.data.click_action,
        data: payload.data.click_action,
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});


