<legend>
类型
</legend>
<div class="row">
    <div class="col-lg-6">
         <div class="input-group">
            <input type="text"  class="form-control"></input>
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="addtype()">添加类型</button>
            </span>
        </div><!-- /input-group -->
    </div><!-- /.col-lg-6 -->
    <div class="btn-group">
        <?php
//            echo json_encode($typeList);
            foreach ($typeList as $key=>$value ) {       
                echo "<a type='button' class='btn btn-default' herf=''>".$value."</a>";
            }
        ?>
    </div>
</div><!-- /.row -->
