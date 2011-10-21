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
		//$oldies=getOldies();
		$volo=insertVolo($_POST);
		$tabella=getVoli();
		html_voli($tabella);
	
	}else if(isset($_POST['nuovo']) && $_POST['nuovo']==booleanToDB(false)){ 	#ricevo il volo vecchio e lo modifico	
		$volo=updateVolo($_POST);
		$tabella=getVoli();
		html_voli($tabella);
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

	if($voli[0]['pictimebool']  =='t') $voli[0]['function']=PIC;
	if($voli[0]['coptimebool']  =='t') $voli[0]['function']=COP;
	if($voli[0]['dualtimebool'] =='t') $voli[0]['function']=DUAL;
	if($voli[0]['instrtimebool']=='t') $voli[0]['function']=INSTR;
	

	return $voli[0];
}

function insertVolo($volo){
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


	$volo['deptime']= $volo['data'] . " " . substr($volo['deptime'], 0, 2) . ":" . substr($volo['deptime'], 2, 2);
	$volo['arrtime']= $volo['data'] . " " . substr($volo['arrtime'], 0, 2) . ":" . substr($volo['arrtime'], 2, 2);
	if($volo['multipilot']= formToDB($volo,'multipilot')==booleanToDB(true))$volo['multipilot']= $volo['totalflighttime']; else $volo['multipilot']  = 0;;

	if($volo['function']==PIC)  $volo['pictime']=  $volo['totalflighttime']; else $volo['pictime']  =0;
	if($volo['function']==COP)  $volo['coptime']=  $volo['totalflighttime']; else $volo['coptime']  =0;	
	if($volo['function']==DUAL) $volo['dualtime']= $volo['totalflighttime']; else $volo['dualtime'] =0;
	if($volo['function']==INSTR)$volo['instrtime']=$volo['totalflighttime']; else $volo['instrtime']=0;
//	var_dump($volo);
	$sql=str_replace(COSTANTE_DATA,            $db->quote($volo['data'],            'date'), $sql);
	$sql=str_replace(COSTANTE_DEPPLACE,        $db->quote($volo['depplace'],        'text'), $sql);
	$sql=str_replace(COSTANTE_ARRPLACE,        $db->quote($volo['arrplace'],        'text'), $sql);
	$sql=str_replace(COSTANTE_DEPTIME,         $db->quote($volo['deptime'],         'timestamp'), $sql);
	$sql=str_replace(COSTANTE_ARRTIME,         $db->quote($volo['arrtime'],         'timestamp'), $sql);
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

	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		//var_dump($res);
		errore("insertVolo - ".$res->getUserInfo());
		$volo['messaggio']="Inserimento NON effettuato - contatta gli amministratori";
	}else{
		$volo['messaggio']="Inserimento effettuato";
	}
	return $volo;

}

function updateVolo($volo){
	global $sqlUpdateVolo, $db;
	$sql=$sqlUpdateVolo;
	
//	echo'	<pre>';
//	var_dump($volo);
	
	$depHour = intval(substr($volo['deptime'], 0, 2));
	$depMin  = intval(substr($volo['deptime'], 2, 2));
	$arrHour = intval(substr($volo['arrtime'], 0, 2));
	$arrMin  = intval(substr($volo['arrtime'], 2, 2));
	$volo['totalflighttime']=$arrHour*60+$arrMin-($depHour*60+$depMin);


	$volo['deptime']= $volo['data'] . " " . substr($volo['deptime'], 0, 2) . ":" . substr($volo['deptime'], 2, 2);
	$volo['arrtime']= $volo['data'] . " " . substr($volo['arrtime'], 0, 2) . ":" . substr($volo['arrtime'], 2, 2);
	if($volo['multipilot']= formToDB($volo,'multipilot')==booleanToDB(true))$volo['multipilot']= $volo['totalflighttime']; else $volo['multipilot']  = 0;;
	


	if($volo['function']==PIC)  $volo['pictime']=  $volo['totalflighttime']; else $volo['pictime']  =0;
	if($volo['function']==COP)  $volo['coptime']=  $volo['totalflighttime']; else $volo['coptime']  =0;	
	if($volo['function']==DUAL) $volo['dualtime']= $volo['totalflighttime']; else $volo['dualtime'] =0;
	if($volo['function']==INSTR)$volo['instrtime']=$volo['totalflighttime']; else $volo['instrtime']=0;
//	var_dump($volo);
	$sql=str_replace(COSTANTE_PK,              $db->quote($volo['pk'],              'text'), $sql);
	$sql=str_replace(COSTANTE_DATA,            $db->quote($volo['data'],            'date'), $sql);
	$sql=str_replace(COSTANTE_DEPPLACE,        $db->quote($volo['depplace'],        'text'), $sql);
	$sql=str_replace(COSTANTE_ARRPLACE,        $db->quote($volo['arrplace'],        'text'), $sql);
	$sql=str_replace(COSTANTE_DEPTIME,         $db->quote($volo['deptime'],         'timestamp'), $sql);
	$sql=str_replace(COSTANTE_ARRTIME,         $db->quote($volo['arrtime'],         'timestamp'), $sql);
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

	$res=$db->query($sql);

	if (PEAR::isError($res)) {
		//var_dump($res);
		errore("insertVolo - ".$res->getUserInfo());
		$volo['messaggio']="Aggiornamento NON effettuato - contatta gli amministratori";
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

































