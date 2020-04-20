<?php session_start();

if (!isset($_SESSION['shoutbox_page'])) {
	$_SESSION['shoutbox_page'] = 1;
}

require_once('assets/config.php');

foreach (glob('assets/classes/*') as $filename) {
	require_once($filename);
}
foreach (glob('assets/functions/*') as $filename) {
	require_once($filename);
}

if ($_SERVER['HTTP_HOST'] == 'portfolio') {
	$host = $localhost_host;
	$username = $localhost_username;
	$password = $localhost_password;
	$database = $localhost_database;
} else {
	$host = $domain_host;
	$username = $domain_username;
	$password = $domain_password;
	$database = $domain_database;
}

header('Content-Type: text/html; charset=utf-8');
$db = new Database($host, $username, $password, $database);
// $db->query("SET NAMES 'utf8'");

date_default_timezone_set($time_zone);

$ds = new Raid('ds', 'DS', 'dragonsoul', 'Dragon Soul');
$fl = new Raid('fl', 'FL', 'firelands', 'Firelands');
$soo = new Raid('soo', 'SoO', 'siegeoforgrimmar', 'Siege of Orgrimmar');
$t11 = new Raid('t11', 'T11', 'tier11', 'Tier 11');
$t14 = new Raid('t14','T14', 'tier14', 'Tier 14');
$tot = new Raid('tot', 'ToT', 'throneofthunder', 'Throne of Thunder');
$uld = new Raid('uld', 'Uld', 'ulduar', 'Ulduar');

if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

header('Content-type: text/html; charset=utf-8');

$r = new Router();
$r->render();
