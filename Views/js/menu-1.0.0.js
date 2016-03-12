var menu = (function($) {
	
	var menuUrl = "../Data.php/Comm/g_Env/GetTreeMenuByModuleId?ModuleId=System";
	var $mainmenu = null;
	
	function getMenuData() {
		
		var data = "";
		
		$.ajax({
            url: menuUrl,
            type: "POST",
            //type: "GET",
            cache: false,
            dataType: "json",
            async: false,
            success: function (json) {
            	data = json;
            },
            error: function () {
            	alert("获取菜单数据失败！");
            }
        });
		
		return data;
		
	}
	
	function createMenu(data) {
		if(typeof data == "undefined" || data == "" || data == "{}") {
			alert("获取菜单数据失败！");
			return;
		}
		
		var menudata = data.Children;
		var menucontent = "";
		
		for(var i = 0; typeof menudata != "undefined" && i < menudata.length; i++) {
			
			var menugroup = "<li class='menugroup'><div class='title'><i class='iconlist icon-reorder'></i><span>"
				+ menudata[i].MenuName
				+ "</span><i class='iconarrow icon-angle-right'></i></div><ul>";
			
			var menuitemdata = menudata[i].Children;
			for(var j = 0; typeof menuitemdata != "undefined" && j < menuitemdata.length; j++) {
				var menuitem = "<li class='menuitem' m_title='" + menuitemdata[j].MenuName + "' m_pageid='" + menuitemdata[j].PageId + "'><div class='title'><span>"
					+ menuitemdata[j].MenuName
					+ "</span></div></li>";
				
				menugroup += menuitem;
			}
			
			menugroup += "</ul>";
			menucontent += menugroup;
		}
		
		$mainmenu.html(menucontent);
	}
	
	function setMenuEvent() {
		var $menugroup = $(".menugroup >.title", $mainmenu);
		var $menuitemgroup = $(".menugroup >ul", $mainmenu);
		var $menuitem = $(".menuitem", $mainmenu);
		$menuitemgroup.hide();
		$menugroup.click(function() {
			var $this = $(this);
			if(!$this.find(".iconarrow").hasClass("show")) {
				$this.find(".iconarrow").removeClass("icon-angle-right").addClass("show").addClass("icon-angle-down");
				$this.siblings("ul").slideDown();
			}
			else {
				$this.find(".iconarrow").removeClass("icon-angle-down").removeClass("show").addClass("icon-angle-right");
				$this.siblings("ul").slideUp();
			}
			return false;
		});

		$menuitem.click(function() {
			var $this = $(this);
			var option = {};
			option.operation = "navtab";
			option.title = $this.attr("m_title");
			option.url = "../Data.php/Comm/r_Env/GetConfigAndData";
			option.data = {PageId : $this.attr("m_pageid")};
			operationcontroller.execute(option);
			return false;
		});
	}
	
	function initMenu() {
		$mainmenu = $("#mainmenu .menu");
		//获取菜单数据
		var data = getMenuData();
		//生成菜单
		createMenu(data);
		//设置菜单事件
		setMenuEvent();
	}
	
	return {
		init : function() {
			initMenu();
		}
	};
	
})(jQuery);