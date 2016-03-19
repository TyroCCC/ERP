<?php

// 用于页面配置数据初始化、所有模块都会使用到





function GetPageBase($DBID, $PageId, $type){
	$sql = "select * from d_page_base where PageId='".$PageId."'";
	if($type == "json"){
		return DB::Instance()->GetJson($DBID, $sql);
	}
	else{
		return DB::Instance()->Get2Arr($DBID, $sql);
	}
}
function GetPageBtn($DBID, $PageId, $type){
	$sql = "select * from d_page_btn where PageId='".$PageId."' and IsActive=1";
	
	if($type == "json"){
		return DB::Instance()->GetJsonWithPrimaryKey($DBID, $sql, "Id");
	}
	else{
		return DB::Instance()->Get2Arr($DBID, $sql);
	}
}
function GetDeleteSqlByParam($DBID, $PageId){
	$sql = "select DataSource from d_page_base where PageId='".$PageId."'";
	$tb = DB::Instance()->SingleVal($DBID, $sql, "DataSource");

	$sql = "select * from r_page_grid where PageId='".$PageId."' and IsPk=1";//主键
	$tmp = DB::Instance()->Get2Arr($DBID, $sql);
	$tmp = ToolMethod::Instance()->TranMy2Arr($tmp);

	$str1 = "";
	foreach ($tmp as $key => $value) {
		$FieldId = $value["FieldId"];
		$str1 .= $FieldId.",";
	}

	$DelPK = ToolMethod::Instance()->GetUrlParam("DelPK");
	if($DelPK == ""){
		$DelPK = ToolMethod::Instance()->GetPostParam("DelPK");
	}

	$DelPK = explode(",", $DelPK);
	$str2 = "";
	foreach ($DelPK as $key => $value) {
		$str2 .= "'".$value."',";
	}

	return "delete from ".$tb." where concat(".rtrim($str1, ",").") in (".rtrim($str2, ",").")";
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
		return '{"Config":{"Base":'.$Base.',"Btn":'.GetPageBtn($DBID, $PageId, "json").'}}';
	});
}

function DeleteData(){
	$DBID = Config::Instance()->DB_Config;
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	if($PageId == ""){
		$PageId = ToolMethod::Instance()->GetPostParam("PageId");
	}

	$sql = GetDeleteSqlByParam($DBID, $PageId);
	echo DB::Instance()->Execute($DBID, $sql);
}

?>