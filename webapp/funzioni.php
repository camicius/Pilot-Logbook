 <?
if(!isset ($config)){ exit(127);}

function errore($testo){
	//html_errore($testo);
	echo $testo;
	echo '<br /><br /><br />';
	echo '<br /><br />Copia il testo qui sopra e mandalo a ced@confartigianato.bs.it <br /><br /><br />';
	echo '<a onClic="index.php">Ritorna alla pagina principale</a>';
	die();

}

function verificaPassword($username, $password){
	global $db;

//TODO
	$result="1";
	//
	//echo $result. "\n\n";
	if ($result=="1"){
		return true;
	}
	else{
		return false;
	}
}

function pagina(){
	// Costruzione della pagina
	if(isset($_GET['pk'])){										#richiamo la pagina della volo per la modifica
		$volo=getVolo($_GET['pk']);
		html_volo($volo);
	}else if(isset($_GET['new'])){ 								#richiamo la pagina della volo per l'inserimento
		html_volo();
	}else if(isset($_POST['nuovo']) && $_POST['nuovo']==booleanToDB(true)){	#ricevo la volo nuova e la inserisco
		$volo=insertVolo($_POST);
		html_volo($volo);
	
	}else if(isset($_POST['nuovo']) && $_POST['nuovo']==booleanToDB(false)){ 	#ricevo la volo vecchia e la modifico	
		$volo=updateVolo($_POST);
		html_volo($volo);
	}else{ 														#mostro l'elenco delle voli
		$tabella=getVoli();
		html_voli($tabella);
	}
	
}

function getVoli($quali="aperte"){
	global $sqlVoli, $sqlVoliMandamento, $db;
	$ordinamento="data";
	$tipoOrdinamento="asc";
	if($_SESSION['ruolo']==COSTANTE_ADMIN || $_SESSION['ruolo']==COSTANTE_ATTIV)
		$sql=$sqlVoli;
	else{
		$sql=$sqlVoliMandamento;
 		$sql=str_replace(COSTANTE_MANDAMENTO,$db->quote($_SESSION['mandamento'], 'text'), $sql);
	}

	$orderClause="";
	if(isset($_GET['ord'])){
		$orderClause .= "order by " . $_GET['ord'];
		$ordinamento = $_GET['ord'];
	}else{
		$orderClause="order by data";
	}

	if(isset($_GET['tipo'])){
		$orderClause .= " " . $_GET['tipo'];
		$tipoOrdinamento = $_GET['tipo'];
	}

	$sql=str_replace(COSTANTE_ORDER, $orderClause, $sql);
	if(isset($_GET['quali'])){
		switch ($_GET['quali']){
			case "tutte":
				$sql=str_replace(COSTANTE_LIMITE, "and true", $sql);
				break;
			case "aperte":
				$sql=str_replace(COSTANTE_LIMITE, "and chiusura='". FALSE . "'", $sql);
				break;
			case "chiuse":
				$sql=str_replace(COSTANTE_LIMITE, "and chiusura='". TRUE . "'", $sql);
				break;
		}
	}
	else{
		$sql=str_replace(COSTANTE_LIMITE, "and chiusura='". FALSE . "'", $sql);
	}
	$res=$db->query($sql);

	if (PEAR::isError($res)) {
	//	var_dump($res);
		errore("getVoli - ".$res->getUserInfo());
	}
	$voli =Array();	
	while (($row = $res->fetchRow())) {
    	$voli[]=$row;
	}
	
	return $voli;


}

function getVolo($pk){
	global $sqlVolo, $db;
	$sql=$sqlVolo;
 	$sql=str_replace(COSTANTE_PK,$db->quote($pk, 'text'), $sql);


	$res=$db->query($sql);

	if (PEAR::isError($res)) {
	//	var_dump($res);
		errore("getVolo - ".$res->getUserInfo());
	}
	while (($row = $res->fetchRow())) {
    	$voli[]=$row;
	}

	return $voli[0];


}

