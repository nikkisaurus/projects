<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Niketa's Slackers</title>
	<link rel="SHORTCUT ICON" href="<?php echo referencePath('assets/images/favicon', 'ico');  ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo referencePath('assets/plugins/scssphp/display'); ?>">

	<!-- JQUERY -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js" type="text/javascript"></script>
	<!-- JQUERY -->

	<!-- CUSTOM SCROLLBAR -->
	<link rel="stylesheet" type="text/css" href="<?php echo referencePath('assets/plugins/custom-scrollbar-plugin/jquery.mCustomScrollbar', 'css'); ?>">
	<!-- CUSTOM SCROLLBAR -->

	<!-- LIGHTBOX2 -->
	<link rel="stylesheet" type="text/css" href="<?php echo referencePath('assets/plugins/lightbox/css/lightbox', 'css'); ?>">
	<script src="<?php echo referencePath('assets/plugins/lightbox/js/jquery-1.10.2.min', 'js');  ?>"></script>
	<script src="<?php echo referencePath('assets/plugins/lightbox/js/lightbox-2.6.min', 'js');  ?>"></script>
	<!-- LIGHTBOX2 -->

	<script src="<?php echo referencePath('assets/javascript', 'js');  ?>"></script>

	<!-- GOOGLE -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-45813026-1', 'niketa.net');
	  ga('send', 'pageview');

	</script>
	<!-- GOOGLE -->
</head>

