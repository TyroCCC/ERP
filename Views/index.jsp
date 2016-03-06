<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">
    
    <title></title>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="page">
	
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	
	<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
	<script type="text/javascript" src="js/unslider.js"></script>
	<script>
	
		window.onload = function() {
			$('.banner').unslider({
				speed: 500,               //  滚动速度
				delay: 3000,              //  动画延迟
				complete: function() {},  //  动画完成的回调函数
				keys: true,               //  启动键盘导航
				dots: true,               //  显示点导航
				fluid: false              //  支持响应式设计
			});
		
		}
	</script>
  </head>
  
  <body>
  	<div class="navmenu">
  		<div class="content">
  			<ul>
  				<li>
  					<a>主页</a>
  				</li>
  				<li>
  					<a>产品中心</a>
  				</li>
  				<li>
  					<a>最新动态</a>
  				</li>
  			</ul>
  		</div>
  	</div>
  	<div class="banner">
  		<ul>
  			<li>This is a slide.</li>
  			<li>This is another slide.</li>
  			<li>This is a final slide.</li>
  		</ul>
  	</div>
  </body>
</html>
