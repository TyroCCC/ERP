var wr_dialog = (function($) {
	
	var template = "<div class=\"wr-dialog\" id=\"#DIALOGID#\">"
		+ "<div class=\"wr-dialog-vessel\">"
		+ "<div class=\"wr-dialog-dragmove wr-dialog-head\">"
		+ "<div class=\"wr-dialog-title\">"
		+ "<span>#DIALOGTITLE#</span>"
		+ "</div>"
		+ "<div class=\"wr-dialog-opericon\"></div>"
		+ "</div>"
		+ "<div class=\"wr-dialog-region\" UI_RESIZE=\"HEIGHT\"></div>"
		+ "</div>"
		+ "<div class=\"wr-dialog-dragresize wr-dialog-dragn\"></div>"
		+ "<div class=\"wr-dialog-dragresize wr-dialog-dragw\"></div>"
		+ "<div class=\"wr-dialog-dragresize wr-dialog-drage\"></div>"
		+ "<div class=\"wr-dialog-dragresize wr-dialog-drags\"></div>"
		+ "<div class=\"wr-dialog-dragresize wr-dialog-dragwn\"></div>"
		+ "<div class=\"wr-dialog-dragresize wr-dialog-dragen\"></div>"
		+ "<div class=\"wr-dialog-dragresize wr-dialog-dragws\"></div>"
		+ "<div class=\"wr-dialog-dragresize wr-dialog-drages\"></div>"
		+ "</div>";
	
	var option = {
			minW: -1,
			minH: -1,
			maxW: -1,
			maxH: -1,
			width: 680,
			height: 500,
			minable: true,
			maxable: true,
			resizeable: true,
			closeable: true,
			dragable: true,
			modal: false
		};
	
	var dragMove = {
			startX : 0,
			startY : 0,
			top : 0,
			left : 0,
			start : function ($obj, event) {
	            var e = event || window.event;
	            this.startX = e.pageX || e.clientX;
	            this.startY = e.pageY || e.clientY;
	            this.top = parseInt($obj.css("top"));
	            this.left = parseInt($obj.css("left"));

	            $(document).mouseup(function(e){
	            	dragMove.stop($obj, e);
	                return false;
	            }).mousemove(function(e) {
	            	dragMove.move($obj, e);
	                return false;
	            });
	        },

	        move : function ($obj, event) {
	            var e = event || window.event;
	            if(e.stopPropagation) { e.stopPropagation(); }
	            if(e.preventDefault) { e.preventDefault(); }

	            var endX = e.pageX || e.clientX;
	            var endY = e.pageY || e.clientY;

	            var distanceX = endX - this.startX;
	            var distanceY = endY - this.startY;

	            var top = this.top + distanceY;
	            var left = this.left + distanceX;
	            if(top < 0 ) {
	            	top = 0;
	            }
	            if(top > $(window).height()) {
	            	top = $(window).height();
	            }
	            
	            $obj.css({
	                top : top,
	                left : left
	            });
	            return false;
	        },
	        
	        stop : function ($obj, event) {
	            var e = event || window.event;
	            $(document).off('mousemove').off('mouseup');
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
	};
	
	var dragResize = {
			startX : 0,
			startY : 0,
			top : 0,
			left : 0,
			width : 0,
			height : 0,
			start : function ($obj, type, op, event) {
	            var e = event || window.event;
	            this.startX = e.pageX || e.clientX;
	            this.startY = e.pageY || e.clientY;
	            this.top = parseInt($obj.css("top"));
	            this.left = parseInt($obj.css("left"));
	            this.width = $obj.width();
	            this.height = $obj.height();

	            $(document).mouseup(function(e){
	            	dragResize.stop($obj, type, op, e);
	                return false;
	            }).mousemove(function(e) {
	            	dragResize.move($obj, type, op, e);
	                return false;
	            });
	        },

	        move : function ($obj, type, op, event) {
	            var e = event || window.event;
	            if(e.stopPropagation) { e.stopPropagation(); }
	            if(e.preventDefault) { e.preventDefault(); }

	            var endX = e.pageX || e.clientX;
	            var endY = e.pageY || e.clientY;

	            var distanceX = endX - this.startX;
	            var distanceY = endY - this.startY;

	            var top = this.top + distanceY;
	            var left = this.left + distanceX;
	            
	    		if(type.indexOf("n") >= 0) {
	    			$obj.css("top", top);
	    			$obj.height(this.height - distanceY);
	    		}
	    		if(type.indexOf("e") >= 0) {
	    			$obj.width(this.width + distanceX);
	    		}
	    		if(type.indexOf("s") >= 0) {
	    			$obj.height(this.height + distanceY);
	    		}
	    		if(type.indexOf("w") >= 0) {
	    			$obj.css("left", left);
	    			$obj.width(this.width - distanceX);
	    		}
	            return false;
	        },
	        
	        stop : function ($obj, type, op, event) {
	            var e = event || window.event;
	            $(document).off('mousemove').off('mouseup');
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
	};
	
	function create(id, title, op) {
		
		var dialog = template;
		dialog = dialog.replace("#DIALOGID#", id);
		dialog = dialog.replace("#DIALOGTITLE#", title);
		$obj = $(dialog);
		
		var width = op.width;
		var height = op.height;
		if(op.minW != -1 && op.minW > width) {
			width = op.minW;
		}
		if(op.minH != -1 && op.minH > height) {
			height = op.minH;
		}
		if(op.maxW != -1 && op.maxW < width) {
			width = op.maxW;
		}
		if(op.maxH != -1 && op.maxH > height) {
			height = op.maxH;
		}
		$obj.width(width);
		$obj.height(height);
		
		var top = ($(window).height() - height) / 2;
		var left = ($(window).width() - width) / 2;
		$obj.css("top", top + "px");
		$obj.css("left", left + "px");
		
		return $obj;
	}
	
	function setEvent($obj, op) {
		
		if(op.minable) {
			var $minObj = $("<div class='wr-dialog-iconitem wr-dialog-minicon'><i class='icon-min0'></i></div>");
			$minObj.appendTo($(".wr-dialog-opericon", $obj));
			$minObj.click(function() {
				minimum($obj.attr("id"));
				return false;
			});
		}
		if(op.maxable) {
			var $max = $("<div class='wr-dialog-iconitem wr-dialog-maxicon'><i class='icon-max0'></i></div>");
			$max.appendTo($(".wr-dialog-opericon", $obj));
			var $resize = $("<div class='wr-dialog-iconitem wr-dialog-resizeicon'><i class='icon-resize0'></i></div>");
			$resize.appendTo($(".wr-dialog-opericon", $obj));
			$resize.hide();
			
			$max.click(function() {
				maximize($obj.attr("id"));
				$max.hide();
				$resize.show();
				return false;
			});
			$resize.click(function() {
				resize($obj.attr("id"));
				$max.show();
				$resize.hide();
				return false;
			});
		}
		if(op.closeable) {
			var $close = $("<div class='wr-dialog-iconitem wr-dialog-closeicon'><i class='icon-close0'></i></div>");
			$close.appendTo($(".wr-dialog-opericon", $obj));
			$close.click(function() {
				close($obj.attr("id"));
			});
		}
		
		if(op.dragable) {
			
			$obj.data("dragable", true);
			
			$(".wr-dialog-dragmove", $obj).mousedown(function(e) {
				
				if($obj.data("dragable")) {
					dragMove.start($obj, e);
				}
                document.onselectstart = function () {
                     return false;
                 };
                 return false;
			});
		}
		
		if(op.resizeable) {
			$(".wr-dialog-dragresize", $obj).mousedown(function(e) {
				
				if($(this).hasClass("wr-dialog-dragwn")) {
					dragResize.start($obj, "wn", op, e);
				}
				else if($(this).hasClass("wr-dialog-dragn")) {
					dragResize.start($obj, "n", op, e);
				}
				else if($(this).hasClass("wr-dialog-dragen")) {
					dragResize.start($obj, "en", op, e);
				}
				else if($(this).hasClass("wr-dialog-dragw")) {
					dragResize.start($obj, "w", op, e);
				}
				else if($(this).hasClass("wr-dialog-drage")) {
					dragResize.start($obj, "e", op, e);
				}
				else if($(this).hasClass("wr-dialog-dragws")) {
					dragResize.start($obj, "ws", op, e);
				}
				else if($(this).hasClass("wr-dialog-drags")) {
					dragResize.start($obj, "s", op, e);
				}
				else if($(this).hasClass("wr-dialog-drages")) {
					dragResize.start($obj, "es", op, e);
				}
                document.onselectstart = function () {
                     return false;
                 };
                 return false;
			});
		}
	}
	
	function open(title, op) {
		op = $.extend({}, option, op);
		var id = $.now().toString();
		var $obj = create(id, title, op);
		setEvent($obj, op);
		return $obj;
	}
	
	function close(id) {
		
	}
	
	function minimum(id) {
		
	}
	
	function maximize(id) {
		
	}
	
	function resize(id) {
		
	}
	
	return {
		open : function(title, op) {
			return open(title, op);
		},
		
		close : function(id) {
			close(id);
		},
		
		minimum : function(id) {
			minimum(id);
		},
		
		maximize : function(id) {
			maximize(id);
		},
		
		resize : function(id) {
			resize(id);
		}
	};
	
}(jQuery));