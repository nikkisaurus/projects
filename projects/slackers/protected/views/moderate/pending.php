<h1>Pending Posts</h1>


<?php if (isset($pending)) { ?>
<div id="pending_container">
<div id="refresh_pending">
<?php foreach ($pending as $post) { $post = (object) $post; ?>
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
	<span class="approve_pending"><a href="<?php echo relativeLink('moderate/approve') . '?id=' . $post->id; ?>">approve</a></span> | 
	<span class="deny_pending"><a href="<?php echo relativeLink('moderate/deny') . '?id=' . $post->id; ?>">deny</a></span>
</div>
</div>
<?php } ?>
</div>
</div>
<?php } else { ?>
There are no pending shoutbox posts.
<?php } ?>
