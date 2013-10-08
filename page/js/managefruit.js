function changeAvailable(fruID)
{
	$.post('/shop/changeAvailable',
	{
		'fruitID':fruID
	},function(data)
	{
		var re = $.parseJSON(data);
		if (re.error.code == 1)
		{
			window.location.reload();	
		} else 
		{
			alertMod(re.error.message);	
		}
	});
}

function changePriority(fruID)
{
	$.post('/shop/changePriority',
	{
		'fruitID':fruID
	},function(data)
	{
		var re = $.parseJSON(data);
		if (re.error.code == 1)
		{
			window.location.reload();	
		} else 
		{
			alertMod(re.error.message);	
		}
	});
}