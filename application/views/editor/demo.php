<html>
	<head>
		<script charset="utf-8" src="/page/kindeditor/kindeditor.js"></script>
		<script charset="utf-8" src="/page/kindeditor/lang/zh_CN.js"></script>
		<script>
		        KindEditor.ready(function(K) {
		                window.editor = K.create('#editor_id');
			});
			var options = {
				cssPath : '/page/kindeditor/css/index.css',
				filterMode : true
			};
			var editor = K.create('textarea[name="content"]', options);
		</script>
		
		<script type="text/javascript">
			function $(id) {
				return document.getElementById(id);
			}
			function showContent() {
				var board = $("debug");
				board.innerHTML = editor.html();
			}
		</script>
	</head>
	<body>
		<textarea id="editor_id" name="content" style="width:700px;height:300px;">
		test
		</textarea>
		<input value="submit" type="submit" onclick="showContent();"/><br>
		<span id="debug"></span>
	</body>
</html>
