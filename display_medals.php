<?php
require_once "functions.php";

// Start printing
$user_id=$cur_post['poster_id'];

$tmp_medals = "";

getUserMedals($user_id,function($hash){
	global $tmp_medals;
	$tmp_medals .= printMedal($hash['mID']);
});

$forum_page['author_info']['medals'] = $tmp_medals;

if ($forum_user['g_id'] == FORUM_ADMIN)
	$forum_page['author_info']['medal_admin'] = "<p><a href=\"".FORUM_ROOT."extensions/punbb_medals/user.php?user={$cur_post['poster_id']}\">Manage Medals</a></p>";