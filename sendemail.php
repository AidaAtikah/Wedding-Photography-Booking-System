<?php 
# Include the Autoloader (see "Libraries" for install instructions)
require 'C:\xampp\htdocs\Swakarya\admin\vendor\autoload.php';
use Mailgun\Mailgun;

//SEND EMAIL WITH TEMPLATE
function sendEmail($to, $subject, $text, $content){
  $mg = Mailgun::create('key-c77f75f3fc9f6d78572b5ed8c2715519'); // For US servers

$html  = file_get_contents($content);

$mg->messages()->send('mail.mysims.me', [
  'from'    => 'Swakarya@email.com',
  'to'      => $to,
  'subject' => $subject,
  'text'    => $text,
  'html'    => $html
]); 

}

//sendEmail2("wanaidazailani@gmail.com", 'Test', 'Test', 'Test');
//SEND EMAIL WITHOUT TEMPLATE
function sendEmail2($to, $subject, $text, $content){
  $mg = Mailgun::create('key-c77f75f3fc9f6d78572b5ed8c2715519'); // For US servers
  $mg->messages()->send('mail.mysims.me', [
    'from'    => 'Swakarya@email.com',
    'to'      => $to,
    'subject' => $subject,
    'text'    => $text,
    'html'    => $content
  ]); 
  
}


?>