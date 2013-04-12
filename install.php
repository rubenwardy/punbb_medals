<?php


if ($forum_db -> table_exists("medals")==false){
	$forum_db -> create_table("medals",array(
		'FIELDS'      => array(
			'uID'   => array(
				'datatype'     => 'INT(10)',
				'allow_null'   => false
			),
			'mID'   => array(
				'datatype'     => 'INT(10)',
				'allow_null'   => false
			)
		)
	));
}
if ($forum_db -> table_exists("medal_def")==false){
	$forum_db -> create_table("medal_def",array(
		'FIELDS'      => array(
			'mID'   => array(
				'datatype'     => 'SERIAL',
				'allow_null'   => false
			),
			'title'   => array(
				'datatype'     => 'VARCHAR(50)',
				'allow_null'   => false,
			),
			'image'   => array(
				'datatype'     => 'VARCHAR(100)',
				'allow_null'   => false,
			),
			'description'   => array(
				'datatype'     => 'VARCHAR(100)',
				'allow_null'   => true,
			)
		),
		'PRIMARY KEY'   => array('mID')
	));
}