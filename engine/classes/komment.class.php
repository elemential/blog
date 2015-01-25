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
	
	public function __construct($id, $ab){
		$this -> ab = $ab ;
		$komment_lekerdezes = sprintf("
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
			WHERE k.id = %d",
			$id);
		$komment_eredmeny = $this -> ab -> query( $komment_lekerdezes ) ;
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
        
        
        $sablon = file_get_contents('engine/templates/comment_form_szerk.tpl');
        $mit = array(
                     '%cim%',
                     '%comment_id%'
                     '%tartalom%',
                     );
        $mire = array(
                      $this -> cim,
                      $this -> id,
                      $this -> tartalom,
                      );
        $sablon = str_replace( $mit, $mire, $sablon );
        echo $sablon ;
        
        
        
        if ( $this -> hozzaszolas_ok == 1 && isset($_SESSION['ok']) && $_SESSION['ok'] === 'true' ){
            $sablon = file_get_contents('engine/templates/comment_form.tpl');
            $mit = '%poszt_id%' ;
            $mire = $this -> id ;
            $sablon = str_replace( $mit, $mire, $sablon );
            echo $sablon ;
            
            
            $sablon = file_get_contents('engine/templates/komment.tpl');
            $mit = array(
                         '%szerzo%',
                         '%datum%',
                         '%tartalom%'
                         );
            $mire = array(
                          ( $this -> szerzo_teljes_nev == '')
                          ? $this->szerzo_nev
                          : $this->szerzo_teljes_nev,
                          $this -> datum,
                          $this -> tartalom
                          );
            $sablon = str_replace( $mit, $mire, $sablon );
            return $sablon ;
            
            
            
        }
    }
	public function nemTalalhato(){
		echo "HIBA: Hiányzó hozzászólás.<br>" ;
	}
	
}

?>
