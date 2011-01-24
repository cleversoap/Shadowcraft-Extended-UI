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
function printItem($id="",$lastRow=false)
{
	if(empty($id))
	{
		return;
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://localhost/Shadowcraft-Extended-UI/items.php?item=" . $id); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$json = json_decode(curl_exec($ch));
	
	
	// Just to simplify the output - I realize this is horribly redundant
	$statAbrv = array('agility' => 'agi', 'stamina' => 'stam', 'expertise' => 'exp', 'haste' => 'haste', 'critical-strike' => 'crit', 'hit' => 'hit');
?>

<div class="itemSlot<?=($lastRow ? ' lastRow' : '')?>">
	<div class="itemTitle">
		<a href="#"><?=$json->title?></a>
	</div>
	<div class="itemIcon" style="background-image:url('http://static.wowhead.com/images/wow/icons/medium/<?=$json->icon->img?>.jpg')">
	</div>
	<div class="itemStats">
		<?php
			foreach($json->stats as $stat => $value)
				echo '<p class="itemStat">+' . $value . ' ' . $statAbrv[$stat] . '</p>';
		?>
	</div>
	<div class="itemMods">
		<?php
			foreach($json->gems as $gem)
				echo '<p >' . $gem->color . '</p>';
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
				<td id="leftItems" class="column">
					<?=printItem($equip['head'])?>
					<?=printItem($equip['neck'])?>
					<?=printItem($equip['shoulders'])?>
					<?=printItem($equip['back'])?>
					<?=printItem($equip['chest'])?>
					<?=printItem($equip['wrist'])?>
				</td>
				<td id="core" align="center" valign="top">
					<div id="dataDisplay">
						<p class="calcStatLabel">Agility</p>
						<p class="calcStatValue">10000</p>
						<p class="calcStatLabel">Attack Power</p>
						<p class="calcStatValue">9000</p>
						<p class="calcStatLabel">Crit</p>
						<p class="calcStatPct">30.11%</p>
						<p class="calcStatValue">8000</p>
						<p class="calcStatLabel">Stamina</p>
						<p class="calcStatValue">7000</p>
						<p class="calcStatLabel">Haste</p>
						<p class="calcStatValue">6000</p>
						<p class="calcStatLabel">Hit</p>
						<p class="calcStatPct">11%</p>
						<p class="calcStatValue">5000</p>
						<p class="calcStatLabel">Expertise</p>
						<p class="calcStatPct">8.11%</p>
						<p class="calcStatValue">4000</p>
						<p class="calcStatLabel">Mastery</p>
						<p class="calcStatValue">3000</p>
					</div>
					<div id="weapons">
						<?=printItem($equip['mainhand'])?>
						<?=printItem($equip['offhand'])?>
						<?=printItem($equip['ranged'])?>
					</div>
				</td>
				<td id="rightItems">
					<?=printItem($equip['hands'])?>
					<?=printItem($equip['waist'])?>
					<?=printItem($equip['legs'])?>
					<?=printItem($equip['feet'])?>
					<?=printItem($equip['ring1'])?>
					<?=printItem($equip['ring2'])?>
					<?=printItem($equip['trinket1'])?>
					<?=printItem($equip['trinket2'],true)?>
				</td>
			</tr>
		</table>
		<div id="footer">
			<a href="https://github.com/cleversoap/Shadowcraft-Extended-UI" target="_blank">UI</a> by keys@saurfang<br/>
			<a href="https://github.com/Aldriana/ShadowCraft-Engine/" target="_blank">Engine</a> by aldriana@doomhammer
		</div>
		</div>
	</body>
</html>