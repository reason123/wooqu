function confirmModifyInfo() {
	$("#confirmModifyInfoModal").modal("show");
}


function modifyShop(id) {
	var arr = new Object();
	arr.ID = id;
	arr.name = document.getElementById("modify_name").value;
	arr.address = document.getElementById("modify_address").value;
	arr.phone = document.getElementById("modify_phone").value;
	arr.detail = $("#modify_detail").val()
	arr.type = document.getElementById("modify_type").value;

	$.post("/shop/modifyShopById",
		{
			content: JSON.stringify(arr)
		}, 
		function(jsdata){
			var data = $.parseJSON(jsdata);
			if (data.error == "") {
				window.location.href = "";
			} else {
				alert(data.error);
				$("#confirmModifyInfoModal").modal("hide");
			}
		});
}

function confirmModifyCargo(id) {
	$("#modifyModal").modal("show");
}

function confirmDeleteCargo(name) {
	$("#deleteBody").html("<h4>一旦删除商品\""+name+"\"则不可恢复</h4>");
	$("#confirmDeleteCargoModal").modal("show");
}


function showAddGoodsModal()
{
	$("#addGoodsModal").modal("show");
}


function addGoods(id)
{
	$.post("/shop/addGoods",
		{ shopID : id,
		  name : document.getElementById("aGname").value,
		  price : document.getElementById("aGprice").value,
		  detail : document.getElementById("aGdetail").value },
		function(jsdata){
			var data = $.parseJSON(jsdata);
			if (data.error == "") {
				window.location.href = "";
			} else {
				alert(data.error);
				$("#addGoodsModal").modal("hide");
			}
		});
}

function deleteCargo(id)
{
	$.post("/shop/delGoods",
		{
			ID:id
		},
		function(jsdata){
			var data = $.parseJSON(jsdata);
			if (data.error == "") {
				window.location.href = "";
			} else {
				alert(data.error);
				$("#confirmDeleteCargoModal").modal("hide");
			}
	)

}