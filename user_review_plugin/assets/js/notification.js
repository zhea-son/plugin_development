jQuery(document).ready(function($) {
    var messageDiv = $('.notification-content'); 

    var msg = document.getElementById('message'); 

    msg.textContent = objNot.message; 
    messageDiv.css('display', 'block');

    
    $('.close-content').on('click', function(e){
        messageDiv.css('display', 'none');
    });

});
