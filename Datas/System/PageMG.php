<?php

// 页面管理





// 获取页面数据
function GetPage(){
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	$PageName = ToolMethod::Instance()->GetUrlParam("PageName");
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");
	$Controller = ToolMethod::Instance()->GetUrlParam("Controller");
	$OuterLink = ToolMethod::Instance()->GetUrlParam("OuterLink");
	$IsActive = ToolMethod::Instance()->GetUrlParam("IsActive");

	$rows = ToolMethod::Instance()->GetUrlParam("rows");
	$page = ToolMethod::Instance()->GetUrlParam("page");

	$str = "";
	if($PageId != ""){
		$str .= " and PageId like '".$PageId."'";
	}
	if($PageName != ""){
		$str .= " and PageName like '".$PageName."'";
	}
	if($ModuleId != ""){
		$str .= " and ModuleId like '".$ModuleId."'";
	}
	if($Controller != ""){
		$str .= " and Controller like '".$Controller."'";
	}
	if($OuterLink != ""){
		$str .= " and ModuleId like '".$OuterLink."'";
	}
	if($IsActive != ""){
		$str .= " and IsActive like '".$IsActive."'";
	}
	if($str != ""){
		$str = " where ".ltrim($str, " and");
	}

	$sql = "select PageId,PageName,ModuleId,Controller,OuterLink,IsActive from g_page ".$str;
	$PagingSql = ToolMethod::Instance()->GetPagingSql($sql, $rows, $page);
	$CountSql = ToolMethod::Instance()->GetCountSql($sql);
	echo DB::Instance()->PageJson(Config::Instance()->DB_Config, $PagingSql, $CountSql);
}

// 增加页面数据
function AddPage(){
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	$PageName = ToolMethod::Instance()->GetUrlParam("PageName");
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");
	$Controller = ToolMethod::Instance()->GetUrlParam("Controller");
	$OuterLink = ToolMethod::Instance()->GetUrlParam("OuterLink");
	$IsActive = ToolMethod::Instance()->GetUrlParam("IsActive");

	if($PageId == ""){
		echo ToolMethod::Instance()->GetErrJsonStr("请输入页面ID");
		return;
	}

	$sql = "insert into g_page(PageId,PageName,ModuleId,Controller,OuterLink,IsActive)
		values('".$PageId."','".$PageName."','".$ModuleId."','".$Controller."','".$OuterLink."','".$IsActive."')
	";
	echo DB::Instance()->Execute(Config::Instance()->DB_Config, $sql);
}

// 删除页面数据
function DelPage(){
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");

	$sql = "delete from g_page where PageId='".$PageId."'";

	echo DB::Instance()->Execute(Config::Instance()->DB_Config, $sql);
}

// 修改页面数据
function MdfPage(){
	$OldPageId = ToolMethod::Instance()->GetUrlParam("OldPageId");
	$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
	$PageName = ToolMethod::Instance()->GetUrlParam("PageName");
	$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");
	$Controller = ToolMethod::Instance()->GetUrlParam("Controller");
	$OuterLink = ToolMethod::Instance()->GetUrlParam("OuterLink");
	$IsActive = ToolMethod::Instance()->GetUrlParam("IsActive");

	if($PageId == ""){
		echo ToolMethod::Instance()->GetErrJsonStr("请输入页面ID");
		return;
	}

	$sql = "update g_page
		set PageId='".$PageId."',PageName='".$PageName."',ModuleId='".$ModuleId."'"
		.",Controller='".$Controller."',OuterLink='".$OuterLink."',IsActive='".$IsActive."'
		where PageId='".$OldPageId."'
	";
	echo DB::Instance()->Execute(Config::Instance()->DB_Config, $sql);
}

?>