<div class="container-fluid">
	<div>
		<h1>hello <?= $user->username ?>!<h1>
	</div>
	<hr/>
	<div>
		<h3>Event Management</h3>
		<ul>
			<li><a href="/adminevent/add">Add Event</a></li>
			<li><a href="/adminevent/all">List Events</a></li>
		</ul>
	</div>
	<hr/>
	<?php if ($user->venue_id == 0) { ?>
	<div>
		<h3>Venue Management</h3>
		<ul>
			<li><a href="/adminvenue/add">Add Venue</a></li>
			<li><a href="/adminvenue/all">List Venues</a></li>
		</ul>
	</div>
	<hr/>
	<?php } ?>
	<div>
		<h3>Artist Management</h3>
		<ul>
			<li><a href="/adminartist/add">Add Artist</a></li>
			<li><a href="/adminartist/all">List Artist</a></li>
		</ul>
	</div>
</div>