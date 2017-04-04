<?php

use D3\SSN\Recaptcha;

?>

<div class="ssn-validator">
	<form id="ssn_validator_form" name="ssn_validator_form" class="ssn-validator-form" method="post"
		action="<?php echo $formAction; ?>">
		<div class="ssn-validator-form-inner">
			<label>
				<?php
					echo $label;
				?>
			</label>
			<div class="ssn-validator-input-container inline-container inputs-container">
				<input
					type="text"
					name="ssn_validator_first"
					class="ssn-validator-input ssn-validator-input-first" maxlength="3"
					value="<?php echo $first; ?>"
					/>
				<span class="ssn-validator-input-separator">-</span>
				<input
					type="text"
					name="ssn_validator_second"
					class="ssn-validator-input ssn-validator-input-second"
					maxlength="2"
					value="<?php echo $second; ?>"
					/>
				<small id="ssn_validator_form_response" class="ssn-validator-form-text"></small>
			</div>
			<div class="ssn-validator-input-container inline-container submit-container">
				<input
					class="ssn-validator-input"
					type="submit"
					name="ssn_validator_submit"
					value="Search"
					/>
			</div>
			<?php
				echo Recaptcha::render()
			?>
		</div>
	</form>
</div>
