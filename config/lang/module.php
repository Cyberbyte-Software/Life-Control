<?php

if (isset($_SESSION['lang']))
    $lang = $_SESSION['lang'];
else
    $lang = 'en';

switch ($lang) 
{
  case 'en':
  $lang_file = 'lang.en.php';
  break;
 
  case 'de':
  $lang_file = 'lang.de.php';
  break;
 
  case 'ne':
  $lang_file = 'lang.ne.php';
  break;
 
  default:
  $lang_file = 'lang.en.php';
 
}

include_once 'config/lang/'.$lang_file;

?>
