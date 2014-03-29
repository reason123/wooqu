var gID = Object();
function makeTypeBody()
{   
    $('#typeBody').html("");
    $.post("/goods/getTypeList",
        {
            goodsID:gID
        },function(jsdata) {
//            alert(jsdata);
            var data = $.parseJSON(jsdata);
            for (x in data) {
                $('#typeBody').append("<button type='button' class='btn btn-default' onclick='deltype(\""+data[x]+"\")'>"+data[x]+"</button>");
            }
        }
    );
}

function deltype(type)
{
    $.post("/goods/deltype",
    {
        goodsID:gID,
        type:type
    },function(data) {
        makeTypeBody();
    });
}

function addtype()
{
    var type = document.getElementById('typeText').value;
    document.getElementById('typeText').value = "";
    if (type == "") {
        alert("请输入类型名称");
        return;
    }

    $.post("/goods/addtype",
    {
        goodsID:gID,
        type:type
    },function(data) {
        makeTypeBody();
    });
}

function showTypeModal(goodsID)
{
    gID = goodsID;
    makeTypeBody();
	$("#typeModal").modal("show");
}

