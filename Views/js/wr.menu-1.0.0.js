var wr_menu = (function($){
	
	return {
		init : function() {
			var $mainmenu = $(".mainmenu");
			var $menugroup = $(".menugroup >.title", $mainmenu);
			var $menuitem = $(".menugroup >ul", $mainmenu);
			$menuitem.hide();
			$menugroup.click(function() {
				var $this = $(this);
				if(!$this.find(".iconarrow").hasClass("show")) {
					/*$menugroup.find(".iconarrow").removeClass("icon-angle-down").removeClass("show").addClass("icon-angle-right");
					$menuitem.slideUp();*/
					$this.find(".iconarrow").removeClass("icon-angle-right").addClass("show").addClass("icon-angle-down");
					$this.siblings("ul").slideDown();
				}
				else {
					$this.find(".iconarrow").removeClass("icon-angle-down").removeClass("show").addClass("icon-angle-right");
					$this.siblings("ul").slideUp();
				}
				return false;
			});
		}
	};
	
})(jQuery);