<h2>Create A Cow</h2>

<?php echo site_url(); ?>

<?= form_open(); ?>
  <div class='row'   >
	<div class=' col-xs-12 col-sm-6 col-md-4'   >
	  <div class='form-group'   >
		<label for=''>Id</label>
        <input type='number' class='form-control' name='id' />
	  </div>
  	  <div class='form-group'   >
		<label for=''>Name</label>
        <input type='text' class='form-control' name='name' />
	  </div>
	  <div class='form-group'   >
		<label for=''>Descr</label>
        <textarea name='descr' class='form-control'></textarea>
	  </div>
	  <div class='form-group'   >
		<label for=''>Deleted</label>
        <input type='number' class='form-control' name='deleted' />
	  </div>
	</div>
  </div>


    <input type="submit" name="submit" value="Create Cow" class="btn btn-primary" />
    &nbsp;or&nbsp;
    <a href="<?= site_url('cows') ?>">Cancel</a>

<?= form_close(); ?>
