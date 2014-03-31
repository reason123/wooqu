function orderDeal(id)
{
    $.post("/shop/shopDeal",{
        orderID:id
    },function(data){
    });
    $("#deal"+id).html("已完成");
}
