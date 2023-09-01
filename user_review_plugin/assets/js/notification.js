jQuery(document).ready(function($) {
    var messageDiv = $('.notification-content'); 
    var msg = document.getElementById('message'); 

    msg.textContent = objNot.message; 
    messageDiv.css('display', 'block');
});