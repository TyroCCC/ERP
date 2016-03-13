<?php

// 用于页面配置数据初始化、所有模块都会使用到





function GetPageBase($DBID, $PageId, $type){
	$sql = "select * from c_page_base where PageId='".$PageId."'";
	if($type == "json"){
		return DB::Instance()->GetJson($DBID, $sql);
	}
	else{
		return DB::Instance()->Get2Arr($DBID, $sql);
	}
}
function GetPageBtn($DBID, $PageId, $type){
	$sql = "select * from c_page_btn where PageId='".$PageId."' and IsActive=1";
	
	if($type == "json"){
		return DB::Instance()->GetJsonWithPrimaryKey($DBID, $sql, "Id");
	}
	else{
		return DB::Instance()->Get2Arr($DBID, $sql);
	}
}
function GetPageForm($DBID, $PageId, $type){
	$sql = "select * from c_page_form where PageId='".$PageId."' and IsActive=1";
	
	if($type == "json"){
		return DB::Instance()->GetJsonWithPrimaryKey($DBID, $sql, "Id");
	}
	else{
		return DB::Instance()->Get2Arr($DBID, $sql);
	}
}
function GetCreateSqlByParam($DBID, $PageId){
	$sql = "select DataSource from c_page_base where PageId='".$PageId."'";
	$tb = DB::Instance()->SingleVal($DBID, $sql, "DataSource");

	$sql = "select * from c_page_form where PageId='".$PageId."' and IsActive=1";
	$tmp = DB::Instance()->Get2Arr($DBID, $sql);
	$tmp = ToolMethod::Instance()->TranMy2Arr($tmp);

	$str1 = "";
	$str2 = "";
	foreach ($tmp as $key => $value) {
		$PostType = $value["PostType"];
		$FormId = $value["FormId"];
		$ValType = $value["ValType"];
		$DBField = $value["DBField"];

		if($PostType == "get"){
			$v = ToolMethod::Instance()->GetUrlParam($FormId);
		}
		else if($PostType == "post"){
			$v = ToolMethod::Instance()->GetPostParam($FormId);
		}

		if($v != "" && $DBField != ""){
			$str1 .= $DBField.",";

			if($ValType == "string"){
				$str2 .= "'".$v."',";
			}
			else if($ValType == "int"){
				$str2 .= $v.",";
			}
		}
	}
	return "insert into ".$tb."(".rtrim($str1, ",").") values(".rtrim($str2, ",").")";
}




function GetConfig(){
	echo ToolMethod::Instance()->JsonWithStatus(function(){
		$DBID = Config::Instance()->DB_Config;
		$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
		if($PageId == ""){
			$PageId = ToolMethod::Instance()->GetPostParam("PageId");
		}

		$Base = GetPageBase($DBID, $PageId, "json");
		$Base = ltrim($Base, "[");
		$Base = rtrim($Base, "]");
		return '{"Base":'.$Base.',"Btn":'.GetPageBtn($DBID, $PageId, "json").',"Form":'.GetPageForm($DBID, $PageId, "json").'}';
	});
}

function CreateData(){
	$DBID = Config::Instance()->DB_Config;
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	if($PageId == ""){
		$PageId = ToolMethod::Instance()->GetPostParam("PageId");
	}

	$sql = GetCreateSqlByParam($DBID, $PageId);
	echo DB::Instance()->Execute($DBID, $sql);
}

?>