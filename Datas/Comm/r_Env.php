<?php

// 用于页面配置数据初始化、所有模块都会使用到





function GetPageBase($DBID, $FormID, $type){
	$sql = "select tb1.*,tb2.PageType from r_page_base as tb1 inner join g_page as tb2 on tb1.PageId=tb2.PageId where tb1.PageId='".$FormID."'";
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
	$sql = "select FormId as tmp_FormId,PostType as tmp_PostType,
		PageId,Id,FormId,FormName,FormType,Width,Height,BackgroundColor,DefaultVal,ValType,ComparisonSign,DBField,PostType,IsRequired,IsActive
	 	from r_page_form where PageId='".$FormID."' and IsActive=1";

	$tmp = DB::Instance()->Get2Arr($DBID, $sql);
	for($i=0; $i<count($tmp); $i++){
		$FormId = $tmp[$i][0]["value"];//表单
		$PostType = $tmp[$i][1]["value"];

		if($PostType == "get"){
			$v = ToolMethod::Instance()->GetUrlParam($FormId);//值
		}
		else if($PostType == "post"){
			$v = ToolMethod::Instance()->GetPostParam($FormId);
		}

		$tmp[$i][count($tmp[$i])] = array(
			"name" => "PreValue",
			"value" => $v
		);
	}
	if($type == "json"){
		$tmp = ToolMethod::Instance()->TranMy2Arr($tmp);
		return ToolMethod::Instance()->TwoArr2JsonWithPrimaryKey($tmp, "Id");
	}
	else{
		return $tmp;
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
			if($ComparisonSign == "like"){
				$whereStr .= " and ".$DBField." ".$ComparisonSign." '%".$FormId."%'";
			}
			else{
				if($ValType == "int"){
					$whereStr .= " and ".$DBField." ".$ComparisonSign." ".$FormId;
				}
				else if($ValType == "string"){
					$whereStr .= " and ".$DBField." ".$ComparisonSign." '".$FormId."'";
				}				
			}
		}
	}
	if($whereStr != ""){
		$whereStr = " where ".ltrim($whereStr, " and");
	}

	$sql = " select ".$field." from(".$tb.") as SelectTb".$whereStr;
	return $sql;
}




function Config(){
	$DBID = Config::Instance()->DB_Config;
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	if($PageId == ""){
		$PageId = ToolMethod::Instance()->GetPostParam("PageId");
	}

	$Base = GetPageBase($DBID, $PageId, "json");
	$Base = ltrim($Base, "[");
	$Base = rtrim($Base, "]");
	return '{"Base":'.$Base.',"Btn":'.GetPageBtn($DBID, $PageId, "json").',"Form":'.GetPageForm($DBID, $PageId, "json").',"Grid":'.GetPageGrid($DBID, $PageId, "json").'}';
}
function Data(){
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
	return DB::Instance()->PageJson($DBID, $PagingSql, $CountSql);
}





function GetConfig(){
	echo ToolMethod::Instance()->JsonWithStatus(function(){
		return Config();
	});
}

function GetData(){
	echo ToolMethod::Instance()->JsonWithStatus(function(){
		return Data();
	});
}

function GetConfigAndData(){
	echo ToolMethod::Instance()->JsonWithStatus(function(){
		return '{"Config":'.Config().',"Data":'.Data()."}";
	});
}

?>