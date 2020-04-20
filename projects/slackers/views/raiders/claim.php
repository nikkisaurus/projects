<h1>Claim a Toon</h1>

<?php if (isset($_SESSION['claim_success'])) {
	session_message('claim_success');
} elseif (isset($error)) {
	echo $error;
} else { ?>
<div class="bottom_padding">To claim a toon, enter the code you received from Niketa below.</div>

<?php session_message('claim_error'); ?>

<div>
	<form action="" method="post">
		<p><input type="text" name="claim_code"></p>
		<p><input type="submit" value="Submit"></p>
	</form>
</div>
<?php } ?>
