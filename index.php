<?
	//Start of index.php
	require_once('engine/require.php');
	require_once('engine/includes/motor.php');
?>
<!DOCTYPE HTML>
<html><head>
	<meta charset="utf-8">
	<title>VPG Blog</title>
	<link rel="stylesheet" type="text/css" href="./assets/style/style.css" />
</head><body onload="JSL('assets/style/main.js');">
    <script>
        //gyorsított betöltődés
        
        function JSL(call) {
        var element = document.createElement("script");
        element.src = call;
        document.body.appendChild(element);
        }
          
          JSL("http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"); 
    </script> 
	<div id="fejlecKontener">
		<header>
			<h1>VPG szakkör blog</h1>
		</header>
	</div>
	<div id="tartalomKontener">
		<aside id="oldalsav">
			<? require('engine/includes/loginform.php'); ?>
		</aside>
		<article>
			<? require('engine/includes/tartalom.php'); ?>
		</article>
		<div class="clearer"></div>
	</div>
	<div id="lablecKontener">
		<footer>
			Copyright
		</footer>
	</div>
</body></html>
