<?php
include("../fct/fonctions.php");
writehead();


$dbc = mysqli_connect("localhost","eBrigade","26071995az","perso");

$query="delete from user_chords where ID=".$_GET["chordsID"];

mysqli_query($dbc,$query);

header("Location: ../page/savedChords.php");


?>