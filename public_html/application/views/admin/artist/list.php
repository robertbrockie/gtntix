<div class="container">
	<h1>All Artists</h1>
	<div class="btn-toolbar"><a href="/adminartist/add"><button class="btn btn-primary">New Artist</button></a></div>

	<div class="well">
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th></th>
					<th>Bio</th>
					<th style="width: 36px;"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($artists as $artist) { ?>
				<tr id="artist_<?= $artist->id ?>">
					<td><?= $artist->name ?></td>
					<td><a href="<?= $artist->website ?>" target="_blank">Website</a></td>
					<td><?= $artist->bio_en ?></td>
					<td>
						<a href="/adminartist/edit/<?= $artist->id ?>"><i class="icon-pencil"></i></a>
						<?php if (user_is_not_venue($user)) { ?>
						<a href="#" onclick="artistDelete(<?= $artist->id ?>)"><i class="icon-remove"></i></a>
						<?php } ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>