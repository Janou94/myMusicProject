<?php

include("../fct/fonctions.php");
writehead();

$query = "insert into user_chords (NAME,VALUE,ID_USER,BPM,RYTHM,PERCUSSION,MELODY) values ('".$_GET['name']."','".$_GET['chordsToSave'][0]."','".$_SESSION['userId']."','".$_GET['BPM']."','".$_GET['rythm']."','".$_GET['percussion']."','".$_GET['melody'][0]."')";
//var_dump($query);
mysqli_query($dbc,$query);

header("Location: ../page/savedChords.php");

?>