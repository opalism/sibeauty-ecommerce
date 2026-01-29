<?php
if( !session_id() ) session_start();

// Bootstrapping
require_once '../app/init.php';

$app = new App;