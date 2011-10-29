<?
if(!isset ($config)){ exit(127);}

function errore($testo){
	//html_errore($testo);
	echo $testo;
	echo '<br /><br /><br />';
	echo '<br /><br />Errore. Contatta gli amministratori, copiando il testo qui sopra <br /><br /><br />';
	echo '<a href="index.php">Ritorna alla pagina principale</a>';
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
	if(isset($_GET['tempozero'])){										#richiamo la pagina del tempo zero per la modifica
		$tempozero=getTempoZero($_SESSION['username']);
		html_tempozero($tempozero);
	}else if(isset($_POST['tempozerosave'])){ 								#richiamo la pagina del volo per il salvataggio
		$tempozero=saveTempoZero($_POST);
		html_tempozero($tempozero);
	}else if(isset($_GET['pk'])){										#richiamo la pagina del volo per la modifica
		$oldies=getOldies();
		$volo=getVolo($_GET['pk']);
		html_volo($volo, $oldies);
	}else if(isset($_GET['new'])){ 								#richiamo la pagina del volo per l'inserimento
		$oldies=getOldies();
		html_volo(null, $oldies);
	}else if(isset($_POST['nuovo']) && $_POST['nuovo']==booleanToDB(true)){	#ricevo il volo nuovo e lo inserisco
		$volo=insertVolo($_POST);
		if(isset($volo['messaggio'])){
			$oldies=getOldies();
			html_volo($volo, $oldies);
		}
		$tabella=getVoli();
		$limiti=getLimiti();
		html_voli($tabella, $limiti);
	}else if(isset($_POST['nuovo']) && $_POST['nuovo']==booleanToDB(false)){ 	#ricevo il volo vecchio e lo modifico	
		$volo=updateVolo($_POST);
		if(isset($volo['messaggio'])){
			$oldies=getOldies();
			html_volo($volo, $oldies);
		}else{
			$tabella=getVoli();
			$limiti=getLimiti();
			html_voli($tabella, $limiti);
		}
	}else{ 														#mostro l'elenco dei voli
		$tabella=getVoli();
		$limiti=getLimiti();
		html_voli($tabella, $limiti);
	}
	
}
// multipilot, totalflighttime, nighttime, ifrtime, pictime, coptime, dualtime, instrtime
function validateTempoZero($tempoZero){
	$errore="";
	$validations = array(
	    'multipilot'      => 'number',
	    'totalflighttime' => 'number',
	    'nighttime'       => 'number',
	    'ifrtime'         => 'number',
	    'pictime'         => 'number',
	    'dualtime'        => 'number',
	    'instrtime'       => 'number');
	$required = array();
	$sanatize = array();

	$validator = new FormValidator($validations, $required, $sanatize);
	
	if($validator->validate($tempoZero))	{
	    $tempoZero = $validator->sanatize($tempoZero);
	}else{
		$errore = "Ci sono campi non validi";
		foreach ($validator->getErrors() as $campo=>$validation){
			$errore .= " <br />" . campo2error($campo, $tempoZero[$campo]);
		}
	}

	return $errore;

}
function validate($volo){
	$volo['acftreg']  =trim($volo['acftreg']);
	$volo['picname']  =trim($volo['picname']);
	$volo['acftreg']  =trim($volo['acftreg']);
	$volo['acftmodel']=trim($volo['acftmodel']);
	$errore="";


	$validations = array(
	    'data'     => 'date',
	    'depplace' => 'icaoAirport',
	    'arrplace' => 'icaoAirport',
	    'deptime'  => 'hour4digit',
	    'arrtime'  => 'hour4digit',
	    'today'    => 'number',
	    'tonight'  => 'number',
	    'ldgday'   => 'number',
	    'ldgnight' => 'number');
	$required = array('data', 'deptime', 'arrtime');
	$sanatize = array();

	$validator = new FormValidator($validations, $required, $sanatize);
	
	if($validator->validate($volo))	{
	    $volo = $validator->sanatize($volo);
	}else{
		$errore = "Ci sono campi non validi";
		foreach ($validator->getErrors() as $campo=>$validation){
			$errore .= " <br />" . campo2error($campo, $volo[$campo]);
		}
	}

	return $errore;

}




