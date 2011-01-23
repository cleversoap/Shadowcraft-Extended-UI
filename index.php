<?php
// Get the default gear list or get one that has been imported
if (!empty($_GET["region"]) && !empty($_GET["realm"]) && !empty($_GET["name"]))
{
	$ce = curl_init();
	curl_setopt($ce, CURLOPT_URL, "http://localhost/Shadowcraft-Extended-UI/armory.php?region=" . $_GET["region"] . "&realm=" . $_GET["realm"] . "&name=" . $_GET["name"]); 
	curl_setopt($ce, CURLOPT_RETURNTRANSFER, 1);
	$equip = (array)json_decode(curl_exec($ce));
}
else
{
	$equip = array('head' => 65129, 'neck' => 65107, 'shoulders' => 65083, 'back' => 65035, 'chest' => 65239, 'wrist' => 65050, 'hands' => 65240, 'waist' => 56537, 'legs' => 65242, 'feet' => 65144, 'ring1' => 65082, 'ring2' => 67136, 'trinket1' => 65026, 'trinket2' => 62051, 'mainhand' => 65081, 'offhand' => 68600, 'ranged' => 68608);
}


// Print an item in a slot
function printItem($id="",$rightAlign=false)
{
	if(empty($id))
	{
		return;
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://localhost/Shadowcraft-Extended-UI/items.php?item=" . $id); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$json = json_decode(curl_exec($ch));
	
?>

<div class="itemSlot">
	<div class="itemTitle">
		<a href="#"><?=$json->title?></a>
	</div>
	<div class="itemIcon">
		<img src="http://static.wowhead.com/images/wow/icons/medium/<?=$json->icon->img?>.jpg" />
	</div>
	<div class="itemStats">
		<?php
			foreach($json->stats as $stat => $value)
				echo '<p class="itemStat">+' . $value . ' ' . $stat . '</p>';
		?>
	</div>
	<div class="itemMods">
		<?php
			foreach($json->gems as $gem)
				echo '<p>' . $gem->color . '</p>';
		?>
	</div>
</div>

<?php
}
?>

<html>
	<head>
		<title>Shadowcraft Extended UI</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script type="text/javascript" language="javascript" href="jquery.js"></script> <!-- MOVE TO BOTTOM WHEN DONE -->
	</head>
	<body>
		<div id="mainContainer">
		<img src="img/header.png" alt="ShadowCraft" />
		<table border="0" id="mainTable">
			<tr>
				<th colspan="3">
					<form action="index.php" method="get">
						<input type="text" name="region" value="<?=(!empty($_GET["region"]) ? $_GET["region"] : "region")?>" />
						<input type="text" name="realm" value="<?=(!empty($_GET["realm"]) ? $_GET["realm"] : "realm")?>" />
						<input type="text" name="name" value="<?=(!empty($_GET["name"]) ? $_GET["name"] : "name")?>" />
						<input type="submit" value="IMPORT" />
					</form>
				</th>
			</tr>
			<tr>
				<td id="slot-0" class="column">
					RACE IMAGE SLIDER
				</td>
				<td id="core" rowspan="3" align="center" valign="top">
					<div id="dataDisplay">
						DATA
					</div>
				</td>
				<td id="rightItems" rowspan="3">
					<?=printItem($equip['hands'])?>
					<?=printItem($equip['waist'])?>
					<?=printItem($equip['legs'])?>
					<?=printItem($equip['feet'])?>
					<?=printItem($equip['ring1'])?>
					<?=printItem($equip['ring2'])?>
					<?=printItem($equip['trinket1'])?>
					<?=printItem($equip['trinket2'])?>
				</td>
			</tr>
			<tr>
				<td id="slot-1">
					ASSAS/CMBT/SUB SLIDER
				</td>
			</tr>
			<tr>
				<td id="leftItems" class="column">
					<?=printItem($equip['head'])?>
					<?=printItem($equip['neck'])?>
					<?=printItem($equip['shoulders'])?>
					<?=printItem($equip['back'])?>
					<?=printItem($equip['chest'])?>
					<?=printItem($equip['wrist'])?>
				</td>
			</tr>
		</table>
		<div id="footer">
			<a href="https://github.com/cleversoap/Shadowcraft-Extended-UI">UI</a> by keys@saurfang<br/>
			<a href="https://github.com/Aldriana/ShadowCraft-Engine/">Engine</a> by aldriana@doomhammer
		</div>
		</div>
	</body>
</html>