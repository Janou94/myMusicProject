<?php
include("../fct/fonctions.php");
writehead();

$query="delete from user_chords where ID=".$_GET["chordsID"];

mysqli_query($dbc,$query);

header("Location: ../page/savedChords.php");


?>