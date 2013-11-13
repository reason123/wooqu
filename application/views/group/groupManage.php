<legend>新增群组</legend>
<div class = "container">
    <div class = "form-horizontal">
        <div class = "control-group">
            <div class = "control-label">群组名称</div>
            <div class = "controls">
                <input type="text" id="groupName" placeholder="shop name" value="<?php if(isset($shopName)) echo $shopName; ?>">
            </div>
        </div>
        <div class="control-group">
            <div class = "control-label">群组类型</div>
            <div class = "controls">
                <select id='type'>
                    <option value='-1'>请选择群组类型</option>
                    <option value='0'>校级群组</option>
                    <option value='1'>院系群组</option>
                    <option value='2'>班级群组</option>
                    <option value='3'>其他群组（社团等）</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <div class = "control-label">上层ID</div>
            <div class = "controls">
                <input type="text" id="parentID"/>
            </div>
        </div>
        <div class="control-group">
            <div class = "controls">
                <button class ="btn" onclick="addGroup()">添加群组</button>
            </div>
        </div>
    </div>
</div>
<legend>群组列表</legend>
<table id="hehe" class="table table-hover">
  <thead>
    <tr>
    <th data-sort="int" class="">int</th>
    <th data-sort="float" class="sorting-asc">float</th>
    <th data-sort="string" class="">string</th>
    </tr>
  </thead>
  <tbody>
    
      
      
    
    
  <tr>
      <td>195</td>
      <td>-858</td>
      <td>orange</td>
    </tr><tr>
      <td>2</td>
      <td>-152.5</td>
      <td>apple</td>
    </tr><tr>
      <td>15</td>
      <td>-.18</td>
      <td>banana</td>
    </tr><tr>
      <td>95</td>
      <td>36</td>
      <td>coke</td>
    </tr><tr>
      <td>-53</td>
      <td>88.5</td>
      <td>zebra</td>
    </tr></tbody>
</table>