function insertVolo($volo){
	//print_r($volo);
	global $sqlInsertVolo, $db;
	$sql=$sqlInsertVolo;

	if($volo['protocollo']=="") $volo['pec_attiva']=booleanToDB(true);
	$volo['pec_attiva']=        formToDB($volo,'pec_attiva');
	$volo['cns_richiesta']=     formToDB($volo,'cns_richiesta');
	$volo['cns_attiva']=        formToDB($volo,'cns_attiva');
	$volo['comunica_incarico']= formToDB($volo,'comunica_incarico');
	$volo['comunica_invia']=    formToDB($volo,'comunica_invia');
	$volo['comunica_evasa']=    formToDB($volo,'comunica_evasa');
	$volo['chiusura']=          formToDB($volo,'chiusura');

	$sql=str_replace(COSTANTE_MANDAMENTO,   $db->quote($volo['mandamento'],         'text'), $sql);
	$sql=str_replace(COSTANTE_UTENTE,       $db->quote($_SESSION['username'],          'text'), $sql);
	$sql=str_replace(COSTANTE_AU,           $db->quote($volo['au'],                 'text'), $sql);
	$sql=str_replace(COSTANTE_RAGSOC,       $db->quote($volo['ragsoc'],             'text'), $sql);
	$sql=str_replace(COSTANTE_REA,          $db->quote($volo['rea'],                'text'), $sql);
	$sql=str_replace(COSTANTE_INDIRIZZO,    $db->quote($volo['indirizzo'],          'text'), $sql);
	$sql=str_replace(COSTANTE_PROTOCOLLO,   $db->quote($volo['protocollo'],         'text'), $sql);
	$sql=str_replace(COSTANTE_PECATTIVA,    $db->quote($volo['pec_attiva'],         'text'), $sql);
	$sql=str_replace(COSTANTE_CNSRICHIESTA, $db->quote($volo['cns_richiesta'],      'text'), $sql);
	$sql=str_replace(COSTANTE_CNSATTIVA,    $db->quote($volo['cns_attiva'],         'text'), $sql);
	$sql=str_replace(COSTANTE_COMINCARICO,  $db->quote($volo['comunica_incarico'],  'text'), $sql);
	$sql=str_replace(COSTANTE_COMINVIA,     $db->quote($volo['comunica_invia'],     'text'), $sql);
	$sql=str_replace(COSTANTE_COMEVASA,     $db->quote($volo['comunica_evasa'],     'text'), $sql);
	$sql=str_replace(COSTANTE_NOTE,         $db->quote($volo['note'],               'text'), $sql);
	$sql=str_replace(COSTANTE_CHIUSURA,     $db->quote($volo['chiusura'] ,          'text'), $sql);





	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		//var_dump($res);
		errore("insertVolo - ".$res->getUserInfo());
		$volo['messaggio']="Inserimento NON effettuato - contatta gli amministratori (ced@confartigianato.bs.it)";
	}else{
		$volo['messaggio']="Inserimento effettuato";
		$volo['pk'] = $db->lastInsertID();
	}
	
	return $volo;
}

function updateVolo($volo){
	global $sqlUpdateVolo, $db;
	$sql=$sqlUpdateVolo;


	$volo['pec_attiva']=        formToDB($volo,'pec_attiva');
	$volo['cns_richiesta']=     formToDB($volo,'cns_richiesta');
	$volo['cns_attiva']=        formToDB($volo,'cns_attiva');
	$volo['comunica_incarico']= formToDB($volo,'comunica_incarico');
	$volo['comunica_invia']=    formToDB($volo,'comunica_invia');
	$volo['comunica_evasa']=    formToDB($volo,'comunica_evasa');
	$volo['chiusura']=          formToDB($volo,'chiusura');

	$sql=str_replace(COSTANTE_PK,           $db->quote($volo['pk'],                 'text'), $sql);
	$sql=str_replace(COSTANTE_MANDAMENTO,   $db->quote($volo['mandamento'],         'text'), $sql);
	$sql=str_replace(COSTANTE_UTENTE,       $db->quote($_SESSION['username'],          'text'), $sql);
	$sql=str_replace(COSTANTE_AU,           $db->quote($volo['au'],                 'text'), $sql);
	$sql=str_replace(COSTANTE_RAGSOC,       $db->quote($volo['ragsoc'],             'text'), $sql);
	$sql=str_replace(COSTANTE_REA,          $db->quote($volo['rea'],                'text'), $sql);
	$sql=str_replace(COSTANTE_INDIRIZZO,    $db->quote($volo['indirizzo'],          'text'), $sql);
	$sql=str_replace(COSTANTE_PROTOCOLLO,   $db->quote($volo['protocollo'],         'text'), $sql);
	$sql=str_replace(COSTANTE_PECATTIVA,    $db->quote($volo['pec_attiva'],         'text'), $sql);
	$sql=str_replace(COSTANTE_CNSRICHIESTA, $db->quote($volo['cns_richiesta'],      'text'), $sql);
	$sql=str_replace(COSTANTE_CNSATTIVA,    $db->quote($volo['cns_attiva'],         'text'), $sql);
	$sql=str_replace(COSTANTE_COMINCARICO,  $db->quote($volo['comunica_incarico'],  'text'), $sql);
	$sql=str_replace(COSTANTE_COMINVIA,     $db->quote($volo['comunica_invia'],     'text'), $sql);
	$sql=str_replace(COSTANTE_COMEVASA,     $db->quote($volo['comunica_evasa'],     'text'), $sql);
	$sql=str_replace(COSTANTE_NOTE,         $db->quote($volo['note'],               'text'), $sql);
	$sql=str_replace(COSTANTE_CHIUSURA,     $db->quote($volo['chiusura'] ,          'text'), $sql);
	



	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		//var_dump($res);
		errore("insertVolo - ".$res->getUserInfo());
		$volo['messaggio']="Aggiornamento NON effettuato - contatta gli amministratori (ced@confartigianato.bs.it)";
	}else{
		$volo['messaggio']="Aggiornamento effettuato";
	}
	return $volo;


}

function formToDB($volo,$campo){
	if(isset($volo[$campo]) && $volo[$campo]=="on") return booleanToDB(true);
	else if(isset($volo[$campo])) return $volo[$campo];
	else return booleanToDB(false);


}
function booleanToDB($bool){
	if ($bool) return "S";
	else return "N";

}
function dbToBoolean($dbValue){
	return $dbValue=="S";

}
?>

































