<?php

// 依赖 SqlHelper Class, 返回自定义格式的 json

class DB{

	//单例模式
	static private $_instance;
	private function __construct() { }
	static public function Instance() {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function GetFirstRow($DBID, $sql){
		return SqlHelper::Instance()->GetFirstRow($DBID, $sql);
	}

	public function SingleVal($DBID, $sql, $key){
		return SqlHelper::Instance()->SingleVal($DBID, $sql, $key);
	}

	public function Get2Arr($DBID, $sql){
		return SqlHelper::Instance()->Get2Arr($DBID, $sql);
	}

	public function GetJson($DBID, $sql){
		$arr = SqlHelper::Instance()->GetJson($DBID, $sql);
		return $arr[1];
	}

	public function UnPageJson($DBID, $sql){
		$arr = SqlHelper::Instance()->GetJson($DBID, $sql);
		$total = $arr[0];
		$rows = $arr[1];
		return '{"total":'.$total.',"rows":'.$rows.'}';
	}

	public function UnPageSummaryJson($DBID, $sql, $SummarySql){
		$arr = SqlHelper::Instance()->GetJson($DBID, $sql);
		$total = $arr[0];
		$rows = $arr[1];
		$arr = SqlHelper::Instance()->GetJson($DBID, $SummarySql);
		$footer = $arr[1];
		return '{"total":'.$total.',"rows":'.$rows.',"footer":'.$footer.'}';
	}

	public function PageJson($DBID, $PagingSql, $CountSql){
		$total = SqlHelper::Instance()->SingleVal($DBID, $CountSql, "total");
		$arr = SqlHelper::Instance()->GetJson($DBID, $PagingSql);
		$rows = $arr[1];
		return '{"total":'.$total.',"rows":'.$rows.'}';
	}

	public function PageSummaryJson($DBID, $PagingSql, $SummarySql, $CountSql){
		$total = SqlHelper::Instance()->SingleVal($DBID, $CountSql, "total");
		$arr = SqlHelper::Instance()->GetJson($DBID, $PagingSql);
		$rows = $arr[1];
		$arr = SqlHelper::Instance()->GetJson($DBID, $SummarySql);
		$footer = $arr[1];
		return '{"total":'.$total.',"rows":'.$rows.',"footer":'.$footer.'}';
	}

	public function Execute($DBID, $sql){
		$result = "";
		$result = SqlHelper::Instance()->Execute($DBID, $sql);
		if($result[0] == "OK"){
			$result = '{"result": "'.$result[0].'","rows":'.$result[1].'}';
		}
		else{
			$result = '{"result": "'.$result[0].'","reason":"'.$result[1].'"}';
		}
		return $result;
	}













	// 测试代码 用于动态生成 sql
	public function GetTbColumnName($DBID, $tb){
		$sql = "select column_name
			from information_schema.columns 
			where table_name = '".$tb."' and table_schema = 'config'";
		return SqlHelper::Instance()->Get2Arr($DBID, $sql);
	}
	public function GetSelectSql($DBID, $tb, $type){
		$colomnsArr = self::GetTbColumnName($DBID, $tb);
		$str = "";
		for ($i=0; $i < count($colomnsArr); $i++) {
			$k = $colomnsArr[$i][0]["value"];//键

			if($type == "get"){
				$v = ToolMethod::Instance()->GetUrlParam($k);//值
			}
			else if(type == "post"){
				$v = ToolMethod::Instance()->GetPostParam($k);
			}
			if($v != ""){
				$str .= " and ".$k." like '%".$v."%'";
			}
		}
		if($str != ""){
			$str = " where ".ltrim($str, " and");
		}
		return "select * from ".$tb.$str;
	}
	public function GetInsertSql($DBID, $tb, $type){
		$colomnsArr = self::GetTbColumnName($DBID, $tb);
		$str = "";
		$str1 = "";
		for ($i=0; $i < count($colomnsArr); $i++) {
			$k = $colomnsArr[$i][0]["value"];//键

			if($type == "get"){
				$v = ToolMethod::Instance()->GetUrlParam($k);//值
			}
			else if(type == "post"){
				$v = ToolMethod::Instance()->GetPostParam($k);
			}
			if($v != ""){
				$str .= "'".$v."',";
				$str1 .= $k.",";
			}
		}
		$str = rtrim($str, ",");
		$str1 = rtrim($str1, ",");

		return "insert into ".$tb."(".$str1.") values(".$str.")";
	}
	public function GetDeleteSql($DBID, $tb, $type){
		$colomnsArr = self::GetTbColumnName($DBID, $tb);
		$str = "";
		for ($i=0; $i < count($colomnsArr); $i++) {
			$k = $colomnsArr[$i][0]["value"];//键

			if($type == "get"){
				$v = ToolMethod::Instance()->GetUrlParam($k);//值
			}
			else if(type == "post"){
				$v = ToolMethod::Instance()->GetPostParam($k);
			}
			if($v != ""){
				$str .= " and ".$k."='".$v."'";
			}
		}
		if($str != ""){
			$str = " where ".ltrim($str, " and");
		}
		return "delete from ".$tb.$str;
	}
	public function GetModifySql($DBID, $tb, $type){
		$colomnsArr = self::GetTbColumnName($DBID, $tb);
		$str = "";
		$str1 = "";
		for ($i=0; $i < count($colomnsArr); $i++) {
			$k = $colomnsArr[$i][0]["value"];//键

			if($type == "get"){
				$v = ToolMethod::Instance()->GetUrlParam($k);//值
			}
			else if(type == "post"){
				$v = ToolMethod::Instance()->GetPostParam($k);
			}
			if($v != ""){
				$str .= $k."="."'".$v."',";
			}

			//筛选条件
			if($type == "get"){
				$v1 = ToolMethod::Instance()->GetUrlParam("old_".$k);//值
			}
			else if(type == "post"){
				$v1 = ToolMethod::Instance()->GetPostParam("old_".$k);
			}
			if($v1 != ""){
				$str1 .= " and ".$k."="."'".$v1."'";
			}
		}
		$str = rtrim($str, ",");
		if($str1 != ""){
			$str1 = " where ".ltrim($str1, " and");
		}

		return "update ".$tb." set ".$str.$str1;
	}











































	
	// // 获取查询参数、返回字段、查询类型,用于sql拼接
	// public function GetPageParamForSql($DBID){
	// 	$PageId = ToolMethod::Instance()->GetPageId();
	// 	$sql = "select ParamsId,FieldsId,QuerysType from config_page_param where PageId='".$PageId."'";
	// 	$tmp = DB::Instance()->GetFirstRow($DBID, $sql);

	// 	$ParamsId = rtrim($tmp["ParamsId"], ",");//查询条件参数列表
	// 	$FieldsId = rtrim($tmp["FieldsId"], ",");//返回字段参数列表
	// 	$QuerysType = rtrim($tmp["QuerysType"], ",");// = 或者 like 的过滤条件

	// 	$result = array(
	// 		"ParamsId" => $ParamsId,
	// 		"FieldsId" => $FieldsId,
	// 		"QuerysType" => $QuerysType
	// 	);
	// 	return $result;
	// }

	// // 根据配置数据 生成 查询 sql
	// public function GetSelectSql($DBID, $sql){
	// 	$Params = self::GetPageParamForSql($DBID);//获取数据库的页面配置数据
	// 	$FieldsId = $Params["FieldsId"];
	// 	$ParamsId = explode(",", $Params["ParamsId"]);
	// 	$QuerysType = explode(",", $Params["QuerysType"]);

	// 	$sql_where = "";
	// 	for ($i=0; $i < count($ParamsId); $i++) {
	// 		$tmp1 = $QuerysType[$i];
	// 		$tmp2 = $ParamsId[$i];

	// 		$tmp3 = ToolMethod::Instance()->GetUrlParam($tmp2);
	// 		if($tmp3 == ""){
	// 			$tmp3 = ToolMethod::Instance()->GetPostParam($tmp2);
	// 		}

	// 		if($tmp1 == "like" && $tmp3 != ""){
	// 			$sql_where .= " and ".$tmp2." ".$tmp1." '%".$tmp3."%'";
	// 		}
	// 		elseif($tmp1 == "=" && $tmp3 != "") {
	// 			$sql_where .= " and ".$tmp2." ".$tmp1." '".$tmp3."'";
	// 		}
	// 	}
	// 	return "select ".$FieldsId." from(".$sql.") as ResultTb where ".ltrim($sql_where, " and");
	// }

	// // 根据配置数据 生成 插入 sql
	// public function GetInsertSql($DBID, $tb){
	// 	$Params = self::GetPageParamForSql($DBID);//获取数据库的页面配置数据
	// 	$ParamsId = explode(",", $Params["ParamsId"]);

	// 	$str = "";
	// 	for ($i=0; $i < count($ParamsId); $i++) {
	// 		$tmp = ToolMethod::Instance()->GetUrlParam($ParamsId[$i]);
	// 		if($tmp == ""){
	// 			$tmp = ToolMethod::Instance()->GetPostParam($ParamsId[$i]);
	// 		}
	// 		$str .= "'".$tmp."',";
	// 	}
	// 	return "insert into ".$tb."(".$Params["ParamsId"].") values(".rtrim($str, ",").")";
	// }

	// // 根据配置数据 生成 删除 sql
	// public function GetDeleteSql($DBID, $tb){
	// 	$Params = self::GetPageParamForSql($DBID);//获取数据库的页面配置数据
	// 	$ParamsId = explode(",", $Params["ParamsId"]);
	// 	$QuerysType = explode(",", $Params["QuerysType"]);

	// 	$sql_where = "";
	// 	for ($i=0; $i < count($ParamsId); $i++) {
	// 		$tmp1 = $QuerysType[$i];
	// 		$tmp2 = $ParamsId[$i];

	// 		$tmp3 = ToolMethod::Instance()->GetUrlParam($tmp2);
	// 		if($tmp3 == ""){
	// 			$tmp3 = ToolMethod::Instance()->GetPostParam($tmp2);
	// 		}

	// 		if($tmp1 == "like" && $tmp3 != ""){
	// 			$sql_where .= " and ".$tmp2." ".$tmp1." '%".$tmp3."%'";
	// 		}
	// 		elseif($tmp1 == "=" && $tmp3 != "") {
	// 			$sql_where .= " and ".$tmp2." ".$tmp1." '".$tmp3."'";
	// 		}
	// 	}
	// 	return "delete from ".$tb." where ".ltrim($sql_where, " and");
	// }

	// // 根据配置数据 生成 修改 sql
	// public function GetModifySql($DBID, $tb){
	// 	$Params = self::GetPageParamForSql($DBID);//获取数据库的页面配置数据
	// 	$ParamsId = explode(",", $Params["ParamsId"]);
	// 	$QuerysType = explode(",", $Params["QuerysType"]);

	// 	$str = "";
	// 	$sql_where = "";
	// 	for ($i=0; $i < count($ParamsId); $i++) {
	// 		$tmp1 = $QuerysType[$i];
	// 		$tmp2 = $ParamsId[$i];

	// 		$tmp3 = ToolMethod::Instance()->GetUrlParam("old_".$tmp2);
	// 		if($tmp3 == ""){
	// 			$tmp3 = ToolMethod::Instance()->GetPostParam("old_".$tmp2);
	// 		}
	// 		if($tmp1 == "like" && $tmp3 != ""){
	// 			$sql_where .= " and ".$tmp2." ".$tmp1." '%".$tmp3."%'";
	// 		}
	// 		elseif($tmp1 == "=" && $tmp3 != "") {
	// 			$sql_where .= " and ".$tmp2." ".$tmp1." '".$tmp3."'";
	// 		}

	// 		$tmp3 = ToolMethod::Instance()->GetUrlParam($tmp2);
	// 		if($tmp3 == ""){
	// 			$tmp3 = ToolMethod::Instance()->GetPostParam($tmp2);
	// 		}
	// 		$str .= $tmp2."='".$tmp3."',";
	// 	}
	// 	return "update ".$tb." set ".rtrim($str, ",")." where ".ltrim($sql_where, " and");
	// }

}

?>