<?php
// logging extension "last heard list" for hbmonitor
// developed by Heiko Amft,DL1BZ dl1bz@bzsax.de

// define array for CSV import of logfile
$log_time=array();
$transmit_timer=array();
$calltype=array();
$event=array();
$system=array();
$src_id=array();
$src_name=array();
$ts=array();
$tg=array();
$tgname=array();
$user_id=array();
$user_call=array();
$user_name=array();

echo "<!DOCTYPE html>\n\n";
echo "<html><Title>Last Heard HBlink3 Bialystok</title>\n\n";
echo "<head>";
echo "<style>";
echo "table { border-collapse: collapse; border: 1px solid #C1DAD7; width: 100%;}";
echo "th { background-color: #f18458; height: 30px; text-align: left; color: white;}";
echo "tr:nth-child(even) { background-color: #f1fafa; }";
echo "td {font-family: Monospace; height: 20px;}";
echo "a:link { text-decoration: none; }";
echo "</style>";
echo "<meta http-equiv=\"refresh\" content=\"30\"></head>\n\n";
echo "<body><font face=\"arial,helvetica\"><font size=\"+1\">\n\n";
echo "<H2 align=\"center\">Activity & Last Heard Dashboard HBlink3</H2>";
echo "<p align=\"middle\">\n";
echo "<font size=\"-2\">&copy; developed by DL1BZ as logging-extension of <A HREF=\"https://github.com/n0mjs710/HBmonitor\">HBmonitor</A> (2018,2019)</font><BR>\n";
echo "<div style=\"overflow-x:auto;\">\n\n";
echo "<table>\n\n";
// define table row titels
echo "<TR><TH>Date<TH>Time (local)<TH>Slot<TH>TG<TH>TG Name<TH>Callsign (DMR-Id)<TH>Name<TH>Length (min:s)<TH>Source<TH>System</TR>\n\n";

// define location and name of logfile
// best practise is write logfile in the directory where this php script is saved because some php installations have problems to read files outside the webserver directories
$handle = fopen("lastheard.log","r");

// import to array
while (($data = fgetcsv ($handle)) !==false)
{
    $log_time[] = $data[0];
    $transmit_timer[] = $data[1];
    $calltype[] = $data[2];
    $event[] = $data[3];
    $system[] = $data[4];
    $src_id[] = $data[5];
    $src_name[] = $data[6];
    $ts[] = $data[7];
    $tg[] = $data[8];
    $tgname[] = $data[9];
    $user_id[] = $data[10];
    $user_call[] = $data[11];
    $user_name[] = $data[12];
}

// define some macros for table output
$s = "<TD>";
$s_r = "<TD align=\"right\">";
$s_m = "<TD align=\"center\">";

// output to html table from the newest entry to the oldest
for ($i=count($log_time)-1; $i >= 0; $i--)

{
// prepare date string for output in european format
$split_date = substr($log_time[$i],0,10);
$date_eu = explode("-", $split_date);

$ts[$i] = substr($ts[$i],-1);
$tg[$i] = substr($tg[$i],2);

// define special character convert for number zero - we write calls with number zero with this character in logs in Germany
$src_name[$i] = str_replace("0","&Oslash;",$src_name[$i]);
if (substr($user_call[$i],2,1)=="0") { $user_call[$i] = str_replace("0","&Oslash;",$user_call[$i]); }

$log_time[$i]=substr($log_time[$i],0,19);

// thats a special thing for an Id comes without DMR-Id from PEGASUS project - it means we need to convert to "NoCall" thats for calls from source ECHOLINK
if ($user_id[$i]=="1234567") {$user_call[$i] = "*NoCallsign*"; $user_id[$i]="-";}

// output table
echo "<TR>".$s.$date_eu[2].".".$date_eu[1].".".$date_eu[0].$s.substr($log_time[$i],11,5).$s.$ts[$i].$s.'<font color=blue><b>'.$tg[$i].'</b></font>'.$s.'<font color=green><b>'.$tgname[$i].'</b></font>'.$s.'<font color=brown><b>'.$user_call[$i]."</b></font><font size=\"-1\"> (".$user_id[$i].")</font>".$s.TRIM($user_name[$i]).$s.date('H:i', mktime(0,round($transmit_timer[$i]))).$s.$src_name[$i].$s.$system[$i]."</TR>\n";
}

echo "\n</table></div></body></html>";

// close logfile after parsing
fclose ($handle);

?>
