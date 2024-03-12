// Initialize Firebase
        // TODO: Replace with your project's customized code snippet
         var config = {
    apiKey: "AIzaSyC-E-uLCJr8nSMS2APbuWKm-sibU49feWE",
    authDomain: "mobipush-v1.firebaseapp.com",
    projectId: "mobipush-v1",
    storageBucket: "mobipush-v1.appspot.com",
    messagingSenderId: "314380072015",
    appId: "1:314380072015:web:4e9277688254167f7d663a",
    measurementId: "G-GERFNH2ZH0"
  };

        firebase.initializeApp(config);
        const messaging = firebase.messaging();
        navigator.serviceWorker.register('./assets/mobipush/pushworker.js')
.then((registration) => {
  messaging.useServiceWorker(registration);
        messaging
            .requestPermission()
            .then(function () {
                console.log("Notification permission granted.");
                // get the token in the form of promise
                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);
                if(localStorage.getItem("pushtoken") !== token){
              $.ajax({url: "./assets/mobipush/subscribe.php?device_token=" + token, success: function(result){
                  localStorage.setItem("pushtoken", token);
               console.log(result);
               }});  
                }
            })
            .catch(function (err) {
                console.log("Unable to get permission to notify.", err);
            });

        messaging.onMessage(function(payload) {
            console.log("Message received. ", payload);
            //foreground notifications
            const {title, ...options} = payload.notification;
            navigator.serviceWorker.ready.then(registration => {
                registration.showNotification(title, options);
            });
        });
});
