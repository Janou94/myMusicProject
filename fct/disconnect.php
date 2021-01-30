<?php
include("../fct/fonctions.php");
writehead();
session_unset();
header ('Location: ../page/login.php');