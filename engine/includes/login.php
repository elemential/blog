<?

	if ( isset( $_POST['fnev'], $_POST['jelszo'] ) ){
		$lekerdezes = sprintf("
			SELECT id, felhasznaloi_nev, teljes_nev
			FROM felhasznalok
			WHERE felhasznaloi_nev = '%s'
			AND jelszo = '%s'",
			$ab -> real_escape_string( $_POST['fnev'] ),
			md5( $_POST['jelszo'] ) ) ;
		$eredmeny = $ab -> query( $lekerdezes );
		if ( $eredmeny -> num_rows == 1 ){ // Siker
			$sor = $eredmeny -> fetch_assoc() ;
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
