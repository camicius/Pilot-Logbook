<?
session_start();
require_once('config.php');

html_header();

$options = array(
 // 'file' => "passwordfile.csv",
	'dsn' => $dsn,
	'table' => 'dat.auth'
  );
$a = new Auth("MDB2", $options, "loginFunction");
$a->start();
if ( isset($_GET['logout']) && $a->checkAuth()) {
	unset($_SESSION['username']);
    $a->logout();
    $a->start();
}
if ($a->checkAuth()){
	$_SESSION['username']=$a->getUsername();
	pagina();
}



















/*
if (isset($_GET['logout'])){
	unset($_SESSION['username']);
	html_login();
}

else if(isset($_SESSION['username'])){
	//sono loggato!
	$username=$_SESSION['username'];

	pagina();

}else if (isset($_POST['username']) && isset($_POST['password'])){
	//verifica la password 
	
	$username=$_POST['username'];
	$password=$_POST['password'];
	$ok=verificaPassword($username, $password);
	//echo "password ok! <BR> <BR>";
	if($ok){
		$_SESSION['username']   = $username;
		pagina();	

		
	}else{
		html_login("Username o password errata!");
	}

}else{
	html_login();
}*/

html_footer();



require_once('debriefing.php');
?>
