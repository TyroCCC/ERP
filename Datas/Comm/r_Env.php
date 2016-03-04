<?php

// 用于页面配置数据初始化、所有模块都会使用到





function GetPageBase($DBID, $FormID, $type){
	$sql = "select * from r_page_base where PageId='".$FormID."'";
	if($type == "json"){
		return DB::Instance()->GetJson($DBID, $sql);
	}
	else{
		return DB::Instance()->Get2Arr($DBID, $sql);
	}
}
function GetPageBtn($DBID, $FormID, $type){
	$sql = "select * from r_page_btn where PageId='".$FormID."' and IsActive=1";
	if($type == "json"){
		return DB::Instance()->GetJsonWithPrimaryKey($DBID, $sql, "Id");
	}
	else{
		return DB::Instance()->Get2Arr($DBID, $sql);
	}
}
function GetPageForm($DBID, $FormID, $type){
	$sql = "select * from r_page_form where PageId='".$FormID."' and IsActive=1";
	if($type == "json"){
		return DB::Instance()->GetJsonWithPrimaryKey($DBID, $sql, "Id");
	}
	else{
		return DB::Instance()->Get2Arr($DBID, $sql);
	}
}
function GetPageGrid($DBID, $FormID, $type){
	$sql = "select * from r_page_grid where PageId='".$FormID."' and IsActive=1";
	if($type == "json"){
		return DB::Instance()->GetJsonWithPrimaryKey($DBID, $sql, "Id");
	}
	else{
		return DB::Instance()->Get2Arr($DBID, $sql);
	}
}
function GetSelectSqlByParam($DBID, $FormID){
	$tb = "";
	$Base = ToolMethod::Instance()->TranMy2Arr(GetPageBase($DBID, $FormID, "arr"));
	if(count($Base) == 1){
		$tb = $Base[0]["DataSource"];
	}
	
	$field = "";
	$Grid = ToolMethod::Instance()->TranMy2Arr(GetPageGrid($DBID, $FormID, "arr"));
	foreach ($Grid as $key => $value) {
		$field .= $value["FieldId"].",";
	}
	$field = rtrim($field, ",");

	$whereStr = "";
	$Form = ToolMethod::Instance()->TranMy2Arr(GetPageForm($DBID, $FormID, "arr"));
	foreach ($Form as $key => $value) {
		if($value["PostType"] == "get"){
			$FormId = ToolMethod::Instance()->GetUrlParam($value["FormId"]);
		}
		else{
			$FormId = ToolMethod::Instance()->GetPostParam($value["FormId"]);
		}

		$DBField = $value["DBField"];
		$ComparisonSign = $value["ComparisonSign"];
		$ValType = $value["ValType"];
		
		if($FormId != ""){
			if($ValType == "int"){
				$whereStr .= " and ".$DBField." ".$ComparisonSign." ".$FormId;
			}
			else if($ValType == "string"){
				$whereStr .= " and ".$DBField." ".$ComparisonSign." '".$FormId."'";
			}
		}
	}
	if($whereStr != ""){
		$whereStr = " where ".ltrim($whereStr, " and");
	}

	$sql = " select ".$field." from(".$tb.") as SelectTb".$whereStr;
	return $sql;
}




function GetPageParam(){
	$DBID = Config::Instance()->DB_Config;
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	if($PageId == ""){
		$PageId = ToolMethod::Instance()->GetPostParam("PageId");
	}

	$Base = GetPageBase($DBID, $PageId, "json");
	$Base = ltrim($Base, "[");
	$Base = rtrim($Base, "]");
	echo '{"Base":'.$Base.',"Btn":'.GetPageBtn($DBID, $PageId, "json").',"Form":'.GetPageForm($DBID, $PageId, "json").',"Grid":'.GetPageGrid($DBID, $PageId, "json").'}';
}
function GetData(){
	$DBID = Config::Instance()->DB_Config;
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	if($PageId == ""){
		$PageId = ToolMethod::Instance()->GetPostParam("PageId");
	}
	
	$sql = GetSelectSqlByParam($DBID, $PageId);

	$rows = ToolMethod::Instance()->GetEasyUiDataGridRows();
	$page = ToolMethod::Instance()->GetEasyUiDataGridPage();

	$PagingSql = ToolMethod::Instance()->GetPagingSql($sql, $rows, $page);
	$CountSql = ToolMethod::Instance()->GetCountSql($sql);
	echo DB::Instance()->PageJson($DBID, $PagingSql, $CountSql);
}

?>