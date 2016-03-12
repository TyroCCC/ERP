<html>
  <head>
    <base href="<%=basePath%>">
    
    <title></title>
    <meta charset="utf-8">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	
	<link rel="stylesheet" type="text/css" href="../Views/css/base.css">
	<link rel="stylesheet" type="text/css" href="../Views/css/headpage.css">
	<link rel="stylesheet" type="text/css" href="../Views/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="../Views/css/menu.css">
	<link rel="stylesheet" type="text/css" href="../Views/css/navtab.css">
	<link rel="stylesheet" type="text/css" href="../Views/css/dialog.css">
	<link rel="stylesheet" type="text/css" href="../Views/css/module.css">
	
	<script type="text/javascript" src="../Views/js/jquery-1.7.2.js"></script>
	<script type="text/javascript" src="../Views/js/utils-1.0.0.js"></script>
	<script type="text/javascript" src="../Views/js/dragbar-1.0.0.js"></script>
	<script type="text/javascript" src="../Views/js/menu-1.0.0.js"></script>
	<script type="text/javascript" src="../Views/js/navtab-1.0.0.js"></script>
	<script type="text/javascript" src="../Views/js/dialog-1.0.0.js"></script>
	<script type="text/javascript" src="../Views/js/module-1.0.0.js"></script>
    <script type="text/javascript" src="../Views/js/pagecontroller-1.0.0.js"></script>
    <script type="text/javascript" src="../Views/js/operationcontroller-1.0.0.js"></script>
	
	<script type="text/javascript">
		window.onload = function() {
            operationcontroller.showLoading();
			dragBar.init($(document));
			menu.init();
			navtab.init();
			utils.resize();
            operationcontroller.hideLoading();
		};
		
		$(window).resize(function () {
			utils.resize();
		});
	</script>
  </head>
  
  <body>
  	<div id="basepage" class="basepage">
    	<div id="headpage" class="headpage">
    	</div>
    	<div class="verticaldragbar" UI_VerticalDragBar="previous"></div>
    	<div id="centerpage" class="centerpage" UI_ReSize="height" >
        	<div id="leftpage" class="leftpage" >
        		<div class="mainmenu" id="mainmenu">
					<ul class="menu"></ul>
				</div>
        	</div>
        	<div class="horizontaldargbar" UI_HorizontalDragBar="previous"></div>
        	<div id="rightpage" class="rightpage" UI_ReSize="width">
        		<div class="maincontent" UI_ReSize="width">
        			<div class="navtab" id="navtab"></div>
        		</div>
        	</div>
    	</div>
    	<div class="verticaldragbar" UI_VerticalDragBar="next"></div>
    	<div id="bottompage" class="bottompage"></div>
    </div>
    <div id="popupage" class="popuppage"></div>
    <div id="loadpage" class="loadpage">
        <div class="content">
            <img src="../Views/images/load.gif" class="loadimg"/>
        </div>
    </div>
  </body>
</html>
