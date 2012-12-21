<?php
echo "Medals: ";

$medal_id=$cur_post['poster_id'];

if (is_numeric($medal_id)==true){
  $res = $forum_db->query("SELECT * FROM punbb_users WHERE id = $medal_id");
}


?>