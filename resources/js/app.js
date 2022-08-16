import {default as axios} from "axios";

require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// let Turbolinks = require("turbolinks")

// Turbolinks.start();
let visaBtn = document.querySelector('.paymentmethod.visa');
if (typeof(visaBtn) != 'undefined' && visaBtn != null) {
    visaBtn.addEventListener('click', function (e) {
        e.preventDefault();
        let sendRequest = new XMLHttpRequest();
        sendRequest.onreadystatechange = function () {
          if (this.readyState === 4 && this.status === 200) {
              let totalAmount = JSON.parse(this.responseText).amount;

              const axios = require("axios").default;
              const options = {
                  method: 'POST',
                  url: 'https://restpilot.paylink.sa/api/auth',
                  headers: {Accept: '*/*', 'Content-Type': 'application/json'},
                  data: {
                      apiId: 'APP_ID_1123453311',
                      persistToken: false,
                      secretKey: '0662abb5-13c7-38ab-cd12-236e58f43766'
                  }
              };
              axios.request(options).then(function (response) {
                  let userData = JSON.parse(visaBtn.dataset.info);
                  let order = new Order({
                      callBackUrl: location.origin + '/paylink/redirect', // callback page URL (for example http://localhost:6655 processPayment.php) in your site to be called after payment is processed. (mandatory)
                      clientName: userData.name, // the name of the buyer. (mandatory)
                      clientMobile: userData.whatsapp_phone, // the mobile of the buyer. (mandatory)
                      amount: totalAmount, // the total amount of the order (including VAT or discount). (mandatory). NOTE: This amount is used regardless of total amount of products listed below.
                      orderNumber: generateSerial()+'-'+generateSerial()+'-'+generateSerial(), // the order number in your system. (mandatory)
                      clientEmail: userData.email, // the email of the buyer (optional)
                      products: [],
                  });
                  let payment = new PaylinkPayments({mode: 'test', defaultLang: 'ar', backgroundColor: '#EEE'});
                  payment.openPayment(response.data.id_token, order, function () {

                  });

              }).catch(function (error) {
                  console.error(error);
              });
          }
        };
        sendRequest.open('GET', location.origin + '/paylink/get-amount', true);
        sendRequest.send();
    });
}
let passwordInputValidation = document.querySelector('.passwordInputValidation');
if (typeof(passwordInputValidation) != 'undefined' && passwordInputValidation != null) {
    document.querySelector('#password').addEventListener('keypress', function (event) {
        var englishAlphabetAndWhiteSpace = /[A-Za-z ]/g;
        var key = String.fromCharCode(event.which);
        if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || englishAlphabetAndWhiteSpace.test(key)) {
            console.log(true);
        } else {
            event.preventDefault();
        }
    });
}

function generateSerial() {
    'use strict';
    var chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',
        serialLength = 5,
        randomSerial = "",
        i,
        randomNumber;
    for (i = 0; i < serialLength; i = i + 1) {
        randomNumber = Math.floor(Math.random() * chars.length);
        randomSerial += chars.substring(randomNumber, randomNumber + 1);
    }
    return randomSerial;

}
let scrollToTop = document.querySelector('.scrollToTop');
if (typeof(scrollToTop) != 'undefined' && scrollToTop != null) {
    window.onscroll = function () {
        if (this.scrollY >= 500) {
            scrollToTop.classList.add('show');
            scrollToTop.classList.remove('hidden');
        } else {
            scrollToTop.classList.remove('show');
            scrollToTop.classList.add('hidden');
        }
    }
    scrollToTop.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({
            top:0,
            behavior:'smooth'
        })
    });
}
let peacock_header = document.querySelector('.peacock-header');
if (typeof(peacock_header) != 'undefined' && peacock_header != null) {
    window.onresize = function () {
        changeHeaderImage();
    }
    function changeHeaderImage() {
        if (typeof(peacock_header) != 'undefined' && peacock_header != null) {
            if (window.innerWidth < 664) {
                peacock_header.src = window.location.origin + '/images/peacock0.jpg';
            } else {
                peacock_header.src = window.location.origin + '/images/peacock.jpg';
            }
        }
    }
    window.addEventListener('load', function () {
        changeHeaderImage();
    }, false);
}







window.addEventListener("load", () => {
    hasNetwork(navigator.onLine);

    window.addEventListener("online", () => {
        // Set hasNetwork to online when they change to online.
        hasNetwork(true);
    });

    window.addEventListener("offline", () => {
        // Set hasNetwork to offline when they change to offline.
        hasNetwork(false);
    });
});
function hasNetwork(online) {
    const element = document.querySelector(".networkStatus");
    // Update the DOM to reflect the current status
    if (online) {
        element.classList.remove("offline");
        element.classList.add("online");
    } else {
        element.classList.remove("online");
        element.classList.add("offline");
    }
}




let visaBtn2 = document.querySelector('.paymentmethod.visapay');
if (typeof(visaBtn2) != 'undefined' && visaBtn2 != null) {
    visaBtn2.addEventListener('click', function (e) {
        e.preventDefault();
        let sendRequest = new XMLHttpRequest();
        sendRequest.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let totalAmount = JSON.parse(this.responseText).amount;

                const axios = require("axios").default;
                const options = {
                    method: 'POST',
                    url: 'https://restpilot.paylink.sa/api/auth',
                    headers: {Accept: '*/*', 'Content-Type': 'application/json'},
                    data: {
                        apiId: 'APP_ID_1123453311',
                        persistToken: false,
                        secretKey: '0662abb5-13c7-38ab-cd12-236e58f43766'
                    }
                };
                axios.request(options).then(function (response) {
                    let userData = JSON.parse(visaBtn2.dataset.info);
                    let order = new Order({
                        callBackUrl: location.origin + '/paylink/redirect-tow', // callback page URL (for example http://localhost:6655 processPayment.php) in your site to be called after payment is processed. (mandatory)
                        clientName: userData.name, // the name of the buyer. (mandatory)
                        clientMobile: userData.whatsapp_phone, // the mobile of the buyer. (mandatory)
                        amount: totalAmount, // the total amount of the order (including VAT or discount). (mandatory). NOTE: This amount is used regardless of total amount of products listed below.
                        orderNumber: generateSerial()+'-'+generateSerial()+'-'+generateSerial(), // the order number in your system. (mandatory)
                        clientEmail: userData.email, // the email of the buyer (optional)
                        products: [],
                    });
                    let payment = new PaylinkPayments({mode: 'test', defaultLang: 'ar', backgroundColor: '#EEE'});
                    payment.openPayment(response.data.id_token, order, function () {

                    });

                }).catch(function (error) {
                    console.error(error);
                });
            }
        };
        sendRequest.open('GET', location.origin + '/paylink/get-amount-tow', true);
        sendRequest.send();
    });
}


let passwordInputs = document.querySelectorAll("input[type='password']");
if (typeof(passwordInputs) != 'undefined' && passwordInputs != null) {
    document.addEventListener('keyup', function (e) {
        let isArabic = /[\u0600-\u06FF\u0750-\u077F]/;
        if (isArabic.test(e.target.value)){
            e.target.value = '';
            e.preventDefault();
        }
    });
}
