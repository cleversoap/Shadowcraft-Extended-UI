<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://www.wowhead.com/item=" . $_GET['item'] . "&xml"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$xml = simplexml_load_string(curl_exec($ch));

$json = '{"icon":"' . $xml->item->icon . '",' . trim($xml->item->json) . ',' . trim($xml->item->jsonEquip) . '}';

$json = json_decode($json);

// Create the output json
$out = new stdClass();

// Title
$out->title = trim(substr($json->name,1));

// Item id
$out->id = trim($json->id);

// Item level
$out->ilvl = trim($json->level);
$out->clr = trim(substr($json->name,0,1));

// Heroic
$out->heroic = (!empty($json->heroic) && $json->heroic == 1 ? 1 : 0);

// Icon
$out->icon->img = trim($json->icon);
$out->icon->id = trim($json->displayid);

// Stats
$stats = array('agi' => 'agility', 'sta' => 'stamina', 'exprtng' => 'expertise', 'hastertng' => 'haste', 'critstrkrtng' => 'critical-strike', 'hitrtng' => 'hit');
foreach($stats as $key => $value)
{
	if(!empty($json->{$key}))
		$out->stats->{$value} = $json->{$key};
}

// Gems

// Clean AND redundant...
echo json_encode($out);
?>