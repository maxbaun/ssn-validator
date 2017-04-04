<?php

use D3\SSN\Export;

?>

<div class="wrap">
	<h2>Export SSN Data</h2>
	<p>Export all data to a CSV file. This will be located in the <?php echo $exportPath; ?> folder. </p>
	<a href="<?php echo Export::exportLink(); ?>" class="button button-primary">Export All Data</a>
</div>
