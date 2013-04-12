<?php
// Functions
function printMedal($id){
	global $forum_db;

	$query = array(
		'SELECT'  => '*',
		'FROM'    => 'medal_def',
		'WHERE'   => "mID = $id"
	);
	$res = $forum_db->query_build($query);

	if (!$res)
		return;

	$row = $forum_db->fetch_assoc($res);

	if (!$row)
		return;

	return "<img src=\"".$row['image']."\" title=\"".$row['title']." - ".$row['description']."\">";
}

function getUserMedals($id,$step){
	global $forum_db;

	$query = array(
		'SELECT'  => '*',
		'FROM'    => 'medals',
		'WHERE'   => "uID = $id"
	);

	$res = $forum_db->query_build($query);

	while ($hash = $forum_db->fetch_assoc($res)){
		$step($hash);
	}
}
