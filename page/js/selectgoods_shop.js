
function turnGoods(goodsID,shopID)
{
	if (document.getElementById("but"+goodsID).value === "add")
	{
		$.post("/shop/addMyGoods",
			{ shopID: shopID,
			  goodsID:goodsID}, 
			function(jsdata){
			});
		$("#but"+goodsID).html("卸载商品");
		$("#but"+goodsID).removeClass().addClass("btn btn-small btn-danger");
		document.getElementById("but"+goodsID).value = "del";
	} else if (document.getElementById("but"+goodsID).value === "del")
	{
		$.post("/shop/delMyGoods",
			{ shopID: shopID,
			  goodsID:goodsID}, 
			function(jsdata){
			})
		$("#but"+goodsID).html("加入商品");
		$("#but"+goodsID).removeClass().addClass("btn btn-small btn-primary");
		document.getElementById("but"+goodsID).value = "add";
	}
}
