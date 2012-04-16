<?php

// a small utility file for us to create an admin user
// THIS FILE SHOULD NEVER BE PUBLICLY ACCESSIBLE

require_once 'users.php';
require_once 'includes/db.php';


$email = 'ho000043@alongquincollege.com';
$password = 'password';

user_create($db, $email, $password);

?>