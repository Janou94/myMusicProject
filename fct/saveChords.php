<?php

include("../fct/fonctions.php");
writehead();
$dbc = mysqli_connect("localhost","eBrigade","26071995az","perso");
$query = "insert into user_chords (NAME,VALUE,ID_USER,BPM) values ('".$_GET['name']."','".$_GET['chordsToSave'][0]."','".$_SESSION['userId']."','".$_GET['BPM']."')";
mysqli_query($dbc,$query);

header("Location: ../page/savedChords.php");

?>