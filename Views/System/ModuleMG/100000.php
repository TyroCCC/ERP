<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="ie-comp">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width">
		<title>测试</title>
		<style>
		</style>
	</head>
	<body>
		<input type="button" class="btnTest" value="测试" />
		<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
		<script>
			(function(){
				$(function(){
					$.getJSON("../../../Data.php/Comm/r_Env/GetPageParam", function(data){
					});
				});

				$(".btnTest").on("click", function(){
					$.getJSON("../../../Data.php/Comm/r_Env/GetData" + window.location.search, function(data){
					});
				});
			})();
		</script>
	</body>
</html>