var utils = (function($){
	
	return {
		
		resize : function($p) {
			
			if(typeof $p == "undefined" || $p == null) {
				$p = $(document);
			}
			
			$("div[UI_ReSize]", $p).each(function() {
				$this = $(this);
				if($this.attr("UI_ReSize") == "height") {
					var height = $this.parent().height();
					$this.siblings("div:visible").each(function() {
						height = height - $(this).outerHeight(true);
					});
					$this.height(height - $this.outerHeight(true) + $this.height());
					$this.width($this.parent().width() - $this.outerWidth(true) + $this.width());
				}
				else if($this.attr("UI_ReSize") == "width") {
					var width = $this.parent().width();
					$this.siblings("div:visible").each(function() {
						width = width - $(this).outerWidth(true);
					});
					$this.width(width - $this.outerWidth(true) + $this.width());
					$this.height($this.parent().height() - $this.outerHeight(true) + $this.height());
				}
			});
		}
	
	};
})(jQuery);