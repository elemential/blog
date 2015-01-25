<?
	session_start() ;
	$ab = new mysqli('localhost','root','E==m*c^13','bejelentkezes');
	$ab -> set_charset('utf8');
	
	require_once('functions.php');
	require('login.php');
	
	// Új blogposzt beszúrása az adatbázisba
	if ( isset($_SESSION['ok']) && $_SESSION['ok'] === 'true' ){
		if (isset($_POST['poszt_cime'], $_POST['poszt_tartalma'], $_POST['poszt_cimkek'])){
			$poszt_cimkek = explode(';',$_POST['poszt_cimkek']);
			print_r($poszt_cimkek);
			$beszuro_lekerdezes = sprintf("
				INSERT INTO posztok (cim, tartalom, szerzo_id, hsz_lehet)
				VALUES ('%s','%s',%d,%d)",
				$ab -> real_escape_string( strip_tags( $_POST['poszt_cime'] ) ),
				$ab -> real_escape_string( strip_tags( $_POST['poszt_tartalma'], '<a><b><i>' )),
				$_SESSION['f_id'],
				( isset( $_POST['hsz_lehet'] ) ? 1 : 0 )
			) ;
			$ab -> query($beszuro_lekerdezes) ;
			$poszt_id = $ab -> insert_id ;
			foreach ( $poszt_cimkek as $aktualis_cimke ){
				$aktualis_cimke = trim( $aktualis_cimke );
				$cimke_adatbazisban_lekerdezes = sprintf("
					SELECT id
					FROM cimkek
					WHERE nev = '%s'",
					$ab -> real_escape_string( $aktualis_cimke) );
				$cimke_adatbazisban_eredmeny = $ab -> query( $cimke_adatbazisban_lekerdezes );
				if ( $cimke_adatbazisban_sor = $cimke_adatbazisban_eredmeny -> fetch_assoc() ){
					$aktualis_cimke_id = $cimke_adatbazisban_sor['id'] ;
					$cimke_poszthoz_lekerdezes = sprintf("
						INSERT INTO posztCimkek
						VALUES (%d, %d)",
						$poszt_id,
						$aktualis_cimke_id );
					$ab -> query($cimke_poszthoz_lekerdezes);
				} else {
					// Beszúrjuk az új címkét az adatbázisba
					$uj_cimke_lekerdezes = sprintf("
						INSERT INTO cimkek (nev)
						VALUES ('%s')",
						$ab -> real_escape_string( strip_tags( $aktualis_cimke ) ) );
					$ab -> query($uj_cimke_lekerdezes);
					// Visszakérjük az új címke azonosítóját
					$uj_cimke_id = $ab -> insert_id ;
					// Összerendeljük az új címkét a poszttal
					$cimke_poszthoz_lekerdezes = sprintf("
						INSERT INTO posztCimkek
						VALUES (%d, %d)",
						$poszt_id,
						$uj_cimke_id );
					$ab -> query($cimke_poszthoz_lekerdezes);
				}
			}
		}
	}
	
	// Új komment beszúrása az adatbázisba
	if ( isset($_SESSION['ok']) && $_SESSION['ok'] === 'true' ){
		if (isset($_POST['comment'], $_GET['poszt_id'])){
			$beszuro_lekerdezes = sprintf("
				INSERT INTO hozzaszolasok (tartalom, szerzo_id, poszt_id)
				VALUES ('%s',%d,%d)",
				$ab -> real_escape_string( strip_tags( $_POST['comment'], '<a><b><i>' ) ),
				$_SESSION['f_id'],
				$_GET['poszt_id']
			) ;
			$ab -> query($beszuro_lekerdezes) ;
		}
	}
	
?>