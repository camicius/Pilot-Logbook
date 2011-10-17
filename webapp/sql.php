 <?
if(!isset ($config)){ exit(127);}





define ('COSTANTE_USER', '%%USER%%');
$sqlVoli='SELECT pk, data, depplace, arrplace, to_char(deptime, \'HH24MI\') as deptime, to_char(arrtime, \'HH24MI\') as arrtime, acftmodel, acftreg, spt, multipilot, totalflighttime, picname, today, tonight, ldgday, ldgnight, nighttime, ifrtime, pictime, coptime, dualtime, instrtime, rmks, user FROM dat.logbook WHERE username=%%USER%%  ';



$sqlOldPlaces = 'select distinct arrplace  from dat.logbook WHERE username=%%USER%%  union distinct  select distinct depplace from dat.logbook WHERE username=%%USER%% ';
$sqlOldModel  = 'select distinct acftmodel from dat.logbook WHERE username=%%USER%%  ';
$sqlOldRegs   = 'select distinct acftreg   from dat.logbook WHERE username=%%USER%%  ';
$sqlOldPIC    = 'select distinct picname   from dat.logbook WHERE username=%%USER%%  ';



define ('COSTANTE_PK', '%%PK%%');
$sqlVolo='SELECT pk, data, depplace, arrplace, to_char(deptime, \'HH24MI\') as deptime, to_char(arrtime, \'HH24MI\') as arrtime, acftmodel, acftreg, spt, totalflighttime = multipilot as multipilotbool, totalflighttime, picname, today, tonight, ldgday, ldgnight, nighttime, ifrtime, pictime, coptime, dualtime, instrtime, totalflighttime = pictime as pictimebool, totalflighttime = coptime as coptimebool, totalflighttime = dualtime as dualtimebool, totalflighttime = instrtime as instrtimebool, 
 rmks, user FROM dat.logbook WHERE pk=%%PK%% ';

define ('COSTANTE_DATA',            '%%DATA%%');
define ('COSTANTE_DEPPLACE',        '%%DEPPLACE%%');
define ('COSTANTE_ARRPLACE',        '%%ARRPLACE%%');
define ('COSTANTE_DEPTIME',         '%%DEPTIME%%');
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
$sqlInsertVolo='INSERT INTO dat.logbook(data, "depPlace", "arrPlace", "depTime", "arrTime", "acftModel", "acftReg", spt, "multiPilot", "totalFlightTime", "picName", "toDay", "toNight", "ldgDay", "ldgNight", "nightTime", "ifrTime", "picTime", "copTime", "dualTime", "instrTime", rmks, "user")
    VALUES (%%DATA%%, %%DEPPLACE%%,  %%ARRPLACE%%, %%DEPTIME%%, %%ARRTIME%%, %%ACFTMODEL%%, %%ACFTREG%%, %%SPT%%,%%MULTIPILOT%%, %%TOTALFLIGHTTIME%%, %%PICNAME%%, %%TODAY%%, %%TONIGHT%%, %%LDGDAY%%, %%LDGNIGHT%%, %%NIGHTTIME%%, %%IFRTIME%%, %%PICTIME%%, %%COPTIME%%, %%DUALTIME%%, %%INSTRTIME%%, %%RMKS%%)';



$sqlUpdateVolo='UPDATE dat.logbook
   SET data=%%DATA%%, depplace=%%DEPPLACE%%, arrplace=%%ARRPLACE%%, deptime=%%DEPTIME%%, arrtime=%%ARRTIME%%, 
       acftmodel=%%ACFTMODEL%%, acftreg=%%ACFTREG%%, spt=%%SPT%%, multipilot=%%MULTIPILOT%%, totalflighttime=%%TOTALFLIGHTTIME%%, 
       picname=%%PICNAME%%, today=%%TODAY%%, tonight=%%TONIGHT%%, ldgday=%%LDGDAY%%, ldgnight=%%LDGNIGHT%%, 
       nighttime=%%NIGHTTIME%%, ifrtime=%%IFRTIME%%, pictime=%%PICTIME%%, coptime=%%COPTIME%%, dualtime=%%DUALTIME%%, 
       instrtime=%%INSTRTIME%%, rmks=%%RMKS%% 
 WHERE PK=%%PK%% and username=%%USER%%' ;

$sqlDeleteVolo='DELETE FROM dat.logbook WHERE PK=%%PK%%';

?>
