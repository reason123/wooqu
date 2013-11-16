<legend><?php echo $title ?>&nbsp;&nbsp;&nbsp;报名表信息</legend>
<table class="table table-hover">
  <thead>
    <tr>
      <th>ID</th>
<?php foreach($s_form as $key => $item){
     if($item[1] == -1 || $item[1] > 0){
         echo '<th>'.$item[0].'</th>';
     }
 }?>
    </tr>
  </thead>
  <tbody>
    <tr>
<?php foreach($e_form_list as $key => $e_form){
     echo '<td>'.$e_form['ID'].'</td>';
     $formInfo = json_decode($e_form['content'],true);
     foreach($formInfo as $index => $val){
         echo '<td>'.$val.'</td>';
     }
 }?>
    </tr>
  </tbody>
</table>