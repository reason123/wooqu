<legend style="margin-top:10px;">绑定信息</legend>
<div class="row">
    <div class="col-lg-3">
        <div class="input-group">
            <input type="text" id = 'email' placeholder='填写您的邮箱' class="form-control" 
            <?php
                if ($userInfo['veri_email'] != NULL) 
                    echo "value = '".$userInfo['veri_email']."' disabled='disabled'" ;
                else if ($userInfo['email'] != NULL)
                    echo "value = '".$userInfo['email']."'";
            ?>></input>
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" <?php if ($userInfo['veri_email'] == NULL) echo "onclick='emailBundling()'" ?>><?php if ($userInfo['veri_email']!=NULL )echo "已"?>绑定邮箱</button>
            </span>
        </div>  
    </div>
  </div>
</div>

