var gID = Object();
function makeTypeBody()
{   
    $('#typeBody1').html("");
    $.post("/goods/getTypeList",
        {
            goodsID:gID,
            level:1
        },function(jsdata) {
//            alert(jsdata);
            var data = $.parseJSON(jsdata);
            for (x in data) {
                $('#typeBody1').append("<button type='button' class='btn btn-default' onclick='deltype(\""+data[x]+"\",1)'>"+data[x]+"</button>");
            }
        }
    );
    $('#typeBody2').html("");
    $.post("/goods/getTypeList",
        {
            goodsID:gID,
            level:2
        },function(jsdata) {
//            alert(jsdata);
            var data = $.parseJSON(jsdata);
            for (x in data) {
                $('#typeBody2').append("<button type='button' class='btn btn-default' onclick='deltype(\""+data[x]+"\",2)'>"+data[x]+"</button>");
            }
        }
    );
    $('#typeBody3').html("");
    $.post("/goods/getTypeList",
        {
            goodsID:gID,
            level:3
        },function(jsdata) {
//            alert(jsdata);
            var data = $.parseJSON(jsdata);
            for (x in data) {
                $('#typeBody3').append("<button type='button' class='btn btn-default' onclick='deltype(\""+data[x]+"\",3)'>"+data[x]+"</button>");
            }
        }
    );
}

function deltype(type,level)
{
    $.post("/goods/deltype",
    {
        goodsID:gID,
        type:type,
        level:level
    },function(data) {
        makeTypeBody();
    });
}

function addtype(level)
{
    var type = document.getElementById('typeText'+level).value;
    document.getElementById('typeText'+level).value = "";
    if (type == "") {
        alert("请输入类型名称");
        return;
    }

    $.post("/goods/addtype",
    {
        goodsID:gID,
        type:type,
        level:level
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

