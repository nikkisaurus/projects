<h1>News</h1>

<?php if (current_user() and current_user()->is_mod) { ?>
<div class="bottom_padding">
		<p align="right"><a href="<?php echo relativeLink('articles/new'); ?>">new article</a></p>
</div>
<?php } ?>

<div id="article_container">
<?php foreach($post as $article) { ?>
	<article id="article">
		<div class="section_header">
			<div class="left">
				<h2 class="article_title" id="article_title_<?php echo $article['id']; ?>"><?php echo $article['title']; ?></h2>
			</div>
			<div class="right">
				<?php echo time_format($article['created_at']); ?>
			</div>
		</div>

		<div class="section">
			<div class="hidden" id="article_post_<?php echo $article['id']; ?>"><?php echo $article['post']; ?></div>
			<?php $article['post'] = process_tags($article['post']); ?>
			<?php echo $article['post']; ?>
		</div>

		<div class="article_info">
				<div class="mod_article"><?php if (current_user() and current_user()->is_mod) { ?><div class="left"><span id="edit_article"><a href="<?php echo relativeLink('articles/edit') . '?id=' . $article['id']; ?>">edit</a></span><?php if (current_user()->is_admin) { ?> | <span id="delete_article"><a href="<?php echo relativeLink('articles/delete') . '?id=' . $article['id']; ?>">delete</a></span><?php } ?></div><?php } ?></div>
			Posted by <a href="<?php echo relativeLink('users/profile') . '?id=' . $article['user_id'];?>"><?php echo ucwords(userinfo($article['user_id'])->username); ?></a>.
			
			<?php if ($article['updated_at'] != $article['created_at']) { ?>
				Edited by <a href="<?php echo relativeLink('users/profile') . '?id=' . $article['last_edited_by'];?>"><?php echo ucwords(userinfo($article['last_edited_by'])->username); ?></a> <?php echo time_prefix($article['updated_at']); ?> <?php echo time_format($article['updated_at']); ?>.
			<?php } ?>
		</div>

		
	</article>
<?php } ?>
</div>

<?php if (sizeof($post) == 0) { ?>
	Welcome to my website!
<?php } ?>
