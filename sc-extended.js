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