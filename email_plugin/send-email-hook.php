<?php 

function send_mail_hook($id, $email){
    if($id != null){
        $single_post = get_post($id);
        $to = "zheasokhanal43@gmail.com"; 
        $subject = $single_post->post_title;
        $message = $single_post->post_content;
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $sent = wp_mail($to, $subject, $message, $headers);
        // echo $sent;
        if ($sent) {
            echo 'Email sent successfully.';
        } else {
            echo 'Email sending failed.';
        }
    }
}
add_action('custom_email_send_action', 'send_mail_hook',10,2);



?>