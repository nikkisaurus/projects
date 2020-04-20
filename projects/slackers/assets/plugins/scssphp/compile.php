<?php

require_once('scss.inc.php');

$scss = new scssc();
$scss->setImportPaths("../../");

echo $scss->compile('@import "css.scss"');
