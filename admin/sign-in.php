<?php

require_once '../users.php';
require_once '../includes/db.php';

if (user_is_signed_in()) {
	header('Location: index.php');
	exit;
}

$error = array();
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$error['email'] = true;
	}
	
	if (empty($password)) {
		$error['password'] = true;	
	}
	
	if (empty($errors)){
		$user = user_get($db, $email);
		
			if(!empty($user)) {
				if (passwords_match($password, $user['password'])) {
					user_sign_in($user['id']);
					header('Location: index.php');
					exit;
				} else {
					$errors['password-no-match'] = true;
				}
			} else {
				$errors['user-non-exsistant'] = true;
			}
		}
}

?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Page Views</title>
<link href="../css/public.css" rel="stylesheet">
</head>

<body>

	<div class="insingle">
        <form method="post" action="sign-in.php">
             <div>
                    <label for="email">Email Adress</label>
                    <input type="email" id="email" name="email" required>
             </div>
             <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
             </div>
        
            <button type="submit">Sign in</button>
    
        </form>
        
        <div class="login buttons-css">
        	<a href="../index.php">Home</a>
    	</div>
     </div>
</body>
</html>
