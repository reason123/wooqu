
function turnGoods(goodsID,groupbuyID)
{
	if (document.getElementById("but"+goodsID).value === "add")
	{
		$.post("/groupbuy/addMyGoods",
			{ groupbuyID: groupbuyID,
			  goodsID:goodsID}, 
			function(jsdata){
			});
		$("#but"+goodsID).html("卸载商品");
		$("#but"+goodsID).removeClass().addClass("btn btn-small btn-danger");
		document.getElementById("but"+goodsID).value = "del";
	} else if (document.getElementById("but"+goodsID).value === "del")
	{
		$.post("/groupbuy/delMyGoods",
			{ groupbuyID: groupbuyID,
			  goodsID:goodsID}, 
			function(jsdata){
			})
		$("#but"+goodsID).html("加入商品");
		$("#but"+goodsID).removeClass().addClass("btn btn-small btn-primary");
		document.getElementById("but"+goodsID).value = "add";
	}
}
