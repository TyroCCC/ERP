var pagecontroller = (function($) {

	function createPage(data) {

		if(typeof data == "undefined" || typeof data.Config == "undefined" || typeof data.Config.Base == "undefined" 
			|| typeof data.Config.Base.PageType == "undefined") {
			return null;
		}

		var $page = null;
		if(data.Config.Base.PageType == "r") {
			$page = queryPageController.create(data);
		}

		return $page;
	}
	
	return {

		createPage : function(data) {
			return createPage(data);
		}
	}
	
})(jQuery);

var queryPageController = (function($) {

	function create(data) {

		var page = "";

		page += createTabForm(data);

		if(typeof data.Config.Base.FormIdLst != "undefined" && typeof data.Config.Form != "undefined") {
			page += createSearchModule(data.Config.Base.FormIdLst, data.Config.Form);
		}

		if(typeof data.Config.Base.BtnIdLst != "undefined" && typeof data.Config.Btn != "undefined") {
			page += createButtonModule(data.Config.Base.BtnIdLst, data.Config.Btn);
		}

		if(typeof data.Config.Base.FieldIdLst != "undefined" && typeof data.Config.Grid != "undefined" && typeof data.Data.rows != "undefined") {
			page += createTableModule(data.Config.Base.FieldIdLst, data.Config.Grid, data.Data.rows);
		}

		return $(page);
	}

	function setEvent($page) {

		$(".searchbutton", $page).click(function() {
			$("input[name]", $page.siblings(".search")).each(function(i,item) {
				var $this = $(this);
				$("input[name='" + $this.attr("name") + "']", $page.siblings(".tabform")).val($this.val());
			});
			navtab.reload();
		});

	}

	function createTabForm(data) {
		var page = "<form class='tabform' style='margin:0;paddin:0'>";
		page += "<input type='hidden' name='PageId' value='" + data.Config.Base.PageId + "'>";
		page += "<input type='hidden' name='Page' value='" + data.Config.Base.Page + "'>";
		page += "<input type='hidden' name='Rows' value='" + data.Config.Base.Rows + "'>";

		var array = data.Config.Base.FormIdLst.split(",");
		for(var i = 0; i < array.length; i++) {
			var searchItem = data.Config.Form[array[i]];
			page += "<input type='hidden' name='" + searchItem.FormId + "' value=''>";
		}

		page += "</form>";
		return page;

	}

	function createSearchModule(searchList, searchData) {
		var array = searchList.split(",");
		var page = "";
		if(array.length == 0) {
			return page;
		}
		page = "<div class='search'>";
		for(var i = 0; i < array.length; i++) {
			var searchItem = searchData[array[i]];
			if(searchItem.FormType == "text") {
				page += "<div class='searchitem'><span>" + searchItem.FormName + ":</span><input name='" + searchItem.FormId + "' type='" + searchItem.FormType + "' value='" + searchItem.PreValue + "'></div>";
			}
		}
		page += "<div class='searchbutton'><button>查  询</button></div></div>";
		return page;
	}

	function createButtonModule(buttonList, buttonData) {
		var array = buttonList.split(",");
		var page = "";
		if(array.length == 0) {
			return page;
		}
		page = "<div class='operation'>";
		for(var i = 0; i < array.length; i++) {
			var buttonItem = buttonData[array[i]];
			page += "<div class='operationbutton'><button><i class='" + buttonItem.IconCls + "'></i>" + buttonItem.BtnName +"</button></div>";
		}
		page += "</div>";
		return page;
	}

	function createTableModule(tableList, tableHeadData, tableBodyData) {
		var headArray = tableList.split(",");
		var bodyArray = new Array();
		var page = "";
		if(headArray.length == 0) {
			return page;
		}
		page = "<div class='table' ui_resize='height'><table cellspacing='0'><tr>";
		for(var i = 0; i < headArray.length; i++) {
			var tableHeadItem = tableHeadData[headArray[i]];
			bodyArray.push(tableHeadItem.FieldId);
			page += "<th>" + tableHeadItem.FieldName +  "</th>";
		}
		page += "</tr>";

		$.each(tableBodyData, function(i, item) {
			page += "<tr>";
			for(var i = 0; i < bodyArray.length; i++) {
				page += "<td>" + item[bodyArray[i]] + "</td>";
			}
			page += "</tr>";
		});

		page += "</table></div>";
		return page;
	}
	
	return {
		create : function(data) {
			var $page = create(data);
			setEvent($page);
			return $page;
		}
	}

})(jQuery);