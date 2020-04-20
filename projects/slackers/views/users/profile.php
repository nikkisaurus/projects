<?php if (isset($user)) { ?>
<h1 class="less_bottom_padding"><?php echo ucwords($user->username); ?>'s Profile</h1>

<div class="right" id="raid_summary_link">
<p><a href="<?php echo relativeLink('users/profile'); ?>">user directory</a></p>

</div>
<div class="clearfix"></div>

<div class="section_header">Raider Information</div>
<div class="section">
<?php if ($user->raider_id) { ?>
	Claimed: <a href="<?php echo relativeLink('raiders/summary') . '?id=' . $user->raider_id; ?>"><?php echo raiderinfo($user->raider_id)->raider; ?></a>
<?php } else { ?>
	<?php echo ucwords($user->username); ?> hasn't claimed a toon.
<?php } ?>
</div>

<div id="account_type_container">
<div class="section_header">Account Type</div>
<div class="section" id="refresh_account_type">
	<p>Account Type: <?php echo ($user->locked ? "Locked" : ucwords(groupinfo($user->group_id)->name)); ?></p>
	<p>Email Verified: <?php echo (ucwords(groupinfo($user->group_id)->email_validated) ? 'Verified' : 'Unverified'); ?></p>
	<p>Character Verified: <?php echo (ucwords(groupinfo($user->group_id)->manually_verified) ? 'Verified' : 'Unverified'); ?></p>

	<?php if (current_user() and current_user()->is_admin and current_user()->user_id != $user->id) { ?><div class="right">
		<span id="promote"><a href="<?php echo relativeLink('admin/promote') . '?id=' . $user->id . '&gid=' . $user->group_id; ?>">promote</a></span>
		 | 
		<span id="demote"><a href="<?php echo relativeLink('admin/demote') . '?id=' . $user->id . '&gid=' . $user->group_id; ?>">demote</a></span>
		 | 
		<span id="lock"><a href="<?php echo relativeLink('admin/lock') . '?id=' . $user->id; ?>"><?php echo ($user->locked ? "unlock" : "lock"); ?></a></span>
	</div><?php } ?>
</div>
</div>
<?php } else { ?>
<h1>User Directory</h1>

<ul class="no_dots">
<?php foreach ($users as $user) { $user = (object) $user; ?>
	<li><a href="<?php echo relativeLink('users/profile') . '?id=' . $user->id; ?>"><?php echo ucwords($user->username); ?></a></li>
<?php } ?>
</ul>
<?php } ?>
