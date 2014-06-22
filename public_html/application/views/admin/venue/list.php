<div class="container">
	<h1>All Venues</h1>
	<div class="btn-toolbar"><a href="/adminvenue/add"><button class="btn btn-primary">New Venue</button></a></div>

	<div class="well">
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Address</th>
					<th></th>
					<th></th>
					<th style="width: 36px;"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($venues as $venue) { ?>
				<tr id="venue_<?= $venue->id ?>">
					<td><?= $venue->name_en ?></td>
					<td><?= $venue->address_en ?></td>
					<td><a href="<?= $venue->map_url ?>" target="_blank">Map</a></td>
					<td><a href="<?= $venue->website ?>" target="_blank">Website</a></td>
					<td>
						<a href="/adminvenue/edit/<?= $venue->id ?>"><i class="icon-pencil"></i></a>
						<a href="#" onclick="venueDelete(<?= $venue->id ?>)"><i class="icon-remove"></i></a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>