<?php

include("../fct/fonctions.php");
writehead();
$dbc = mysqli_connect("localhost","eBrigade","26071995az","perso");
$query = "insert into user_chords (NAME,VALUE,ID_USER,BPM,RYTHM,PERCUSSION,MELODY) values ('".$_GET['name']."','".$_GET['chordsToSave'][0]."','".$_SESSION['userId']."','".$_GET['BPM']."','".$_GET['rythm']."','".$_GET['percussion']."','".$_GET['melody'][0]."')";
//var_dump($query);
mysqli_query($dbc,$query);

header("Location: ../page/savedChords.php");

?>