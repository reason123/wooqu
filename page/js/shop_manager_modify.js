var goodsID = 0;
var shopID = new Object();

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

function confirmDeleteCargo(id) {
	goodsID = id;
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

function deleteGoods()
{
	$.post("/shop/delGoods",
		{
			ID:goodsID
		},
		function(jsdata){
			var data = $.parseJSON(jsdata);
			if (data.error == "") {
				window.location.href = "";
			} else {
				alert(data.error);
				$("#confirmDeleteCargoModal").modal("hide");
			}
	});

}

function makeOrderMessageBody()
{   
    $('#orderMessageBody').html("");
    $.post("/shop/getOrderMessageList",
        {
            shopID:shopID
        },function(jsdata) {
            var data = $.parseJSON(jsdata);
            for (x in data) {
                $('#orderMessageBody').append("<button type='button' class='btn btn-default' onclick='delOrderMessage(\""+data[x]+"\")'>"+data[x]+"</button>");
            }
        }
    );
}

function delOrderMessage(orderMessage)
{
    $.post("/shop/delOrderMessage",
    {
        shopID:shopID,
        orderMessage:orderMessage
    },function(data) {
        makeOrderMessageBody();
    });
}

function addOrderMessage()
{
    var orderMessage = document.getElementById('orderMessageText').value;
    document.getElementById('orderMessageText').value = "";
    if (orderMessage == "") {
        alert("请输入类型名称");
        return;
    }

    $.post("/shop/addOrderMessage",
    {
        shopID:shopID,
        orderMessage:orderMessage
    },function(data) {
        makeOrderMessageBody();
    });
}

function showOrderMessageModal(id)
{
    shopID = id;
    makeOrderMessageBody();
	$("#orderMessageModal").modal("show");
}

