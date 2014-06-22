<div class="container">
	<?= form_open_multipart('/adminartist/edit/'.$artist->id, array('class' => 'form-artist')) ?>
		<h2 class="form-login-heading">Update Artist: <?= $artist->name ?></h2>

		<?php if (validation_errors() != false) { ?>
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo validation_errors(); ?>
			</div>
		<?php } ?>

		<input type="hidden" name="id" value="<?= $artist->id ?>"/>
		<label for="name">Name</label>
		<input type="text" name="name" value="<?= $artist->name ?>"/>

		<label for="website">Website</label>
		<input type="text" name="website" value="<?= $artist->website ?>"/>

		<label for="website">Twitter</label>
		<input type="text" name="twitter_url" value="<?= $artist->twitter_url ?>"/>

		<label for="website">Facebook</label>
		<input type="text" name="facebook_url" value="<?= $artist->facebook_url ?>"/>

		<label for="bio_en">Bio (english)</label>
		<textarea name="bio_en"><?= $artist->bio_en ?></textarea>

		<label for="bio_fr">Bio (french)</label>
		<textarea name="bio_fr"><?= $artist->bio_fr ?></textarea>

		<label for="artist_image">Image</label>
		<?php if (!empty($artist->image_url)) { ?>
			<div id="artist_image_<?= $artist->id ?>"><img src="<?= base_url().'uploads/'.$artist->image_url ?>" /></div>
			<div id="artist_image_delete"><a href="#" onclick="deleteArtistImage(<?= $artist->id ?>); return false;">[&times] Remove Image</a></div>
		<?php } ?>
		<input type="file" name="artist_image" />

		
		<div class="row text-center">
			<button class="btn btn-large btn-primary" type="submit">Update Artist</button>
			<a href="/adminartist/delete/<?= $artist->id ?>">
				<button class="btn btn-large btn-danger" type="button" onclick="return confirm('Delete artist?');">Delete Event</button>
			</a>
		</div>
	</form>
</div>