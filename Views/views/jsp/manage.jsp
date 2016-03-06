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
	
	<link rel="stylesheet" type="text/css" href="css/base.css">
	
	<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
	<script type="text/javascript" src="js/utils-1.0.0.js"></script>
	<script type="text/javascript" src="js/dragbar-1.0.0.js"></script>
	
	<script type="text/javascript">
		window.onload = function() {
			utils.resize();
			dragBar.init($(document));
		};
		
		window.onresize = function() {
			utils.resize();
		};
	</script>
  </head>
  
  <body>
  	<div id="basepage" class="basepage">
    	<div id="headpage" class="headpage">
    	</div>
    	<div class="verticaldragbar" UI_VerticalDragBar="previous"></div>
    	<div id="centerpage" class="centerpage" UI_ReSize="height" >
        	<div id="leftpage" class="leftpage" ></div>
        	<div class="horizontaldargbar" UI_HorizontalDragBar="previous"></div>
        	<div id="rightpage" class="rightpage" UI_ReSize="width"></div>
    	</div>
    	<div class="verticaldragbar" UI_VerticalDragBar="next"></div>
    	<div id="bottompage" class="bottompage"></div>
    </div>
    <div id="popupage" class="popuppage"></div>
  </body>
</html>
