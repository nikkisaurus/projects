<h1>Update Bonus Rolls</h1>

<?php if (isset($_SESSION['update_summary'])) { ?>
<script type="text/javascript">
$.ajax({
    url: "../inc/lastupdate.php",
    async: false,
    type: "POST"
});
</script>
<ul class="no_dots">
<?php
foreach ($_SESSION['update_summary'] as $k => $v) {
	if (is_array($v)) { ?>
	<li><strong><?php echo raiderinfo($k)->raider; ?>'s</strong> new bonus roll is <?php echo $v['new_bonus']; ?>. Last week it was <em><?php echo $v['last_bonus_roll']; ?></em> and previously it was  <em><?php echo $v['prev_bonus_roll']; ?></em>.</li>
<?php } else { ?>
	<li><?php echo raiderinfo($v)->raider; ?> attended but did not receive a bonus roll.</li>
<?php }
unset($_SESSION['update_summary']);
} ?>
</ul>

<p align="center"><a href="<?php echo relativeLink('admin/update'); ?>">back</a></p>
<?php } elseif (isset($raiders)) { ?>
<form action="" method="post" id="update_list">
<?php session_message('update_error'); ?>
<div class="right"><input type="radio" name="group" value="1" checked>1 <input type="radio" name="group" value="2">2 <input type="checkbox" name="multgroups" value="1"><label for="multgroups" class="tooltip hidden"><em>Other groups from this week have already been posted.</em></label><input type="text" name="orid" placeholder="OpenRaid ID"></div>
<div class="clearfix"></div>
<table id="update_options">
	<tr>
		<td>
			<select id="raid" name="raid">
				<option selected disabled></option>
				<option value="ds">Dragon Soul</option>
				<option value="fl">Firelands</option>
				<option value="soo">Siege of Orgimmar</option>
				<option value="t11">Tier 11</option>
				<option value="t14">Tier 14</option>
				<option value="tot">Throne of Thunder</option>
				<option value="uld">Ulduar</option>
			</select>
		</td>
		<td>
			<input type="date" name="date">
		</td>
		<td>
			<select id="raiders_select">
				<option selected></option>
				<?php foreach($raiders as $raider) { ?>
				<option id="raider_<?php echo $raider['id']; ?>" value="<?php
					echo implode(',', array(
						'id' => ($raider['id']),
						'name' => $raider['raider'],
						'server' => $raider['server'],
						'btag' => $raider['btag'],
						'friends' => $raider['friends'],
						'exempt' => $raider['exempt']
					));
				?>"><?php echo $raider['raider']; ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
</table>

<div class="top_padding">
<table id="update_pending">
	<thead>
		<tr>
			<th></th>
			<th>Raider</th>
			<th>Server</th>
			<th>Btag</th>
			<th>Friends</th>
			<th>Exempt</th>
			<th>Spent</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7"><a href="">new raider</a></td>
		</tr>
	</tfoot>
</table>
</div>

<p class="footer">Counter: <span id="pending_counter">0</span></p>

<div class="right"><input type="submit" value="Update"><input type="reset" value="Clear"></div>
</form>
<?php } ?>
