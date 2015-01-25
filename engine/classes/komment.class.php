<?
require_once(__DIR__.'/../require.php');
class Komment {
	
	private $ab ;
	private $id ;
	private $datum ;
	private $tartalom ;
	private $szerzo_id ;
	private $szerzo_nev ;
	private $szerzo_teljes_nev ;
	private $hozzaszolas_ok=false;
	
	public function __construct($id, $tartalom=false){
		if ($id==0){
			query(
				"INSERT INTO hozzaszolasok (szerzo_id, tartalom) VALUES (#1, @2)",
				$_SESSION['f_id'],
				$tartalom
			);
		}
		$komment_eredmeny = query("
			SELECT
				k.id               AS k_id,
				k.datum            AS k_datum,
				k.tartalom         AS k_tartalom,
				f.id               AS f_id,
				f.felhasznaloi_nev AS f_nev,
				f.teljes_nev       AS f_teljes_nev
			FROM hozzaszolasok AS k
			JOIN felhasznalok AS f
				ON k.szerzo_id = f.id
			WHERE k.id = #1
			ORDER BY datum DESC",
			$id);
		if ( $komment_eredmeny -> num_rows == 0 ){
			$this -> nemTalalhato();
		} else {
			$aktualis_komment = $komment_eredmeny -> fetch_assoc();
			$this -> id = $aktualis_komment['k_id'];
			$this -> datum = $aktualis_komment['k_datum'];
			$this -> tartalom = $aktualis_komment['k_tartalom'];
			$this -> szerzo_id = $aktualis_komment['f_id'];
			$this -> szerzo_nev = $aktualis_komment['f_nev'];
			$this -> szerzo_teljes_nev = $aktualis_komment['f_teljes_nev'];
		}
	}
	
    public function megjelenit(){
        
		$sablon = file_get_contents('engine/templates/komment'.(($_SESSION['f_id']===$this->szerzo_id)?'_szerk':'').'.tpl');
		
        $mit = array(
                     '%szerzo%',
					 '%datum%',
                     '%tartalom%',
                     );
        $mire = array(
                      $this -> id,
					  $this -> datum,
                      $this -> tartalom,
                      );
        $sablon = str_replace( $mit, $mire, $sablon );
        echo $sablon;
    }
	public function nemTalalhato(){
		echo "HIBA: Hiányzó hozzászólás.<br>" ;
	}
	
	public function update($tartalom=false){
		$tartalom=$tartalom?$tartalom:'tartalom';
		query("
			UPDATE hozzaszolasok (tartalom)
			VALUES (@1)
			WHERE id=#2",
			$ab -> real_escape_string( strip_tags( $tartalom, '<a><b><i>' ) ),
			$this -> id
		);
	}
}

?>
