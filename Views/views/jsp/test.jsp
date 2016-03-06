<%@ page language="java" import="java.util.*" pageEncoding="utf-8"%>
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
	
	<link rel="stylesheet" type="text/css" href="css/dialog.css">
	
	<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
	<script type="text/javascript" src="js/utils-1.0.0.js"></script>
	
	<script type="text/javascript">
		window.onload = function() {
			utils.resize();
			//dragBar.init($(document));
		};
		
		window.onresize = function() {
			utils.resize();
		};
	</script>
  </head>
  
  <body>
  	<div class="dialog">
  		<div class="top">
  			<div class="resize_wn"></div>
  			<div class="resize_n" UI_ReSize="width"></div>
  			<div class="resize_en"></div>
  		</div>
  		<div class="center" UI_ReSize="height">
  			<div class="resize_w"></div>
  			<div class="content" UI_ReSize="width"></div>
  			<div class="resize_e"></div>
  		</div>
  		<div class="bottom">
  			<div class="resize_ws"></div>
  			<div class="resize_s" UI_ReSize="width"></div>
  			<div class="resize_es"></div>
  		</div>
  	</div>
  </body>
</html>
