<?php

require_once "medal_types.php";

echo "<li style=\"margin-top:10px;\">\n";

$medals_i=$cur_post['medals'];

$medals=explode(",",$medals_i);

while (list($key,$val)=each($medals)){
  if ($val!=""){
  $med_img="medal_q.png";
  $med_titl=$val;

  if (isset($medal_types[strtolower($val)]['name']))
     $med_titl=$medal_types[strtolower($val)]['name'];

  if (isset($medal_types[strtolower($val)]['image']))
     $med_img=$medal_types[strtolower($val)]['image'];

  if (isset($medal_types[strtolower($val)]['description']))
     $med_titl.=" - ".$medal_types[strtolower($val)]['description'];

 echo "<img src=\"img/$med_img\" title=\"$med_titl\">\n";
  }
}

echo "</li>\n";
?>