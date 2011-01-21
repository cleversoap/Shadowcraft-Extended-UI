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

<table>
	<tr valign="top">
	<td>
		<img src="http://static.wowhead.com/images/wow/icons/medium/<?=$json->icon->img?>.jpg" /><br />
		<?php
			foreach($json->stats as $stat => $value)
				echo '<p class="itemStat">+' . $value . ' ' . $stat . '</p>';
		?>
	</td>
	<td>
		<table>
			<tr>
				<td><?=$json->title?></td>
			</tr>
			<?php
				foreach($json->gems as $gem)
				{
					echo '<tr><td>' . $gem->color . '</td></tr>';
				}
			?>
		</table>
	</td>
	</tr>
</table>

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
				<th colspan="5">
					<form action="index.php" method="get">
						<input type="text" name="region" value="<?=(!empty($_GET["region"]) ? $_GET["region"] : "region")?>" />
						<input type="text" name="realm" value="<?=(!empty($_GET["realm"]) ? $_GET["realm"] : "realm")?>" />
						<input type="text" name="name" value="<?=(!empty($_GET["name"]) ? $_GET["name"] : "name")?>" />
						<input type="submit" value="IMPORT" />
					</form>
				</th>
			</tr>
			<tr>
				<td id="raceBox">
					RACE IMAGE SLIDER
				</td>
				<td id="core" colspan="3" rowspan="7" align="center" valign="top">
					<div id="dataDisplay">
						DATA
					</div>
				</td>
				<td id="slot-10">
					<?=printItem($equip['hands'])?>
				</td>
			</tr>
			<tr>
				<td id="modBox">
					ASSAS/CMBT/SUB SLIDER
				</td>
				<td id="slot-1">
					<?=printItem($equip['waist'])?>
				</td>
			</tr>
			<tr>
				<td id="slot-2">
					<?=printItem($equip['head'])?>
				</td>
				<td id="slot-4">
					<?=printItem($equip['legs'])?>
				</td>
			</tr>
			<tr>
				<td id="slot-3">
					<?=printItem($equip['neck'])?>
				</td>
				<td id="slot-6">
					<?=printItem($equip['feet'])?>
				</td>
			</tr>
			<tr>
				<td id="slot-4">
					<?=printItem($equip['shoulders'])?>
				</td>
				<td id="slot-8">
					<?=printItem($equip['ring1'])?>
				</td>
			</tr>
			<tr>
				<td id="slot-16">
					<?=printItem($equip['back'])?>
				</td>
				<td id="slot-10">
					<?=printItem($equip['ring2'])?>
				</td>
			</tr>
			<tr>
				<td id="slot-5">
					<?=printItem($equip['chest'])?>
				</td>
				<td id="slot-11">
					<?=printItem($equip['trinket1'])?>
				</td>
			</tr>
			<tr>
				<td>
					<?=printItem($equip['wrist'])?>
				</td>
				<td>
					<?=printItem($equip['mainhand'])?>
				</td>
				<td>
					<?=printItem($equip['offhand'])?>
				</td>
				<td>
					<?=printItem($equip['ranged'])?>
				</td>
				<td id="slot-12">
					<?=printItem($equip['trinket2'])?>
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