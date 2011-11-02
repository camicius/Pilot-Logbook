<?
session_start();
ob_start();
require_once('config.php');

html_header();

$options = array(
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


html_footer();

require_once('debriefing.php');
ob_flush();
?>
