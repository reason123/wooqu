<a class="btn btn-default" style="margin-bottom: 10px;" href="/manager/goods">返回商品管理</a>
<legend>修改商品</legend>
<form class="pubForm form-horizontal" action="/goods/modGoods?goodsID=<?php echo $goodsID;?>" method = "post" enctype="multipart/form-data">
    <div class="form-group" >
        <label class="control-label col-lg-2">商品名称</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="name" value ="<?php echo $goodsInfo['name']?>">
            <?php echo form_error('name',"<span class='error'>","</span>");?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-2">商品图片</label>
        <div class="col-lg-3">
            <input type="file" name="pic" value ="<?php echo $goodsInfo['pic']?>">
        </div>
    </div>
    <div class="form-group" >
        <label class="control-label col-lg-2">商品价格</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="price" value ="<?php echo $goodsInfo['price']?>">
            <?php echo form_error('price',"<span class='error'>","</span>");?>
        </div>
     </div>

     <div class="form-group" >
        <label class="control-label col-lg-2">商品单位</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="priceType" value ="<?php echo $goodsInfo['priceType']?>">
            <?php echo form_error('priceType',"<span class='error'>","</span>");?>
        </div>
     </div>

     <div class="form-group">
        <label class="control-label col-lg-2">商品介绍</label>
        <div class="col-lg-5">
            <textarea rows="5" name="detail" class="form-control" value ="<?php echo $goodsInfo['detail']?>"></textarea>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2"></label>
        <div class="col-lg-3">
            <input type="submit" class="btn btn-default">
        </div>
     </div>
</form>