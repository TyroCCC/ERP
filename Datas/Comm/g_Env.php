<?php

// 用于页面配置数据初始化、所有模块都会使用到





// 获取模块数据
function GetModule(){
	echo ToolMethod::Instance()->JsonWithStatus(function(){
		$sql = "select ModuleId,ModuleName
			from g_module
			where IsActive=1
			order by Seq";
		return DB::Instance()->UnPageJson(Config::Instance()->DB_Config, $sql);
	});
}

// 获取树菜单数据
function GetTreeMenuByModuleId(){
	echo ToolMethod::Instance()->JsonWithStatus(function(){
		$ModuleId = ToolMethod::Instance()->GetUrlParam("ModuleId");
		if($ModuleId == ""){
			$ModuleId = ToolMethod::Instance()->GetPostParam("ModuleId");
		}
		$sql = "select tb1.MenuId,tb1.MenuName,tb1.NodeLevel,tb1.ParentMenuId,tb1.PageId,tb1.IconCls,tb1.IconAlign,tb2.ModuleId,tb2.Controller,tb2.OuterLink
			from(
			     select * from g_menu where ModuleId='".$ModuleId."' and IsActive=1
			) as tb1
			left join(
			     select * from g_page where IsActive=1
			) as tb2
			on tb1.PageId=tb2.PageId";

		$result = DB::Instance()->Get2Arr(Config::Instance()->DB_Config, $sql);
		if(!count($result)){//没有数据
			return "{}";
		}
		else{
			$result = ToolMethod::Instance()->TranMy2Arr($result);
			$result = ToolMethod::Instance()->GetTreeArr($result);
			$result = json_encode($result);
			$result = str_replace(":null", ':""', $result);
			$result = ltrim($result, "[");
			$result = rtrim($result, "]");
			return $result;
		}
	});
}

// 获取当前页面的信息
function GetPageParam(){
	echo ToolMethod::Instance()->JsonWithStatus(function(){
		$PageId = ToolMethod::Instance()->GetUrlParam("PageId");
		if($PageId == ""){
			$PageId = ToolMethod::Instance()->GetPostParam("PageId");
		}
		$sql = "select * from g_page where IsActive=1 and PageId='".$PageId."'";
		return DB::Instance()->UnPageJson(Config::Instance()->DB_Config, $sql);
	});
}

?>