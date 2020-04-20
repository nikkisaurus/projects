<?php
if (isset($raiders)) {
?>
<h1 class="less_bottom_padding">Raiders</h1>

<div class="right" id="search_box">
<form action="<?php echo relativeLink('raiders/search'); ?>" method="get">
<input type="submit" value="Search">
<input type="text" name="s">
</form>
</div>

<div class="clearfix"></div>
<div id="raider_list">
<ul class="no_dots">
	<?php
	if (isset($raiders)) {
		foreach ($raiders as $raider) {
				foreach ($raider as $k => $v) {
					$raider[$k] = $v;
				}
	?>

	<li><a href="?id=<?php echo $raider['id']; ?>"><?php echo $raider['raider']; ?><?php if ($raider['server'] != '') { ?>-<?php } ?><?php echo $raider['server']; ?></a></li>

	<?php
			}
	}
	?>
</ul>
</div>
<?php }  elseif (isset($raider)) {
	foreach ($raider as $k => $v) {
		$raider[$k] = $v;
	}
	?>
<h1 class="less_bottom_padding"><?php echo $raider['raider']; ?>'s Raid Profile</h1>

<div class="right" id="raid_summary_link">
<p><em><?php echo $raider['server']; ?></em></p>
<?php if (isset($user)) { ?><p>Claimed by <a href="<?php echo relativeLink('users/profile') . '?id=' . $user->id; ?>"><?php echo ucwords($user->username); ?></a>.</p><?php } ?>
<p><a href="<?php echo relativeLink('raiders/summary'); ?>">view more</a></p>

</div>
<div class="clearfix"></div>

<div class="section_header">Summary</div>
<div class="section">

<?php
	if (!isset($raids)) {
		echo $raider['raider'];
?>
 has not attended any raids with bonus rolls.
<?php
	} else {

?>

<?php $rolls = array(); ?>
	<table id="raid_summary">
		<thead>
			<tr>
			<?php foreach ($raids as $k => $v) { ?>
				<?php if ($k != 'id' and $k != 'raider_id' and $v != null) { ?><td><?php echo raids($k)->abbreviated_proper; ?></td><?php } ?>
			<?php } ?>
			</tr>
		</thead>
		<tbody>
			<tr>
			<?php foreach ($raids as $k => $v) {
				 if ($k != 'id' and $k != 'raider_id' and $v != null) { $rolls[$k] = $v; $array = json_decode($v, true); ?>
				 	<td><?php echo reset($array); ?></td>
			<?php }} ?>
			</tr>
		</tbody>
	</table>
</div>


<?php

foreach ($rolls as $raid => $bonusroll) {
	$bonusroll = json_decode($bonusroll, true);
	$week_num = sizeof($bonusroll);
?>
	<div class="raids">
		<div class="section_header" id="<?php echo raids($raid)->abbreviated; ?>">
			<div class="left">
<a href="<?php echo relativeLink('bonusrolls?raid=' . raids($raid)->abbreviated); ?>"><?php echo raids($raid)->proper; ?></a>
			</div>
			<div class="right">
				<strong>Current Bonus Roll:</strong> <?php echo $bonusroll[$week_num]; ?>
			</div>
		</div>

		<div class="section week_list" id="section<?php echo raids($raid)->abbreviated; ?>">
			<ul class="no_dots">
<?php foreach ($bonusroll as $week => $roll) { ?>

				<li><a href="<?php echo relativeLink('attendance?raid=' . $raid . '#week' . $week); ?>">W<?php if ($week < 10) {echo 0;} echo $week; ?></a>: <?php echo $roll; ?></li>

<?php } ?>
			</ul>
		</div>
	</div>
<?php } ?>

<?php }} ?>
