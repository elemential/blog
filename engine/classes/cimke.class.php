<?
require_once(__DIR__.'/../require.php');
class Cimke {
	
	private $id ;
	private $nev ;

	public function __construct($id, $nev){
		// Itt szeretnénk beállítani a címke adatait
		$this -> id  = $id ;
		$this -> nev = $nev ;
	}
	
	public function megjelenit(){
		$sablon = file_get_contents('engine/templates/cimke.tpl');
		$mit = array(
			'%id%',
			'%nev%'
			);
		$mire = array(
			$this -> id,
			$this -> nev
			);
		$sablon = str_replace( $mit, $mire, $sablon );
		return $sablon ;
	}

}

?>