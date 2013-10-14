<?php 
    if (!isset($_GET['id'])) echo '<a class="btn btn-default" style="margin-bottom: 10px;" href="/manager/goods">返回商品管理</a>'; 
    if (isset($_GET['id'])) echo '<a class="btn btn-default" style="margin-bottom: 10px;" href="/manager/groupbuy_goods?id='.$_GET['id'].'">返回商品管理</a>'; 
?>
<legend>新增商品</legend>
<form class="pubForm form-horizontal" action="/goods/newGoods<?php if (isset($_GET['id'])) echo '?id='.$_GET['id']; ?>" method = "post" enctype="multipart/form-data">
    <div class="form-group" >
        <label class="control-label col-lg-2">商品名称</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="name" value="<?php if (isset($goodsinfo["name"])) echo $goodsInfo["name"]; ?>">
            <?php echo form_error('name',"<span class='error'>","</span>");?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-2">商品图片</label>
        <div class="col-lg-3">
            <input type="file" name="pic" value="<?php if (isset($goodsinfo["pic"])) echo $goodsInfo["pic"]; ?>">
        </div>
    </div>
    <div class="form-group" >
        <label class="control-label col-lg-2">商品价格</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="price" value="<?php if (isset($goodsinfo["price"])) echo $goodsinfo["price"]; ?>">
            <?php echo form_error('price',"<span class='error'>","</span>");?>
        </div>
     </div>

     <div class="form-group" >
        <label class="control-label col-lg-2">商品单位</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="priceType" value="<?php if (isset($goodsinfo["priceType"])) echo $goodsinfo["priceType"]; ?>">
            <?php echo form_error('priceType',"<span class='error'>","</span>");?>
        </div>
     </div>

     <div class="form-group">
        <label class="control-label col-lg-2">商品介绍</label>
        <div class="col-lg-5">
            <textarea rows="5" name="detail" class="form-control" value="<?php if (isset($goodsinfo["detail"])) echo $goodsinfo["detail"]; ?>"></textarea>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2"></label>
        <div class="col-lg-3">
            <input type="submit" class="btn btn-default">
        </div>
     </div>
</form>