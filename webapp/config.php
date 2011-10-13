<?

$config="ok";
/*
	Dati di connessione al db e a ldap
*/
define('DB_HOST',   'localhost');
define('DB_PORT',   '6543');
define('DB_USER',   'prjadmin');
define('DB_PSW',    '');
define('DB_SCHEMA', 'metopack');

/*
	importazione librerie di accesso al db
*/
require_once 'MDB2.php';

$options=Array('spt'=> Array('SE', 'ME'));

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
