<?
	if ( isset( $_GET['muvelet']) ){
		if ( $_GET['muvelet'] == 'uj_poszt' ){
			require('ujposzt.php');
		} elseif ( $_GET['muvelet'] == 'poszt' && isset( $_GET['poszt_id'] ) ) {
			$poszt = new Poszt( $_GET['poszt_id'], $ab ) ;
		} elseif ( $_GET['muvelet'] == 'cimke' && isset( $_GET['cimke_id'] ) ) {
			
			$res=query('
				SELECT p.id AS id
				FROM posztok AS p
				JOIN posztCimkek AS pc
				ON p.id = pc.poszt_id
				WHERE pc.cimke_id = #1',
				$_GET['cimke_id'] );
			while ( $aktualis_poszt = $res -> fetch_assoc()){
				$poszt = new Poszt( $aktualis_poszt['id'], $ab );
			}
		}
	} else { // Ha nincs megadott művelet, az összes cikket megjelenítjük
		$res=query("
			SELECT id
			FROM posztok
			ORDER BY datum DESC");
		while ( $aktualis_poszt = $res -> fetch_assoc()){
			$poszt = new Poszt( $aktualis_poszt['id'], $ab );
		}
	}
?>