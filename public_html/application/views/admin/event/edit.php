<div class="container">
	<?= form_open_multipart('/adminevent/edit/'.$event->id, array('class' => 'form-event')) ?>
		<input type="hidden" name="id" value="<?= $event->id ?>"/>
		<div class="row text-center">
			<h2 class="form-login-heading">Update Event</h2>
		</div>

		<?php if (validation_errors() != false) { ?>
		<div class="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php echo validation_errors(); ?>
		</div>
		<?php } ?>

		<!-- event artists -->
		<div class="well">
			<div><h3>Artists</h3></div>

			<div id="event_added_artists" class="row text-center">
				<ul>
				<?php foreach ($event_artists as $event_artist) { ?>
					<li id="event_artist_<?= $event_artist->id ?>" <?php if ($event_artist->is_headliner) { echo 'class="headliner"'; } ?>>
						<input type="hidden" name="event_artists[]" value="<?= $event_artist->id ?>"/>
						<p><?= $event_artist->name ?></p>
						<span>
							<a href="#" onclick="eventAddHeadliner(<?= $event->id ?>, <?= $event_artist->id ?>); return false;">make headliner</a> |
							<a href="#" onclick="eventRemoveHeadliner(<?= $event->id ?>, <?= $event_artist->id ?>); return false;">remove headliner</a> |  
							<a href="#" onclick="eventRemoveArtist(<?= $event_artist->id ?>); return false;">remove</a>
						</span>
					</li>
				<?php } ?>
				</ul>
			</div>

			<div class="row">
				<a href="#myModal" role="button" data-toggle="modal"><button class="btn btn-primary">Add Artist</button></a>
			</div>
		</div>

		<!-- event venue -->
		<div class="well">
			<div><h3>Venue</h3></div>
			<div>
				<select name="venue_id">
					<option value="">Choose a venue...</option>
				<?php foreach ($venues as $venue) { ?>
					<option value="<?= $venue->id ?>" <?php echo $event->venue_id == $venue->id ? 'selected' : '' ?>><?= $venue->name_en ?></option>
				<?php } ?>
				</select>
			</div>
		</div>

		<!-- event dates/times -->
		<div class="well">
			<div><h3>Dates/Times</h3></div>

			<div><b>Show Date</b></div>
			<div id="event_date" class="input-append date">
				<input data-format="yyyy-MM-dd" type="text" name="date" value="<?= $event->date ?>"/>
				<span class="add-on">
					<i data-date-icon="icon-calendar"></i>
				</span>
			</div>

			<div><b>Door Time</b></div>
			<div id="event_door_time" class="input-append">
				<input data-format="hh:mm" type="text" name="door_time" value="<?= $event->door_time ?>"/>
				<span class="add-on">
					<i data-time-icon="icon-time"></i>
				</span>
			</div>

			<div><b>Show Time</b></div>
			<div id="event_show_time" class="input-append">
				<input data-format="hh:mm" type="text" name="show_time" value="<?= $event->show_time ?>"/>
				<span class="add-on">
					<i data-time-icon="icon-time"></i>
				</span>
			</div>
			
			<div><b>Announce Date</b></div>
			<div id="event_announce_date" class="input-append date">
				<input data-format="yyyy-MM-dd hh:mm:ss" type="text" name="announce_date" value="<?= $event->announce_date ?>"/>
				<span class="add-on">
					<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				</span>
			</div>
		</div>

		<!-- event ticket information -->
		<div class="well">
			<div><h3>Ticket Information</h3></div>

			<div><b>Ticket URL</b></div>
			<div><input type="text" name="ticket_url_en" placeholder="Ticket URL (english)" value="<?= $event->ticket_url_en ?>"/></div>
			<div><input type="text" name="ticket_url_fr" placeholder="Ticket URL (french)" value="<?= $event->ticket_url_fr ?>"/></div>

			<div><b>Onsale Date</b></div>
			<div id="event_ticket_onsale_date" class="input-append date">
				<input data-format="yyyy-MM-dd hh:mm:ss" type="text" name="ticket_onsale_date" value="<?= $event->ticket_onsale_date ?>"/>
				<span class="add-on">
					<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
				</span>
			</div>
		</div>

		<!-- event presenter -->
		<div class="well">
			<div><h3>Presenter</h3></div>
			<div><input type="text" name="presenter_en" placeholder="Presenter (english)" value="<?= $event->presenter_en ?>"/></div>
			<div><input type="text" name="presenter_fr" placeholder="Presenter (french)" value="<?= $event->presenter_fr ?>"/></div>
		</div>

		<!-- event description-->
		<div class="well">
			<div><h3>Description</h3></div>
			<div><textarea name="description_en" placeholder="Description (english)"><?= $event->description_en ?></textarea></div>
			<div><textarea name="description_fr" placeholder="Description (french)"><?= $event->description_fr ?></textarea></div>
		</div>

		<!-- event misc detail-->
		<div class="well">
			<div><h3>Misc Details</h3></div>
			
			<div>
				<label class="checkbox">Non GTN Event<input type="checkbox" name="non_gtn_event" <?= $event->non_gtn_event ? 'checked' : '' ?>/></label>
				<label class="checkbox">Age Restricted<input type="checkbox" name="age_restricted" <?= $event->age_restricted ? 'checked' : '' ?>/></label>
				<label class="checkbox">Seated Show<input type="checkbox" name="seated" <?= $event->seated ? 'checked' : '' ?>/></label>
			</div>

			<div><h3>Optional Title</h3></div>
			<div><input type="text" name="optional_title_en" placeholder="Optional Title (english)" value="<?= $event->optional_title_en ?>"/></div>
			<div><input type="text" name="optional_title_fr" placeholder="Optional Title (french)" value="<?= $event->optional_title_fr ?>"/></div>
		</div>

		<!-- event poster -->
		<div class="well">
			<div><h3>Image</h3></div>
			<div class="row text-center">
				<?php if (!empty($event->image_url)) { ?>
					<div id="event_image_<?= $event->id ?>"><img src="<?= base_url().'uploads/'.$event->image_url ?>" /></div>
					<div id="event_image_delete"><a href="#" onclick="deleteEventImage(<?= $event->id ?>); return false;">[&times] Remove Image</a></div>
				<?php } ?>
				<input type="file" name="event_image" />	
			</div>
		</div>

		<div class="row text-center">
			<button class="btn btn-large btn-primary" type="submit">Update Event</button>
			<a href="/adminevent/delete/<?= $event->id ?>"><button class="btn btn-large btn-danger" type="button" onclick="return confirm('Delete event?');">Delete Event</button></a>
		</div>
	</form>

	<!-- add artist to event modal -->
	<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Add Artist</h3>
		</div>
		<div class="modal-body">
			<select name="artist_id" id="event_artists">
				<?php foreach($artists as $artist) { ?>
					<option data-artist-id="<?= $artist->id ?>" data-artist-name="<?= $artist->name ?>" data-event-id="<?= $event->id ?>"><?= $artist->name ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
			<button id="add_event_artist" class="btn btn-success" data-dismiss="modal">Add Artist</button>
		</div>
	</div>
</div>