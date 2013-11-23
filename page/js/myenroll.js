var signID = -1;
var type = -1;
function conModal(sID,t){
    type = t;
    signID = sID;
    $("#conModal").modal("show");
}

function delEnroll(){
    if(type == 1){
        delSign();
    }else if(type == 2){
        cancelForm();
    }
}

function delSign(){
    $.post('/activity/delSign',
           {
               'signID':signID
           },
           function(data){
               var re = $.parseJSON(data);
               handleRes(re);
           });
}

function cancelForm(){
    $.post('/activity/cancelform',
           {
               'formID': signID
           },function(data){
               console.log(data);
               var re = $.parseJSON(data);
               handleRes(re);
           });
}

function handleRes(re){
    $("#conModal").modal('hide');
    if(re['error']['code'] == 1){
        alert('取消报名成功');
        window.location.reload();
    }else if(re['error']['code'] == -12){
        alertMod('活动报名已结束');
    }else if(re['error']['code'] == -11){
        alertMod('活动报名尚未开始');
    }else{
        alertMod(re['error']['message']);
    }
}