function getLimiti(){
	global $sqlLimiteTempo, $sqlLimiteAtterraggi, $db;
	$sql=$sqlLimiteTempo;
 	$sql=str_replace(COSTANTE_USER,$db->quote($_SESSION['username'], 'text'), $sql);

	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		var_dump ($sql);
		//var_dump($res);
		
		errore("getLimiti - ".$res->getUserInfo());
	}
	$tempo=$res->fetchOne();
	if (is_null($tempo)) $tempo=0;

	$sql=$sqlLimiteAtterraggi; 	
	$sql=str_replace(COSTANTE_USER,$db->quote($_SESSION['username'], 'text'), $sql);

	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		var_dump ($sql);
		//var_dump($res);
		
		errore("getLimiti - ".$res->getUserInfo());
	}
	$ldgRow=$res->fetchRow();
	if (is_null($ldgRow['ldg'])) $ldgRow['ldg']=0;
	if (is_null($ldgRow['to'])) $ldgRow['to']=0;
	return Array( 'tempo' => $tempo, 'ldg'=>$ldgRow['ldg'], 'to'=>$ldgRow['to']);
}




function getVoli(){
	global $sqlVoli, $sqlTotali, $db;
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
	
	$sql=$sqlTotali;
 	$sql=str_replace(COSTANTE_USER,$db->quote($_SESSION['username'], 'text'), $sql);

	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		var_dump ($sql);
		//var_dump($res);
		
		errore("getVoli - ".$res->getUserInfo());
	}
	$row = $res->fetchRow();
	$volo['pk']             = '';
	$volo['data']           = '';
	$volo['depplace']       = '';
	$volo['arrplace']       = '';
	$volo['deptime']        = '';
	$volo['arrtime']        = '';
	$volo['acftmodel']      = '';
	$volo['acftreg']        = '';
	$volo['spt']            = '';
	$volo['multipilot']     = '';
	$volo['totalflighttime']= $row['totalflighttime'] ;
	$volo['picname']        = '';
	$volo['today']          = '';
	$volo['tonight']        = '';
	$volo['ldgday']         = '';
	$volo['ldgnight']       = '';
	$volo['nighttime']      = $row['nighttime'] ;
	$volo['ifrtime']        = $row['ifrtime'];
	$volo['pictime']        = $row['pictime'];
	$volo['coptime']        = $row['coptime'];
	$volo['dualtime']       = $row['dualtime'];
	$volo['instrtime']      = $row['instrtime'];
	$volo['rmks']           = '';
	$voli[]=$volo;
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

	if($voli[0]['pictimebool']  =='t') $voli[0]['function']=PIC;
	if($voli[0]['coptimebool']  =='t') $voli[0]['function']=COP;
	if($voli[0]['dualtimebool'] =='t') $voli[0]['function']=DUAL;
	if($voli[0]['instrtimebool']=='t') $voli[0]['function']=INSTR;
	

	return $voli[0];
}
###############################################################################
###############################################################################
###############################################################################
###############################################################################
###############################################################################
###############################################################################

function getTempoZero($username){
	global $sqlGetTempoZero, $db;


	$sql=$sqlGetTempoZero;
 	$sql=str_replace(COSTANTE_USER,$db->quote($username, 'text'), $sql);
	

	$res=$db->query($sql);

	if (PEAR::isError($res)) {
	//	var_dump($res);
		errore("getVolo - ".$res->getUserInfo());
	}
	
	return $res->fetchRow();
}


###############################################################################
###############################################################################
###############################################################################
###############################################################################
###############################################################################
###############################################################################

