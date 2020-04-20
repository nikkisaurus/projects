<h1>Reset Password</h1>

<div class="bottom_padding">Enter your email below to reset your password. If you've forgotten your username a password reset will be necessary and your username will be supplied to you in the email.</div>

<form action="" method="post">
<p><input type="text" name="email" placeholder="Email"></p>
<p><input type="submit"></p>
</form>

<div class="top_padding"><?php session_message('forgot_error'); session_message('reset_sent'); ?></div>
