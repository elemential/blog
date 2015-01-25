<?
	require_once(__DIR__.'/../require.php');
	
	if ( isset($_SESSION['ok']) && $_SESSION['ok'] === 'true' ){
		// Ha be vagyunk jelentkezve
		require('engine/templates/loginform-loggedin.tpl');
	} else {
		// Ha nem vagyunk bejelentkezve
		require('engine/templates/loginform-notloggedin.tpl');
	}
?>