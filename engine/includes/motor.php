<?
	session_start() ;
	
	require_once(__DIR__.'/../require.php');
	require('login.php');
	
	// Új blogposzt beszúrása az adatbázisba
	if ( isset($_SESSION['ok']) && $_SESSION['ok'] === 'true' ){
		if (isset($_POST['poszt_cime'], $_POST['poszt_tartalma'], $_POST['poszt_cimkek'])){
			$poszt_cimkek = explode(';',$_POST['poszt_cimkek']);
			print_r($poszt_cimkek);
			query("
				INSERT INTO posztok (cim, tartalom, szerzo_id, hsz_lehet)
				VALUES ('@1','@2',#3,?4)",
				$ab -> real_escape_string( strip_tags( $_POST['poszt_cime'] ) ),
				$ab -> real_escape_string( strip_tags( $_POST['poszt_tartalma'], '<a><b><i>' )),
				$_SESSION['f_id'],
				isset( $_POST['hsz_lehet'] )
			) ;
			$poszt_id = sqlid();
			foreach ( $poszt_cimkek as $aktualis_cimke ){
				$aktualis_cimke = trim( $aktualis_cimke );
				$cimke_adatbazisban_eredmeny = query("
					SELECT id
					FROM cimkek
					WHERE nev = @1",
					$ab -> real_escape_string( $aktualis_cimke) );
				if ( $cimke_adatbazisban_sor = $cimke_adatbazisban_eredmeny -> fetch_assoc() ){
					$aktualis_cimke_id = $cimke_adatbazisban_sor['id'] ;
					query("
						INSERT INTO posztCimkek
						VALUES (#1, #2)",
						$poszt_id,
						$aktualis_cimke_id );
				} else {
					// Beszúrjuk az új címkét az adatbázisba
					query("
						INSERT INTO cimkek (nev)
						VALUES (@1)",
						$ab -> real_escape_string( strip_tags( $aktualis_cimke ) ) );
					// Visszakérjük az új címke azonosítóját
					$uj_cimke_id = sqlid() ;
					// Összerendeljük az új címkét a poszttal
					query("
						INSERT INTO posztCimkek
						VALUES (#1, #2)",
						$poszt_id,
						$uj_cimke_id );
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
    //Szerkesztett komment beszúrása az adatbázisba
    if (isset($_SESSION['ok']) && $_SESSION['ok'] === 'true' ){
        if (isset($_POST['comment'], $_GET['comment_id'])){
            $beszuro_lekerdezes = sprintf("
                UPDATE hozzaszolasok (tartalom)
                VALUES ('%s')
                WHERE id=%d",
                $ab -> real_escape_string( strip_tags( $_POST['comment'], '<a><b><i>' ) ),
                $_GET[comment_id]
                        ) ;
        $ab -> query($beszuro_lekerdezes) ;
    }
}
	
?>