<?php
	if (isset($_GET['p'])) {
		$_SESSION['shoutbox_page'] = intval($_GET['p']);
		$page = $_SESSION['shoutbox_page'];

		if (intval($page) != 1) {
			$previous_page = intval($page) - 1;
		} else {
			$previous_page = 1;
		}
		$next_page = intval($page) + 1;
	} else {
		$page = 1;
		$previous_page = 1;
		$next_page = $page + 1;
	}

	$paginator = new Paginator($_SESSION['shoutbox_page']);
	$previous_page = $paginator->previous_page;
	$next_page = $paginator->next_page;
	$last_page = $paginator->last_page;
	$shouts = $paginator->chunks;
?>
<div id="shoutbox_arrows">
	<ul class="no_dots">
		<li id="first_page"><a href="<?php echo relativeLink('refresh') . '?page=1'; ?>">&lt;&lt;</a></li>
		<li id="previous_page"><a href="<?php echo relativeLink('refresh') . '?page=' . $previous_page; ?>">&lt;</a></li>
		<li><strong>Pg#<?php if ($page > $last_page) {echo $last_page;} else {echo $_SESSION['shoutbox_page'];} ?></strong></li>
		<li id="next_page"><a href="<?php echo relativeLink('refresh') . '?page=' . $next_page; ?>">&gt;</a></li>
		<li id="last_page"><a href="<?php echo relativeLink('refresh') . '?page=' . $last_page; ?>">&gt;&gt;</a></li>
	</ul>
</div>

<div id="shoutbox" class="custom_scrollbar">
<div id="refresh_me">
<?php

	if (sizeof($shouts) == 0) {
?>
	<p>There are no posts.</p>
<?php

}

foreach ($shouts as $shout) {
	foreach ($shout as $k => $v) {
		$shout[$k] = $v;
		if ($k == 'guest') {
			$shout[$k] = ucwords($v);
		}
	}

?>

	<div class="post_info">
		<div class="left">
			<?php if ($shout['user_id'] == null) {echo $shout['guest'];} else { ?><a href="<?php echo relativeLink('users/profile'); ?>?id=<?php echo $shout['user_id']; ?>"><?php echo ucwords(userinfo($shout['user_id'])->username); ?></a><?php } ?>
		</div>
		<div class="right">
			<?php time_format($shout['created_at']); ?>
		</div>
	</div>
	<p class="post_comment" id="shoutbox_comment_<?php echo $shout['id']; ?>"><?php echo $shout['comment']; ?></p>
	<?php if (!$shout['last_edited_by'] == null) { ?>
		<p class="last_edited">Edited by <?php echo ucwords(userinfo($shout['last_edited_by'])->username); ?> <?php time_prefix($shout['updated_at']); ?> <?php time_format($shout['updated_at']); ?>.</p>
	<?php } ?>
	<?php if (current_user()) { if (current_user()->user_id == $shout['user_id'] or current_user()->is_mod) { ?>

		<p class="post_edit">
			<span class="shoutbox_edit">
				<a id="<?php echo $shout['id']; ?>" href="<?php echo relativeLink('shoutbox/edit') . '?id=' . $shout['id'] . '&uid=' . $shout['user_id'] ?>">
					edit
				</a>
			</span>
			<?php if (current_user()->is_admin or current_user()->user_id == $shout['user_id']) { ?><span class="shoutbox_delete"> |
				<a href="<?php echo relativeLink('shoutbox/delete') . '?id=' . $shout['id'] . '&uid=' . $shout['user_id']; ?>">
					delete
				</a>
			</span>
			<?php } ?>
			<?php if (current_user()->is_mod) { ?><span class="shoutbox_hide" id="<?php echo $page; ?>"> |
				<a href="<?php echo relativeLink('moderate/deny') . '?id=' . $shout['id']. '&uid=' . $shout['user_id']; ?>">
					hide
				</a>
			</span><?php } ?>
		</p>
	<?php }} ?>
<?php } ?>
</div>
	</div>