function insertVolo($volo){
	$errorevalidazione=validate($volo);

	//print_r($volo);
	global $sqlInsertVolo, $db;
	$sql=$sqlInsertVolo;
	
//	echo'	<pre>';
//	var_dump($volo);
	
	$depHour = intval(substr($volo['deptime'], 0, 2));
	$depMin  = intval(substr($volo['deptime'], 2, 2));
	$arrHour = intval(substr($volo['arrtime'], 0, 2));
	$arrMin  = intval(substr($volo['arrtime'], 2, 2));
	$volo['totalflighttime']=$arrHour*60+$arrMin-($depHour*60+$depMin);


	$volo['deptimedb']= $volo['data'] . " " . substr($volo['deptime'], 0, 2) . ":" . substr($volo['deptime'], 2, 2);
	$volo['arrtimedb']= $volo['data'] . " " . substr($volo['arrtime'], 0, 2) . ":" . substr($volo['arrtime'], 2, 2);
	if(formToDB($volo,'multipilot')==booleanToDB(true)){
		$volo['multipilot']= $volo['totalflighttime'];
		$volo['multipilotbool']= booleanToDB(true);
	}
	else {
		$volo['multipilot']  = 0;
		$volo['multipilotbool']= booleanToDB(false);
	}
	if($volo['function']==PIC)  $volo['pictime']=  $volo['totalflighttime']; else $volo['pictime']  =0;
	if($volo['function']==COP)  $volo['coptime']=  $volo['totalflighttime']; else $volo['coptime']  =0;	
	if($volo['function']==DUAL) $volo['dualtime']= $volo['totalflighttime']; else $volo['dualtime'] =0;
	if($volo['function']==INSTR)$volo['instrtime']=$volo['totalflighttime']; else $volo['instrtime']=0;
//	var_dump($volo);
	$sql=str_replace(COSTANTE_DATA,            $db->quote($volo['data'],            'date'), $sql);
	$sql=str_replace(COSTANTE_DEPPLACE,        $db->quote($volo['depplace'],        'text'), $sql);
	$sql=str_replace(COSTANTE_ARRPLACE,        $db->quote($volo['arrplace'],        'text'), $sql);
	$sql=str_replace(COSTANTE_DEPTIME,         $db->quote($volo['deptimedb'],       'timestamp'), $sql);
	$sql=str_replace(COSTANTE_ARRTIME,         $db->quote($volo['arrtimedb'],       'timestamp'), $sql);
	$sql=str_replace(COSTANTE_ACFTMODEL,       $db->quote($volo['acftmodel'],       'text'), $sql);
	$sql=str_replace(COSTANTE_ACFTREG,         $db->quote($volo['acftreg'],         'text'), $sql);
	$sql=str_replace(COSTANTE_SPT,             $db->quote($volo['spt'],             'text'), $sql);
	$sql=str_replace(COSTANTE_MULTIPILOT,      $db->quote($volo['multipilot'],      'integer' ), $sql);
	$sql=str_replace(COSTANTE_TOTALFLIGHTTIME, $db->quote($volo['totalflighttime'], 'integer' ), $sql);
	$sql=str_replace(COSTANTE_PICNAME,         $db->quote($volo['picname'],         'text'), $sql);
	$sql=str_replace(COSTANTE_TODAY,           $db->quote($volo['today'],           'integer'), $sql);
	$sql=str_replace(COSTANTE_TONIGHT,         $db->quote($volo['tonight'],         'integer'), $sql);
	$sql=str_replace(COSTANTE_LDGDAY,          $db->quote($volo['ldgday'],          'integer'), $sql);
	$sql=str_replace(COSTANTE_LDGNIGHT,        $db->quote($volo['ldgnight'],        'integer'), $sql);
	$sql=str_replace(COSTANTE_NIGHTTIME,       $db->quote($volo['nighttime'] ,      'integer'), $sql);
	$sql=str_replace(COSTANTE_IFRTIME,         $db->quote($volo['ifrtime'],         'integer'), $sql);
	$sql=str_replace(COSTANTE_PICTIME,         $db->quote($volo['pictime'],         'integer'), $sql);
	$sql=str_replace(COSTANTE_COPTIME,         $db->quote($volo['coptime'],         'integer'), $sql);
	$sql=str_replace(COSTANTE_DUALTIME,        $db->quote($volo['dualtime'],        'integer'), $sql);
	$sql=str_replace(COSTANTE_INSTRTIME,       $db->quote($volo['instrtime'],       'integer'), $sql);
	$sql=str_replace(COSTANTE_RMKS,            $db->quote($volo['rmks'] ,           'text'), $sql);
	$sql=str_replace(COSTANTE_USER,            $db->quote($_SESSION['username'],    'text'), $sql);	
//	print $sql;
//	echo'	</pre>';
	if($errorevalidazione!=''){
		$volo['messaggio']="Inserimento NON effettuato - $errorevalidazione";
		return $volo;
	}
	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		//var_dump($res);
		errore("insertVolo - ".$res->getUserInfo());
		$volo['messaggio']="Inserimento NON effettuato - contatta gli amministratori";
	}
	return $volo;

}

