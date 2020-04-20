<h1><?php echo raids($raid)->abbreviated_proper; ?> Bonus Rolls</h1>

<table id="bonus_rolls">
	<thead>
		<tr>
			<th></th>
		<?php foreach ($weeks as $k => $v) { ?>
			<th class="week">
				<p>Week <?php echo $k; ?></p>
				<p class="small_text"><a href="<?php echo relativeLink('attendance?raid=' . $raid . '#week' . $k); ?>"><em><?php echo date('m/d/y', strtotime($v['date'])); ?></em></a></p>
			</th>
		<?php }
		if (count($weeks) < 5) {
			for ($i = 0;  $i < 5 - count($weeks); $i++ ) {
				?>
				<th class="filler_week"></th>
				<?php }} ?>
	</thead>
	<tbody>
		<tr class="spacer">
			<td></td>
			<td colspan="6"></td>
		</tr>
	<?php foreach ($raider as $k => $v) { ?>
		<tr>
			<td id="<?php echo $v['raider_id']; ?>">
				<span><div id="<?php echo raiderinfo($v['raider_id'])->server; ?>" class="server hidden"><?php echo raiderinfo($v['raider_id'])->server; ?></div><a href="<?php echo relativeLink('raiders/summary') . '?id=' . $v['raider_id']; ?>"><?php echo $k; ?></a></span>
			</td>
		<?php foreach ($v as $k => $week) { if ($k != 'raider_id') { ?>
			<td class="week"><?php echo $week; ?></td>
		<?php }} ?>
		</tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6"><em>If you have any questions about your bonus rolls, please contact Niketa. Additionally, you can request a change to a character's name or server if you've claimed it under your account.</em></td>
		</tr>
	</tfoot>
</table>
