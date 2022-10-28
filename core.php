<?php
// exit("babak");
// get json per action and decoding it...
$content = file_get_contents("php://input");
$update = json_decode($content);
// external functions and codes...
require_once './requirements.php';

// text messages codes...
if (isset($update->message)) {
    require_once './Templates/Message.php';
    
} else if (isset($update->callback_query)) {
    require_once './Templates/Callbackquery.php';
}