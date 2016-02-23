<?php

// 页面管理





// 获取页面数据
function GetModule(){
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");
	$ModuleName = ToolMethod::Instance()->GetUrlParam("ModuleName");
	$IsActive = ToolMethod::Instance()->GetUrlParam("IsActive");

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

	$sql = "select PageId,PageName,ModuleId,Controller,OuterLink,IsActive from g_page ".$str;
	echo DB::Instance()->UnPageJson(Config::Instance()->DB_Config, $sql);
}

// 增加页面数据
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

// 删除页面数据
function DelModule(){
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");

	$sql = "delete from g_module where ModuleId='".$ModuleId."'";

	echo DB::Instance()->Execute(Config::Instance()->DB_Config, $sql);
}

// 修改页面数据
function MdfModule(){
	$OldModuleId = ToolMethod::Instance()->GetUrlParam("OldModuleId");
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");
	$ModuleName = ToolMethod::Instance()->GetUrlParam("ModuleName");
	$IsActive = ToolMethod::Instance()->GetUrlParam("IsActive");
	$Seq = ToolMethod::Instance()->GetUrlParam("Seq");

	if($ModuleId == "" || $OldModuleId == ""){
		echo ToolMethod::Instance()->GetErrJsonStr("请输入模块ID");
		return;
	}

	$sql = "update g_module
		set ModuleId='".$ModuleId."',ModuleName='".$ModuleName."',IsActive='".$IsActive."',Seq='".$Seq."'
		where ModuleId='".$OldModuleId."'
	";
	echo DB::Instance()->Execute(Config::Instance()->DB_Config, $sql);
}

?>