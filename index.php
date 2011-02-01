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
	$equip = array('head' => 59455, 'neck' => 65107, 'shoulders' => 65083, 'back' => 65035, 'chest' => 65239, 'wrist' => 65050, 'hands' => 65240, 'waist' => 56537, 'legs' => 65242, 'feet' => 65144, 'ring1' => 65082, 'ring2' => 67136, 'trinket1' => 65026, 'trinket2' => 62051, 'mainhand' => 65081, 'offhand' => 68600, 'ranged' => 68608);
}


// Print an item in a slot
function printItem($slot,$lastRow=false)
{
	global $equip;
	
	$id = $equip[$slot];

	if(empty($id))
		return;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://localhost/Shadowcraft-Extended-UI/items.php?item=" . $id); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$json = json_decode(curl_exec($ch));
	
	
	// Just to simplify the output - I realize this is horribly redundant
	$statAbrv = array('agility' => 'agi', 'stamina' => 'stam', 'expertise' => 'exp', 'haste' => 'haste', 'critical-strike' => 'crit', 'hit' => 'hit');
?>

<div class="itemSlot<?=($lastRow ? ' lastRow' : '')?>" id="slot-<?=$slot?>">
	<div class="itemTitle">
		<a href="#" class="quality<?=$json->quality?>"><?=$json->title?></a>
	</div>
	<div class="itemIcon" style="background-image:url('http://static.wowhead.com/images/wow/icons/medium/<?=strtolower($json->icon->img)?>.jpg')">
		<?=$json->ilvl?>
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
				echo '<p style="background-color:' . $gem->color . ';">' . $gem->color . '</p>';
		?>
	</div>
</div>

<?php
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<title>Shadowcraft Extended UI</title>
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript" src="easySlider.js"></script> <!-- MOVE TO BOTTOM WHEN DONE -->
		<script type="text/javascript" src="sc-extended.js"></script>
		<script type="text/javascript">
		$(document).ready(function()
		{
			// Create image sliders for race and spec
			$("#raceSlider").easySlider({continuous:true, controlsShow:false, prevId:'racePrev', nextId:'raceNext'});
			$("#specSlider").easySlider({continuous:true, controlsShow:false, prevId:'specPrev', nextId:'specNext'});
			
			// Setup buffs toggle button
			$("#btnBuffs").click(function()
			{
	 			$("#buffs").slideToggle("slow");
	  			$(this).toggleClass("active");
			});
		});
		</script>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<div id="mainContainer">
		<img src="img/header.png" alt="ShadowCraft" />
		<div id="quote">
			<?php 
				$lines = file("quotes.txt");
				echo $lines[array_rand($lines)];
			?>
		</div>
	
					<form action="index.php" method="get">
						<select name="region">
							<option value="us">US</option>
							<option value="eu" <?=(!empty($_GET["region"]) && $_GET["region"] == "eu" ? "SELECTED" : '')?>>EU</option>
						</select>
						<input type="text" name="realm" value="<?=(!empty($_GET["realm"]) ? $_GET["realm"] : "realm")?>" />
						<input type="text" name="name" value="<?=(!empty($_GET["name"]) ? $_GET["name"] : "name")?>" />
						<input type="submit" value="IMPORT" />
					</form>
					
		</table>
				<div id="leftItems">
					<div class="itemSlot slideSlot" id="raceSlider">
						<ul>
							<li><img src="img/crest_goblin.jpg" alt="GOBLIN" /></li>
							<li><img src="img/crest_gnome.jpg" alt="GNOME" /></li>
							<li><img src="img/crest_nelf.jpg" alt="NIGHT ELF" /></li>
							<li><img src="img/crest_orc.jpg" alt="ORC" /></li>
							<li><img src="img/crest_belf.jpg" alt="BLOOD ELF" /></li>
							<li><img src="img/crest_human.jpg" alt="HUMAN" /></li>
							<li><img src="img/crest_dwarf.jpg" alt="DWARF" /></li>
							<li><img src="img/crest_worgen.jpg" alt="WORGEN" /></li>
							<li><img src="img/crest_troll.jpg" alt="TROLL" /></li>
							<li><img src="img/crest_undead.jpg" alt="UNDEAD" /></li>
						</ul>
						<span id="racePrev" class="navLeft"><a href="javascript:void(0);" onclick="javascript:slideRace(false);"><img src="img/slide_prev.png" alt="&lt;" /></a></span>
						<span id="raceNext" class="navRight"><a href="javascript:void(0);" onclick="javascript:slideRace(true);"><img src="img/slide_next.png" alt="&gt;" /></a></span>
					</div>
					<div class="itemSlot slideSlot" id="specSlider">
						<ul>
							<li>
								<img src="img/spec_assass.jpg" alt="ASSASSINATION" />
								<p>31/2/8</p>
							</li>
							<li>
								<img src="img/spec_combat.jpg" alt="COMBAT" />
								<p>7/31/3</p>
							</li>
							<li>
								<img src="img/spec_sub.jpg" alt="SUBTLETY" />
							</li>
						</ul>
						<span id="specPrev" class="navLeft"><a href="javascript:void(0);" onclick="javascript:slideSpec(false);"><img src="img/slide_prev.png" alt="&lt;" /></a></span>
						<span id="specNext" class="navRight"><a href="javascript:void(0);" onclick="javascript:slideSpec(true);"><img src="img/slide_next.png" alt="&gt;" /></a></span>
					</div>
					<?=printItem('head')?>
					<?=printItem('neck')?>
					<?=printItem('shoulders')?>
					<?=printItem('back')?>
					<?=printItem('chest')?>
					<?=printItem('wrist')?>
		</div>
		<div id="dataDisplay">
						<p class="calcStatLabel">Agility</p>
						<p class="calcStatValue" id="stat-agi">10000</p>
						<p class="calcStatLabel">Attack Power</p>
						<p class="calcStatValue" id="stat-ap">9000</p>
						<p class="calcStatLabel">Crit</p>
						<p class="calcStatValue" id="stat-crit">8000</p>
						<p class="calcStatPct" id="stat-crit-pct">30.11%</p>
						<p class="calcStatLabel">Stamina</p>
						<p class="calcStatValue" id="stat-stam">7000</p>
						<p class="calcStatLabel">Haste</p>
						<p class="calcStatValue" id="stat-haste">6000</p>
						<p class="calcStatLabel">Hit</p>
						<p class="calcStatValue" id="stat-hit">5000</p>
						<p class="calcStatPct" id="stat-hit-pct">11%</p>
						<p class="calcStatLabel">Expertise</p>
						<p class="calcStatValue" id="stat-exp">4000</p>
						<p class="calcStatPct" id="stat-exp-pct">8.11%</p>
						<p class="calcStatLabel">Mastery</p>
						<p class="calcStatValue" id="stat-mast">3000</p>
		<div id="glyphs">
			<select id="glyph1">
				<option value="adrenaline_rush">Adrenaline Rush</option>
				<option value="backstab" selected="true">Backstab</option>
				<option value="eviscerate">Eviscerate</option>
				<option value="hemorrhage">Hemorrhage</option>
				<option value="killing_spree">Killing Spree</option>
				<option value="mutilate">Mutilate</option>
				<option value="revealing_strike">Revealing Strike</option>
				<option value="rupture">Rupture</option>
				<option value="shadow_dance">Shadow Dance</option>
				<option value="sinister_strike">Sinister Strike</option>
				<option value="slice_and_dice">Slice n' Dice</option>
				<option value="vendetta">Vendetta</option>
			</select>
			<select id="glyph2">
				<option value="adrenaline_rush">Adrenaline Rush</option>
				<option value="backstab">Backstab</option>
				<option value="eviscerate">Eviscerate</option>
				<option value="hemorrhage">Hemorrhage</option>
				<option value="killing_spree">Killing Spree</option>
				<option value="mutilate" selected="true">Mutilate</option>
				<option value="revealing_strike">Revealing Strike</option>
				<option value="rupture">Rupture</option>
				<option value="shadow_dance">Shadow Dance</option>
				<option value="sinister_strike">Sinister Strike</option>
				<option value="slice_and_dice">Slice n' Dice</option>
				<option value="vendetta">Vendetta</option>
			</select>
			<select id="glyph3">
				<option value="adrenaline_rush">Adrenaline Rush</option>
				<option value="backstab">Backstab</option>
				<option value="eviscerate">Eviscerate</option>
				<option value="hemorrhage">Hemorrhage</option>
				<option value="killing_spree">Killing Spree</option>
				<option value="mutilate">Mutilate</option>
				<option value="revealing_strike">Revealing Strike</option>
				<option value="rupture" selected="true">Rupture</option>
				<option value="shadow_dance">Shadow Dance</option>
				<option value="sinister_strike">Sinister Strike</option>
				<option value="slice_and_dice">Slice n' Dice</option>
				<option value="vendetta">Vendetta</option>
			</select>
		</div>
		<a id="btnBuffs">BUFFS</a>
		<div id="buffs">
			<fieldset>
				<legend>FOOD</legend>
				<input type="checkbox" value="buff-guild_feast" />
				<label for="buff-guid_feast">Guild Feast</label>
			</fieldset>
			<fieldset>
				<legend>POTIONS</legend>
				<input type="checkbox" value="buff-tolvir_potion" />
				<label for="buff-tolvir_potion">Potion of the Tol'vir</label>
			</fieldset>
		</div>
		<div id="weapons">
			<?=printItem('mainhand')?>
			<?=printItem('offhand')?>
			<?=printItem('ranged')?>
		</div>
		</div>
		<div id="rightItems">
					<?=printItem('hands')?>
					<?=printItem('waist')?>
					<?=printItem('legs')?>
					<?=printItem('feet')?>
					<?=printItem('ring1')?>
					<?=printItem('ring2')?>
					<?=printItem('trinket1')?>
					<?=printItem('trinket2',true)?>
		</div>
		<div id="footer">
			<a href="https://github.com/cleversoap/Shadowcraft-Extended-UI" target="_blank">UI</a> by keys@saurfang<br/>
			<a href="https://github.com/Aldriana/ShadowCraft-Engine/" target="_blank">Engine</a> by aldriana@doomhammer
		</div>
		</div>
	</body>
</html>