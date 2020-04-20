<h1><?php $server = "yes"; echo $title; ?> Attendance</h1>

<div class="weeks">
	<?php foreach ($weeks as $week) { ?>
	<?php $aname = explode("_", $week['week'], 2); ?>
	<div class="week" id="week<?php echo $aname[0]; ?>">
		<div class="section_header" id="<?php echo $week['week']; ?>">
			<div class="left">
				<?php echo $week['title']; ?>
			</div>
			<div class="right">
				<?php foreach ($week['links'] as $run => $id) { ?>
					<?php echo $run > 0 ? ' | ' :''; ?><a href="<?php echo 'http://openraid.us/r/' . $id; ?>" target="new"><?php echo $week['dates'][$run]; ?></a>
				<?php } ?>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="section"  id="section<?php echo $week['week']; ?>">
			<ul class="no_dots">
				<?php foreach ($week['raiders'] as $raider) { ?>
					<li><span class="attendees"><div id="<?php echo $raider['server']; ?>" class="server hidden"><?php echo $raider['server']; ?></div><a href="<?php echo relativeLink('raiders/summary') . '?id=' . $raider['id']; ?>"><?php echo $raider['raider']; ?></a></span></li>
				<?php } ?>
			</ul>
		</div>
		<p class="link_to_top"><a href="#">top</a></p>

	</div>
	<?php } ?>
</div>
