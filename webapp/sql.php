 <?
if(!isset ($config)){ exit(127);}





define ('COSTANTE_USER', '%%USER%%');
$sqlVoli='SELECT pk, data, to_char(data, \'DD-MM-YYYY\') as datapp, depplace, arrplace, to_char(deptime, \'HH24MI\') as deptime, to_char(arrtime, \'HH24MI\') as arrtime, acftmodel, acftreg, spt, multipilot, totalflighttime = multipilot as multipilotbool, totalflighttime, picname, today, tonight, ldgday, ldgnight, nighttime, ifrtime, pictime, coptime, dualtime, instrtime, rmks, user FROM dat.logbook WHERE username=%%USER%% and depplace!=\'T0T0\' and arrplace!=\'T0T0\' order by data desc';

$sqlTotali="select sum(totalflighttime) as totalflighttime, sum(nighttime) as nighttime,  sum(ifrtime) as ifrtime, sum(pictime) as pictime, sum(coptime) as coptime, sum(dualtime) as dualtime,  sum(instrtime) as instrtime
from dat.logbook
where username=%%USER%%";

$sqlLimiteTempo="select sum(totalflighttime) as totalflighttime from dat.logbook where username=%%USER%% and data > current_date -integer '30'";
$sqlLimiteAtterraggi="select sum (ldgday)+sum (ldgnight) as ldg, sum (today)+sum (tonight) as to from dat.logbook where username=%%USER%% and data > current_date -integer '90'";

$sqlOldPlaces = 'select * from (select  arrplace as place from dat.logbook WHERE username=%%USER%% and depplace !=\'T0T0\' 
union   
select  depplace as place from dat.logbook WHERE username=%%USER%% and depplace !=\'T0T0\'  ) as place
group by place order by count(*) desc
';


$sqlOldModel  = 'select acftmodel from dat.logbook WHERE username=%%USER%% and depplace !=\'T0T0\'  group by acftmodel order by count (*) desc';
$sqlOldRegs   = 'select acftreg   from dat.logbook WHERE username=%%USER%% and depplace !=\'T0T0\'  group by acftreg   order by count (*) desc ';
$sqlOldPIC    = 'select picname   from dat.logbook WHERE username=%%USER%% and depplace !=\'T0T0\'  group by picname   order by count (*) desc';



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
$sqlInsertVolo='INSERT INTO dat.logbook(data, depplace, arrplace, deptime, arrtime, acftmodel, acftreg, spt, multipilot, totalflighttime, picname, today, tonight, ldgday, ldgnight, nighttime, ifrtime, pictime, coptime, dualtime, instrtime, rmks, username)
    VALUES (%%DATA%%, %%DEPPLACE%%,  %%ARRPLACE%%, %%DEPTIME%%, %%ARRTIME%%, %%ACFTMODEL%%, %%ACFTREG%%, %%SPT%%,%%MULTIPILOT%%, %%TOTALFLIGHTTIME%%, %%PICNAME%%, %%TODAY%%, %%TONIGHT%%, %%LDGDAY%%, %%LDGNIGHT%%, %%NIGHTTIME%%, %%IFRTIME%%, %%PICTIME%%, %%COPTIME%%, %%DUALTIME%%, %%INSTRTIME%%, %%RMKS%%, %%USER%%)';



$sqlUpdateVolo='UPDATE dat.logbook
   SET data=%%DATA%%, depplace=%%DEPPLACE%%, arrplace=%%ARRPLACE%%, deptime=%%DEPTIME%%, arrtime=%%ARRTIME%%, 
       acftmodel=%%ACFTMODEL%%, acftreg=%%ACFTREG%%, spt=%%SPT%%, multipilot=%%MULTIPILOT%%, totalflighttime=%%TOTALFLIGHTTIME%%, 
       picname=%%PICNAME%%, today=%%TODAY%%, tonight=%%TONIGHT%%, ldgday=%%LDGDAY%%, ldgnight=%%LDGNIGHT%%, 
       nighttime=%%NIGHTTIME%%, ifrtime=%%IFRTIME%%, pictime=%%PICTIME%%, coptime=%%COPTIME%%, dualtime=%%DUALTIME%%, 
       instrtime=%%INSTRTIME%%, rmks=%%RMKS%% 
 WHERE PK=%%PK%% and username=%%USER%%' ;

$sqlDeleteVolo='DELETE FROM dat.logbook WHERE PK=%%PK%%';




$sqlGetTempoZero="select pk, multipilot, totalflighttime, nighttime, ifrtime, pictime, coptime, dualtime, instrtime from dat.logbook where username=%%USER%% and depplace='T0T0' and arrplace='T0T0'";
$sqlUpdateTempoZero='UPDATE dat.logbook SET multipilot=%%MULTIPILOT%%, totalflighttime=%%TOTALFLIGHTTIME%%, nighttime=%%NIGHTTIME%%, ifrtime=%%IFRTIME%%, pictime=%%PICTIME%%, coptime=%%COPTIME%%, dualtime=%%DUALTIME%%, instrtime=%%INSTRTIME%% WHERE PK=%%PK%% and username=%%USER%%  and depplace=\'T0T0\' and arrplace=\'T0T0\'' ;

?>
