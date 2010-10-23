function Raid(xmlText)
{
	/* Parent class */
	this.prototype.orden = new Orden(xmlText);
	this.prototype.queue = new Queue(xmltext);

	if (xmlText == undefined)
	{
		/* Raid class attributes */
		this.raid_id = new Number();
		this.from = new String();	// Nombre de la aldea origen
		this.to = new String();		// 
	}
	else
	{
		this.raid_id = 
	}
}


Raid.prototype.get = function(id)
{
 
}

