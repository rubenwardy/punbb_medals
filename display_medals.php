<?php
$medal_id=$cur_post['poster_id'];

if (is_numeric($medal_id)==false)
  return;

echo "<li>Medals<br>";
echo "SELECT * FROM punbb_users WHERE id=".$medal_id;

if (!$forum_db)
  return;

$medal_res = $forum_db->query("SELECT * FROM punbb_users WHERE id=".$medal_id) or die("query error");

if (!$medal_res)
  return;

$medal_h = mysql_fetch_array($medal_res);

if (!$medal_h)
  return;
     
echo ": '".$medal_h['medals']."'";

echo "</li>";
?>