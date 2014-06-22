<div class="container">
	<?= form_open('/adminvenue/edit/'.$venue->id, array('class' => 'form-venue')) ?>
		<h2 class="form-login-heading">Edit Venue: <?= $venue->name_en ?></h2>
		<input type="hidden" name="id" value="<?= $venue->id ?>"/>

		<?php if (validation_errors() != false) { ?>
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo validation_errors(); ?>
			</div>
		<?php } ?>

		<label for="name_en">Name (english)</label>
		<input type="text" name="name_en" value="<?= $venue->name_en ?>"/>

		<label for="address_en">Address (english)</label>
		<textarea name="address_en"><?= $venue->address_en ?></textarea>

		<label for="name_fr">Name (french)</label>
		<input type="text" name="name_fr" value="<?= $venue->name_fr ?>"/>

		<label for="address_fr">Address (french)</label>
		<textarea name="address_fr"><?= $venue->address_fr ?></textarea>

		<label for="map_url">Map URL</label>
		<input type="text" name="map_url" value="<?= $venue->map_url ?>"/>

		<label for="website">Website</label>
		<input type="text" name="website" value="<?= $venue->website ?>"/>

		<div class="row text-center">
			<button class="btn btn-large btn-primary" type="submit">Update Venue</button>
			<a href="/adminvenue/delete/<?= $venue->id ?>">
				<button class="btn btn-large btn-danger" type="button" onclick="return confirm('Delete venue?');">Delete Venue</button>
			</a>
		</div>
	</form>
</div>