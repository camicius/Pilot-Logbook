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
	//
	//echo $result. "\n\n";
	if ($result=="1"){
		return true;
	}
	else{
		return false;
	}

}
function getMandamento($dn){
	global $mandamentiLdap;
	//uid=occhi,ou=People,o=Upa
	//uid=se0287,ou=Lumezzane,ou=People,o=Upa
	$dnArray=explode(',' , $dn);
	if(count($dnArray)==4){	#paesi
		$mandamento=str_replace("ou=","",$dnArray[1]);
		return array_search($mandamento, $mandamentiLdap);
	}else{#brescia
		return("001");
	}
}

function pagina(){
	// Costruzione della pagina
	if(isset($_GET['pk'])){										#richiamo la pagina della pratica per la modifica
		$pratica=getPratica($_GET['pk']);
		html_pratica($pratica);
	}else if(isset($_GET['new'])){ 								#richiamo la pagina della pratica per l'inserimento
		html_pratica();
	}else if(isset($_POST['nuovo']) && $_POST['nuovo']==booleanToDB(true)){	#ricevo la pratica nuova e la inserisco
		$pratica=insertPratica($_POST);
		html_pratica($pratica);
	
	}else if(isset($_POST['nuovo']) && $_POST['nuovo']==booleanToDB(false)){ 	#ricevo la pratica vecchia e la modifico	
		$pratica=updatePratica($_POST);
		html_pratica($pratica);
	}else{ 														#mostro l'elenco delle pratiche
		$tabella=getPratiche();
		html_pratiche($tabella);
	}
	
}

function getPratiche($quali="aperte"){
	global $sqlPratiche, $sqlPraticheMandamento, $db;
	$ordinamento="data";
	$tipoOrdinamento="asc";
	if($_SESSION['ruolo']==COSTANTE_ADMIN || $_SESSION['ruolo']==COSTANTE_ATTIV)
		$sql=$sqlPratiche;
	else{
		$sql=$sqlPraticheMandamento;
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
		errore("getPratiche - ".$res->getUserInfo());
	}
	$pratiche =Array();	
	while (($row = $res->fetchRow())) {
    	$pratiche[]=$row;
	}
	
	return $pratiche;


}

function getPratica($pk){
	global $sqlPratica, $db;
	$sql=$sqlPratica;
 	$sql=str_replace(COSTANTE_PK,$db->quote($pk, 'text'), $sql);


	$res=$db->query($sql);

	if (PEAR::isError($res)) {
	//	var_dump($res);
		errore("getPratica - ".$res->getUserInfo());
	}
	while (($row = $res->fetchRow())) {
    	$pratiche[]=$row;
	}

	return $pratiche[0];


}

function insertPratica($pratica){
	//print_r($pratica);
	global $sqlInsertPratica, $db;
	$sql=$sqlInsertPratica;

	if($pratica['protocollo']=="") $pratica['pec_attiva']=booleanToDB(true);
	$pratica['pec_attiva']=        formToDB($pratica,'pec_attiva');
	$pratica['cns_richiesta']=     formToDB($pratica,'cns_richiesta');
	$pratica['cns_attiva']=        formToDB($pratica,'cns_attiva');
	$pratica['comunica_incarico']= formToDB($pratica,'comunica_incarico');
	$pratica['comunica_invia']=    formToDB($pratica,'comunica_invia');
	$pratica['comunica_evasa']=    formToDB($pratica,'comunica_evasa');
	$pratica['chiusura']=          formToDB($pratica,'chiusura');

	$sql=str_replace(COSTANTE_MANDAMENTO,   $db->quote($pratica['mandamento'],         'text'), $sql);
	$sql=str_replace(COSTANTE_UTENTE,       $db->quote($_SESSION['username'],          'text'), $sql);
	$sql=str_replace(COSTANTE_AU,           $db->quote($pratica['au'],                 'text'), $sql);
	$sql=str_replace(COSTANTE_RAGSOC,       $db->quote($pratica['ragsoc'],             'text'), $sql);
	$sql=str_replace(COSTANTE_REA,          $db->quote($pratica['rea'],                'text'), $sql);
	$sql=str_replace(COSTANTE_INDIRIZZO,    $db->quote($pratica['indirizzo'],          'text'), $sql);
	$sql=str_replace(COSTANTE_PROTOCOLLO,   $db->quote($pratica['protocollo'],         'text'), $sql);
	$sql=str_replace(COSTANTE_PECATTIVA,    $db->quote($pratica['pec_attiva'],         'text'), $sql);
	$sql=str_replace(COSTANTE_CNSRICHIESTA, $db->quote($pratica['cns_richiesta'],      'text'), $sql);
	$sql=str_replace(COSTANTE_CNSATTIVA,    $db->quote($pratica['cns_attiva'],         'text'), $sql);
	$sql=str_replace(COSTANTE_COMINCARICO,  $db->quote($pratica['comunica_incarico'],  'text'), $sql);
	$sql=str_replace(COSTANTE_COMINVIA,     $db->quote($pratica['comunica_invia'],     'text'), $sql);
	$sql=str_replace(COSTANTE_COMEVASA,     $db->quote($pratica['comunica_evasa'],     'text'), $sql);
	$sql=str_replace(COSTANTE_NOTE,         $db->quote($pratica['note'],               'text'), $sql);
	$sql=str_replace(COSTANTE_CHIUSURA,     $db->quote($pratica['chiusura'] ,          'text'), $sql);





	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		//var_dump($res);
		errore("insertPratica - ".$res->getUserInfo());
		$pratica['messaggio']="Inserimento NON effettuato - contatta gli amministratori (ced@confartigianato.bs.it)";
	}else{
		$pratica['messaggio']="Inserimento effettuato";
		$pratica['pk'] = $db->lastInsertID();
	}
	
	return $pratica;
}