<body>
	<?php if (isset($_SESSION['refresh_last_updated'])) { ?>
		<script type="text/javascript">
		$.ajax({
		    url: "inc/lastupdate.php",
		    async: false,
		    type: "POST"
		});
		</script>
	<?php }	unset($_SESSION['refresh_last_updated']); ?>

	<div id="wrapper">
		<header>
		<?php if (current_user() and current_user()->user_id == 2) { ?><img src="<?php echo referencePath('assets/images/raccoon', 'png'); ?>" id="raccoon"><?php } ?>
			<div id="home_overlay"></div>
			<div id="nav">
				<ul id="or_nav">
					<li><a href="http://openraid.us/p/niketa" target="new">group</a></li>
					<li><a href="http://openraid.us/groups/index/niketa#events" target="new">upcoming events</a></li>
				</ul>
				<ul id="main_nav">
					<li><a href="<?php echo relativeLink(''); ?>">home</a></li>
					<li><a href="<?php echo relativeLink('rules'); ?>">rules</a></li>
					<li class="nav_dropdown">
						<a href="" id="bonusrolls_menu">bonusrolls</a>
						<ul id="nav_bonusrolls">
							<li><a href="<?php echo relativeLink('bonusrolls?raid=ds'); ?>">Dragon Soul</a></li>
							<li><a href="<?php echo relativeLink('bonusrolls?raid=fl'); ?>">Firelands</a></li>
							<li><a href="<?php echo relativeLink('bonusrolls?raid=soo'); ?>">Siege of Orgrimmar</a></li>
							<li><a href="<?php echo relativeLink('bonusrolls?raid=t11'); ?>">Tier 11</a></li>
							<li><a href="<?php echo relativeLink('bonusrolls?raid=t14'); ?>">Tier 14</a></li>
							<li><a href="<?php echo relativeLink('bonusrolls?raid=tot'); ?>">Throne of Thunder</a></li>
							<li><a href="<?php echo relativeLink('bonusrolls?raid=uld'); ?>">Ulduar</a></li>
							<li><a href="<?php echo relativeLink('spent'); ?>">Spent</a></li>
						</ul>
					</li>
					<li class="nav_dropdown">
						<a href="" id="attendance_menu">attendance</a>
						<ul id="nav_attendance">
							<li><a href="<?php echo relativeLink('attendance?raid=ds'); ?>">Dragon Soul</a></li>
							<li><a href="<?php echo relativeLink('attendance?raid=fl'); ?>">Firelands</a></li>
							<li><a href="<?php echo relativeLink('attendance?raid=soo'); ?>">Siege of Orgrimmar</a></li>
							<li><a href="<?php echo relativeLink('attendance?raid=t11'); ?>">Tier 11</a></li>
							<li><a href="<?php echo relativeLink('attendance?raid=t14'); ?>">Tier 14</a></li>
							<li><a href="<?php echo relativeLink('attendance?raid=tot'); ?>">Throne of Thunder</a></li>
							<li><a href="<?php echo relativeLink('attendance?raid=uld'); ?>">Ulduar</a></li>
						</ul>
					</li>
					<li><a href="<?php echo relativeLink('reserves'); ?>">reserves</a></li>
					<li class="nav_dropdown">
						<a href="" id="addons_menu">addons</a>
						<ul id="nav_addons">
							<li><a href="<?php echo relativeLink('baa'); ?>">Busy and Away</a></li>
							<li><a href="<?php echo relativeLink('mla'); ?>">Master Looter Assistant</a></li>
						</ul>
					</li>
					<li><a href="<?php echo relativeLink('raiders/summary'); ?>">raiders</a></li>
					<li><a href="<?php echo relativeLink('info'); ?>">info</a></li>
				</ul>
			</div>
		</header>
		<aside>
			<h2 id="shoutbox_header">Shoutbox</h2>
			<div  id="shoutbox_container">
			<?php relativeInclude('views/shoutbox/shoutbox'); ?>
			</div>

			<?php if (!current_user()) { ?>
				Login or register to post to the shoutbox.
			<?php } elseif (!current_user()->email_validated) { ?>
				You must validate your account before posting to the shoutbox.
			<?php } elseif (current_user()->locked) { ?>
				Your account has been locked.
			<?php } else { ?>
				<div id="shoutbox_div">
				<form action="<?php echo relativeLink('shoutbox/post'); ?>" method="post" id="shoutbox_form" <?php if (!current_user()->manually_verified) { ?>onsubmit="shoutbox_mod();"<?php } ?>>
					<input type="text" name="shoutbox_comment" placeholder="Submit a shoutbox post..." autocomplete="off">
					<div class="hidden">
						<input type="hidden" value="<?php echo getURI(fullURL()); ?>" name="current_page">
						<input type="submit" name="shoutbox_submit">
					</div>
					<p><?php session_message('shoutbox_error'); ?></p>
				</form>
				</div>
			<?php if (!current_user()->manually_verified) { ?><p id="shoutbox_msg">Shoubox posts will be submitted for moderation.</p><?php } ?>
			<?php } ?>
			<?php if (!current_user()) { ?>
				<h2>Login</h2>
					<div id="login_form">
						<form action="<?php echo relativeLink('login'); ?>" method="post"><ul class="no_dots">
							<li><input type="text" placeholder="Username" name="username"></li>
							<li><input type="password" placeholder="Password" name="password"></li>
							<li><input type="hidden" value="<?php echo getURI(fullURL()); ?>" name="current_page"></li>
							<li><input type="submit" value="Login"></li>
						</ul></form>
					</div>
					<?php session_message('login_error'); ?>
				<h2>Register</h2>
					<div id="register_form">
						<form action="<?php echo relativeLink('register'); ?>" method="post"><ul class="no_dots">
							<li><input type="text" placeholder="Username" name="username"></li>
							<li><input type="text" placeholder="Email" name="email"></li>
							<li><input type="password" placeholder="Password" name="password"></li>
							<li><input type="password" placeholder="Confirm Password" name="password2"></li>

							<div class="top_padding">
							<?php $security_question = generate_security_question(); ?>
							<li><input type="hidden" name="question_id" value="<?php echo $security_question->id; ?>"><?php echo $security_question->question; ?></li>
							<li><input type="text" name="security_question"></li>
							</div>

							<li><input type="hidden" value="<?php echo getURI(fullURL()); ?>" name="current_page"></li>
							<li><input type="submit" value="Register"></li>
						</ul></form>
					</div>
					<?php session_message('register_error'); ?>
			<?php } else { ?>
				<h2><?php echo current_user()->username; ?></h2>
					<ul class="no_dots">
						<div id="account_links">
						<?php if (!current_user()->email_validated) { ?>
						<li><a href="<?php echo relativeLink('users/resend'); ?>">Resend Verification Email</a></li>
						<?php } ?>
						<li><a href="<?php echo relativeLink('users/account'); ?>">Account</a></li>
						<li><a href="<?php echo relativeLink('users/profile'); ?>?id=<?php echo current_user()->user_id; ?>">Profile</a></li>
						<li><a href="<?php echo relativeLink('users/profile'); ?>">User Directory</a></li>
						</div>
						<?php if (current_user()->is_mod) { ?>
						<div id="moderation_links" class="top_padding<?php if ('niketa is admin') { ?> bottom_padding<?php } ?>">
							<h3>Moderation</h3>
							<li><a href="<?php echo relativeLink('moderate/pending'); ?>">Pending Posts (<span id="pending_count"><?php post_count(0); ?></span>)</a></li>
							<li><a href="<?php echo relativeLink('moderate/denied'); ?>">Denied Posts (<span id="denied_count"><?php post_count(2); ?></span>)</a></li>
						</div>
						<?php }
						if (current_user()->is_admin) { ?>
						<div id="admin_links">
							<h3>Admin</h3>
							<li><a href="<?php echo relativeLink('admin/update'); ?>">Update Bonus Rolls</a></li>
							<li><a href="<?php echo relativeLink('reindex'); ?>">Reindex Tables</a></li>
							<li><a href="http://www.000webhost.com/includes/stats.php?action=view_stats&domain=niketa.net&login_hash=" target="new">Counter160</a></li>
							<li><a href="https://www.google.com/analytics/web/?hl=en#report/visitors-overview/a45813026w76563574p79147778/" target="new">Google Analytics</a></li>
						</div>
						<?php } ?>
						<li><a href="<?php echo relativeLink('logout'); ?>">Logout</a></li>
					</ul>
			<?php } ?>
		</aside>
		<main>
			<?php echo $content; ?>
		</main>
		<footer><?php relativeInclude('inc/views/lastupdate'); ?></footer>
	</div>
	<script src="<?php echo referencePath('assets/plugins/custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min', 'js'); ?>"></script>
</body>
</html>
