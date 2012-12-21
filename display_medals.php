<?php

require "medal_types.php";

echo "<li style=\"margin-top:10px;\">\n";

$medals_i=$cur_post['medals'];

$medals=explode(",",$medals_i);

while (list($key,$val)=each($medals)){
  $med_img="q";

  if (isset($medal_types[strtolower($val)]))
     $med_img=$medal_types[strtolower($val)];

 echo "<img src=\"img/medal_$med_img.png\" title=\"$val\">\n";
}

echo "</li>\n";
?>