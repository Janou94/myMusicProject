<?php

function writehead() {

	require "../sql/conf.php";
	session_start();

	
	//include scripts and libraries
	echo "<script type='text/javascript' src='../js/jQuery.js'></script>\n";

	foreach (glob("../css/bootstrap/*.css") as $css) {
    	echo "<link type='text/css' rel='stylesheet' href='$css'>\n";
	}
	foreach (glob("../css/fa/*.css") as $css) {
    	echo "<link type='text/css' rel='stylesheet' href='$css'>\n";
	}
	echo "<link type='text/css' rel='stylesheet' href='../css/main.css'>";
	echo "<link type='text/css' rel='stylesheet' href='../css/rangeslider.css'>";

	foreach (glob("../js/bootstrap/*.js") as $js) {
    	echo "<script type='text/javascript' src='$js'></script>\n";
	}
	/*foreach (glob("../js/fa/*.js") as $js) {
    	echo "<script type='text/javascript' src='$js'></script>\n";
	}*/
	echo "<script type='text/javascript' src='../js/Tone.js'></script>\n";
	echo "<script type='text/javascript' src='../js/rangeslider.js'></script>\n";
	echo "<script type='text/javascript' src='../js/rangeslider.min.js'></script>\n";
	echo "<script type='text/javascript' src='../js/jquery.knob.js'></script>\n";

	//taking care of inactive delay

	if (explode("/",$_SERVER['PHP_SELF'])[3]<>"login.php" and explode("/",$_SERVER['PHP_SELF'])[3]<>"connect.php" and explode("/",$_SERVER['PHP_SELF'])[3]<>"disconnect.php" and explode("/",$_SERVER['PHP_SELF'])[3]<>"newAccount.php") {

		$query='select TIME_TO_SEC(TIMEDIFF(NOW(), LASTSEEN))/3600 as TIMEDIFF from user_account where ID='.$_SESSION['userId'];
		$answer=mysqli_fetch_array(mysqli_query($dbc,$query));
	 	if ($answer[0]>1) header("Location: ../fct/disconnect.php?error=3"); 
	 	
	 	else {
	 		$query='update user_account set LASTSEEN=NOW() where ID='.$_SESSION['userId'];
	 		mysqli_query($dbc,$query);
	 	}
	 	
 	}

 	//taking care of unsets accounts
 	if (explode("/",$_SERVER['PHP_SELF'])[3]<>"login.php" and explode("/",$_SERVER['PHP_SELF'])[3]<>"connect.php" and explode("/",$_SERVER['PHP_SELF'])[3]<>"disconnect.php" and explode("/",$_SERVER['PHP_SELF'])[3]<>"newAccount.php") {

 		if (!isset($_SESSION['login'])) header("Location: ../page/login.php");
 	}


}

?>



