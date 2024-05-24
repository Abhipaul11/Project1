<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin</title>
</head>
<body>
	<div>
		<h1>This is Admin Home Page</h1><?php if(isset($_SESSION['username'])) echo $_SESSION["username"]?>
		<a href="logout.php">Logout</a>
	</div>
</body>
</html>