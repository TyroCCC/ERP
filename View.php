<?php

//页面统一入口 

$url = $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];

$arr = explode("/", $url);

if(count($arr) == 4){
	require_once("./Views/".$arr[3].".php");
}
else{
	if(count($arr) == 6){
		$module = $arr[3];
		$controller = $arr[4];
		$action =  $arr[5];
	}
	else{
		echo "404 Not Found";
		return;
	}

	if($action == ""){
		echo "404 Not Found";
		return;
	}

	require_once('./Comms/Config.php');//配置信息
	require_once('./Comms/ToolMethod.php');//常用方法
	require_once('./Comms/SqlHelper.php');//数据库基础操作
	require_once('./Comms/DB.php');//本项目数据库操作
	require_once('./Comms/User.php');//本项目登录用户操作

	$sql = "select * from g_page where IsActive=1 and PageId='".$action."'";
	$type = DB::Instance()->SingleVal(Config::Instance()->DB_Config, $sql, "PageType");

	if($type != ""){
		require_once("./Views/Templates/".$type."_Template.php");
	}
	else{
		echo "404 Not Found";
	}
}

?>