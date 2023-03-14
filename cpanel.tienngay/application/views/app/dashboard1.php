<div class="right_col" role="main">
	<br>&nbsp;
	<?php if ($this->session->flashdata('error')) { ?>
		<div class="alert alert-danger alert-result">
			<?= $this->session->flashdata('error') ?>
		</div>
	<?php } ?>
	<?php if ($this->session->flashdata('success')) { ?>
		<div class="alert alert-success alert-result">
			<?= $this->session->flashdata('success') ?></div>
	<?php } ?>
</div>
