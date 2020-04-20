<h1>Spent</h1>

<div class="section_header">Dragon Soul</div>
<div class="section">
<ul class="no_dots">
<?php if($spent_ds) {foreach ($spent_ds as $spent_ds) { if ($spent_ds['raid'] == "ds") { ?>
	<li><em><?php echo $spent_ds['raider']; ?></em> spent <em><?php echo $spent_ds['spent_amount']; ?></em> for <em><?php echo $spent_ds['spent_on']; ?></em> on <em><?php echo $spent_ds['datef']; ?></em>.</li>
<?php }}} else { ?>
	<li>No one has spent a bonus roll in Dragon Soul.</li>
<?php } ?>
</ul>
</div>


<div class="section_header">Firelands</div>
<div class="section">
<ul class="no_dots">
<?php if($spent_fl) {foreach ($spent_fl as $spent_fl) { if ($spent_fl['raid'] == "fl") { ?>
	<li><em><?php echo $spent_fl['raider']; ?></em> spent <em><?php echo $spent_fl['spent_amount']; ?></em> for <em><?php echo $spent_fl['spent_on']; ?></em> on <em><?php echo $spent_fl['datef']; ?></em>.</li>
<?php }}} else { ?>
	<li>No one has spent a bonus roll in Firelands.</li>
<?php } ?>
</ul>
</div>


<div class="section_header">Tier 11</div>
<div class="section">
<ul class="no_dots">
<?php if($spent_t11) {foreach ($spent_t11 as $spent_t11) { if ($spent_t11['raid'] == "t11") { ?>
	<li><em><?php echo $spent_t11['raider']; ?></em> spent <em><?php echo $spent_t11['spent_amount']; ?></em> for <em><?php echo $spent_t11['spent_on']; ?></em> on <em><?php echo $spent_t11['datef']; ?></em>.</li>
<?php }}} else { ?>
	<li>No one has spent a bonus roll in Tier 11 raids.</li>
<?php } ?>
</ul>
</div>


<div class="section_header">Tier 14</div>
<div class="section">
<ul class="no_dots">
<?php if($spent_t14) {foreach ($spent_t14 as $spent_t14) { if ($spent_t14['raid'] == "t14") { ?>
	<li><em><?php echo $spent_t14['raider']; ?></em> spent <em><?php echo $spent_t14['spent_amount']; ?></em> for <em><?php echo $spent_t14['spent_on']; ?></em> on <em><?php echo $spent_t14['datef']; ?></em>.</li>
<?php }}} else { ?>
	<li>No one has spent a bonus roll in Tier 14 raids.</li>
<?php } ?>
</ul>
</div>



<div class="section_header">Throne of Thunder</div>
<div class="section">
<ul class="no_dots">
<?php if($spent_tot) {foreach ($spent_tot as $spent_tot) { if ($spent_tot['raid'] == "tot") { ?>
	<li><em><?php echo $spent_tot['raider']; ?></em> spent <em><?php echo $spent_tot['spent_amount']; ?></em> for <em><?php echo $spent_tot['spent_on']; ?></em> on <em><?php echo $spent_tot['datef']; ?></em>.</li>
<?php }}} else { ?>
	<li>No one has spent a bonus roll in Throne of Thunder.</li>
<?php } ?>
</ul>
</div>


<div class="section_header">Ulduar</div>
<div class="section">
<ul class="no_dots">
<?php if($spent_uld) {foreach ($spent_uld as $spent_uld) { if ($spent_uld['raid'] == "uld") { ?>
	<li><em><?php echo $spent_uld['raider']; ?></em> spent <em><?php echo $spent_uld['spent_amount']; ?></em> for <em><?php echo $spent_uld['spent_on']; ?></em> on <em><?php echo $spent_uld['datef']; ?></em>.</li>
<?php }}} else { ?>
	<li>No one has spent a bonus roll in Ulduar.</li>
<?php } ?>
</ul>
</div>
