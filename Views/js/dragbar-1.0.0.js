var dragBar = (function($) {
	
	var startPoint = 0;
	var $item = null;
	var direction = "";
	
	function init($p) {
		$("div[UI_HorizontalDragBar]", $p).each(function() {
			$this = $(this);
			$this.mousedown(function(event) {
				dragBar.start($(this), "horizontal", event);
				return false;
			});
		});
		
		$("div[UI_VerticalDragBar]", $p).each(function() {
			$this = $(this);
			$this.mousedown(function(event) {
				dragBar.start($(this), "vertical", event);
				return false;
			});
		});
	}
	
	function start(_$item, _direction, e) {
		
		document.onselectstart=function(e)
		{
			return false;
		};
		
		$item = _$item;
		direction = _direction;
		if(direction == "horizontal") {
			startPoint = (e.pageX || e.clientX);
		}
		else if(direction == "vertical") {
			startPoint = (e.pageY || e.clientY);
		}
		
		$(document).bind("mouseup", dragBar.stop).bind("mousemove", dragBar.move);
	}
	
	function move(e) {
		if(!e) {
			e = window.event;
		}
		if(direction == "horizontal") {
			var left = (e.pageX || e.clientX);
			var $obj;
			if($item.attr("UI_HorizontalDragBar") == "next") {
				$obj = $item.next();
				$obj.width($obj.width() - left + startPoint);
			}
			else {
				$obj = $item.prev();
				$obj.width($obj.width() + left - startPoint);
			}
			startPoint = left;
		}
		else if(direction == "vertical"){
			var top = (e.pageY || e.clientY);
			var $obj;
			if($item.attr("UI_VerticalDragBar") == "next") {
				$obj = $item.next();
				$obj.height($obj.height() - top + startPoint);
			}
			else {
				$obj = $item.prev();
				$obj.height($obj.height() + top - startPoint);
			}
			startPoint = top;
		}
		
		utils.resize();
		
		if(e.stopPropagation) {
			e.stopPropagation();
		}
		if(e.preventDefault) {
			e.preventDefault();
		}
		return false;
	}
	
	function stop(e) {
		$(document).unbind('mousemove', dragBar.move).unbind('mouseup', dragBar.stop);
		
		document.onselectstart = function(e) {
			return true;
		};
		
		if(e.stopPropagation) {
			e.stopPropagation();
		}
		if(e.preventDefault) {
			e.preventDefault();
		}
		return false;
	}
	
	return {
		init : function($p) {
			init($p);
		},
		
		start : function(_$item, _direction, e) {
			start(_$item, _direction, e);
		},
		
		move : function(e) {
			move(e);
		},
		
		stop : function(e) {
			stop(e);
		}
	};
	
}(jQuery));