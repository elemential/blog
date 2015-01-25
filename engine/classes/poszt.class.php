<?
require_once(__DIR__.'/../require.php');
class Poszt {
	
	private $ab ;
	private $id ;
	private $cim ;
	private $datum ;
	private $tartalom ;
	private $hozzaszolas_ok ;
	private $szerzo_id ;
	private $szerzo_nev ;
	private $szerzo_teljes_nev ;
	private $hozzaszolasok ;
	private $cimkek ;
	
	public function __construct($id, $ab){
		$this -> ab = $ab ;
		$this -> cimkek = Array();
		$res=query("
			SELECT
				p.id               AS p_id,
				p.cim              AS p_cim,
				p.datum            AS p_datum,
				p.tartalom         AS p_tartalom,
				p.hsz_lehet        AS p_hsz_lehet,
				f.id               AS f_id,
				f.felhasznaloi_nev AS f_nev,
				f.teljes_nev       AS f_teljes_nev
			FROM posztok AS p
			JOIN felhasznalok AS f
				ON p.szerzo_id = f.id
			WHERE p.id = #1",
			$id);
		if ( $res -> num_rows == 0 ){
			$this -> nemTalalhato();
		} else {
			$aktualis_poszt = $res -> fetch_assoc();
			$this -> id = $aktualis_poszt['p_id'];
			$this -> cim = $aktualis_poszt['p_cim'];
			$this -> datum = $aktualis_poszt['p_datum'];
			$this -> tartalom = $aktualis_poszt['p_tartalom'];
			$this -> hozzaszolas_ok = $aktualis_poszt['p_hsz_lehet'];
			$this -> szerzo_id = $aktualis_poszt['f_id'];
			$this -> szerzo_nev = $aktualis_poszt['f_nev'];
			$this -> szerzo_teljes_nev = $aktualis_poszt['f_teljes_nev'];
			$this -> hozzaszolasok = array();
			
			$res=query("
				SELECT id
				FROM hozzaszolasok
				WHERE poszt_id = #1
				ORDER BY datum DESC",
				$this -> id );
			while ( $komment = $res -> fetch_assoc()){
				$this->hozzaszolasok[] = new Komment( $komment['id'], $this-> ab );

			}

			$res=query("
				SELECT c.id, c.nev
				FROM cimkek AS c
				JOIN posztCimkek AS pc
					ON c.id = pc.cimke_id
				JOIN posztok AS p
					ON pc.poszt_id = p.id
				WHERE p.id = #1",
				$this -> id ) ;
			while ( $cimke = $res -> fetch_assoc() ){
				$uj_cimke = new Cimke($cimke['id'],$cimke['nev']);				
				$this -> cimkek[] = $uj_cimke ;
			}
			$this -> megjelenit();
		}
	}
	
	public function megjelenit(){
		
		$cimkek_html_kimenet = '' ;
		foreach ( $this -> cimkek as $aktualis_cimke ){
			$cimkek_html_kimenet .= $aktualis_cimke -> megjelenit() ;
		}
		
		$kommentek_html_kimenet = '' ;
		if ( $this -> hozzaszolas_ok == 1 ){
			foreach ( $this -> hozzaszolasok AS $hsz ){
				$kommentek_html_kimenet .= $hsz -> megjelenit() ;
			}
		}
		
		$sablon = file_get_contents('engine/templates/poszt.tpl');
		$mit = array(
			'%id%',
			'%cim%',
			'%szerzo%',
			'%datum%',
			'%tartalom%',
			'%cimkek%',
			'%hozzaszolasok%'
			);
		$mire = array(
			$this -> id,
			$this -> cim,
			( $this -> szerzo_teljes_nev == '')
				? $this->szerzo_nev
				: $this->szerzo_teljes_nev,
			$this -> datum,
			$this -> tartalom,
			$cimkek_html_kimenet,
			$kommentek_html_kimenet
			);
		$sablon = str_replace( $mit, $mire, $sablon );
		echo $sablon ;

		if ( $this -> hozzaszolas_ok == 1 && isset($_SESSION['ok']) && $_SESSION['ok'] === 'true' ){
			$sablon = file_get_contents('engine/templates/comment_form.tpl');
			$mit = '%poszt_id%' ;
			$mire = $this -> id ;
			$sablon = str_replace( $mit, $mire, $sablon );
			echo $sablon ;
		}
		
	}
	
	public function nemTalalhato(){
		echo "HIBA: 404, a keresett bejegyzés nem található.<br>" ;
	}
	
}

?>
