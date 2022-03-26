<?php

require_once 'config.php';
function sendMessage($sender, $message)
{
    $replyMessage = rawurlencode($message);
    $url = URL_WHATSAPP."/sendtext/to/{$sender}/message/{$replyMessage}";

    $header = [
        'X-Requested-With: XMLHttpRequest',
        'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_REFERER, $refer);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $datas = curl_exec($ch);
    $error = curl_error($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $status;
}

function saveInbox($database, $sender, $message)
{
    list($senderNumber, $sufix) = explode('@', $sender);
    $database->insert('inbox', [
        'SenderNumber' => $senderNumber,
        'TextDecoded' => $message,
    ]);
}

function readOutbox($database, $limit = 20)
{
    return $database->select('outbox', ['ID', 'DestinationNumber', 'TextDecoded'], [
        'LIMIT' => $limit,
        'ORDER' => ['ID' => 'ASC'],
    ]);
}

function saveSentItem($database, $data)
{
    //$database->beginDebug();
    $database->delete('outbox', ['ID' => $data['ID']]);
    $database->insert('sentitems', [
        'DestinationNumber' => $data['DestinationNumber'],
        'TextDecoded' => $data['TextDecoded'],
        'Text' => '-',
        'UDH' => '212',
        'SenderID' => 'easyWA',
        'CreatorID' => 'easyWA',
        'ID' => $data['ID'],
    ]);
    //print_r($database->debugLog());
}
