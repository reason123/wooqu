<legend>团购商品</legend>
<form class="pubForm form-horizontal" action="/groupbuy/modGoods?goodsID=<?php echo $_GET['goodsID'].'&';?>groupbuyID=<?php echo $_GET['groupbuyID'];?>" method = "post" enctype="multipart/form-data">
    <div class="form-group" >
        <label class="control-label col-lg-2">团购价格</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="price" value ="<?php echo $_REQUEST['price']?>">
            <?php echo form_error('price',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2"></label>
        <div class="col-lg-3">
            <input type="submit" class="btn btn-default">
        </div>
     </div>
</form>