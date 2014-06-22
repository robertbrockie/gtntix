<div class="container">
	<?= form_open('admin/login', array('class' => 'form-login')) ?>
		<h2 class="form-login-heading">GTN Tickets Login</h2>
		
		<?php if (validation_errors() != false) { ?>
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo validation_errors(); ?>
			</div>
		<?php } ?>

		<input type="text" class="input-block-level" placeholder="Username" name="username" value="<?= set_value('username') ?>"/>
		<input type="password" class="input-block-level" placeholder="Password" name="password"/>
		<button class="btn btn-large btn-primary" type="submit">Login</button>
	</form>
</div>