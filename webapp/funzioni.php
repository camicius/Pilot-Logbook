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
	if(isset($_GET['pk'])){										#richiamo la pagina del volo per la modifica
		$oldies=getOldies();
		$volo=getVolo($_GET['pk']);
		html_volo($volo, $oldies);
	}else if(isset($_GET['new'])){ 								#richiamo la pagina del volo per l'inserimento
		$oldies=getOldies();
		html_volo(null, $oldies);
	}else if(isset($_POST['nuovo']) && $_POST['nuovo']==booleanToDB(true)){	#ricevo il volo nuovo e lo inserisco
		$oldies=getOldies();
		$volo=insertVolo($_POST);
		html_volo($volo, $oldies);
	
	}else if(isset($_POST['nuovo']) && $_POST['nuovo']==booleanToDB(false)){ 	#ricevo il volo vecchio e lo modifico	
		$oldies=getOldies();
		$volo=updateVolo($_POST);
		html_volo($volo, $oldies);
	}else{ 														#mostro l'elenco dei voli
		$tabella=getVoli();
		html_voli($tabella);
	}
	
}

function getVoli(){
	global $sqlVoli, $db;
	$sql=$sqlVoli;
 	$sql=str_replace(COSTANTE_USER,$db->quote($_SESSION['username'], 'text'), $sql);

	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		var_dump ($sql);
		//var_dump($res);
		
		errore("getVoli - ".$res->getUserInfo());
	}
	$voli =Array();	
	while (($row = $res->fetchRow())) {
    	$voli[]=$row;
	}
	
	return $voli;


}



function getOldies(){

	global $db, $username, $sqlOldPlaces, $sqlOldModel, $sqlOldRegs, $sqlOldPIC;

//recupero i vecchi aeroporti
	$sql=$sqlOldPlaces;
 	$sql=str_replace(COSTANTE_USER,$db->quote($username, 'text'), $sql);
	$res=$db->query($sql);
	if (PEAR::isError($res)) {
	//	var_dump($res);
		errore("getVolo - ".$res->getUserInfo());
	}
	$oldPlaces= $res->fetchCol();

//recupero i vecchi modelli
	$sql=$sqlOldModel;
 	$sql=str_replace(COSTANTE_USER,$db->quote($username, 'text'), $sql);
	$res=$db->query($sql);
	if (PEAR::isError($res)) {
	//	var_dump($res);
		errore("getVolo - ".$res->getUserInfo());
	}
	$oldModels= $res->fetchCol();

//recupero le vecchie marche
	$sql=$sqlOldRegs;
 	$sql=str_replace(COSTANTE_USER,$db->quote($username, 'text'), $sql);
	$res=$db->query($sql);
	if (PEAR::isError($res)) {
	//	var_dump($res);
		errore("getVolo - ".$res->getUserInfo());
	}
	$oldRegs= $res->fetchCol();

//recupero i vecchi PIC name
	$sql=$sqlOldPIC;
 	$sql=str_replace(COSTANTE_USER,$db->quote($username, 'text'), $sql);
	$res=$db->query($sql);
	if (PEAR::isError($res)) {
	//	var_dump($res);
		errore("getVolo - ".$res->getUserInfo());
	}
	$oldPIC= $res->fetchCol();


	$oldies=Array(
		'places' => $oldPlaces,
		'models' => $oldModels,
		'regs'   => $oldRegs,
		'pic'    => $oldPIC,	
	);	
	return $oldies;
}



function getVolo($pk){
	global $sqlVolo, $db, $username, $sqlOldPlaces, $sqlOldModel, $sqlOldRegs, $sqlOldPIC;


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

































