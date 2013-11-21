var request = new Object();
function subCon(){
    $("#conModal").modal('show');
}

function subForm(){
    getRequest(request);
    info = [];
    for(i = 0; i < $(".form-info").length; i ++){
        if($(".form-info")[i].value == "on"){
            info.push(Number($(".form-info")[i].checked));
        }else{
            info.push($(".form-info")[i].value);
        }
    }
    $.post('/activity/subform',
           {
               'actID': request['actID'],
               'content': JSON.stringify(info)
           },
           function(data){
               var re = $.parseJSON(data);
               handleRes(re);
           });
}

function handleRes(re){
    $("#conModal").modal('hide');
    if(re['error']['code'] == 1){
        alert('提交报名表成功');
        window.location.href="/userpage/myenroll";
    }else if(re['error']['code'] == -12){
        alertMod('活动报名已结束');
    }else if(re['error']['code'] == -11){
        alertMod('活动报名尚未开始');
    }else{
        alertMod(re['error']['message']);
    }
}
