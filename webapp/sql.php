 <?
if(!isset ($config)){ exit(127);}

#chiusura
#prima le pratiche vecchie

define ('COSTANTE_LIMITE', '%%LIMITE%%');
define ('COSTANTE_USER', '%%USER%%');
define ('COSTANTE_ORDER',  '%%ORDER%%');
$sqlPratiche='SELECT data, "depPlace", "arrPlace", "depTime", "arrTime", "acftModel", "acftReg", spt, "multiPilot", "totalFlightTime", "picName", "toDay", "toNight", "ldgDay", "ldgNight", "nightTime", "ifrTime", "picTime", "copTime", "dualTime", "instrTime", rmks, "user" FROM dat.pec WHERE user=%%USER%%  %%LIMITE%% %%ORDER%%';


define ('COSTANTE_DEPTIME', '%%DEPTIME%%');
$sqlPratica='SELECT data, "depPlace", "arrPlace", "depTime", "arrTime", "acftModel", "acftReg", spt, "multiPilot", "totalFlightTime", "picName", "toDay", "toNight", "ldgDay", "ldgNight", "nightTime", "ifrTime", "picTime", "copTime", "dualTime", "instrTime", rmks, "user" FROM dat.pec WHERE user=%%USER%% and "depTime" = %%DEPTIME%%';

define ('COSTANTE_DATA',            '%%DATA%%');
define ('COSTANTE_DEPPLACE',        '%%DEPPLACE%%');
define ('COSTANTE_ARRPLACE',        '%%ARRPLACE%%');
define ('COSTANTE_ARRTIME',         '%%ARRTIME%%');
define ('COSTANTE_ACFTMODEL',       '%%ACFTMODEL%%');
define ('COSTANTE_ACFTREG',         '%%ACFTREG%%');
define ('COSTANTE_SPT',             '%%SPT%%');
define ('COSTANTE_MULTIPILOT',      '%%MULTIPILOT%%');
define ('COSTANTE_TOTALFLIGHTTIME', '%%TOTALFLIGHTTIME%%');
define ('COSTANTE_PICNAME',         '%%PICNAME%%');
define ('COSTANTE_TODAY',           '%%TODAY%%');
define ('COSTANTE_TONIGHT',         '%%TONIGHT%%');
define ('COSTANTE_LDGDAY',          '%%LDGDAY%%');
define ('COSTANTE_LDGNIGHT',        '%%LDGNIGHT%%');
define ('COSTANTE_NIGHTTIME',       '%%NIGHTTIME%%');
define ('COSTANTE_IFRTIME',         '%%IFRTIME%%');
define ('COSTANTE_PICTIME',         '%%PICTIME%%');
define ('COSTANTE_COPTIME',         '%%COPTIME%%');
define ('COSTANTE_DUALTIME',        '%%DUALTIME%%');
define ('COSTANTE_INSTRTIME',       '%%INSTRTIME%%');
define ('COSTANTE_RMKS',            '%%RMKS%%');
$sqlInsertPratica='INSERT INTO dat.logbook(data, "depPlace", "arrPlace", "depTime", "arrTime", "acftModel", "acftReg", spt, "multiPilot", "totalFlightTime", "picName", "toDay", "toNight", "ldgDay", "ldgNight", "nightTime", "ifrTime", "picTime", "copTime", "dualTime", "instrTime", rmks, "user")
    VALUES (%%DATA%%, %%DEPPLACE%%,  %%ARRPLACE%%, %%DEPTIME%%, %%ARRTIME%%, %%ACFTMODEL%%, %%ACFTREG%%, %%SPT%%,%%MULTIPILOT%%, %%TOTALFLIGHTTIME%%, %%PICNAME%%, %%TODAY%%, %%TONIGHT%%, %%LDGDAY%%, %%LDGNIGHT%%, %%NIGHTTIME%%, %%IFRTIME%%, %%PICTIME%%, %%COPTIME%%, %%DUALTIME%%, %%INSTRTIME%%, %%RMKS%%)';


define ('COSTANTE_PK',              '%%PK%%');
$sqlUpdatePratica='UPDATE dat.logbook
   SET data=%%DATA%%, "depPlace"=%%DEPPLACE%%, "arrPlace"=%%ARRPLACE%%, "depTime"=%%DEPTIME%%, "arrTime"=%%ARRTIME%%, 
       "acftModel"=%%ACFTMODEL%%, "acftReg"=%%ACFTREG%%, spt=%%SPT%%, "multiPilot"=%%MULTIPILOT%%, "totalFlightTime"=%%TOTALFLIGHTTIME%%, 
       "picName"=%%PICNAME%%, "toDay"=%%TODAY%%, "toNight"=%%TONIGHT%%, "ldgDay"=%%LDGDAY%%, "ldgNight"=%%LDGNIGHT%%, 
       "nightTime"=%%NIGHTTIME%%, "ifrTime"=%%IFRTIME%%, "picTime"=%%PICTIME%%, "copTime"=%%COPTIME%%, "dualTime"=%%DUALTIME%%, 
       "instrTime"=%%INSTRTIME%%, rmks=%%RMKS%%, "user"=%%USER%%
 WHERE PK=%%PK%%';

$sqlDeletePratica='DELETE FROM dat.logbook WHERE PK=%%PK%%';

?>
