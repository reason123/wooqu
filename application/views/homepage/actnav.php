<div style="padding:20px;">

<form class="form-horizontal">
  <div class="form-group">
    <label class="control-label col-lg-2">活动类型</label>
    <div class="col-lg-3">
      <select class="form-control" id="type-select" onchange="selectType()">
        <option value="-1" <?php if($actType=='null') echo 'selected="selected"'?>>请选择类型...</option>
        <option value="0" <?php if($actType=='normal') echo 'selected="selected"'?>>普通活动</option>
        <option value="1" <?php if($actType=='groupbuy') echo 'selected="selected"'?>>团购活动</option>
      </select>
    </div>
  </div>
</form>
<script type="text/javascript" src="/page/js/actnav.js"></script>
</div>