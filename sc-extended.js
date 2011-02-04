// Array of all items the user has equipped
var equip = new Array();
equip['head'] = null;
equip['neck'] = null;
equip['shoulders'] = null;
equip['back'] = null;
equip['chest'] = null;
equip['wrist'] = null;
equip['hands'] = null;
equip['waist'] = null;
equip['legs'] = null;
equip['feet'] = null;
equip['ring1'] = null;
equip['ring2'] = null;
equip['trinket1'] = null;
equip['trinket2'] = null;
equip['mainhand'] = null;
equip['offhand'] = null;
equip['ranged'] = null;

// Array of all the stats for the user
var stats = new Array();
stats['agi'] = 0;
stats['ap'] = 0;
stats['crit'] = 0;
stats['stam'] = 0;
stats['haste'] = 0;
stats['hit'] = 0;
stats['exp'] = 0;
stats['mast'] = 0;

// Race and spec - matching the format expected by Shadowcraft
var races = ['goblin','gnome','night-elf','orc','blood-elf','human','dwarf','worgen','troll','undead'];
var race = 0;

var specs = ['31/2/8','7/31/3','2/8/31'];
var spec = '30101001001039308092109210390912'; // Not...not actually a spec

// Array of all the mods the user has applied
var mods = new Array();

// Compiles all the modifications on all items to get stats and get them ready for presenting
function compileItems()
{
}

// Checks for a gem bonus
function checkSocketBonus()
{
}

// Check to make sure meta bonus is fulfilled
function checkMeta()
{
	// Get id of meta gem
	var metaId = getGem('head',0);
}

function getGem(slot,gemSlot)
{
	return equip[slot].gems[gemSlot];
}

// Performs the calculations and returns results
function calculate()
{
}

// UI Functions
function printItem(itemId,slot)
{
	//alert("Getting item: " + itemId + " for slot: " + slot);
	var slotBox = $("#slot-" + slot);
	
	// Clear contents and put loading image
	slotBox.empty();
	slotBox.append("<img src=\"img/loader.gif\" alt=\"Loading...\" />");

	$.getJSON(
				'http://localhost/Shadowcraft-Extended-UI/items.php',
			  	{item:itemId},
			  	function(data)
			  	{
			  		// Clear contents again
			  		slotBox.empty();
			  		
			  		// Add a title
			  		slotBox.append("<div class=\"itemTitle\"><a class=\"quality" + data.quality + "\">" + data.title + "</a></div>");
			  		
			  		// Make the title open up a selector box
			  		slotBox.find(".itemTitle").click(openGearSelector);
			  		
			  		// Icon and iLvl
			  		slotBox.append("<div class=\"itemIcon\" style=\"background-image:url('http://static.wowhead.com/images/wow/icons/medium/" + data.icon.img.toLowerCase() + ".jpg')\">" + data.ilvl + "</div>");
			  	
			  		// Stats
			  		slotBox.append("<div class=\"itemStats\"></div>");
			  		for (var stat in data.stats)
						slotBox.find(".itemStats").append("<p class=\"itemStat\">+" + data.stats[stat] + " " + stat + "</p>");
						
					// Mods
					slotBox.append("<div class=\"itemMods\"></div>");
					
					// Gems
					for (var gem in data.gems)
						slotBox.find(".itemMods").append("<p style=\"background-color:" + data.gems[gem].color + ";\">" + data.gems[gem].color + "</p>");
			  	}
			 );
}

function openGearSelector()
{
	
	// Get the slot to select gear from
	var slot = $(this).parent().attr('id').substring(5);
	
	// If the gearbox currently open is the one that was clicked then just close it and return
	if ($(".selectGear").length)
	{
		//alert($(".selectGear").attr('id').substring(6));
	
		if($(".selectGear").attr('id').substring(7) == slot)
		{
			$(".selectGear").remove();
			return;
		}
	
		// Remove all current gear selection boxes
		$(".selectGear").remove();
	}
	
	
	// Create a new box
	$("body").append('<div class="selectGear" id="select-' + slot + '">Selecting items for ' + slot + '</div>');
	
	// Get the box
	var gBox = $(".selectGear");
	
	// There must be a better way to check this but okay
	if($(this).parent().parent().attr('id') == 'rightItems')
	{
		gBox.addClass("selectGearRight");
		gBox.css("left",550);
	}
	else
	{
		gBox.css("left",400);
	}
	
	gBox.css("top",$(this).parent().position().top);
}

function slideRace(forward)
{
	if (forward) // WTF?! Why is this even necessary - see below
		race++;
		
	// NO FUCKING IDEA WHY THIS WON'T ACTUALLY INCREMENT IF FORWARD IS TRUE	
	if (forward && ++race >= races.length)
		race = 0;
	else if(--race < 0)
		race = races.length - 1;
}

function slideSpec(forward)
{
	if (forward)
		spec++;
		
	if (forward && ++spec >= specs.length)
		spec = 0;
	else if (--spec < 0)
		spec = specs.length - 1;
}