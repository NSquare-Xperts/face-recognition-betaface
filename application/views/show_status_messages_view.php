<?php
if ($this->session->flashdata('_success') != '') {
    ?>
    <div class="alert alert-success alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->session->flashdata('_success'); ?>
    </div>
    <?php
}
if ($this->session->flashdata('_error') != '') {
    ?>
    <div class="alert alert-danger alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->session->flashdata('_error'); ?>
    </div>
    <?php
}
?>