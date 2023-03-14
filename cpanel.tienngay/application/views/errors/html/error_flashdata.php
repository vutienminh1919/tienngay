<?php  defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (!empty($this->session->flashdata('msg_error'))) { ?>
  <div class="error alert alert-danger alert-dismissible" id="validation_error">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo $this->session->flashdata('msg_error'); ?>
  </div>
  <?php } ?>

  <?php if (!empty($this->session->flashdata('msg_success'))) { ?>
    <div class="error alert alert-success alert-dismissible" id="validation_success">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php echo $this->session->flashdata('msg_success'); ?>
    </div>
    <?php } ?>