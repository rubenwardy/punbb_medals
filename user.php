<?php

if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', '../../');
require FORUM_ROOT.'include/common.php';
require FORUM_ROOT.'include/common_admin.php';

if ($forum_user['g_id'] != FORUM_ADMIN)
	message($lang_common['No permission']);

// Load the admin.php language file
require FORUM_ROOT.'lang/'.$forum_user['language'].'/admin_common.php';

$forum_page['group_count'] = $forum_page['item_count'] = $forum_page['fld_count'] = 0;
$forum_page['crumbs'] = array(
	array($forum_config['o_board_title'], forum_link($forum_url['index'])),
	array($lang_admin_common['Forum administration'], forum_link($forum_url['admin_index'])),
	"Medals"
);

define('FORUM_PAGE_SECTION', 'punbb_medals');
define('FORUM_PAGE', 'admin-punbb_medals');

$message="Manage a user's medals";
$user = $_GET['user'];
$medals = array();

if (!$user){
	error("Unknown user");
}

if ($_GET['mode']=="grant"){
	$query = array(
		'INSERT'   => 'uID,mID',
		'INTO'     => 'medals',
		'VALUES'   => "$user,".$_POST['medal'],
	);
	$forum_db->query_build($query) or error(__FILE__, __LINE__);
	header("location: user.php?user=".$user);
}else if ($_GET['mode']=="revoke"){
	$query = array(
		'DELETE'   => 'medals',  // table name
		'WHERE'    => 'gID='.$_GET['id']
	);
	$forum_db->query_build($query);
	header("location: user.php?user=".$user);
}

$query = array(
	'SELECT'  => '*',
	'FROM'    => 'medals',
	'WHERE' => 'uID='.$user
);
$res = $forum_db->query_build($query);
while ($row = $forum_db->fetch_assoc($res)){
	$query2 = array(
		'SELECT'  => '*',
		'FROM'    => 'medal_def',
		'WHERE' => 'mID='.$row['mID']
	);
	$res2 = $forum_db->query_build($query2);
	if ($res2){
		$row2 = $forum_db->fetch_assoc($res2);
		$row2['gID']=$row['gID'];
		array_push($medals,$row2);
	}else{
		echo "Def error";
	}
}

require FORUM_ROOT.'header.php';
ob_start();
?>
	<div class="main-subhead">
		<h2 class="hn"><span><?php echo $message;?></span></h2>
	</div>
<div class="main-content main-frm">
	<div class="content-head">
		<div class="content-head">
			<h2 class="hn"><span>Grant A medal</span></h2>
		</div>
		<fieldset class="frm-group group1">
			<form action="user.php?mode=grant&<?php echo "user=$user";?>" method="post">
				<div class="sf-set set1">
					<div class="sf-box text">
						<label for="fld9">
							<span>Medal</span>
							<small>The medal to give</small>
						</label><br />
					<span class="fld-input">
						<select name="medal">
							<?php
							$query = array(
								'SELECT'  => '*',
								'FROM'    => 'medal_def',
								'ORDER BY' => 'mID'
							);

							function PlayerHasMedal($medals,$id){
								for ($a=0;$a<count($medals);$a++){
									if ($medals[$a]['mID']==$id){
										return true;
									}
								}
								return false;
							}

							$res = $forum_db->query_build($query);
							$results=0;
							while ($row = $forum_db->fetch_assoc($res)){
								$results++;
								if(!PlayerHasMedal($medals,$row['mID'])){
									echo "<option value=\"{$row['mID']}\">{$row['title']}</option>";
								}
							}
							?>
						</select>
					<span>
					</div>
				</div>
				<div class="frm-buttons">
					<span class="submit primary"><input type="submit" name="add" value="Grant" /></span>
				</div>
			</form>
		</fieldset>

		<div style="padding:20px;padding-top:0;">
			<table>
				<tr>
					<th style="width:20px"></th>
					<th style="width:100px;">Title</th>
					<th>Description</th>
					<th style="width:50px"></th>
				</tr>
				<?php
				for ($a=0;$a<count($medals);$a++){
					$row = $medals[$a];
					echo "\t\t\t<tr>\n";
					echo "\t\t\t\t<td><img src=\"".FORUM_ROOT.$row['image']."\"></td>\n";
					echo "\t\t\t\t<td>".$row['title']."</td>\n";
					echo "\t\t\t\t<td>".$row['description']."</td>\n";
					echo "\t\t\t\t<td><a href=\"user.php?user=$user&mode=revoke&id=".$row['gID']."\">Revoke</a></td>\n";
					echo "\t\t\t</tr>\n";
				}
				echo "\t\t</table>\n";
				?>
			</table>
		</div>
	</div>
<?php
$tpl_temp = forum_trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
require FORUM_ROOT.'footer.php';