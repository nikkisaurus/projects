<h1>Select a Table</h1>

<div class="right">
	<form action="" method="post" id="reindex">
		<select name="table" id="reindex_select">
			<option selected disabled></option>
			<option>all</option>
		<?php
				
			foreach ($tables as $table) {
		?>
			<option><?php echo $table['TABLE_NAME']; ?></option>
		<?php
			}
		?>
		</select>
	</form>
</div>

<div class="clearfix"></div>

<div>
<?php
if ($error) {
	echo $error;
} elseif ($success) {
	echo $success;
} elseif ($successful) {
	foreach ($successful as $msg) {
		echo $msg;
	}
}
?>
</div>
