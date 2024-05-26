window.onload = function() {
    render();
};

function render() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
    recaptchaVerifier.render();
}



function phoneAuth() {
    
    let number = document.getElementById('mobile').value;
    var phoneNumber = "+91" + number;
    firebase.auth().signInWithPhoneNumber(phoneNumber, window.recaptchaVerifier).then(function(confirmationResult) {
        window.confirmationResult = confirmationResult;
        coderesult = confirmationResult;
        console.log(coderesult);
        alert("Message sent");
    }).catch(function(error) {
        alert(error.message);
    });
}

// function phoneAuth() {
//     // Retrieve the phone number in international format (including the country code)
//     const phoneNumber = phoneInput.getNumber();
//     // Log the phone number to the console
//     console.log('Phone number:', phoneNumber);

//     // Use the phone number in Firebase authentication
//     firebase.auth().signInWithPhoneNumber(phoneNumber, window.recaptchaVerifier)
//         .then(function(confirmationResult) {
//             window.confirmationResult = confirmationResult;
//             coderesult = confirmationResult;
//            console.log(coderesult);
//             console.log('Confirmation result:', confirmationResult);
//             alert('Message sent');
//         })
//         .catch(function(error) {
//             alert('Error:', error.message);
//         });
// }

