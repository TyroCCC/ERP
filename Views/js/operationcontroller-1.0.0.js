var operationcontroller = (function($) {

	function showLoading() {
		$("#loadpage").show();
	}

	function hideLoading() {
		$("#loadpage").hide();
	}

	function execute(option) {

		if(typeof option == "undefined" || typeof option.operation == "undefined"){
			return;
		}

		if(option.operation == "navtab") {
			navtab.open(option.title || "新标签");
			var data = {};
			data.url = option.url;
			data.data = option.data;
			data.callback = function(data) {
				var $page = pagecontroller.createPage(data);
            	navtab.getTabContent().html("");
            	$page.appendTo(navtab.getTabContent());
            	utils.resize(navtab.getTabContent());
			};
			ajaxData(data);
		}
		else if(option.operation == "reloadnavtab") {
			var data = {};
			data.url = option.url;
			data.data = option.data;
			data.callback = function(data) {
				var $page = pagecontroller.createPage(data);
            	navtab.getTabContent().html("");
            	$page.appendTo(navtab.getTabContent());
            	utils.resize(navtab.getTabContent());
			};
			ajaxData(data);
		}
		else if(option.operation == "dialog") {
			var $dialog = dialog.open(option.title || "新窗口");
			var data = {};
			data.url = option.url;
			data.data = option.data;
			data.callback = function(data) {
				var $page = pagecontroller.createPage(data);
				dialog.getDialogContent().html("");
				$page.appendTo(dialog.getDialogContent());
				utils.resize(dialog.getDialogContent());
			};
			ajaxData(data);
		}
		else if(option.operation == "post" || option.operation == "get") {
			var data = {};
			data.url = option.url;
			data.data = option.data;
			data.callback = function(data) {
				if(data.result == "failed") {
					alert(data.reason);
					return;
				}
				option.callback();
			};
			ajaxData(data);
		}
		else {
			if(typeof option.callback != "undefined") {
				option.callback();
			}
		}

	}

	function ajaxData(option) {
		showLoading();
		$.ajax({
            url: option.url,
            data: option.data || {},
            type: option.type || "POST",
            cache: option.cache || false,
            dataType: option.dataType || "json",
            async: option.async || true,
            success: function (data) {
            	if(typeof option.callback != "undefined") {
            		option.callback(data);
            	}
            	hideLoading();
            },
            error: function () {
            	hideLoading();
            	alert("获取数据失败！");
            }
        });
	}
	
	return {

		showLoading : function() {
			showLoading();
		},

		hideLoading : function() {
			hideLoading();
		},

		execute : function(option) {
			execute(option);
		},

		ajaxData : function(option) {
			ajaxData(option);
		}

	}
	
})(jQuery);