function updatePratica($pratica){
	global $sqlUpdatePratica, $db;
	$sql=$sqlUpdatePratica;


	$pratica['pec_attiva']=        formToDB($pratica,'pec_attiva');
	$pratica['cns_richiesta']=     formToDB($pratica,'cns_richiesta');
	$pratica['cns_attiva']=        formToDB($pratica,'cns_attiva');
	$pratica['comunica_incarico']= formToDB($pratica,'comunica_incarico');
	$pratica['comunica_invia']=    formToDB($pratica,'comunica_invia');
	$pratica['comunica_evasa']=    formToDB($pratica,'comunica_evasa');
	$pratica['chiusura']=          formToDB($pratica,'chiusura');

	$sql=str_replace(COSTANTE_PK,           $db->quote($pratica['pk'],                 'text'), $sql);
	$sql=str_replace(COSTANTE_MANDAMENTO,   $db->quote($pratica['mandamento'],         'text'), $sql);
	$sql=str_replace(COSTANTE_UTENTE,       $db->quote($_SESSION['username'],          'text'), $sql);
	$sql=str_replace(COSTANTE_AU,           $db->quote($pratica['au'],                 'text'), $sql);
	$sql=str_replace(COSTANTE_RAGSOC,       $db->quote($pratica['ragsoc'],             'text'), $sql);
	$sql=str_replace(COSTANTE_REA,          $db->quote($pratica['rea'],                'text'), $sql);
	$sql=str_replace(COSTANTE_INDIRIZZO,    $db->quote($pratica['indirizzo'],          'text'), $sql);
	$sql=str_replace(COSTANTE_PROTOCOLLO,   $db->quote($pratica['protocollo'],         'text'), $sql);
	$sql=str_replace(COSTANTE_PECATTIVA,    $db->quote($pratica['pec_attiva'],         'text'), $sql);
	$sql=str_replace(COSTANTE_CNSRICHIESTA, $db->quote($pratica['cns_richiesta'],      'text'), $sql);
	$sql=str_replace(COSTANTE_CNSATTIVA,    $db->quote($pratica['cns_attiva'],         'text'), $sql);
	$sql=str_replace(COSTANTE_COMINCARICO,  $db->quote($pratica['comunica_incarico'],  'text'), $sql);
	$sql=str_replace(COSTANTE_COMINVIA,     $db->quote($pratica['comunica_invia'],     'text'), $sql);
	$sql=str_replace(COSTANTE_COMEVASA,     $db->quote($pratica['comunica_evasa'],     'text'), $sql);
	$sql=str_replace(COSTANTE_NOTE,         $db->quote($pratica['note'],               'text'), $sql);
	$sql=str_replace(COSTANTE_CHIUSURA,     $db->quote($pratica['chiusura'] ,          'text'), $sql);
	



	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		//var_dump($res);
		errore("insertPratica - ".$res->getUserInfo());
		$pratica['messaggio']="Aggiornamento NON effettuato - contatta gli amministratori (ced@confartigianato.bs.it)";
	}else{
		$pratica['messaggio']="Aggiornamento effettuato";
	}
	return $pratica;


}

function formToDB($pratica,$campo){
	if(isset($pratica[$campo]) && $pratica[$campo]=="on") return booleanToDB(true);
	else if(isset($pratica[$campo])) return $pratica[$campo];
	else return booleanToDB(false);


}


function booleanToDB($bool){
	if ($bool) return "S";
	else return "N";

}
function dbToBoolean($dbValue){
	return $dbValue=="S";

}
function canedit($campo, $record){
	global $sqlAuth, $db;

	switch ($_SESSION['ruolo']){
		case COSTANTE_ADMIN: // per l'admin valgono sempre i valori del db
		case COSTANTE_RO: // per ro valgono sempre i valori del db
			break;	
		case COSTANTE_ATTIV: //per l'attivatore vale sempre il valore del db a meno che la pratica sia chiusa
			if (dbToBoolean($record['chiusura']))return false;
			break;
		case COSTANTE_OPER: //per oper  vale sempre il valore del db a meno che la pratica abbia la pec attiva
			if (dbToBoolean($record['pec_attiva']))return false;
			break;
	}


	$sql=$sqlAuth;
 	$sql=str_replace(COSTANTE_CAMPO,$db->quote($campo, 'text'), $sql);
 	$sql=str_replace(COSTANTE_RUOLO,$db->quote($_SESSION['ruolo'], 'text'), $sql);
	
	$res=$db->query($sql);

	if (PEAR::isError($res)) {
	//	var_dump($res);
		errore("canedit - ".$res->getUserInfo());
	}
	$auth=$res->fetchRow();

	if($auth['auth']=="w") return true;
	else return false;
	

}
?>

































