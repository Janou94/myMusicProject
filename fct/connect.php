<?php
include("../fct/fonctions.php");
writehead();

if (isset($_POST['login']) and isset($_POST['password'])) {
	$login=$_POST['login'];
	$password=$_POST['password'];

	$query="select * from user_account where login='".$login."' and password='".md5($password)."'";
	$answer=mysqli_query($dbc,$query);
	$answer2=mysqli_num_rows(mysqli_query($dbc,$query));
	if ($answer2==0) header("Location: ../page/login.php?error=2");

	else {
		$answer=mysqli_fetch_array($answer);
		$_SESSION['login']=$answer['LOGIN'];
		$_SESSION['userId']=$answer['ID'];
		$query='update user_account set LASTSEEN=NOW() where ID='.$_SESSION['userId'];
	 	mysqli_query($dbc,$query);
		var_dump($answer['ID']);
		header("Location: ../page/index.php");
	}
}

else header("Location: ../page/login.php?error=1");