<?php
require_once( '../../../wp-load.php' );

$comment_post_ID = 228;

$comments = $wpdb->get_results( "SELECT * FROM wp_comments WHERE comment_post_ID = '228' AND comment_id > 101;");

$count = 0;
foreach ($comments as $c) {
    $headers = "From: {$c->comment_author} <{$c->comment_author_email}>\r\n";
    $headers .= "Bcc: mariuscraciunoiu@gmail.com, paul.craciunoiu@gmail.com\r\n";
    $data = "You received a message from {$c->comment_author} ({$c->comment_author_email}) on {$c->comment_date}:

{$c->comment_content}
";
    wp_mail('Lorri Capizzi <marius@craciunoiu.net>', 'SJ Gear Up Contact Form Message'
            , $data, $headers);
    sleep(10);
    $count++;
}

echo "Sent $count emails...\n";
