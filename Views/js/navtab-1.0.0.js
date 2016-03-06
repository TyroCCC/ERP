var navtab = (function($) {
	
	var $navtab = null;
	var $tabhead = null;
	var $tabcontent = null;
	var $moveleft = null;
	var $tabheadcontent = null;
	var $tabheadlist = null;
	var $moveright = null;
	var moveSpeed = 100;
	
	function init() {
		
		$navtab = $("#navtab");
		
		$tabhead = $("<div class='tabhead'></div>");
		$tabhead.appendTo($navtab);
		$moveleft = $("<div class='moveleft'><i class='icon-chevron-left iconmove'></i></div>");
		$moveleft.appendTo($tabhead);
		$tabheadcontent = $("<div class='tabheadcontent' UI_ReSize='width'></div>");
		$tabheadcontent.appendTo($tabhead);
		$tabheadlist = $("<ul class='tabheadlist'></ul>");
		$tabheadlist.appendTo($tabheadcontent);
		$moveright = $("<div class='moveright'><i class='icon-chevron-right iconmove'></i></div>");
		$moveright.appendTo($tabhead);
		
		$tabcontent = $("<div class='tabcontent' UI_ReSize='height'></div>");
		$tabcontent.appendTo($navtab);
		
		setEvent();
	}
	
	function open(title) {
		
		var id = $.now().toString();
		
		var $tabHeadItem = $("<li class='tabheaditem' UI_CONTENTID='" + id + "'><div class='title'>" + title + "</div></li>");
		var $tabHeadItemIcon = $("<i class='iconclose icon-remove-sign'></i>");
		$tabHeadItemIcon.appendTo($tabHeadItem);
		$tabHeadItem.appendTo($tabheadlist);
		
		$tabheadlist.width($tabheadlist.width() + $tabHeadItem.outerWidth(true));
		
		var $tabContentItem = $("<div class='tabitemcontent' id='" + id + "'UI_ReSize='height'>");
		$tabContentItem.appendTo($tabcontent);
		
		setTabItemEvent($tabHeadItem, $tabContentItem);
		resizeTabHead();
		$tabHeadItem.click();
	}
	
	function setTabItemEvent($tabHeadItem, $tabContentItem) {
		
		$tabHeadItem.click(function() {
			var $this = $(this);
			if(!$this.hasClass("active")) {
				$this.siblings(".tabheaditem").removeClass("active");
				$this.addClass("active");

				$tabContentItem.siblings(".tabitemcontent").hide();
				$tabContentItem.show();
				
				var pointS = $this[0].offsetLeft;
				var pointE = $this[0].offsetLeft + $this.outerWidth(true);
				if(pointS < -parseInt($tabheadlist.css("left"))) {
					$tabheadlist.stop(true, true);
					$tabheadlist.animate({left: -pointS + "px"});
				}
				if(pointE > parseInt($tabheadlist.css("left")) + $tabheadcontent.width()) {
					$tabheadlist.stop(true, true);
					$tabheadlist.animate({left: $tabheadcontent.width() - pointE + "px"});
				}

				utils.resize($tabcontent);
			}
			
			return false;
		});
		
		$(".iconclose", $tabHeadItem).click(function() {
			
			if($tabHeadItem.prev(".tabheaditem").length > 0) {
				$tabHeadItem.prev(".tabheaditem").click();
			}
			else {
				$tabHeadItem.next(".tabheaditem").click();
			}
			
			var width = $tabHeadItem.outerWidth(true);
			$tabHeadItem.remove();
			$tabContentItem.remove();
			$tabheadlist.width($tabheadlist.width() - width);
			resizeTabHead();
		});
		
	}
	
	function setEvent() {
		
		$moveleft.click(function() {
			//$tabheadlist.css("left", Math.min(parseInt($tabheadlist.css("left")) + moveSpeed, 0));
			var left = Math.min(parseInt($tabheadlist.css("left")) + moveSpeed, 0);
			$tabheadlist.stop(true, true);
			$tabheadlist.animate({left: left + "px"});
			return false;
		});
		
		$moveright.click(function() {
			//$tabheadlist.css("left", Math.max(parseInt($tabheadlist.css("left")) - moveSpeed, $tabheadcontent.width()- $tabheadlist[0].scrollWidth));
			var left = Math.max(parseInt($tabheadlist.css("left")) - moveSpeed, $tabheadcontent.width()- $tabheadlist[0].scrollWidth);
			$tabheadlist.stop(true, true);
			$tabheadlist.animate({left: left + "px"});
			return false;
		});
		
		$(window).resize(function () {
			resizeTabHead();
        });
	}
	
	function resizeTabHead() {
		
		var moveLeftWidth = 0;
		var moveRightWidth = 0;
		if($moveleft.is(":visible")) {
			moveLeftWidth = $moveleft.outerWidth(true);
		}
		if($moveright.is(":visible")) {
			moveRightWidth = $moveright.outerWidth(true);
		}
		
		if($tabheadcontent.width() + moveLeftWidth + moveRightWidth < $tabheadlist[0].scrollWidth) {
			$moveleft.show();
			$moveright.show();
		}
		else {
			$moveleft.hide();
			$moveright.hide();
		}
		utils.resize($tabhead);
		
		if($tabheadcontent.width() >= $tabheadlist[0].scrollWidth) {
			$tabheadlist.css("left", 0);
		}
		else {
			var left = parseInt($tabheadlist.css("left"));
			$tabheadlist.css("left", Math.max(left, $tabheadcontent.width() - $tabheadlist[0].scrollWidth));
		}
		
	}
	
	function getTab(id) {
		if(null == id || typeof id == "undefined") {
			return $(".tabheaditem.active", $tabheadlist);
		}
	}
	
	function getTabContent(id) {
		
		if(null == id || typeof id =="undefind") {
			var $tab = getTab();
			var $tabContent = $("#" + $tab.attr("UI_CONTENTID"));
			return $tabContent;
		}
		
	}

	function reload(id) {
		var $tabContent = getTabContent(id);
		var $form = $(".tabform", $tabContent);
		if($form.length == 0) {
			return false;
		}
		$.ajax({
            url: "../Data.php/Comm/r_Env/GetConfigAndData",
            data: $form.serialize(),
            type: "POST",
            cache: false,
            dataType: "json",
            async: false,
            success: function (data) {
            	var $page = pagecontroller.createPage(data);
            	$tabContent.html("");
            	$page.appendTo($tabContent);
            	utils.resize($tabContent);
            },
            error: function () {
            	alert("获取数据失败！");
            }
        });
	}
	
	return {
		
		init : function() {
			init();
		},
		
		open : function(title) {
			open(title);
		},
		
		close : function() {
			
		},
		
		getTab : function(id) {
			return getTab(id);
		},
		
		getTabContent : function(id) {
			return getTabContent(id);
		},

		reload : function (id) {
			reload(id);
		}
	};
	
})(jQuery);