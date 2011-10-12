 <?
if(!isset ($config)){ exit(127);}

#chiusura
#prima le pratiche vecchie

define ('COSTANTE_LIMITE', '%%LIMITE%%');
define ('COSTANTE_ORDER',  '%%ORDER%%');
$sqlPratiche="SELECT pk, mandamento,  date(data) as data, utente,au, ragsoc, rea, indirizzo, protocollo, pec_attiva, cns_richiesta, cns_attiva, comunica_incarico, comunica_invia, comunica_evasa, note, chiusura FROM dat.pec WHERE TRUE %%LIMITE%% %%ORDER%%";

define ('COSTANTE_MANDAMENTO', '%%MANDAMENTO%%');
$sqlPraticheMandamento="SELECT pk, mandamento,  date(data) as data, utente, au, ragsoc, rea, indirizzo, protocollo, pec_attiva, cns_richiesta, cns_attiva, comunica_incarico, comunica_invia, comunica_evasa, note, chiusura FROM dat.pec where mandamento= %%MANDAMENTO%%  %%LIMITE%% order by chiusura, data";

define ('COSTANTE_PK', '%%PK%%');
$sqlPratica="SELECT pk, mandamento, date(data) as data, utente,au, ragsoc, rea, indirizzo, protocollo, pec_attiva, cns_richiesta, cns_attiva, comunica_incarico, comunica_invia, comunica_evasa, note, chiusura FROM dat.pec WHERE pk=%%PK%%";

define ('COSTANTE_DATA',         '%%DATA%%');
define ('COSTANTE_UTENTE',       '%%UTENTE%%');
define ('COSTANTE_AU',           '%%AU%%');
define ('COSTANTE_RAGSOC',       '%%RAGSOC%%');
define ('COSTANTE_REA',          '%%REA%%');
define ('COSTANTE_INDIRIZZO',    '%%INDIRIZZO%%');
define ('COSTANTE_PROTOCOLLO',   '%%PROTOCOLLO%%');
define ('COSTANTE_PECATTIVA',    '%%PECATTIVA%%');
define ('COSTANTE_CNSRICHIESTA', '%%CNSRICHIESTA%%');
define ('COSTANTE_CNSATTIVA',    '%%CNSATTIVA%%');
define ('COSTANTE_COMINCARICO',  '%%COMINCARICO%%');
define ('COSTANTE_COMINVIA',     '%%COMINVIA%%');
define ('COSTANTE_COMEVASA',     '%%COMEVASA%%');
define ('COSTANTE_NOTE',         '%%NOTE%%');
define ('COSTANTE_CHIUSURA',     '%%CHIUSURA%%');

$sqlInsertPratica="INSERT INTO dat.pec(mandamento, utente, au, ragsoc, rea, indirizzo, protocollo, pec_attiva, cns_richiesta, cns_attiva, comunica_incarico, comunica_invia, comunica_evasa, note, chiusura)
    VALUES (%%MANDAMENTO%%, %%UTENTE%%,  %%AU%%, %%RAGSOC%%, %%REA%%, %%INDIRIZZO%%, %%PROTOCOLLO%%, %%PECATTIVA%%,%%CNSRICHIESTA%%, %%CNSATTIVA%%, %%COMINCARICO%%, %%COMINVIA%%, %%COMEVASA%%, %%NOTE%%, %%CHIUSURA%%)";

$sqlUpdatePratica="UPDATE dat.pec SET mandamento=%%MANDAMENTO%%, au=%%AU%%, ragsoc=%%RAGSOC%%, rea=%%REA%%, indirizzo=%%INDIRIZZO%%, protocollo=%%PROTOCOLLO%%, pec_attiva=%%PECATTIVA%%, cns_richiesta=%%CNSRICHIESTA%%, cns_attiva=%%CNSATTIVA%%, comunica_incarico=%%COMINCARICO%%, comunica_invia=%%COMINVIA%%, comunica_evasa=%%COMEVASA%%, note=%%NOTE%%, chiusura=%%CHIUSURA%%WHERE pk=%%PK%%";


define ('COSTANTE_CAMPO', '%%CAMPO%%');
define ('COSTANTE_RUOLO', '%%RUOLO%%');
$sqlAuth="select auth from dat.pec_auth where campo=%%CAMPO%% and ruolo=%%RUOLO%%";
?>
