<h1>Account Settings</h1>

<p class="section_header">Account Information</p>
<div class="section">
	<p>Username: <?php echo current_user()->username; ?></p>
	<p>Email: <?php echo current_user()->email; ?></p>
</div>

<p class="section_header">Account Type</p>
<div class="section">
	<p>Account Type: <?php echo ucwords(current_user()->name); ?></p>
	<p>Email Verified: <?php echo (current_user()->email_validated ? 'Verified' : 'Unverified'); ?></p>
	<p>Character Verified: <?php echo (current_user()->manually_verified ? 'Verified' : 'Unverified'); ?></p>

		<p class="top_padding" align="right">
			<?php if (!current_user()->manually_verified and current_user()->email_validated) { ?>
				<a href="<?php echo relativeLink('raiders/claim'); ?>">Claim Character</a>
			<?php } ?>
			<?php if (!current_user()->email_validated) { ?>
				<a href="<?php echo relativeLink('users/resend'); ?>">Resend Verification Email</a>
			<?php } ?>
		</p>
</div>

<p class="section_header">Update Account Information</p>
<div class="section">
	<form class="bottom_padding" action="" method="post">
		<table id="update_account_information">
		<tr>
			<td>Current Password:</td>
			<td><input type="password" name="password"></td>
		</tr>
		<tr>
			<td>New Password:</td>
			<td><input type="password" name="new_password"></td>
		</tr>
		<tr>
			<td>Confirm New Password:</td>
			<td><input type="password" name="confirm_password"></td>
		</tr>
		<tr>
			<td>New Email: </td>
			<td><input type="text" name="new_email"></td>
		</tr>
		<tr class="spacer"><td></td></tr>
		<tr>
			<td><input type="submit" value="Update"></td>
		</tr>
		</table>
	</form>

	<?php session_message('update_error'); session_message('update_success'); ?>
</div>
