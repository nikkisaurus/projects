<h1>Denied Posts</h1>


<?php if (isset($denied)) { ?>
<div id="denied_container">
<div id="refresh_denied">
<?php foreach ($denied as $post) { $post = (object) $post; ?>
<div class="section_header">
	<div class="left">
		<a href="<?php echo relativeLink('users/profile'); ?>?id=<?php echo $post->user_id; ?>"><?php echo ucwords(userinfo($post->user_id)->username); ?></a>
	</div>
	<div class="right">
		<?php echo time_format($post->created_at); ?>
	</div>
	<div class="clearfix"></div>
</div>
<div class="section">
<?php echo $post->comment; ?>
<div class="right">
	<span class="approve_denied"><a href="<?php echo relativeLink('moderate/approve') . '?id=' . $post->id; ?>">approve</a></span>
	<?php if (current_user()->is_admin) { ?> | <span class="delete_denied"><a href="<?php echo relativeLink('shoutbox/delete') . '?id=' . $post->id; ?>">delete</a></span><?php } ?>
</div>
</div>
<?php } ?>
</div>
</div>
<?php } else { ?>
There are no denied shoutbox posts.
<?php } ?>
