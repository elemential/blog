<?
	require_once(__DIR__.'/../require.php');
	
	if ( isset( $_GET['muvelet']) ){
		if ( $_GET['muvelet'] == 'uj_poszt' ){
			require('ujposzt.php');
		} elseif ( $_GET['muvelet'] == 'poszt' && isset( $_GET['poszt_id'] ) ) {
			$poszt = new Poszt( $_GET['poszt_id'], $ab ) ;
		} elseif ( $_GET['muvelet'] == 'cimke' && isset( $_GET['cimke_id'] ) ) {
			
			$cimke_posztok_lekerdezes = sprintf('
				SELECT p.id AS id
				FROM posztok AS p
				JOIN posztCimkek AS pc
				ON p.id = pc.poszt_id
				WHERE pc.cimke_id = %d',
				$_GET['cimke_id'] );
			$cimke_posztok_eredmeny = $ab -> query( $cimke_posztok_lekerdezes );
			while ( $aktualis_poszt = $cimke_posztok_eredmeny -> fetch_assoc()){
				$poszt = new Poszt( $aktualis_poszt['id'], $ab );
			}
		}
	} else { // Ha nincs megadott művelet, az összes cikket megjelenítjük
		$poszt_id_lekerdezes = "
			SELECT id
			FROM posztok
			ORDER BY datum DESC" ;
		$poszt_id_eredmeny = $ab -> query($poszt_id_lekerdezes);
		while ( $aktualis_poszt = $poszt_id_eredmeny -> fetch_assoc()){
			$poszt = new Poszt( $aktualis_poszt['id'], $ab );
		}
	}
?>