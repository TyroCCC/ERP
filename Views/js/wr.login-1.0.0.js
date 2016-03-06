var wr_login = (function($) {
	
	var RSAKey = null;
	
	function getRSAKey() {
		
		var modulus = "";
		var exponent = "";
		
		$.ajax({
			type : "post",
			url : "getRSAParams",
			dataType : "json",
			async: false,
			success : function(json) {
				modulus = json.modulus;
				exponent = json.exponent;
				RSAKey = RSAUtils.getKeyPair(exponent, '', modulus);
			},
			error : function() {
				alert("与服务器通信失败！");
			}
		});
	}
	
	function initUI() {
		getRSAKey();
	}
	
	return {
		init : function() {
			initUI();
		},
		
		login : function(obj) {
			
			$("#loginForm").append($(obj).find("input").clone());
			$("input[data-type='rsapassword']", $("#loginForm")).each(function() {
				var $this = $(this);
				if(RSAKey == null) {
					return false;
				}
				$this.val(RSAUtils.encryptedString(RSAKey, $this.val()));
			});
			
			$("#loginForm").submit();
			return false;
		}
	};
})(jQuery);