<?php

// 模块管理





// 获取模块数据
function GetModule(){
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");
	$ModuleName = ToolMethod::Instance()->GetUrlParam("ModuleName");
	$IsActive = ToolMethod::Instance()->GetUrlParam("IsActive");
	
	$rows = ToolMethod::Instance()->GetUrlParam("rows");//行数
	$page = ToolMethod::Instance()->GetUrlParam("page");//页码

	$str = "";
	if($ModuleId != ""){
		$str .= " and ModuleId like '".$ModuleId."'";
	}
	if($ModuleName != ""){
		$str .= " and ModuleName like '".$ModuleName."'";
	}
	if($IsActive != ""){
		$str .= " and IsActive = '".$IsActive."'";
	}
	if($str != ""){
		$str = " where ".ltrim($str, " and");
	}

	$sql = "select ModuleId,ModuleName,IsActive,Seq
		from g_module
		".$str."
		order by Seq
	";

	$PagingSql = ToolMethod::Instance()->GetPagingSql($sql, $rows, $page);//sql、行数、页码
	$CountSql = ToolMethod::Instance()->GetCountSql($sql);//总数sql
	echo DB::Instance()->PageJson(Config::Instance()->DB_Config, $PagingSql, $CountSql);//获取分页json
}

// 增加模块数据
function AddModule(){
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");
	$ModuleName = ToolMethod::Instance()->GetUrlParam("ModuleName");
	$IsActive = ToolMethod::Instance()->GetUrlParam("IsActive");
	$Seq = ToolMethod::Instance()->GetUrlParam("Seq");

	if($ModuleId == ""){
		echo ToolMethod::Instance()->GetErrJsonStr("请输入模块ID");
		return;
	}

	$sql = "insert into g_module(ModuleId,ModuleName,IsActive,Seq)
		values('".$ModuleId."','".$ModuleName."','".$IsActive."','".$Seq."')
	";
	echo DB::Instance()->Execute(Config::Instance()->DB_Config, $sql);
}

// 删除模块数据
function DelModule(){
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");

	$sql = "delete from g_module where ModuleId='".$ModuleId."'";

	echo DB::Instance()->Execute(Config::Instance()->DB_Config, $sql);
}

// 修改模块数据
function MdfModule(){
	$old_ModuleId = ToolMethod::Instance()->GetUrlParam("old_ModuleId");
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");
	$ModuleName = ToolMethod::Instance()->GetUrlParam("ModuleName");
	$IsActive = ToolMethod::Instance()->GetUrlParam("IsActive");
	$Seq = ToolMethod::Instance()->GetUrlParam("Seq");

	if($ModuleId == "" || $old_ModuleId == ""){
		echo ToolMethod::Instance()->GetErrJsonStr("请输入模块ID");
		return;
	}

	$sql = "update g_module
		set ModuleId='".$ModuleId."',ModuleName='".$ModuleName."',IsActive='".$IsActive."',Seq='".$Seq."'
		where ModuleId='".$old_ModuleId."'
	";
	echo DB::Instance()->Execute(Config::Instance()->DB_Config, $sql);
}

?>