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