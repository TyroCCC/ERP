<?php

//页面统一入口 

require_once('./Comms/Config.php');//配置信息
require_once('./Comms/ToolMethod.php');//常用方法
require_once('./Comms/SqlHelper.php');//数据库基础操作
require_once('./Comms/DB.php');//本项目数据库操作
require_once('./Comms/User.php');//本项目登录用户操作

$url = $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];

$arr = explode("/", $url);

if(count($arr) == 3){
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	if($PageId == ""){
		$PageId = ToolMethod::Instance()->GetPostParam("PageId");
	}

	if($PageId == ""){
		echo "404 Not Found";
	}
	else{
		
		$sql = "select * from g_page where IsActive=1 and PageId='".$PageId."'";
		$type = DB::Instance()->SingleVal(Config::Instance()->DB_Config, $sql, "PageType");

		if($type != ""){
			require_once("./Views/Templates/".$type."_Template.php");
		}
		else{
			echo "404 Not Found";
		}
	}
}
else if(count($arr) == 4){
	@require_once("./Views/".$arr[3].".php");
}
else{
	echo "404 Not Found";
}

?>