<?php
date_default_timezone_set("America/Chicago");
$string = "Last update on ".date("l, F jS, Y")." at ".date("g:i A").".";

file_put_contents(dirname(__FILE__) . '/views/lastupdate.php', $string);