function updateVolo($volo){
	$errorevalidazione=validate($volo);
	
	global $sqlUpdateVolo, $db;
	$sql=$sqlUpdateVolo;
	
//	echo'	<pre>';
//	var_dump($volo);
	
	$depHour = intval(substr($volo['deptime'], 0, 2));
	$depMin  = intval(substr($volo['deptime'], 2, 2));
	$arrHour = intval(substr($volo['arrtime'], 0, 2));
	$arrMin  = intval(substr($volo['arrtime'], 2, 2));
	$volo['totalflighttime']=$arrHour*60+$arrMin-($depHour*60+$depMin);


	$volo['deptimedb']= $volo['data'] . " " . substr($volo['deptime'], 0, 2) . ":" . substr($volo['deptime'], 2, 2);
	$volo['arrtimedb']= $volo['data'] . " " . substr($volo['arrtime'], 0, 2) . ":" . substr($volo['arrtime'], 2, 2);
	if(formToDB($volo,'multipilot')==booleanToDB(true)){
		$volo['multipilot']= $volo['totalflighttime'];
		$volo['multipilotbool']= booleanToDB(true);
	}
	else {
		$volo['multipilot']  = 0;
		$volo['multipilotbool']= booleanToDB(false);
	}


	if($volo['function']==PIC)  $volo['pictime']=  $volo['totalflighttime']; else $volo['pictime']  =0;
	if($volo['function']==COP)  $volo['coptime']=  $volo['totalflighttime']; else $volo['coptime']  =0;	
	if($volo['function']==DUAL) $volo['dualtime']= $volo['totalflighttime']; else $volo['dualtime'] =0;
	if($volo['function']==INSTR)$volo['instrtime']=$volo['totalflighttime']; else $volo['instrtime']=0;
//	var_dump($volo);
	$sql=str_replace(COSTANTE_PK,              $db->quote($volo['pk'],              'text'), $sql);
	$sql=str_replace(COSTANTE_DATA,            $db->quote($volo['data'],            'date'), $sql);
	$sql=str_replace(COSTANTE_DEPPLACE,        $db->quote($volo['depplace'],        'text'), $sql);
	$sql=str_replace(COSTANTE_ARRPLACE,        $db->quote($volo['arrplace'],        'text'), $sql);
	$sql=str_replace(COSTANTE_DEPTIME,         $db->quote($volo['deptimedb'],       'timestamp'), $sql);
	$sql=str_replace(COSTANTE_ARRTIME,         $db->quote($volo['arrtimedb'],       'timestamp'), $sql);
	$sql=str_replace(COSTANTE_ACFTMODEL,       $db->quote($volo['acftmodel'],       'text'), $sql);
	$sql=str_replace(COSTANTE_ACFTREG,         $db->quote($volo['acftreg'],         'text'), $sql);
	$sql=str_replace(COSTANTE_SPT,             $db->quote($volo['spt'],             'text'), $sql);
	$sql=str_replace(COSTANTE_MULTIPILOT,      $db->quote($volo['multipilot'],      'integer' ), $sql);
	$sql=str_replace(COSTANTE_TOTALFLIGHTTIME, $db->quote($volo['totalflighttime'], 'integer' ), $sql);
	$sql=str_replace(COSTANTE_PICNAME,         $db->quote($volo['picname'],         'text'), $sql);
	$sql=str_replace(COSTANTE_TODAY,           $db->quote($volo['today'],           'integer'), $sql);
	$sql=str_replace(COSTANTE_TONIGHT,         $db->quote($volo['tonight'],         'integer'), $sql);
	$sql=str_replace(COSTANTE_LDGDAY,          $db->quote($volo['ldgday'],          'integer'), $sql);
	$sql=str_replace(COSTANTE_LDGNIGHT,        $db->quote($volo['ldgnight'],        'integer'), $sql);
	$sql=str_replace(COSTANTE_NIGHTTIME,       $db->quote($volo['nighttime'] ,      'integer'), $sql);
	$sql=str_replace(COSTANTE_IFRTIME,         $db->quote($volo['ifrtime'],         'integer'), $sql);
	$sql=str_replace(COSTANTE_PICTIME,         $db->quote($volo['pictime'],         'integer'), $sql);
	$sql=str_replace(COSTANTE_COPTIME,         $db->quote($volo['coptime'],         'integer'), $sql);
	$sql=str_replace(COSTANTE_DUALTIME,        $db->quote($volo['dualtime'],        'integer'), $sql);
	$sql=str_replace(COSTANTE_INSTRTIME,       $db->quote($volo['instrtime'],       'integer'), $sql);
	$sql=str_replace(COSTANTE_RMKS,            $db->quote($volo['rmks'] ,           'text'), $sql);
	$sql=str_replace(COSTANTE_USER,            $db->quote($_SESSION['username'],    'text'), $sql);	
//	print $sql;
//	echo'	</pre>';
	if($errorevalidazione!=''){
		$volo['messaggio']="Inserimento NON effettuato - $errorevalidazione";
		return $volo;
	}
	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		//var_dump($res);
		errore("insertVolo - ".$res->getUserInfo());
		$volo['messaggio']="Aggiornamento NON effettuato - contatta gli amministratori";
	}
	return $volo;


}
###############################################################################
###############################################################################
###############################################################################
###############################################################################
###############################################################################
###############################################################################
function saveTempozero($tempozero){
	global $sqlUpdateTempoZero, $db;
	$tempozero['totalflighttime']=$tempozero['pictime']+$tempozero['coptime']+$tempozero['dualtime']+$tempozero['instrtime'];
	$sql=$sqlUpdateTempoZero;
	$errorevalidazione=validateTempoZero($tempozero);
	$sql=str_replace(COSTANTE_PK,              $db->quote($tempozero['pk'],              'text'), $sql);
	$sql=str_replace(COSTANTE_MULTIPILOT,      $db->quote($tempozero['multipilot'],      'integer' ), $sql);
	$sql=str_replace(COSTANTE_TOTALFLIGHTTIME, $db->quote($tempozero['totalflighttime'], 'integer' ), $sql);
	$sql=str_replace(COSTANTE_NIGHTTIME,       $db->quote($tempozero['nighttime'] ,      'integer'), $sql);
	$sql=str_replace(COSTANTE_IFRTIME,         $db->quote($tempozero['ifrtime'],         'integer'), $sql);
	$sql=str_replace(COSTANTE_PICTIME,         $db->quote($tempozero['pictime'],         'integer'), $sql);
	$sql=str_replace(COSTANTE_COPTIME,         $db->quote($tempozero['coptime'],         'integer'), $sql);
	$sql=str_replace(COSTANTE_DUALTIME,        $db->quote($tempozero['dualtime'],        'integer'), $sql);
	$sql=str_replace(COSTANTE_INSTRTIME,       $db->quote($tempozero['instrtime'],       'integer'), $sql);
	$sql=str_replace(COSTANTE_USER,            $db->quote($_SESSION['username'],         'text'), $sql);		
	if($errorevalidazione!=''){
		$tempozero['messaggioko']="Aggiornamento NON effettuato - $errorevalidazione";
		return $tempozero;
	}else{
		$tempozero['messaggiook']="Aggiornamento effettuato";
	}
	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		//var_dump($res);
		errore("insertVolo - ".$res->getUserInfo());
		$tempozero['messaggioko']="Aggiornamento NON effettuato - contatta gli amministratori";
	}
	return $tempozero;


}
###############################################################################
###############################################################################
###############################################################################
###############################################################################
###############################################################################
###############################################################################
function campo2error($campo, $valore){
	switch ($campo){
		case 'depplace': 
			return "L'aeroporto di partenza non &egrave valido ($valore)";
	    case 'data':    
			return "La data non &egrave; valida ($valore)";
	    case 'depplace':
			return "L'aeroporto di partenza non &egrave; valido ($valore)";
	    case 'arrplace':
			return "L'aeroporto di arrivo non &egrave; valido ($valore)";
	    case 'deptime': 
			return "L'ora di partenza non &egrave; valida (formato hhmm in orario zulu)";
	    case 'arrtime': 
			return "L'ora di arrivo non &egrave; valida (formato hhmm in orario zulu)";
	    case 'today':
	    case 'tonight': 
	    case 'ldgday':  
	    case 'ldgnight':
	    case 'multipilot':
	    case 'nighttime':
	    case 'ifrtime':
	    case 'pictime':
	    case 'dualtime':
	    case 'instrtime':
			return "$valore non &egrave; un numero";
		default:
			return "$campo ha un valore non valido ($valore)";
	}
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

































