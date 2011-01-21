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
					<label for="importChar">IMPORT</label>
				</th>
			</tr>
			<tr>
				<td id="slot-0">
					RACE IMAGE SLIDER
				</td>
				<td id="core" colspan="3" rowspan="7" align="center" valign="top">
					<div id="dataDisplay">
						DATA
					</div>
				</td>
				<td id="slot-10">
					<?=printItem("65240")?>
				</td>
			</tr>
			<tr>
				<td id="slot-1">
					ASSAS/CMBT/SUB SLIDER
				</td>
				<td id="slot-2">
					<?=printItem("56537")?>
				</td>
			</tr>
			<tr>
				<td id="slot-3">
					<?=printItem("65129")?>
				</td>
				<td id="slot-4">
					<?=printItem("65242")?>
				</td>
			</tr>
			<tr>
				<td id="slot-5">
					<?=printItem("65107")?>
				</td>
				<td id="slot-6">
					<?=printItem("65144")?>
				</td>
			</tr>
			<tr>
				<td id="slot-7">
					<?=printItem("65083")?>
				</td>
				<td id="slot-8">
					<?=printItem("65082")?>
				</td>
			</tr>
			<tr>
				<td id="slot-9">
					<?=printItem("65035")?>
				</td>
				<td id="slot-10">
					<?=printItem("67136")?>
				</td>
			</tr>
			<tr>
				<td>
					<?=printItem("65239")?>
				</td>
				<td id="slot-11">
					<?=printItem("65026")?>
				</td>
			</tr>
			<tr>
				<td>
					<?=printItem("65050")?>
				</td>
				<td>
					<?=printItem("65081")?>
				</td>
				<td>
					<?=printItem("68600")?>
				</td>
				<td>
					<?=printItem("68608")?>
				</td>
				<td id="slot-12">
					<?=printItem("62051")?>
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