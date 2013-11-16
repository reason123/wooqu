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
               if(re['error']['code'] == 1){
                   alert('提交成功');
                   window.location.reload();
               }else{
                   alert(data);
               }
           });
}
