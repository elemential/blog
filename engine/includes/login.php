<?
  //session_start();  
  
  require_once("lapisclient.php");
  
  $lapis = new Lapis("lapisSessionId");
  
	if ( isset( $_GET['sessionid'] ) ){
	  
	  $lapis->login();
	  
		$lekerdezes = sprintf("
			SELECT felhasznaloi_nev, teljes_nev
			FROM felhasznalok
			WHERE id=%d",
			$lapis->getUserId() ) ;
		$eredmeny = $ab -> query( $lekerdezes );
		if ( $eredmeny -> num_rows == 1 ){ // Siker
			$sor = $eredmeny -> fetch_assoc() ;
			$_SESSION['ok'] = 'true' ;
			$_SESSION['f_id'] = $lapis->getUserId() ;
			$_SESSION['f_nev'] = $sor['felhasznaloi_nev'] ;
			$_SESSION['f_teljes_nev'] = $sor['teljes_nev'] ;
		} else { // Hiba
			unset( $_SESSION ) ;
			$_SESSION['ok'] = 'false' ;
			session_destroy() ;
		}
	}

	if ( isset( $_POST['kijelentkezes'] ) ){
		unset( $_SESSION ) ;
		$_SESSION['ok'] = 'false' ;
		session_destroy() ;
	}

?>
