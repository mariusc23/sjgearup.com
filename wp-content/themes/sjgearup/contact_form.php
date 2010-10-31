<?php
define('FROM_CONTACT', 'Titu Andreescu <tandreescu@gmail.com>');
/* Contact form handling here */
if ($_POST['contact'] || $_POST['contact_email']) {
    require_once( '../../../wp-load.php' );
    $contact_invalid = array();
    $contact_data = array();
    $contact_data['name'] = filter_var($_POST['contact_name'], FILTER_SANITIZE_STRING);
    $contact_data['message'] = filter_var($_POST['contact_message'], FILTER_SANITIZE_STRING);
    $contact_data['email'] = filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL);
    foreach ($contact_data as $contact_key => $contact_field) {
        if (!$contact_field) {
            $contact_invalid[$contact_key] = true;
        }
    }

    if (!$contact_invalid && !$_COOKIE['awesomemath_contact']) {
        $comment_post_ID = 228;
        $comment_author = $contact_data['name'];
        $comment_author_email = $contact_data['email'];
        $comment_author_url = '';
        $comment_content = $contact_data['message'];
        $comment_type = '';
        $comment_parent = 0;
        $user_ID = 0;

        $commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
        $comment_id = wp_new_comment( $commentdata );
        $comment_approved = $wpdb->get_results( "SELECT (comment_approved = 'spam') AS spam FROM wp_comments WHERE comment_ID = '{$comment_id} LIMIT 1;'");
        setcookie('awesomemath_contact', 1, time() + 300, '/');
        if ($comment_id && !$comment_approved[0]->spam) {
            $success = true;
            // not spam!
            $contact_headers = "From: {$contact_data['name']} <{$contact_data['email']}>\r\nBCC: mariuscraciunoiu@gmail.com,paulcraciunoiu@gmail.com\r\n"
                . "Content-Type: text/html; charset=iso-8859-1\r\n";
            if (!wp_mail(FROM_CONTACT, 'AwesomeMath Contact Form Message'
                , '<pre style="font-family: Helvetica, Arial, sans-serif">' . $contact_data['message'] . '</pre>', $contact_headers)) {
                $success = false;
            }
            $contact_headers = "From: " . FROM_CONTACT . "\r\n" . 'Reply-To: ' . FROM_CONTACT . "\r\nContent-Type: text/html; charset=iso-8859-1\r\n";
            if (!wp_mail("{$contact_data['name']} <{$contact_data['email']}>", 'Thank you for contacting AwesomeMath'
                , '<p>Thank you for contacting AwesomeMath. We will get back to you shortly.</p>

<p>Below is a copy of your message.
If for any reason we do not get back to you soon, simply reply to this email.</p>

<p>------------------------------</p>

<pre>' . $contact_data['message'] . '</pre>', $contact_headers)) {
                $success = false;
            }

            if (!$success) {
                $myFile = "fail-mail.txt";
                $fh = fopen($myFile, 'a') or die("can't open file");
                $time_c = date('Y-m-d H:i:s');
                fwrite($fh, "You received a message from {$contact_data['name']} ({$contact_data['email']}) on {$time_c}\n");
                fclose($fh);
            }
            // redirect to prevent resubmission
            header("Location: {$_SERVER['HTTP_REFERER']}?contacted");
            die;
        } else {
            wp_mail('mariuscraiunoiu@gmail.com', 'AwesomeMath Contact Form Message'
                , $contact_data['message'], "From: {$contact_data['name']} <{$contact_data['email']}>\r\nBCC: paulcraciunoiu@gmail.com\r\n");
        }
    }
}
