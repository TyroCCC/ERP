var dialog = (function($) {
	
	var defaultOpation = {
			removable : true,
			resizeable : true,
			minsizeable : true,
			maxsizeable : true,
			closeable : true,
			width : 680,
			height: 420
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
	            if(top > $(window).height() - $(".dialog-move", $obj).height()) {
	            	top = $(window).height() - $(".dialog-move", $obj).height();
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
			start : function ($obj, type, event) {
	            var e = event || window.event;
	            this.startX = e.pageX || e.clientX;
	            this.startY = e.pageY || e.clientY;
	            this.top = parseInt($obj.css("top"));
	            this.left = parseInt($obj.css("left"));
	            this.width = $obj.width();
	            this.height = $obj.height();

	            $(document).mouseup(function(e){
	            	dragResize.stop($obj, type, e);
	                return false;
	            }).mousemove(function(e) {
	            	dragResize.move($obj, type, e);
	                return false;
	            });
	        },

	        move : function ($obj, type, event) {
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
	    		 utils.resize($obj);
	            
	            return false;
	        },
	        
	        stop : function ($obj, type, event) {
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
	            
	            utils.resize($obj);
	            
	            return false;
	        }
	};
	
	function create(title, opation) {
		
		opation = $.extend({}, defaultOpation, opation);
		
		var $dialog = $("<div class='dialog active'><div class='vessel'><div class='head'><div class='title'></div><div class='operationbar'></div></div><div class='content' UI_ReSize='height'></div></div></div>");
		$dialog.width(opation.width);
		$dialog.height(opation.height);

		var top = ($(window).height() - $dialog.outerHeight()) / 2;
		var left = ($(window).width() - $dialog.outerWidth()) / 2;
		$dialog.css("top", top + "px");
		$dialog.css("left", left + "px");

		$(".title", $dialog).html(title);

		if(opation.closeable) {
			$("<div class='close'><i class='icon-remove'></i></div>").appendTo($(".operationbar", $dialog));
		}
		
		return $dialog;
		
	}
	
	function setEvent($obj, opation) {
		
		opation = $.extend({}, defaultOpation, opation);
		
		if(opation.removable) {
			$(".head", $obj).addClass("dialog-move");
			$(".dialog-move", $obj).mousedown(function(e) {
				dragMove.start($obj, e);
                document.onselectstart = function () {
                     return false;
                 };
                 return false;
			});
		}
		
		if(opation.resizeable) {
			$("<div class='dialog-resize dialog-dragn'></div>").appendTo($obj);
			$("<div class='dialog-resize dialog-dragw'></div>").appendTo($obj);
			$("<div class='dialog-resize dialog-drage'></div>").appendTo($obj);
			$("<div class='dialog-resize dialog-drags'></div>").appendTo($obj);
			$("<div class='dialog-resize dialog-dragwn'></div>").appendTo($obj);
			$("<div class='dialog-resize dialog-dragen'></div>").appendTo($obj);
			$("<div class='dialog-resize dialog-dragws'></div>").appendTo($obj);
			$("<div class='dialog-resize dialog-drages'></div>").appendTo($obj);
			
			$(".dialog-resize", $obj).mousedown(function(e) {
				
				if($(this).hasClass("dialog-dragwn")) {
					dragResize.start($obj, "wn", e);
				}
				else if($(this).hasClass("dialog-dragn")) {
					dragResize.start($obj, "n", e);
				}
				else if($(this).hasClass("dialog-dragen")) {
					dragResize.start($obj, "en", e);
				}
				else if($(this).hasClass("dialog-dragw")) {
					dragResize.start($obj, "w", e);
				}
				else if($(this).hasClass("dialog-drage")) {
					dragResize.start($obj, "e", e);
				}
				else if($(this).hasClass("dialog-dragws")) {
					dragResize.start($obj, "ws", e);
				}
				else if($(this).hasClass("dialog-drags")) {
					dragResize.start($obj, "s", e);
				}
				else if($(this).hasClass("dialog-drages")) {
					dragResize.start($obj, "es", e);
				}
                document.onselectstart = function () {
                     return false;
                 };
                 return false;
			});
		}

		if(opation.closeable) {
			$(".head .operationbar .close", $obj).click(function() {
				$obj.remove();
				return false;
			});
		}
	}

	function getDialog(id) {
		if(null == id || typeof id == "undefined") {
			return $(".dialog.active");
		}
	}

	function getDialogContent(id) {
		var $obj = getDialog(id);
		return $(".content", $obj);
	}

	function close(id) {
		if(null == id || typeof id == "undefined") {
			$(".dialog.active").remove();
		}
	}
	
	return {
		
		open : function(title, opation) {
			var $dialog = create(title, opation);
			setEvent($dialog, opation);
			$dialog.appendTo($("#popupage"));
			utils.resize($dialog);
			return $dialog;
		},

		getDialog : function(id) {
			return getDialog(id);
		},

		getDialogContent : function(id) {
			return getDialogContent();
		},

		close : function(id) {
			close(id);
		}
		
	};
	
}(jQuery));