var delShopId;

function addShop() {
	$("#addShopModal").modal("show");
}

function confirmAdd() {
	var name = $("#add_name").val();
	var address = $("#add_address").val();
	var phone = $("#add_phone").val();
	var detail = $("#add_detail").val();
	var type = $("#add_type").val();
	var grouplist = $("#group_list").val();
	$.post("/shop/addShop", {
		name: name,
		address: address,
		phone: phone,
		detail: detail,
		type: type,
		groupID: grouplist
	},
	function(jsdata){
		var data = $.parseJSON(jsdata);
		if (data.error == "") {
			window.location.href = "";
		} else {
			alert(data.error);
		}
	});
}


function confirmDeleteShop(id,name) {
	delShopId = id;
	$("#deleteBody").html("<h4>一旦删除商店“"+name+"”则不可恢复</h4>");
	$("#confirmDeleteShopModal").modal("show");
}

function delShop() {
	$.post("/shop/deleteShopById",
	    { id: delShopId },
		function(data){
			var ret = $.parseJSON(data);
			if (ret.error == "") {
				window.location.href="";
			} else {
				alert(ret.error);
				$("#confirmDeleteShopModal").modal("hide");
			}
		}
	);
}

$(function(){
})
