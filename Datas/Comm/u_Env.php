<?php

// 用于页面配置数据初始化、所有模块都会使用到





function GetPageBase($DBID, $PageId, $type){
	$sql = "select * from u_page_base where PageId='".$PageId."'";
	if($type == "json"){
		return DB::Instance()->GetJson($DBID, $sql);
	}
	else{
		return DB::Instance()->Get2Arr($DBID, $sql);
	}
}
function GetPageBtn($DBID, $PageId, $type){
	$sql = "select * from u_page_btn where PageId='".$PageId."' and IsActive=1";
	
	if($type == "json"){
		return DB::Instance()->GetJsonWithPrimaryKey($DBID, $sql, "Id");
	}
	else{
		return DB::Instance()->Get2Arr($DBID, $sql);
	}
}
function GetPageForm($DBID, $PageId, $type){
	$sql = "select * from r_page_grid where PageId='".$PageId."' and IsPk=1";//主键
	$tmp = DB::Instance()->Get2Arr($DBID, $sql);
	$tmp = ToolMethod::Instance()->TranMy2Arr($tmp);

	$whereSql = "";
	foreach ($tmp as $key => $value) {
		$PostType = $value["PostType"];
		$FieldId = $value["FieldId"];
		if($PostType == "get"){
			$v = ToolMethod::Instance()->GetUrlParam($FieldId);
		}
		else if($PostType == "post"){
			$v = ToolMethod::Instance()->GetPostParam($FieldId);
		}
		$whereSql .= " and ".$FieldId."='".$v."'";
	}
	$sql = "select DataSource from r_page_base where PageId='".$PageId."'";
	$tb = DB::Instance()->SingleVal($DBID, $sql, "DataSource");
	$sql = "select * from(".$tb.") as resultTb where ".ltrim($whereSql ," and");
	$tmp = DB::Instance()->Get2Arr($DBID, $sql);

	$sql = "select * from u_page_form where PageId='".$PageId."' and IsActive=1";
	$tmp1 = DB::Instance()->Get2Arr($DBID, $sql);

	for($i=0; $i<count($tmp1); $i++){
		$tmp_len1=count($tmp1[$i]);
		for($j=0; $j<$tmp_len1; $j++){

			if($tmp1[$i][$j]["name"] == "FormId"){//关联对应表单的数据
				for($k=0; $k<count($tmp); $k++){
					$tmp_len=count($tmp[$k]);
					for($h=0; $h<count($tmp[$k]); $h++){
						if($tmp[$k][$h]["name"] == $tmp1[$i][$j]["value"]){
							
							$tmp1[$i][$tmp_len1] = array(
								"name" => "PreValue",
								"value" => $tmp[$k][$h]["value"]
							);
							
						}

					}
				}

			}

		}
	}

	if($type == "json"){
		$tmp1 = ToolMethod::Instance()->TranMy2Arr($tmp1);
		return ToolMethod::Instance()->TwoArr2JsonWithPrimaryKey($tmp1, "Id");
	}
	else{
		return $tmp1;
	}

}
function GetUpdateSqlByParam($DBID, $PageId){
	$sql = "select DataSource from u_page_base where PageId='".$PageId."'";
	$tb = DB::Instance()->SingleVal($DBID, $sql, "DataSource");

	$sql = "select * from r_page_grid where PageId='".$PageId."' and IsPk=1";//主键
	$tmp = DB::Instance()->Get2Arr($DBID, $sql);
	$tmp = ToolMethod::Instance()->TranMy2Arr($tmp);

	$str1 = "";
	foreach ($tmp as $key => $value) {
		$PostType = $value["PostType"];
		$FieldId = $value["FieldId"];
		if($PostType == "get"){
			$v = ToolMethod::Instance()->GetUrlParam("old_".$FieldId);
		}
		else if($PostType == "post"){
			$v = ToolMethod::Instance()->GetPostParam("old_".$FieldId);
		}
		$str1 .= " and ".$FieldId."='".$v."'";
	}

	$sql = "select * from u_page_form where PageId='".$PageId."' and IsActive=1";
	$tmp = DB::Instance()->Get2Arr($DBID, $sql);
	$tmp = ToolMethod::Instance()->TranMy2Arr($tmp);

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
			if($ValType == "string"){
				$str2 .= $DBField."='".$v."',";
			}
			else if($ValType == "int"){
				$str2 .= $DBField."=".$v.",";
			}
		}
	}
	return "update ".$tb." set ".rtrim($str2, ",")." where ".ltrim($str1, " and");
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
		return '{"Config":{"Base":'.$Base.',"Btn":'.GetPageBtn($DBID, $PageId, "json").',"Form":'.GetPageForm($DBID, $PageId, "json").'}}';
	});
}

function UpdateData(){
	$DBID = Config::Instance()->DB_Config;
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	if($PageId == ""){
		$PageId = ToolMethod::Instance()->GetPostParam("PageId");
	}

	$sql = GetUpdateSqlByParam($DBID, $PageId);
	echo DB::Instance()->Execute($DBID, $sql);
}

?>