<?

/**contiene tutta la parte di registrazione

*/

session_start();
ob_start();
require_once('config.php');

html_header();

$optionsAuth = array(
	'dsn' => $dsn,
	'table' => 'dat.auth'
  );

if ( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordrpt']) ) {
	if($_POST['password'] != $_POST['passwordrpt']){
		html_login("register.php", "Le due password non coincidono!");
	}else{
		$a = new Auth("MDB2", $optionsAuth, "loginFunction");
		$a->start();
		$a->addUser($_POST['username'],$_POST['password']);
		$sql="INSERT INTO dat.logbook (username, depplace, arrplace, deptime, arrtime, multipilot, totalflighttime, nighttime, ifrtime, pictime, coptime, dualtime, instrtime)
				VALUES ( %%USER%%, 'T0T0', 'T0T0', '1970-01-01 00:00:00', '1970-01-01 00:00:00', 0,0,0,0,0,0,0,0);"	;
	 	$sql=str_replace(COSTANTE_USER,$db->quote($_POST['username'], 'text'), $sql);
		$res=$db->query($sql);

		if (PEAR::isError($res)) {
		//	var_dump($res);
			errore("register - ".$res->getUserInfo());
		}
		echo "<h3>Procedi al login, con la password scelta!</h3>";
		mail (MAILTO , "Logbook - Registrato nuovo utente" , "Registrato nuovo utente: \n username" . $_POST['username']);
		html_login();
    }
}else{
	html_login("register.php");

}


html_footer();

require_once('debriefing.php');
ob_flush();
?>
