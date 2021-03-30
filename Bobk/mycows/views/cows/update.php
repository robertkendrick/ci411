<h2>Edit Cow</h2>

<?= form_open(); ?>

<div class='row'   >
<div class=' col-xs-12 col-sm-6 col-md-4'   >
<div class='form-group'   >
		<label for=''>Id</label>
            <input type='number' name='id' class='form-control' value='<?= set_value('id', $item->id ) ?>' />
		</div>
<div class='form-group'   >
		<label for=''>Name</label>
            <input type='text' name='name' class='form-control' value='<?= set_value('name', $item->name ) ?>' />
		</div>
<div class='form-group'   >
		<label for=''>Descr</label>
            <textarea  class='form-control' name='descr'><?= set_value('descr', $item->descr ) ?></textarea>
		</div>
<div class='form-group'   >
		<label for=''>Deleted</label>
            <input type='number' name='deleted' class='form-control' value='<?= set_value('deleted', $item->deleted ) ?>' />
		</div>
</div>
</div>

<input type="submit" name="submit" class="btn btn-primary" value="Save Cow" />
&nbsp;or&nbsp;
<a href="<?= site_url('cows') ?>">Cancel</a>

<?= form_close(); ?>
