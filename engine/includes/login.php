<?
	require_once(__DIR__.'/../require.php');
	if ( isset( $_POST['fnev'], $_POST['jelszo'] ) ){
		$res=query("
			SELECT id, felhasznaloi_nev, teljes_nev
			FROM felhasznalok
			WHERE felhasznaloi_nev = @1
			AND jelszo = @2",
			$ab -> real_escape_string( $_POST['fnev'] ),
			md5( $_POST['jelszo'] ) ) ;
		if ( $res -> num_rows == 1 ){ // Siker
			$sor = $res -> fetch_assoc() ;
			$_SESSION['ok'] = 'true' ;
			$_SESSION['f_id'] = $sor['id'] ;
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
