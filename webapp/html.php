<?
if(!isset ($config)){ exit(127);}
function html_header(){


	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
	echo '<head>';
	echo '	<title>Private Pilot Logbook</title>';
	echo '	<link href="style.css" rel="stylesheet" type="text/css">';
	echo '<head>';
	echo '<body>';


		echo '<h1> Private Pilot Logbook</h1>';



}

function html_login($error=""){
	echo '<div id="login"><form method="post" action="index.php">';
	echo '<div id="box"><label class="label_login" for="username">Codice utente:</label> <input type="text" name="username" id="username"/><br />';
	echo '<label class="label_login" for="password">Password:</label> <input type="password" name="password" id="password"/><br />';
	echo '';
	echo '';
	echo '';
	echo '';
	echo '';
	echo '<input type="submit" value="Login!" /><br />';
	echo "$error";
	echo '</div>';

	echo '</form></div>';
}


function html_footer(){


echo '</body>';
echo '</html>';



}
function html_headerRow(){
	echo '<tr>';
	echo '<th rowspan="2"> &nbsp;</th>';
	echo '<th rowspan="2"> Data </th>';
	echo '<th colspan="2"> Partenza</th>';	
	echo '<th colspan="2"> Arrivo </th>';
	echo '<th colspan="2"> Aereo</th>';
	echo '<th rowspan="2"> SPT</th>';
	echo '<th rowspan="2"> Multi<br /> Pilot <br />Time</th>';
	echo '<th rowspan="2"> Total <br />Pilot<br /> Time</th>';
	echo '<th rowspan="2"> Nome del PIC </th>';
	echo '<th colspan="2"> T/O </th>';
	echo '<th colspan="2"> LDG</th>';
	echo '<th colspan="2"> Op. Time</th>';
	echo '<th colspan="4"> Pilot Function Time</th>';
	echo '<th rowspan="2"> Remarks</th>';
	echo '</tr>';
	echo '<tr>';
	echo '<th>Aeroporto</th>';
	echo '<th>Orario</th>';
	echo '<th>Aeroporto</th>';
	echo '<th>Orario</th>';
	echo '<th>Modello</th>';
	echo '<th>Marche</th>';
	echo '<th>D</th>';
	echo '<th>N</th>';
	echo '<th>D</th>';
	echo '<th>N</th>';
	echo '<th>Night</th>';
	echo '<th>IFR</th>';
	echo '<th>PIC</th>';
	echo '<th>Cop.</th>';
	echo '<th>Dual</th>';
	echo '<th>Instr.</th>';
	echo '</tr>';
	
}


function html_voli($tabella){

	echo '<h3> <a href="index.php?new"> Inserisci un nuovo volo</a> -  <a href="index.php?logout">Logout</a> </h3>';
	if(count ($tabella)==0)echo '<h1> Nessun volo presente</h1>';
	else {
		echo '<table border="1"> ';
		html_headerRow();
		$countRow=0;	
		foreach ($tabella as $riga)	{
			if(++$countRow== 15) html_headerRow();
			echo '<tr>';
			echo '<td><a href="index.php?pk=' . $riga['pk'] . '">modifica</a></td>';
			echo '<td>' . $riga['data']  . '</td>';
			echo '<td>' . $riga['depplace'] . '</td>';
			echo '<td>' . $riga['deptime'] . '</td>';
			echo '<td>' . $riga['arrplace'] . '</td>';
			echo '<td>' . $riga['arrtime'] . '</td>';
			echo '<td>' . $riga['acftmodel'] . '</td>';
			echo '<td>' . $riga['acftreg'] . '</td>';
			echo '<td>' . $riga['spt'] . '</td>';
			echo '<td>' . $riga['multipilot'] . '</td>';
			echo '<td>' . $riga['totalflighttime'] . '</td>';
			echo '<td>' . $riga['picname'] . '</td>';
			echo '<td>' . $riga['today'] . '</td>';
			echo '<td>' . $riga['tonight'] . '</td>';
			echo '<td>' . $riga['ldgday'] . '</td>';
			echo '<td>' . $riga['ldgnight'] . '</td>';
			echo '<td>' . $riga['nighttime'] . '</td>';
			echo '<td>' . $riga['ifrtime'] . '</td>';
			echo '<td>' . $riga['pictime'] . '</td>';
			echo '<td>' . $riga['coptime'] . '</td>';
			echo '<td>' . $riga['dualtime'] . '</td>';
			echo '<td>' . $riga['instrtime'] . '</td>';
			echo '<td>' . $riga['rmks'] . '</td>';
			echo '<td><a href="index.php?pk=' . $riga['pk'] . '">modifica</a></td>';
			echo '</tr>';
		}
		echo '</table> ';
	}
}

