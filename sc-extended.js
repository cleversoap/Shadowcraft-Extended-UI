// Array of all items the user has equipped
var equip = new Array();

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
			  		printItemSlot(slot,data);
			  	}
			 );
}

function printItemSlot(slot,data)
{
	var slotBox = $("#slot-" + slot);
	
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
	
	// Assign the item to the user's equipment set
	setItem(slot,data);
}

function setItem(slot,item)
{
	equip[slot] = item;
}

function getItem(slot)
{
	return equip[slot];
}

function printSelectItem(slot,index,itemId)
{
	$.getJSON(
				'http://localhost/Shadowcraft-Extended-UI/items.php',
			  	{item:itemId},
			  	function(data)
			  	{
			  		var sBox = $(".selectGear").find("#select-" + slot + "-" + index);
			  		
			  		sBox.append('<a class="itemTitle quality' + data.quality + '">' + data.title + '</a>');
			  		
			  		sBox.append('<div class="selectStats"></div>');
			  		
			  		var statsCompare = compareStats(slot,data.stats);
			  		
			  		for (var stat in data.stats)
			  		{
			  			sBox.find(".selectStats").append('<span>+' + data.stats[stat] + (statsCompare[stat] ? '(' + statsCompare[stat] + ')' : '') + ' ' + stat);
			  		}
			  	}
			  );
}

function compareStats(slot,stats)
{
	slotStats = equip[slot].stats;

	var sks = ['agi','stam','exp','mast','haste','crit','hit'];
	
	var out = new Array();
	
	for (var sk in sks)
	{
		out[sks[sk]] = stats[sks[sk]] - slotStats[sks[sk]];
	}
	
	return out;
}

function openGearSelector()
{
	
	// Get the slot to select gear from
	var slotBox = $(this).parent();
	var slot = slotBox.attr('id').substring(5);
	
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
	$("body").append('<div class="selectGear" id="select-' + slot + '"></div>');
	
	// Get the box
	var gBox = $(".selectGear");
	
	// There must be a better way to check this but okay
	if($(this).parent().parent().attr('id') == 'rightItems')
	{
		gBox.addClass("selectGearRight");
		gBox.css("left",slotBox.position().left - slotBox.width() * 1.285);
	}
	else
	{
		gBox.css("left",slotBox.position().left + slotBox.width() * 1.125);
	}
	
	gBox.css("top",$(this).parent().position().top - 20);
	
	// Iterate through available slots for gear to select
	for (var i = 0; i < itemdb[slot].length; i++)
	{
		// Add the container div
		gBox.append('<div class="selectGearBox" id="select-' + slot + '-' + i + '"></div>');
		
		// Retrieve the item to put in the slot
		// ignore if it is the currently selected item
		if (itemdb[slot][i] != equip[slot].id)
			printSelectItem(slot,i,itemdb[slot][i]);
	}
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