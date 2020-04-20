<h1>Reset Your Password</h1>

<?php if (isset($_SESSION['reset_success'])) { session_message('reset_success'); } elseif (isset($_SESSION['reset_error'])) { session_message('reset_error'); } else { ?>
Choose a new password:

<form action="" method="post">
<p><input type="password" name="password"></p>
<p><input type="submit" value="Reset"></p>
</form>
<?php } ?>
