<?
	require_once(__DIR__.'/../require.php');
	
	if ( isset($_SESSION['ok']) && $_SESSION['ok'] === 'true' ){
		require('engine/templates/ujposzt-loggedin.tpl');
	} else {
		require('engine/templates/ujposzt-notloggedin.tpl');
	}
?>