<?php

$post = db()->query("SELECT * FROM `articles` ORDER BY `created_at` DESC LIMIT 1")->fetchAll();

Router::renderView(array('post' => $post));
