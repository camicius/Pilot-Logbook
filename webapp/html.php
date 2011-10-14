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

function html_volo($tabella=Array(), $oldies){
	global $options;
	$tabella['nuovo'] ='N';
	if(!isset($tabella['data'])){
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
	echo '<form action="index.php" method="post" name="volo" enctype="multipart/form-data">';
	echo '<input type="hidden" name="nuovo" value="' . $tabella['nuovo'] . '" />';
	if (isset($tabella['pk'])) echo '<input type="hidden" name="pk" value="' . $tabella['pk'] . '" />';

	if( isset($tabella['messaggio'])) echo '<tr><th style="background-color: #00ff00;" colspan="2">' . $tabella['messaggio'] . '</th></tr>';
	var_dump($tabella);
	var_dump($oldies);

	echo '<tr><th colspan="2">Data</th><td>'                                        . html_data         ('data',                          $tabella['data'])       . '</td></tr>';
	echo '<tr><th rowspan="2">Partenza</th><th>aeroporto</th><td>'                  . html_text_and_old ('depplace',   $oldies['places'], $tabella['depplace'])   . '</td></tr>';
	echo '<tr><th>orario</th><td>'                                                  . html_time         ('deptime',                       $tabella['deptime'])    . '</td></tr>';
	echo '<tr><th rowspan="2">Arrivo</th><th>aeroporto</th><td>'                    . html_text_and_old ('arrplace',   $oldies['places'], $tabella['arrplace'])   . '</td></tr>';
	echo '<tr><th>orario</th><td>'                                                  . html_time         ('arrtime',                       $tabella['arrtime'])    . '</td></tr>';
	echo '<tr><th rowspan="2">Aeroplano</th><th>modello</th><td>'                   . html_text_and_old ('acftmodel',  $oldies['models'], $tabella['acftmodel'])  . '</td></tr>';
	echo '<tr><th>marche</th><td>'                                                  . html_text_and_old ('acftreg',    $oldies['regs'],   $tabella['acftreg'])    . '</td></tr>';
	echo '<tr><th colspan="2">S.P.T. (SE/ME)</th><td>'                              . html_combobox     ('spt',        $options['spt'],   $tabella['spt'])        . '</td></tr>';
	echo '<tr><th colspan="2">Multi Pilot</th><td>'                                 . html_checkbox     ('multipilot',                    $tabella['multipilot']) . '</td></tr>';
	echo '<tr><th colspan="2">Nome del PIC</th><td>'                                . html_text_and_old ('picname',    $oldies['pic'] ,   $tabella['picname'])    . '</td></tr>';
	echo '<tr><th rowspan="2">Decolli</th><th>giorno</th><td>'                      . html_number       ('today',                         $tabella['today'])      . '</td></tr>';
	echo '<tr><th>notte</th><td>'                                                   . html_number       ('tonight',                       $tabella['tonight'])    . '</td></tr>';
	echo '<tr><th rowspan="2">Atterraggi</th><th>giorno</th><td>'                   . html_number       ('ldgday',                        $tabella['ldgday'])     . '</td></tr>';
	echo '<tr><th>notte</th><td>'                                                   . html_number       ('ldgnight',                      $tabella['ldgnight'])   . '</td></tr>';
	echo '<tr><th rowspan="2">Op. Time</th><th>notturno</th><td>'                   . html_time         ('nigthtime',                     $tabella['nigthtime'])  . '</td></tr>';
	echo '<tr><th>IFR</th><td>'                                                     . html_time         ('ifrtime',                       $tabella['ifrtime'])    . '</td></tr>';
	echo '<tr><th rowspan="4">Pilot <br />Function <br />Time</th><th>PIC</th><td>' . html_checkbox     ('pictime',                       $tabella['pictime'])    . '</td></tr>';
	echo '<tr><<th>Copilot</th><td>'                                                . html_checkbox     ('coptime',                       $tabella['coptime'])    . '</td></tr>';
	echo '<tr><th>Dual</th><td>'                                                    . html_checkbox     ('dualtime',                      $tabella['dualtime'])   . '</td></tr>';
	echo '<tr><th>Instructor</th><td>'                                              . html_checkbox     ('instrtime',                     $tabella['instrtime'])  . '</td></tr>';
	echo '<tr><th colspan="2">Remarks</th><td>'                                     . html_number       ('rmks',                          $tabella['rmks'])       . '</td></tr>';




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

function html_data( $name, $value=FALSE){
	$string="";
	//$string .='<input name="' . $name . '" type="text" value="' . $tabella[$name] . '"></input>';
	return $string;
}

function html_text( $name, $value=''){
	$string="";
	$string .='<input name="' . $name . '" type="text" value="' . $value . '"></input>';
	return $string;
}

function html_time( $name, $value=''){
	$string="";
	$string .='<input name="' . $name . '" type="text" value="' . $value . '"></input>';
	return $string;
}
function html_number( $name, $value=''){
	$string="";
	$string .='<input name="' . $name . '" type="text" value="' . $value . '"></input>';
	return $string;
}
function html_text_and_old( $name, $oldValues, $value=''){
	$string="";
	$string .='<input name="' . $name . '" type="text" value="' . $value . ' "></input>';
	$string .='<select  name="' . $name . 'old" onchange="if(this.options[this.selectedIndex].value != \'NIL\') document.volo.' . $name . '.value=this.options[this.selectedIndex].value;">';
	$string .= '  <option value="NIL" label="Recent Entries" selected="selected">Recent Entries</option>';
	foreach ($oldValues as $old){
		$string .= '  <option value="' . $old . '" label="' . $old . '">' . $old . '</option>';
	} 
	$string .='</select>';
	
	return $string;
}
?> 
