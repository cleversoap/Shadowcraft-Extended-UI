<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://www.wowhead.com/item=" . $_GET['item'] . "&xml"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$xml = simplexml_load_string(curl_exec($ch));

$json = '{"icon":"' . $xml->item->icon . '",' . trim($xml->item->json) . ',' . trim($xml->item->jsonEquip) . '}';

$json = json_decode($json);


// Clean AND redundant...
echo json_encode($json);

?>