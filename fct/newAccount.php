<?php

if (isset($_POST['login']) and isset($_POST['password'])) {
	$login=$_POST['login'];
	$password=$_POST['password'];


	$dbc = mysqli_connect("localhost","eBrigade","26071995az","perso");
	$query="select * from user_account where login='".$login."'";
	$answer=mysqli_num_rows(mysqli_query($dbc,$query));
	if ($answer>0) header("Location: ../page/newAccount.php?error=1");

	else {
		$query="insert into user_account (LOGIN, PASSWORD) values ('".$login."','".md5($password)."')";
		mysqli_query($dbc,$query);
		header("Location: ../page/login.php?success=1");
	}
}

else header("Location: ../page/newAccount.php?error=1");
