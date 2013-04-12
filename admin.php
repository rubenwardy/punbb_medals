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

$message="Define medal types";

if ($_GET['mode'] && $_GET['mode']=="add"){
	$title = $_POST['title'];
	$description = $_POST['desc'];
	$image = $_POST['image'];

	if ($_FILES["upload"]){
		if (file_exists("imgs/" . $_FILES["upload"]["name"]))
		{
			$message =  $_FILES["file"]["name"] . " already exists. ";
		}
		else
		{
			move_uploaded_file($_FILES["file"]["tmp_name"],	"imgs/" . $_FILES["file"]["name"]);
			$message = "Stored in: " . "imgs/" . $_FILES["file"]["name"];
			$image = $_FILES["file"]["name"];
		}
	}

	if ($title && $description && $image){
		$image = "extensions/punbb_medals/imgs/$image";
		$title = $forum_db->escape($title);
		$description = $forum_db->escape($description);
		$image = $forum_db->escape($image);

		$query = array(
			'INSERT'   => 'title,description,image',
			'INTO'     => 'medal_def',
			'VALUES'   => "'$title','$description','$image'",
		);
		$forum_db->query_build($query) or error(__FILE__, __LINE__);
	}

	header("location: admin.php");

}elseif ($_GET['mode'] && $_GET['mode']=="delete" && $_GET['id']){
	$query = array(
		'DELETE'   => 'medal_def',  // table name
		'WHERE'    => 'mID='.$_GET['id']
	);
	$forum_db->query_build($query);
}

require FORUM_ROOT.'header.php';
ob_start();
	?>
<div class="main-subhead">
        <h2 class="hn"><span><?php echo $message;?></span></h2>
</div>
<div class="main-content main-frm">
	<div class="content-head">
		<h2 class="hn"><span>Add a medal definition</span></h2>
	</div>
	<fieldset class="frm-group group1">
		<form action="admin.php?mode=add" method="post">
			<div class="sf-set set1">
				<div class="sf-box text">
					<label for="fld9"><span>Title</span><small>The title of the medal.</small></label><br />
					<span class="fld-input"><input name="title" type="text" maxlength="50"></span>
				</div>
			</div>
			<div class="sf-set set2">
				<div class="sf-box text">
					<label for="fld9">
						<span>Description</span>
						<small>An explaination of what the user has done to deserve this.</small>
					</label><br />
					<span class="fld-input"><input name="desc" type="text" maxlength="500"></span>
				</div>
			</div>
			<div class="sf-set set1">
				<div class="sf-box text">
					<label for="fld9">
						<span>Image</span>
						<small>The medal's icon.</small>
					</label><br />
					<span class="fld-input">
						<select name="image">
							<?php
							if ($handle = opendir('imgs')) {
								/* This is the correct way to loop over the directory. */
								while (false !== ($entry = readdir($handle))) {
									if ($entry[0] != ".")
										echo "<option>$entry</option>";
								}
							}
							?>
						</select>
						or
						<input type="file" name="upload">
					<span>
				</div>
			</div>
			<div class="frm-buttons">
				<span class="submit primary"><input type="submit" name="add" value="Add definition" /></span>
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

			$query = array(
				'SELECT'  => '*',
				'FROM'    => 'medal_def',
				'ORDER BY' => 'mID'
			);

			$res = $forum_db->query_build($query);
			$results=0;
			while ($row = $forum_db->fetch_assoc($res)){
				$results++;
				echo "\t\t\t<tr>\n";
				echo "\t\t\t\t<td><img src=\"".FORUM_ROOT.$row['image']."\"></td>\n";
				echo "\t\t\t\t<td>".$row['title']."</td>\n";
				echo "\t\t\t\t<td>".$row['description']."</td>\n";
				echo "\t\t\t\t<td><a href=\"admin.php?mode=delete&id=".$row['mID']."\">Delete</a></td>\n";
				echo "\t\t\t</tr>\n";
			}

			if ($results==0){
				echo "\t\t\t<tr>\n";
				echo "\t\t\t\t<td colspan=3 style=\"text-align:center;\"><i>No medal definitions found</i></td>\n";
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