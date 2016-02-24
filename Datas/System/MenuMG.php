<?php

// 菜单管理





// 获取菜单数据
function GetMenu(){
	$DBID = Config::Instance()->DB_Config;
	$rows = ToolMethod::Instance()->GetUrlParam("rows");
	$page = ToolMethod::Instance()->GetUrlParam("page");

	$sql = DB::Instance()->GetSelectSql($DBID, "g_menu", "get", "like");
	$PagingSql = ToolMethod::Instance()->GetPagingSql($sql, $rows, $page);
	$CountSql = ToolMethod::Instance()->GetCountSql($sql);
	echo DB::Instance()->PageJson($DBID, $PagingSql, $CountSql);
}

// 增加菜单数据
function AddGetMenu(){
	$DBID = Config::Instance()->DB_Config;
	$sql = DB::Instance()->GetInsertSql($DBID, "g_menu", "get");
	echo DB::Instance()->Execute($DBID, $sql);
}

// 删除菜单数据
function DelGetMenu(){
	$DBID = Config::Instance()->DB_Config;
	$sql = DB::Instance()->GetDeleteSql($DBID, "g_menu", "get");
	echo DB::Instance()->Execute($DBID, $sql);
}

// 修改菜单数据
function MdfGetMenu(){
	$DBID = Config::Instance()->DB_Config;
	$sql =DB::Instance()->GetModifySql($DBID, "g_menu", "get");
	echo DB::Instance()->Execute($DBID, $sql);
}

?>