function venueDelete(id) {
	if (confirm('Delete Venue?')) {
		$.ajax({
			url: '/adminvenue/delete/' + id
		}).done(function() {
			$('#venue_' + id).remove();
		});
	}
}