<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">
    
    <title>登录页面</title>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="登录界面">
	
	<link rel="stylesheet" type="text/css" href="css/wr.login.css">
	
	<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
	<script type="text/javascript" src="js/wr.login-1.0.0.js"></script>
	<script type="text/javascript" src="js/other/security.js"></script>
	<script type="text/javascript">
		$(function() {
			wr_login.init();
		});
	</script>
  </head>
  
  <body>
  	<div>
  		<form action="<%=path%>/login" onsubmit="wr_login.login(this);return false;">
  			<div>
  				用户:
  			</div>
  			<div>
  				<input type="text" name="user" data-type="text">
  			</div>
  			<div>
  				密码:
  			</div>
  			<div>
  				<input type="password" name="password" data-type="rsapassword">
  			</div>
  			<div>
  				<input type="submit" value="登录">
  			</div>
  		</form>
  		<form id="loginForm" action="<%=path%>/login" style="display:none;">
  		</form>
  	</div>
  </body>
</html>