function html_volo($tabella=Array()){
	$tabella['nuovo'] ='N';
	if(!isset($tabella['mandamento'])){
		$tabella = Array(
			'mandamento'        => $_SESSION['mandamento'],
			'data'              => date("d/m/Y"),
			'au'                => '',
			'ragsoc'            => '',
			'rea'               => '',
			'indirizzo'         => '',
			'protocollo'        => '',
			'pec_attiva'        => booleanToDB(false),
			'cns_richiesta'     => booleanToDB(false),
			'cns_attiva'        => booleanToDB(false),
			'comunica_incarico' => booleanToDB(false),
			'comunica_invia'    => booleanToDB(false),
			'comunica_evasa'    => booleanToDB(false),
			'note'              => '',
			'chiusura'          => booleanToDB(false),
			'nuovo'             => booleanToDB(true),
		);	
	}
	echo '<table border=1> ';
	echo '<form action="index.php" method="post" enctype="multipart/form-data">';
	echo '<input type="hidden" name="nuovo" value="' . $tabella['nuovo'] . '" />';
	if (isset($tabella['pk'])) echo '<input type="hidden" name="pk" value="' . $tabella['pk'] . '" />';
	if( isset($tabella['messaggio'])) echo '<tr><th style="background-color: #00ff00;" colspan="2">' . $tabella['messaggio'] . '</th></tr>';
	echo '<tr><th>Mandamento</th>';
	if (canedit('mandamento', $tabella)) echo '<td>' . html_combobox('mandamento',$mandamenti, $tabella['mandamento']) . '</td>';
	else echo '<td><input name="mandamento" type="hidden" value="' . $tabella['mandamento'] . '"></input>' . $mandamenti[$tabella['mandamento']]['label'] . '</td>';

	echo '</tr><tr><th>Data richiesta</th>';
	if (canedit('data', $tabella)) echo '<td><input name="data" type="text" value="' . $tabella['data'] . '"></input></td>';
	else echo '<td><input name="data" type="hidden" value="' . $tabella['data'] . '"></input>' . $tabella['data'] . '</td>';

	echo '</tr><tr><th>Codice Metopack</th>';
	if (canedit('au', $tabella)) echo '<td><input name="au" type="text" value="' . $tabella['au'] . '"></input></td>';
	else echo '<td><input name="au" type="hidden" value="' . $tabella['au'] . '"></input>' . $tabella['au'] . '</td>';

	echo '</tr><tr><th>Ragione sociale</th>';
	if (canedit('ragsoc', $tabella)) echo '<td><input name="ragsoc" type="text" value="' . $tabella['ragsoc'] . '"></input></td>';
	else echo '<td><input name="ragsoc" type="hidden" value="' . $tabella['ragsoc'] . '"></input>' . $tabella['ragsoc'] . '</td>';

	echo '</tr><tr><th>Codice REA</th>';
	if (canedit('rea', $tabella)) echo '<td><input name="rea" type="text" value="' . $tabella['rea'] . '"></input></td>';
	else echo '<td><input name="rea" type="hidden" value="' . $tabella['rea'] . '"></input>' . $tabella['rea'] . '</td>';

	echo '</tr><tr><th>Indirizzo PEC</th>';
	if (canedit('indirizzo', $tabella)) echo '<td><input name="indirizzo" type="text" value="' . $tabella['indirizzo'] . '"></input></td>';
	else echo '<td><input name="indirizzo" type="hidden" value="' . $tabella['indirizzo'] . '"></input>' . $tabella['indirizzo'] . '</td>';

	echo '</tr><tr><th>Codice d\'ordine</th>';
	if (canedit('protocollo', $tabella)) echo '<td><input name="protocollo" type="text" value="' . $tabella['protocollo'] . '"></input></td>';
	else echo '<td><input name="protocollo" type="hidden" value="' . $tabella['protocollo'] . '"></input>' . $tabella['protocollo'] . '</td>';

	echo '</tr><tr><th>PEC attiva</th>';
	if (canedit('pec_attiva', $tabella)) echo '<td>' .  html_checkbox('pec_attiva',$tabella['pec_attiva']) . '</td>';
	else echo '<td><input name="pec_attiva" type="hidden" value="' . $tabella['pec_attiva'] . '"></input>' . $tabella['pec_attiva'] . '</td>';

	echo '</tr><tr><th>Richiesta CNS</th>';
	if (canedit('cns_richiesta', $tabella)) echo '<td>' .  html_checkbox('cns_richiesta',$tabella['cns_richiesta']) . '</td>';
	else echo '<td><input name="cns_richiesta" type="hidden" value="' . $tabella['cns_richiesta'] . '"></input>' . $tabella['cns_richiesta'] . '</td>';

	echo '</tr><tr><th>CNS attiva</th>';
	if (canedit('cns_attiva', $tabella)) echo '<td>' .  html_checkbox('cns_attiva',$tabella['cns_attiva']) . '</td>';
	else echo '<td><input name="cns_attiva" type="hidden" value="' . $tabella['cns_attiva'] . '"></input>' . $tabella['cns_attiva'] . '</td>';

	echo '</tr><tr><th>Comunica in carico</th>';
	if (canedit('comunica_incarico', $tabella)) echo '<td>' .  html_checkbox('comunica_incarico',$tabella['comunica_incarico']) . '</td>';
	else echo '<td><input name="comunica_incarico" type="hidden" value="' . $tabella['comunica_incarico'] . '"></input>' . $tabella['comunica_incarico'] . '</td>';

	echo '</tr><tr><th>Comunica inviata</th>';
	if (canedit('comunica_invia', $tabella)) echo '<td>' .  html_checkbox('comunica_invia',$tabella['comunica_invia']) . '</td>';
	else echo '<td><input name="comunica_invia" type="hidden" value="' . $tabella['comunica_invia'] . '"></input>' . $tabella['comunica_invia'] . '</td>';

	echo '</tr><tr><th>Comunica evasa</th>';
	if (canedit('comunica_evasa', $tabella)) echo '<td>' .  html_checkbox('comunica_evasa',$tabella['comunica_evasa']) . '</td>';
	else echo '<td><input name="comunica_evasa" type="hidden" value="' . $tabella['comunica_evasa'] . '"></input>' . $tabella['comunica_evasa'] . '</td>';

	echo '</tr><tr><th>Note</th>';
	if (canedit('note', $tabella)) echo '<td><input name="note" type="textarea" value="' . $tabella['note'] . '"></input></td>';
	else echo '<td><input name="note" type="hidden" value="' . $tabella['note'] . '"></input>' . $tabella['note'] . '</td>';

	echo '</tr><tr><th>Volo chiusa</th>';
	if (canedit('chiusura', $tabella)) echo '<td>' .  html_checkbox('chiusura',$tabella['chiusura']) . '</td>';
	else echo '<td><input name="chiusura" type="hidden" value="' . $tabella['chiusura'] . '"></input>' . $tabella['chiusura'] . '</td>';
	
	if($_SESSION['ruolo']==COSTANTE_ADMIN){
		if($tabella['nuovo'] ==booleanToDB(true))	echo '<tr><th colspan="2"><input type="submit" value="Inserisci volo" /></th></tr>';
		else echo '<tr><th colspan="2"><input type="submit" value="Aggiorna volo" /></th></tr>';
	}else if($_SESSION['ruolo']==COSTANTE_ATTIV && $tabella['chiusura']==booleanToDB(false)){
		if($tabella['nuovo'] ==booleanToDB(true))	echo '<tr><th colspan="2"><input type="submit" value="Inserisci volo" /></th></tr>';
		else echo '<tr><th colspan="2"><input type="submit" value="Aggiorna volo" /></th></tr>';
	}else if(($_SESSION['ruolo']==COSTANTE_OPER) && $tabella['pec_attiva']==booleanToDB(false)){
		if($tabella['nuovo'] ==booleanToDB(true))	echo '<tr><th colspan="2"><input type="submit" value="Inserisci volo" /></th></tr>';
		else echo '<tr><th colspan="2"><input type="submit" value="Aggiorna volo" /></th></tr>';
	}


	echo '</form>';
	echo '</table> ';
	echo '<a href="index.php">Torna all\'elenco voli</a><br />';
	echo '<a href="index.php?new">Inserisci una nuova volo</a><br />';
}
function html_combobox($name, $options, $selezionato=""){
	$string="";
	$string.= '<select name="mandamento"> ';
	foreach ($options as $option){
		if($selezionato==$option['value']) $string.=  '<option value="'.$option['value'].'" name="'.$option['value'].'" selected="selected">'.$option['label'].' </option>';
		else $string.=  '<option value="'.$option['value'].'" name="'.$option['value'].'"> '.$option['label'].'</option>';
  	}
	$string.=  '</select> ';
	return $string;
}
function html_checkbox( $name, $value=FALSE){
	$string="";
	if ($value == booleanToDB(true)) $string .=  "<input type='checkbox' name='$name' checked='checked' />";
	else $string .=  "<input type='checkbox' name='$name' />";
	return $string;

}



?> 
