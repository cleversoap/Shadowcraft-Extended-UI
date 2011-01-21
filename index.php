<?php
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
		<img src="http://static.wowhead.com/images/wow/icons/medium/<?=$json->icon?>.jpg" /><br />
		+301 Agi<br />
		+512 Stam
	</td>
	<td>
		<table>
			<tr>
				<td colspan="2"><?=$json->name?></td>
			</tr>
			<tr>
				<td>[E]</td>
				<td>Enchant</td>
			</tr>
			<tr>
				<td>[C]</td>
				<td>Cogwheel</td>
			</tr>
			<tr>
				<td>[C]</td>
				<td>Cogwheel</td>
			</tr>
			<tr>
				<td>[B]</td>
				<td>Gem Bonus</td>
			</tr>
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
	</head>
	<body>
		<div id="mainContainer">
		<h1>Shadowcraft</h1>
		<table border="0" id="mainTable">
			<tr>
				<th colspan="3">
					<label for="importChar">IMPORT</label>
				</th>
			</tr>
			<tr>
				<td id="slot-0">
					<?=printItem("65129")?>
				</td>
				<td id="core" rowspan="8" align="center" valign="top">
					<div id="dataDisplay">
						DATA
					</div>
					<table border="1">
						<tr>
							<td>
								<?=printItem("65081")?>
							</td>
							<td>
								<?=printItem("68600")?>
							</td>
							<td>
								<?=printItem("68608")?>
							</td>
						</tr>
					</table>
				</td>
				<td id="slot-10">
					<?=printItem("65240")?>
				</td>
			</tr>
			<tr>
				<td id="slot-1">
					<?=printItem("65107")?>
				</td>
				<td id="slot-2">
					<?=printItem("56537")?>
				</td>
			</tr>
			<tr>
				<td id="slot-3">
					<?=printItem("65083")?>
				</td>
				<td id="slot-4">
					<?=printItem("65242")?>
				</td>
			</tr>
			<tr>
				<td id="slot-5">
					<?=printItem("65035")?>
				</td>
				<td id="slot-6">
					<?=printItem("65144")?>
				</td>
			</tr>
			<tr>
				<td id="slot-7">
					<?=printItem("65239")?>
				</td>
				<td id="slot-8">
					<?=printItem("65082")?>
				</td>
			</tr>
			<tr>
				<td id="slot-9">
					<?=printItem("65050")?>
				</td>
				<td id="slot-10">
					<?=printItem("67136")?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td id="slot-11">
					<?=printItem("65026")?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td id="slot-12">
					<?=printItem("62051")?>
				</td>
			</tr>
		</table>
		</div>
	</body>
</html>