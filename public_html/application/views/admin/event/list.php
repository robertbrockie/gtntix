<div class="container">
	<h1>All Events</h1>
	<div class="btn-toolbar"><a href="/adminevent/add"><button class="btn btn-primary">New Event</button></a></div>


	<div class="well">
		<table class="table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Venue</th>
					<th>Artists</th>
					<th style="width: 36px;"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($events as $event) { ?>
				<tr id="event_<?= $event->id ?>">
					<td><?= $event->id ?></td>
					<td><?= $event->date ?></td>
					<td><?= $event->venue_name ?></td>
					<td><?= $events_artists[$event->id] ?></td>
					<td>
						<a href="/adminevent/edit/<?= $event->id ?>"><i class="icon-pencil"></i></a>
						<a href="#" onclick="eventDelete(<?= $event->id ?>)"><i class="icon-remove"></i></a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>