<?php
	session_start();

	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>user</title>
</head>
<body>
	<div>
		<h1>This is user Home Page</h1><?php echo $_SESSION["username"]?>
		
		<a href="logout.php">Logout</a>
	</div>
</body>
</html>