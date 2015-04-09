<?php

$lang = $_SESSION['lang'];

switch ($lang) 
{
  case 'en':
  $lang_file = 'lang.en.php';
  break;
 
  case 'de':
  $lang_file = 'lang.de.php';
  break;
 
  case 'es':
  $lang_file = 'lang.es.php';
  break;
 
  default:
  $lang_file = 'lang.en.php';
 
}

include_once 'config/lang/'.$lang_file;

?>
