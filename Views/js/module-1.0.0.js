var searchmodule = (function($) {
	
	function init(data) {
		
		var module = "";
		if(typeof data != "undefind" && data.length > 0) {
			
			module += "<div class='search'>";
			
			for(var i = 0; i < data.length; i++) {
				if(typeof data[i].type != "undefind" && data[i].type == "text") {
					module += "<div class='searchitem'><span>" + data[i].name + ":</span><input name='" + data[i].id + "' type='" + data[i].type + "'></div>";
				}
			}
			
			module += "<div class='searchbutton'><button>查  询</button></div></div>";
		}
		
		return module;
	}
	
	return {
		init : function(data) {
			return init(data);
		}
	};
	
})(jQuery);

var buttonmodule = (function($) {
	
	function init(data) {
		
		var module = "";
		if(typeof data != "undefind" && data.length > 0) {
			
			module += "<div class='operation'>";
			
			for(var i = 0; i < data.length; i++) {
				module += "<div class='operationbutton'><button><i class='" + data[i].BtnIcon + "'></i>" + data[i].BtnName +"</button></div>";
			}
			
			module += "</div>";
		}
		
		return module;
	}

	return  {
		init : function(data) {
			return init(data);
		}
	};
})(jQuery);
