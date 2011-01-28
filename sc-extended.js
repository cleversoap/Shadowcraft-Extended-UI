// Array of all items the user has equipped
var equip = new Array();

// Array of all the stats for the user
var stats = new Array();

// Race and spec - matching the format expected by Shadowcraft
var races = ['goblin','gnome','night-elf','orc','blood-elf','human','dwarf','worgen','troll','undead'];
var race = 0;


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
}

// Performs the calculations and returns results
function calculate()
{
}

function slideRace(forward)
{
	if (forward) // WTF?! Why is this even necessary - see below
		++race;
		
	// NO FUCKING IDEA WHY THIS WON'T ACTUALLY INCREMENT IF FORWARD IS TRUE	
	if (forward && ++race >= races.length)
		race = 0;
	else if(--race < 0)
		race = 9;
}