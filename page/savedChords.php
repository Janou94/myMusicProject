<?php
include("../fct/fonctions.php");
writehead();

$dbc = mysqli_connect("localhost","eBrigade","26071995az","perso");
$query="Select * from user_chords where ID_USER=".$_SESSION['userId'];

$answer=mysqli_query($dbc,$query);




echo "<div class='container-fluid' align=center style='display:inline-block;'>
                <div class='col-sm-4' style='margin-top:10px' align=center>
                    <div class='card hide card-default graycarddefault' align=center style=''>
            <div class='card-header graycard'>
            <div class='card-title'><strong> My Chord Progressions </strong></div>
            </div>
                <div class='card-body graycard'>";
                while ($row = mysqli_fetch_array($answer)) {
					echo "<span class='noteButton2ContainerLoad'>
					<button type='button' style='' onclick ='location.href=\"index.php?chordsToLoad=".$row['VALUE']."&BPM=".$row["BPM"]."&percussion=".$row['PERCUSSION']."&rythm=".$row['RYTHM']."&melody=".$row['MELODY']."\"' class ='btn btn-light'>".$row['NAME']."</button>
					<button onclick='location.href=\"../fct/delChords.php?chordsID=".$row['ID']."\"' class=\"btn btn-danger btn-sm deleteNoteButton\" style='float:none;top:-20px;right:15px'>X</button>
					</span><br>";
				}
        echo "</div>
	            <div class='card-footer'>
	            <button type='button' onClick=\"location.href='index.php'\" class ='btn btn-light'>Retour</button>
	            </div>
             </div>
                ";


?>