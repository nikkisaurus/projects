<?php

// Connect to database
require_once "assets/config.php";
require_once "controllers/database.php";
$db = new Database(sprintf("mysql:host=%s;dbname=%s;port=%u;charset=%s", DB_SERVER, DB_NAME, DB_PORT, DB_CHARSET), DB_USERNAME, DB_PASSWORD);

// Display index
require_once "views/index.html";