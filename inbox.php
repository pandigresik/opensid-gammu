<?php
require_once 'connection.php';
require_once 'helper.php';

$data = $_POST;
$sender = $data['sender'];
$message = $data['message'];
$file = fopen('logs.txt', 'a+');
fwrite($file, json_encode($data).PHP_EOL);
fclose($file);
saveInbox($database, $sender, $message);
$message = implode(PHP_EOL,['pesan',$message,'telah masuk ke sistem']);
sendMessage($sender, $message);


