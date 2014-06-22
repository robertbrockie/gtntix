function artistDelete(id) {
	if (confirm('Delete Artist?')) {
		$.ajax({
			url: '/adminartist/delete/' + id
		}).done(function() {
			$('#artist_' + id).remove();
		});
	}
}

function deleteArtistImage(id) {
	if (confirm('Delete Image?')) {
		$.ajax({
			url: '/adminartist/delete_image/' + id
		}).done(function() {
			$('#artist_image_' + id).remove();
			$('#artist_image_delete').remove();
		});
	}
}