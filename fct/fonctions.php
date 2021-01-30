<?php

function writehead() {

	session_start();
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
}
?>



