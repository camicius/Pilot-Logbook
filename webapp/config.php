<?
error_reporting(E_ALL & ~E_DEPRECATED);
$config="ok";
/*
	Dati di connessione al db e a ldap
*/
require_once 'params.php';


/*
	importazione librerie di accesso al db
*/
require_once 'MDB2.php';
/*

*/
define('PIC',     'PIC');
define('COP',     'Copilot');
define('DUAL',     'Dual');
$options=Array('spt'=> Array('S', 'M'),
			   'function' => Array (PIC, COP,DUAL),

);

/*
costanti booleane sul db
*/
define('TRUE',     'S');
define('FALSE',     'N');
/*
	importazione libreria di query upacontratti e di file accessori
*/
require_once 'sql.php';
require_once 'html.php';
require_once 'funzioni.php';
require_once 'Formvalidator.php';
require_once "Auth.php";
require_once 'fpdf/fpdf.php';
/*
	connessione al db
*/
$dsn='pgsql://' . DB_USER . ':' . DB_PSW . '@tcp(' . DB_HOST . ':' . DB_PORT . ')/' . DB_SCHEMA;

//$dsn='pgsql://' . DB_USER . '@unix(' . DB_HOST . ')/' . DB_SCHEMA;

$db =& MDB2::connect($dsn);
if (PEAR::isError($db)) {
	//print_r($db);
	echo "d'oh!";
    die($db->getMessage());
}

$db->setFetchMode(MDB2_FETCHMODE_ASSOC);

date_default_timezone_set('Europe/Rome');

?>
