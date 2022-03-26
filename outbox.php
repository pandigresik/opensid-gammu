<?php
require_once 'connection.php';
require_once 'helper.php';

$outbox = readOutbox($database, LIMIT_OUTBOX);
if(!empty($outbox)){    
    foreach($outbox as $o){
        $sender = $o['DestinationNumber'].'@s.whatsapp.net';
        $message = $o['TextDecoded'];        
        $result = sendMessage($sender, $message);        
        if($result == 200){
            saveSentItem($database, $o);
        }    
    }
}




