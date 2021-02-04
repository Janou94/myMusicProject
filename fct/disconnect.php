<?php
include("../fct/fonctions.php");
writehead();

if (isset($_GET['error'])) $error=$_GET['error'];
else $error=0;



session_unset();
if ($error==3)header ('Location: ../page/login.php?error=3');
else header ('Location: ../page/login.php');