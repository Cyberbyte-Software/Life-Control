<?php
include("steamSettings.php");
header("Location: ../".$steamauth['logoutpage']);
session_start();
unset($_SESSION['steamid']);
unset($_SESSION['steam_uptodate']);
?>