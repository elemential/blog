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
<<<<<<< HEAD
</head><body>
	<div id="fejlecKontener">
		<header>
			<h1>VPG szakkör blog</h1>
=======
    <link rel="stylesheet" type="text/css" href="./assets/style/main.js" />
    <script>
           fome = { primaryColor : '#666',
            theme : 0 };
    </script>
    
    
</head> <body onload="JSL('assets/style/main.js');">
    <script>
        //gyorsított betöltődés
        
        function JSL(call) {
        var element = document.createElement("script");
        element.src = call;
        document.body.appendChild(element);
        }
          
          JSL("http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"); 
    </script> 
    
    <fome-menu></fome-menu>
    <!-- <img src="assets/images/profile_icon.png" > -->
    
	<div id="fejlecKontener">
		<header>
			<h1 onclick="location.href='index.php'">VPG szakkör blog</h1>         
            <img src="assets/images/up.png" width="40px" class="off">
>>>>>>> c36cff95522272f3cfaf32b04dc1d16e2cdb8512
		</header>
	</div>
	<div id="tartalomKontener">
		<aside id="oldalsav">
			<?php require('engine/includes/loginform.php'); ?>
		</aside>
		<article>
			<?php require('engine/includes/tartalom.php'); ?>
		</article>
		<div class="clearer"></div>
	</div>
	<div id="lablecKontener">
		<footer>
			Copyleft 2014<br><br>
            Készítette: VPG Webfejlesztés szakkör 2013-2014-ben
            <img src="assets/images/up.png" class="buttup">
		</footer>
	</div>
<<<<<<< HEAD
=======
    
   <link rel="import" href="http://elemential.net/polyfome/include_minimalist.html">
     <link rel="import" href="http://elemential.net/polyfome/elementile.html">
          
>>>>>>> c36cff95522272f3cfaf32b04dc1d16e2cdb8512
</body></html>
