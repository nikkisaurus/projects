<?php

$search = db()->prepare("SELECT * FROM `raiders` WHERE `raider` LIKE :search_term OR `raider` = :search_term_decode");

if ($search->execute(array(':search_term' => $data['s'], ':search_term_decode' => utf8_decode($data['s']))) and $search->rowCount() === 1) {
	$results = $search->fetch();
	$id = $results['id'];
	$url = 'raiders/summary?id=' . $id;
	Router::redirect_to($url);
	return;
} else {
	$error = "No results were found for your search.";
}


Router::renderView(array('error' => $error));
