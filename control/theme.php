<?php
//Default Theme
$theme_name = "default";
$theme_color = "teal darken-3";
$theme_secondary = "";
$theme_syntax = "deep-purple darken-3";
$theme_meta = "#004d40";
$theme_metasyntax = "#4A148C";

//Set Night Theme
if(date("G")>17){
  $theme_name = "night";
  $theme_color = "grey darken-4";
  $theme_secondary = "grey darken-3";
  $theme_syntax = "blue-grey darken-4";
  $theme_meta = "#212121";
  $theme_metasyntax = "#263238";
}

?>
