<?php

// 页面管理





// 获取页面数据
function GetPage(){
	$DBID = Config::Instance()->DB_Config;
	$rows = ToolMethod::Instance()->GetUrlParam("rows");
	$page = ToolMethod::Instance()->GetUrlParam("page");

	$sql = DB::Instance()->GetSelectSql($DBID, "g_page", "get");
	$PagingSql = ToolMethod::Instance()->GetPagingSql($sql, $rows, $page);
	$CountSql = ToolMethod::Instance()->GetCountSql($sql);
	echo DB::Instance()->PageJson($DBID, $PagingSql, $CountSql);
}

// 增加页面数据
function AddPage(){
	$DBID = Config::Instance()->DB_Config;
	$sql = DB::Instance()->GetInsertSql($DBID, "g_page", "get");
	echo DB::Instance()->Execute($DBID, $sql);
}

// 删除页面数据
function DelPage(){
	$DBID = Config::Instance()->DB_Config;
	$sql = DB::Instance()->GetDeleteSql($DBID, "g_page", "get");
	echo DB::Instance()->Execute($DBID, $sql);
}

// 修改页面数据
function MdfPage(){
	$DBID = Config::Instance()->DB_Config;
	$sql =DB::Instance()->GetModifySql($DBID, "g_page", "get");
	echo DB::Instance()->Execute($DBID, $sql);
}

?>