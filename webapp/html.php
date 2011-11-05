<?
if(!isset ($config)){ exit(127);}
function html_header(){


	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
	echo '<head>';
	echo '	<title>Private Pilot Logbook</title>';
	echo '	<link href="style.css" rel="stylesheet" type="text/css">';
	echo '	<link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>';
	echo '	<script type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>';

	echo '</head>';
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

function html_backup($tabella){
	echo '<table> ';
	echo '<tr>';
	echo '<td>data</td>';
	echo '<td>depplace</td>';
	echo '<td>deptime</td>';
	echo '<td>arrplace</td>';
	echo '<td>arrtime</td>';
	echo '<td>acftmodel</td>';
	echo '<td>acftreg</td>';
	echo '<td>spt</td>';
	echo '<td>multipilot</td>';
	echo '<td>totalflighttime</td>';
	echo '<td>picname</td>';
	echo '<td>today</td>';
	echo '<td>tonight</td>';
	echo '<td>ldgday</td>';
	echo '<td>ldgnight</td>';
	echo '<td>nighttime</td>';
	echo '<td>ifrtime</td>';
	echo '<td>pictime</td>';
	echo '<td>coptime</td>';
	echo '<td>dualtime</td>';
	echo '<td>instrtime</td>';
	echo '<td>rmks</td>';
	echo '</tr>';
	foreach ($tabella as $riga)	{
		if ($riga['depplace']=='')continue;
		echo '<tr>';
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
		echo '</tr>';
	}
	echo '</table> ';
}



function html_voli($tabella, $limiti){


	echo '<h3> <a href="index.php?new"> Inserisci un nuovo volo</a> - <a href="index.php?tempozero"> Modifica i tempi volo di partenza</a> -  <a href="index.php?backup"> Esporta il logbook</a> -  <a href="index.php?logout">Logout</a> </h3>';
	if(count ($tabella)==0)echo '<h1> Nessun volo presente</h1>';
	else {
		echo '<h2>Informazioni utili </h2>';
		echo 'Negli ultimi 30 giorni hai volato per ' . $limiti['tempo'] . ' minuti<br />' ;
		echo 'Negli ultimi 90 giorni hai effettuato ' . $limiti['to'] . ' decolli e ' . $limiti['ldg'] . ' atterraggi<br />' ;
		echo '<h2>Dettaglio dei voli </h2>';
		echo '<table border="1"> ';
		html_headerRow();
		$countRow=0;	
		foreach ($tabella as $riga)	{
			if(++$countRow== 15) html_headerRow();
			echo '<tr>';
			if($riga['pk']!='')echo '<td><a href="index.php?pk=' . $riga['pk'] . '">modifica</a></td>';
			else echo '<td>Totali</td>';
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
			if($riga['pk']!='')echo '<td><a href="index.php?pk=' . $riga['pk'] . '">modifica</a></td>';
			else echo '<td>Totali</td>';
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
			'nuovo'            => 'S',
			'data'             => '',
			'depplace'         => '',
			'deptime'          => '',
			'arrplace'         => '',
			'arrtime'          => '',
			'acftmodel'        => '',
			'acftreg'          => '',
			'spt'              => '',
			'multipilotbool'   => booleanToDB(false),
			'picname'          => '',
			'today'            => 1,
			'tonight'          => 0,
			'ldgday'           => 1,
			'ldgnight'         => 0,
			'nighttime'        => '',
			'ifrtime'          => '',
			'function'         => '',
			'instructor'       => 'N',
			'rmks'             => ''
		);	
	}


	echo '<table border=1> ';
	echo '<form action="index.php" method="post" name="volo" enctype="multipart/form-data">';
	echo '<input type="hidden" name="nuovo" value="' . $tabella['nuovo'] . '" />';
	if (isset($tabella['pk'])) echo '<input type="hidden" name="pk" value="' . $tabella['pk'] . '" />';

	if( isset($tabella['messaggio'])) echo '<tr><th style="background-color: red;" colspan="3">' . $tabella['messaggio'] . '</th></tr>';


	echo '<tr><th colspan="2">Data</th><td>'                                        . html_data              ('data',                            $tabella['data'])          . '</td></tr>';
	echo '<tr><th rowspan="2">Partenza</th><th>aeroporto</th><td>'                  . html_text_and_old      ('depplace',   $oldies['places'],   $tabella['depplace'])      . '</td></tr>';
	echo '<tr><th>orario</th><td>'                                                  . html_time              ('deptime',                         $tabella['deptime'])       . '</td></tr>';
	echo '<tr><th rowspan="2">Arrivo</th><th>aeroporto</th><td>'                    . html_text_and_old      ('arrplace',   $oldies['places'],   $tabella['arrplace'])      . '</td></tr>';
	echo '<tr><th>orario</th><td>'                                                  . html_time              ('arrtime',                         $tabella['arrtime'])       . '</td></tr>';
	echo '<tr><th rowspan="2">Aeroplano</th><th>modello</th><td>'                   . html_text_and_old      ('acftmodel',  $oldies['models'],   $tabella['acftmodel'])     . '</td></tr>';
	echo '<tr><th>marche</th><td>'                                                  . html_text_and_old      ('acftreg',    $oldies['regs'],     $tabella['acftreg'])       . '</td></tr>';
	echo '<tr><th colspan="2">S.P.T. (SE/ME)</th><td>'                              . html_radio             ('spt',        $options['spt'],     $tabella['spt'])           . '</td></tr>';
	echo '<tr><th colspan="2">Multi Pilot</th><td>'                                 . html_checkbox          ('multipilot',                      $tabella['multipilotbool']). '</td></tr>';
	echo '<tr><th colspan="2">Nome del PIC</th><td>'                                . html_text_and_old      ('picname',    $oldies['pic'] ,     $tabella['picname'])       . '</td></tr>';
	echo '<tr><th rowspan="2">Decolli</th><th>giorno</th><td>'                      . html_number            ('today',                           $tabella['today'])         . '</td></tr>';
	echo '<tr><th>notte</th><td>'                                                   . html_number            ('tonight',                         $tabella['tonight'])       . '</td></tr>';
	echo '<tr><th rowspan="2">Atterraggi</th><th>giorno</th><td>'                   . html_number            ('ldgday',                          $tabella['ldgday'])        . '</td></tr>';
	echo '<tr><th>notte</th><td>'                                                   . html_number            ('ldgnight',                        $tabella['ldgnight'])      . '</td></tr>';
	echo '<tr><th rowspan="2">Op. Time</th><th>notturno</th><td>'                   . html_time              ('nighttime',                       $tabella['nighttime'])     . '</td></tr>';
	echo '<tr><th>IFR</th><td>'                                                     . html_time              ('ifrtime',                         $tabella['ifrtime'])       . '</td></tr>';
	echo '<tr><th colspan="2">Pilot <br />Function <br />Time</th><td>'             . html_radio             ('function', $options['function'],  $tabella['function'])      . '</td></tr>';
	echo '<tr><th colspan="2">Instructor</th><td>'                                  . html_checkbox          ('instructor',                      $tabella['instructor'])    . '</td></tr>';
	echo '<tr><th colspan="2">Remarks</th><td>'                                     . html_number            ('rmks',                            $tabella['rmks'])          . '</td></tr>';



	if($tabella['nuovo'] == booleanToDB(true))	echo '<tr><th colspan="3"><input type="submit" value="Inserisci volo" /></th></tr>';
	else echo '<tr><th colspan="3"><input type="submit" value="Aggiorna volo" /></th></tr>';

	echo '</form>';
	echo '</table> ';
	echo '<a href="index.php">Torna all\'elenco voli</a><br />';
	echo '<a href="index.php?new">Inserisci un nuovo volo</a><br />';
}



function html_tempozero($tempoZero){

	echo '<table border=1> ';
	echo '<form action="index.php" method="post" name="volo" enctype="multipart/form-data">';
    echo '<input type="hidden" name="pk" value="' . $tempoZero['pk'] . '" />';
    echo '<input type="hidden" name="tempozerosave" value="tempozerosave" />';
	if( isset($tempoZero['messaggiook'])) echo '<tr><th style="background-color: green;" colspan="2">' . $tempoZero['messaggiook'] . '</th></tr>';
	if( isset($tempoZero['messaggioko'])) echo '<tr><th style="background-color: red;"   colspan="2">' . $tempoZero['messaggioko'] . '</th></tr>';
	echo '<tr><th>Total Flight Time </th><td>' . $tempoZero['totalflighttime']                                  . '</td></tr>';
	echo '<tr><th>Multi Pilot Time </th><td>'  . html_number ('multipilot',      $tempoZero['multipilot'])      . '</td></tr>';
	echo '<tr><th>Night Time </th><td>'        . html_number ('nighttime',       $tempoZero['nighttime'])       . '</td></tr>';
	echo '<tr><th>IFR Time </th><td>'          . html_number ('ifrtime',         $tempoZero['ifrtime'])         . '</td></tr>';
	echo '<tr><th>PIC Time </th><td>'          . html_number ('pictime',         $tempoZero['pictime'])         . '</td></tr>';
	echo '<tr><th>Copilot Time </th><td>'      . html_number ('coptime',         $tempoZero['coptime'])         . '</td></tr>';
	echo '<tr><th>Dual Time </th><td>'         . html_number ('dualtime',        $tempoZero['dualtime'])        . '</td></tr>';
	echo '<tr><th>Instructor Time </th><td>'   . html_number ('instrtime',       $tempoZero['instrtime'])       . '</td></tr>';
	echo '<tr><th colspan="2"><input type="submit" value="Aggiorna!" /></th></tr>';
	echo '</form>';
	echo '</table> ';
	echo '<a href="index.php">Torna all\'elenco voli</a><br />';
	echo '<a href="index.php?new">Inserisci un nuovo volo</a><br />';


}










function html_combobox($name, $optionsCB, $selezionato=""){
	$string="";
	$string.= '<select name="'.$name.'"> ';
	foreach ($optionsCB as $option){
		if($selezionato==$option['value']) $string.=  '<option value="'.$option['value'].'" name="'.$option['value'].'" selected="selected">'.$option['label'].' </option>';
		else $string.=  '<option value="'.$option['value'].'" name="'.$option['value'].'"> '.$option['label'].'</option>';
  	}
	$string.=  '</select> ';
	return $string;
}
function html_radio($name, $optionsR, $selezionato=""){
	$string="";
	foreach ($optionsR as $option){
		if($selezionato==$option) $string.=  '<input type="radio" value="'.$option.'" name="'.$name.'" checked="checked">'.$option.' </input>';
		else $string.=  '<input type="radio" value="'.$option.'" name="'.$name.'"> '.$option.'</input>';
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

function html_data( $name, $value=''){
	$string="";
	$string .='	<input value="' . $value . '" readonly="readonly" name="' . $name . '" type="text" /><input value="Cal" onclick="displayCalendar(document.forms[0].' . $name . ',\'yyyy-mm-dd\',this)" type="button" />';
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
	$string .='<input name="' . $name . '" type="text" value="' . $value . '"></input>';
	$string .='<select  name="' . $name . 'old" onchange="if(this.options[this.selectedIndex].value != \'NIL\') document.volo.' . $name . '.value=this.options[this.selectedIndex].value;">';
	$string .= '  <option value="NIL" label="Recent Entries" selected="selected">Recent Entries</option>';
	foreach ($oldValues as $old){
		$string .= '  <option value="' . $old . '" label="' . $old . '">' . $old . '</option>';
	} 
	$string .='</select>';
	
	return $string;
}
function html_checkbox_and_text( $name, $value, $valueBool=FALSE){
	$string="";
	if ($valueBool =="t" || $valueBool== booleanToDB(true)) $string .=  "<input type='checkbox' name='". $name."bool' checked='checked' />";
	else $string .=  "<input type='checkbox' name='". $name."bool' />";
	$string .='<input name="' . $name . '" type="text" value="' . $value . '"></input>';
	return $string;

}

?> 
