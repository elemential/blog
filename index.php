<?
	//Start of index.php
	require_once('engine/includes/motor.php');
?>
<!DOCTYPE HTML>
<html><head>
	<meta charset="utf-8">
	<title>VPG Blog</title>
	<link rel="stylesheet" type="text/css" href="./assets/style/style.css" />
    <script>
           fome = { primaryColor : '#666',
            theme : 0 };
    </script>
</head><body>
    
    <fome-menu></fome-menu>
    
   
	<div id="fejlecKontener">
		<header>
			<h1>BLOG</h1>
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
   <link rel="import" href="http://elemential.net/polyfome/include_minimalist.html">
     <link rel="import" href="http://elemential.net/polyfome/elementile.html">
</body></html>
