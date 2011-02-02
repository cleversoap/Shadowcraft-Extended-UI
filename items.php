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
$out->quality = trim(substr($json->name,0,1));

// Heroic
$out->heroic = (!empty($json->heroic) && $json->heroic == 1 ? 1 : 0);

// Icon
$out->icon->img = trim($json->icon);
$out->icon->id = trim($json->displayid);

// Stats
$stats = array('agi' => 'agi', 'sta' => 'stam', 'exprtng' => 'exp', 'hastertng' => 'haste', 'critstrkrtng' => 'crit', 'hitrtng' => 'hit');
foreach($stats as $key => $value)
{
	if(!empty($json->{$key}))
		$out->stats->{$value} = $json->{$key};
}

// Gems
$out->gems = array();
if(!empty($json->nsockets))
{
	for($i = 1; $i <= $json->nsockets; $i++)
	{
		$out->gems[$i-1]->id = $json->{'socket'. $i};
		$color = null;
		
		switch($json->{'socket'. $i})
		{
			case 1:
				$color = 'meta';
				break;
				
			case 2:
				$color = 'blue';
				
			case 4:
				$color = 'yellow';
				break;
				
			case 8:
				$color = 'red';
				break;
				
			case 32:
				$color = 'cogwheel';
				break;
		}
		
		$out->gems[$i-1]->color = $color;
	}
}

/* Debugging
echo '<pre>';
print_r($json);
print_r($out);
echo '</pre>';
*/

// Clean AND redundant...
echo json_encode($out);
?>