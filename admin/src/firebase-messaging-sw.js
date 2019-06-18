// Import and configure the Firebase SDK
// These scripts are made available when the app is served or deployed on Firebase Hosting
// If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup
    importScripts('https://www.gstatic.com/firebasejs/5.9.3/firebase-app.js');
    importScripts('https://www.gstatic.com/firebasejs/5.9.3/firebase-messaging.js');

    var firebaseConfig = {
        apiKey: "AIzaSyAF5WYA5A7YjdbkT_ylK0ksc_DPrXgrBwY",
        authDomain: "crud-ios-75d97.firebaseapp.com",
        databaseURL: "https://crud-ios-75d97.firebaseio.com",
        projectId: "crud-ios-75d97",
        storageBucket: "crud-ios-75d97.appspot.com",
        messagingSenderId: "373076070879",
        appId: "1:373076070879:web:9c77f8052310798a"
      };
    firebase.initializeApp(firebaseConfig);

var messaging = firebase.messaging();

/**
 * Here is is the code snippet to initialize Firebase Messaging in the Service
 * Worker when your app is not hosted on Firebase Hosting.

 // [START initialize_firebase_in_sw]
 // Give the service worker access to Firebase Messaging.
 // Note that you can only use Firebase Messaging here, other Firebase libraries
 // are not available in the service worker.
 importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-app.js');
 importScripts('https://www.gstatic.com/firebasejs/4.8.1/firebase-messaging.js');

 // Initialize the Firebase app in the service worker by passing in the
 // messagingSenderId.
 firebase.initializeApp({
   'messagingSenderId': 'YOUR-SENDER-ID'
 });

 // Retrieve an instance of Firebase Messaging so that it can handle background
 // messages.
 const messaging = firebase.messaging();
 // [END initialize_firebase_in_sw]
 **/


// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// [START background_handler]
messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  var notificationTitle = 'Background Message Title';
  var notificationOptions = {
    body: 'Background Message body.',
    icon: '/firebase-logo.png'
  };

  return self.registration.showNotification(notificationTitle,
    notificationOptions);
});
// [END background_handler]